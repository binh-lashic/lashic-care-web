<?php 
class Model_User_Client extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'client_user_id',
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
}
