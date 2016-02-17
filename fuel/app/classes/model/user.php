<?php 
class Model_User extends Orm\Model{

	protected static $_properties = array(
		'id',
		'username',
		'password',
		'name',
		'kana',
		'email',
		'profile_fields',
		'last_login',
		'login_hash',
		'gender',
		'phone',
		'cellular',
		'work_start_date',
		'memo',
		'admin',
		'address',
		'area',
		'blood_type',
		'birthday',
		'created_at',
	);

	public static function createTable() {
		try {
		    DB::query("DROP TABLE users")->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
		}
        $sql = "CREATE TABLE users (
		 id int NOT NULL IDENTITY (1, 1),
		 username NVARCHAR(50),
		 password NVARCHAR(255),
		 name NVARCHAR(50),
		 kana NVARCHAR(512),
		 email NVARCHAR(512),
		 profile_fields NVARCHAR(512),
		 last_login NVARCHAR(512),
		 login_hash NVARCHAR(512),
		 gender NCHAR(1),
		 phone NVARCHAR(512),
		 cellular NVARCHAR(255),
		 work_start_date DATE,
		 memo NTEXT,
		 admin INT DEFAULT 0,
		 address NTEXT,
		 area NVARCHAR(255),
		 blood_type NVARCHAR(255),
		 birthday DATE,
		 created_at INT
		) ON [PRIMARY];";
		try {
			DB::query($sql)->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public static function getAdmins(){
		$sql = "SELECT * FROM users WHERE admin=1;";
		$res = DB::query($sql)->execute();
		return $res->as_array();
	}

	public static function getClients($user_id=null) {
		$users = array();
		if($user_id) {
			$rows = \Model_User_Client::find("all", array(
				'where' => array(
					'user_id' => $user_id,
				),
				'related' => array('user')
			));
			foreach($rows as $row) {
				$users[] = $row->user;
			}
		} else {
			$rows = \Model_User::find("all", array(
				'where' => array('admin' => 0)
			));
			foreach($rows as $row) {
				$users[] = $row;
			}			
		}
		return $users;
	}

	public static function getUsers(){
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		return $res->as_array();
	}

	public static function getUser($id){
		$sql = "SELECT * FROM users WHERE id = :id;";
		$query = DB::query($sql);
		$query->parameters(array('id' => $id));
		$res = $query->execute();
		
		$user = $res[0];
		if($user) {
			unset($user['password']);
			unset($user['last_login']);
			unset($user['login_hash']);
			unset($user['created_at']);
			unset($user['profile_fields']);
			return $user;
		} else {
			return null;
		}	
	}

	public static function saveUser($params) {
		if(empty($params['email']) && isset($params['username'])) {
			$params['email'] = $params['username'];
		}
		if(empty($params['admin'])) {
			$params['admin'] = 0;
		}
		try {
			if(!empty($params['id'])) {
				$id = $params['id'];
			} else if($id = Auth::create_user(
		                $params['username'],
		                $params['password'],
		                $params['email'])) {
			}
			$user = \Model_User::find($id);
			unset($params['id']);
			unset($params['username']);
			unset($params['password']);
			unset($params['email']);
			if($user) {
				$user->set($params);
				if($user->save()) {
					//センサーを保存
					if(isset($params['sensor_id'])) {
						$user_sensor = \Model_User_Sensor::find("first", array(
							'where' => array(
								'user_id' => $user->id,
							),
						));
						//もし設定が無い場合は新規作成
						if(empty($user_sensor)){
							$user_sensor = \Model_User_Sensor::forge();
						}

						$user_sensor->set(array(
							'user_id' => $user->id,
							'sensor_id' => $params['sensor_id'],
						));
			
						try {
							$user_sensor->save();
						} catch(Exception $e) {
							echo $e->getMessage();
							exit;
						}					
					}
					return array(
						'id' => $user->id,
						'username' => $user->username,
						'email' => $user->email,
						'name' => $user->name,
						'kana' => $user->kana,
						'gender' => $user->gender,
						'phone' => $user->phone,
						'cellular' => $user->cellular,
						'address' => $user->address,
						'area' => $user->area,
						'blood_type' => $user->blood_type,
						'birthday' => $user->birthday,
						'work_start_date' => $user->work_start_date,
						'memo' => $user->memo,
						'admin' => $user->admin,
					);
				} else {
					return null;
				}				
			}
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public static function getSensors($user_id) {
		$sensors = array();
		if($user_id) {
			$rows = \Model_User_Sensor::find("all", array(
				'where' => array(
					'user_id' => $user_id,
				),
				'related' => array('sensor')
			));
			foreach($rows as $row) {
				$sensors[] = $row->sensor;
			}
		}
		return $sensors;
	}

	public static function saveClients($user_id, $client_user_ids) {
        foreach($client_user_ids as $client_user_id => $value) {
            if($value === "true") {
                $user_client = \Model_User_Client::forge();
                $user_client->set(array(
                    'user_id' => $user_id,
                    'client_user_id' => $client_user_id,
                ));
                try {
                    if($user_client->save()) {        
                    }
                } catch(Exception $e) {
                }
            } else {
                $user_client = \Model_User_Client::find("first", array(
                    'where' => array(
                        'user_id' => $user_id,
                        'client_user_id' => $client_user_id,
                    ),
                ));
                unset($user_client->user);
                try {
                    if(isset($user_client) && $user_client->delete()) {
                    }
                } catch(Exception $e) {
                }
            }
        }
        return;
	}
}
		