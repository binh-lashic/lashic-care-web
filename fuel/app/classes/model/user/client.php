<?php 
class Model_User_Client extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'client_user_id',
                'admin',
	);

	protected static $_belongs_to = array(
		'client'=> array(
	        'model_to' => 'Model_User',
	        'key_from' => 'client_user_id',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
		'admin'=> array(
	        'model_to' => 'Model_User',
	        'key_from' => 'user_id',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
    	)
	);


	public static function createTable(){
		try {
		    DB::query("DROP TABLE user_clients")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE user_clients (
  id INT NOT NULL IDENTITY (1, 1),
  user_id INT NOT NULL,
  client_user_id INT NOT NULL
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function saveUserClient($params) {
		if(isset($params['id'])) {
	    	$user_client = \Model_User_Client::find($params['id']);
		} else {
			if(empty($params['user_id']) && isset($params['email'])) {
				$user = \Model_User::getUserFromEmail($params['email']);
				if(!$user) {
					$data = array(
						'last_name' => $params['last_name'],
						'first_name' => $params['first_name'],
						'last_kana' => $params['last_kana'],
						'first_kana' => $params['first_kana'],
						'email' => $params['email'],
						'admin' => 0,
						'password' => sha1($params['email']),
					);
					$user = \Model_User::saveUser($data);
				}
				$params['user_id'] = $user['id'];
			}
			if(isset($params['user_id'])) {
				$user_client = \Model_User_Client::find("first", array(
					"where" => array(
						"user_id" => $params['user_id'],
						"client_user_id" => $params['client_user_id'],
					)
				));				
			}

			if(empty($user_client)) {
				$user_client = \Model_User_Client::forge();
	    	}
		}
    	unset($params['q']);
    	unset($params['id']);
	    $user_client->set($params);
		if($user_client->save()) {
			return $user_client;
		}
    	return null;
    }

	public static function deleteUserClient($params) {
		if(isset($params['id'])) {
	    	$user_client = \Model_User_Client::find($params['id']);
		} else {
			if(isset($params['user_id'])) {
				$user_client = \Model_User_Client::find("first", array(
					"where" => array(
						"user_id" => $params['user_id'],
						"client_user_id" => $params['client_user_id'],
					)
				));				
			}
		}
		if($user_client->delete(false)) {
			return $user_client;
		}
    	return null;
    }

    public static function getUserClient($user_id, $client_user_id) {
        return \Model_User_Client::find("first", array(
               'where' => array(
                   'user_id'        => $user_id,
                   'client_user_id' => $client_user_id,
               )
        ));
    }

    public static function getUserClients($user_id) {
        $sql = '
            SELECT
                c.id AS id,
                c.user_id AS user_id,
                c.client_user_id AS client_user_id,
                s2.admin AS admin,
                u.last_name AS last_name,
                u.first_name AS first_name,
                s1.sensor_id AS sensor_id
            FROM
                dbo.user_clients c
            INNER JOIN
                dbo.users u ON c.client_user_id = u.id
            INNER JOIN 
                dbo.user_sensors s1 ON c.client_user_id = s1.user_id
            INNER JOIN
                dbo.user_sensors s2 ON c.user_id = s2.user_id
            INNER JOIN
                dbo.sensors s ON s2.sensor_id = s.id
            WHERE
                s1.sensor_id = s2.sensor_id
                AND s.type = :type
                AND c.user_id = :user_id
        ';
        $query = DB::query($sql);
        $query->parameters(array('type' => 'sensor', 'user_id' => $user_id));
        return $query->execute();
    }
    
    /*
     * 新規追加
     * 
     * @access public
     * @param array $params
     * @throw
     */
    public static function createUserClient($params)
    {
        try {
            $client = \Model_User_Client::forge($params);
            $client->save();    
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /*
     * 見守られユーザーの削除 
     * users, user_clients, user_sensorsを削除
     * 
     * @access public
     * @params int $user_id 見守られユーザID
     * @throw
     * 
     */
    public function deleteClients($user_id)
    {
        $db = Database_Connection::instance();
        $db->start_transaction();
        
        try {
            // user_clients削除
            DB::delete('user_clients')
                    ->where('client_user_id', '=', $user_id)
                    ->execute();
        } catch (Exception $e) {
            $db->rollback_transaction();
            throw new Exception("delete clients_users failed. (user_id:".$user_id.") [".$e->getMessage()."]");
        }
        
        try {
            // user_sensors削除 
            DB::delete('user_sensors')
                    ->where('user_id', '=', $user_id)
                    ->execute();
        } catch (Exception $e) {
            $db->rollback_transaction();
            throw new Exception("delete user_sensors failed. (user_id:".$user_id.") [".$e->getMessage()."]");
        }

        try {
            // users削除
            DB::delete('users')
                    ->where('id', '=', $user_id)
                    ->execute();
        } catch (Exception $e) {
            $db->rollback_transaction();
            throw new Exception("delete users failed. (user_id:".$user_id.") [".$e->getMessage()."]");
        }
        
        $db->commit_transaction();
    }
    
    /*
     * 見守られユーザー一覧取得
     * センサー機器が複数レコード紐づいている場合は、複数レコードをカンマ区切りでセンサーIDと出荷日を連結する 
     * 
     *  @params int $user_id
     *  @return array $reuslt
     */
    public function getUserClientList($user_id)
    {
        try {
            $query = DB::query(
                    "SELECT "
                    . "id, last_name, first_name, sensor "
                    . "FROM ( "
                    . "     SELECT "
                    . "     client_user_id, "
                    . "     STUFF(( "
                    . "         SELECT "
                    . "             ',' + name + ':' + CAST(shipping_date as varchar) "
                    . "         FROM " 
                    . "             user_sensors AS us "
                    . "         LEFT JOIN " 
                    . "             sensors AS s ON us.sensor_id = s.id "
                    . "         WHERE "
                    . "             user_id = t1.client_user_id "
                    . "         FOR XML PATH('') "
                    . "     ), 1, 1, '') AS sensor "
                    . "     FROM "
                    . "         user_clients as t1 "
                    . "     WHERE " 
                    . "         t1.user_id = :user_id " 
                    . ") AS cu "
                    . "LEFT JOIN "
                    . " users AS u "
                    . " ON cu.client_user_id = u.id "
                    . "WHERE u.admin = 0 "
                    . "ORDER BY id "
            );

            $rows = $query->parameters(['user_id' => $user_id])
                                ->execute()
                                ->as_array();
            $result = [];
            // 連結したセンサーIDと出荷日をそれぞれの配列に格納
            array_walk($rows, function ($values, $keys) use (&$result) {
                foreach ($values as $key => $value) {
                    if ($key == 'sensor') {
                        $sensor_name = [];
                        $shipping_date = [];
                        foreach (explode(',', $value) as $name) {
                            list($sensor_name[], $shipping_date[]) = explode(':', $name);
                        }
                        $result[$keys]['sensor_name'] = $sensor_name;
                        $result[$keys]['shipping_date'] = $shipping_date;
                    } else {
                        $result[$keys][$key] = $value;
                    }
                }
            });

            return $result;
        } catch (Exception $e) {
            \Log::error('User Client List Getting Failed. [' . $e->getMessage(). ']');
            throw new Exception($e);
        }
    }
}
