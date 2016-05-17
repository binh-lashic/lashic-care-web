<?php 
class Model_User extends Orm\Model{

	protected static $_properties = array(
		'id',
		'username',
		'password',
		'name',
		'kana',
		'first_name',
		'last_name',
		'first_kana',
		'last_kana',
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
		'zip_code',
		'prefecture',
		'address',
		'area',
		'blood_type',
		'birthday',
		'emergency_first_name_1',
		'emergency_last_name_1',
		'emergency_first_kana_1',
		'emergency_last_kana_1',
		'emergency_phone_1',
		'emergency_cellular_1',
		'emergency_first_name_2',
		'emergency_last_name_2',
		'emergency_first_kana_2',
		'emergency_last_kana_2',
		'emergency_phone_2',
		'emergency_cellular_2',
		'profile_image',
		'created_at',
		'subscription',
	);

    public static function validate($factory)
	{
		$val = Validation::forge($factory);
		switch($factory) {
			case "basic":
				$val->add_field('name', '', 'required');
				$val->add_field('kana', '', 'required');
				$val->add_field('gender', '', 'required');
				$val->add_field('phone', '', 'required');				
				break;
			case "email":
				$val->add_field('email', '', 'required');
				break;
		}
		return $val;
	}

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
		 zip_code NVARCHAR(255),
		 prefecture NVARCHAR(255),
		 address NTEXT,
		 area NVARCHAR(255),
		 blood_type NVARCHAR(255),
		 birthday DATE,
		 emergency_name_1 NVARCHAR(50),
		 emergency_phone_1 NVARCHAR(50),
		 emergency_cellular_1 NVARCHAR(50),
		 emergency_name_2 NVARCHAR(50),
		 emergency_phone_2 NVARCHAR(50),
		 emergency_cellular_2 NVARCHAR(50),
		 profile_image NVARCHAR(255),
		 created_at INT,
		 subscription INT DEFAULT 1,
		) ON [PRIMARY];";
		try {
			DB::query($sql)->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public static function format($user) {
		$ret = array();
		$keys = array(
			'id',
			'username',
			'name',
			'first_name',
			'last_name',
			'kana',
			'first_kana',
			'last_kana',
			'email',
			'gender',
			'phone',
			'cellular',
			'work_start_date',
			'memo',
			'admin',
			'zip_code',
			'prefecture',
			'address',
			'area',
			'blood_type',
			'birthday',
			'profile_image',
			'emergency_first_name_1',
			'emergency_last_name_1',
			'emergency_first_kana_1',
			'emergency_last_kana_1',
			'emergency_phone_1',
			'emergency_cellular_1',
			'emergency_first_name_2',
			'emergency_last_name_2',
			'emergency_first_kana_2',
			'emergency_last_kana_2',
			'emergency_phone_2',
			'emergency_cellular_2',
			'subscription',
		);
		foreach($keys as $key) {
			$ret[$key] = $user[$key];
		}
		$ret['name'] = $ret['last_name'].$ret['first_name'];
		$ret['kana'] = $ret['last_kana'].$ret['first_kana'];

		$ret['profile_image'] = Uri::base()."images/user/".$ret['profile_image'];
		if(isset($ret['birthday'])) {
			$now = date("Ymd");
			$birthday = date("Ymd", strtotime($ret['birthday']));
			$ret['age'] = (int)(floor((int)$now - (int)$birthday) / 10000);
		} else {
			$ret['age'] = null;
		}
		return $ret;
	}

	public static function getClients($user_id=null) {
		$users = array();
		if($user_id) {
			$rows = \Model_User_Client::find("all", array(
				'where' => array(
					'user_id' => $user_id,
				),
				'related' => array('client')
			));
			foreach($rows as $row) {
				$users[] = \Model_User::format($row->client);
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

	public static function getAdmins($client_user_id=null) {
		$users = array();
		list(, $user_id) = Auth::get_user_id();

		if($client_user_id) {
			$rows = \Model_User_Client::find("all", array(
				'where' => array(
					'client_user_id' => $client_user_id,
					array('user_id', "!=", $user_id),
				),
				'related' => array('admin')
			));
			foreach($rows as $row) {
				$users[] = \Model_User::format($row->admin);
			}
		} else {
			$rows = \Model_User::find("all", array(
				'where' => array('admin' => 1)
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
			return \Model_User::format($user);
		} else {
			return null;
		}	
	}

	public static function saveUser($params) {
        $config = array(
            'path' => DOCROOT.DS.'images/user',
            'randomize' => true,
            'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
        );

        try {
	        Upload::process($config);
	        if (Upload::is_valid())
	        {
	            Upload::save();
	            $files = Upload::get_files();
	            $params['profile_image'] = $files[0]['saved_as'];
	        }

	        // エラー有り
	        foreach (Upload::get_errors() as $file)
	        {
	            // $file['errors']の中にエラーが入っているのでそれを処理
	        }
        } catch (Exception $e) {

        }

		if(empty($params['email']) && isset($params['username'])) {
			$params['email'] = $params['username'];
		}
		if(empty($params['username'])) {
			$params['username'] = sha1($params['email'].mt_rand());
		}
		/*
		if(empty($params['admin'])) {
			$params['admin'] = 0;
		}
		*/
		try {
			if(!empty($params['id'])) {
				$id = $params['id'];
			} else {
				$id = Auth::create_user(
		                $params['username'],
		                $params['password'],
		                $params['email']);
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

					$sendgrid = new SendGrid(Config::get("sendgrid"));
					$email = new SendGrid\Email();
					$email
					    ->addTo($user['email'])
					    ->setFrom(Config::get("email.from"))
					    ->setSubject(Config::get("email.templates.user_update.subject"))
					    ->setText(Config::get("email.templates.user_update.text"));
					try {
					    $sendgrid->send($email);
					} catch(\SendGrid\Exception $e) {
						echo $e->getMessage();
					}
					return \Model_User::format($user);
				} else {
					return null;
				}				
			}
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}

	public static function changePassword($params) {
		if(!empty($params['id'])) {
			$id = $params['id'];
			$user = \Model_User::find($id);
		}
		if($user) {
			if(Auth::change_password($params['password'], $params['new_password'], $user['username'])) {
				$sendgrid = new SendGrid(Config::get("sendgrid"));
				$email = new SendGrid\Email();
				$email
				    ->addTo($user['email'])
				    ->setFrom(Config::get("email.from"))
				    ->setSubject(Config::get("email.templates.user_update.subject"))
				    ->setText(Config::get("email.templates.user_update.text"));
				try {
				    $sendgrid->send($email);
				} catch(\SendGrid\Exception $e) {
					echo $e->getMessage();
				}
				return true;
			} else {
				return false;
			}
		}
	}

	public static function getSensors($user_id) {
		$sensors = array();
		if($user_id) {
			$rows = \Model_User_Sensor::find("all", array(
				'where' => array(
					'user_id' => $user_id,
				),
				'related' => array(
					'sensor' => array(
						'order_by' => array('name' => 'asc'),
					)
				),
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
		