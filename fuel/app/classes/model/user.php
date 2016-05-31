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
		'email_confirm',
		'new_email',
		'email_confirm_token',
		'email_confirm_expired',
	);

    public static function validate($factory)
	{
		$val = Validation::forge($factory);
		switch($factory) {
			case "register":
				$val->add_field('email', '', 'required');	
				$val->add_field('first_name', '', 'required');
				$val->add_field('first_kana', '', 'required');
				$val->add_field('last_name', '', 'required');
				$val->add_field('last_kana', '', 'required');
				$val->add_field('gender', '', 'required');
				$val->add_field('phone', '', 'required');
				$val->add_field('prefecture', '', 'required');	
				$val->add_field('address', '', 'required');	
				$val->add_field('password', '', 'required');
				$val->add_field('password_confirm', '', 'required');	
				break;			
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
			'email_confirm',
			'new_email',
			'email_confirm_token',
			'email_confirm_expired',
		);
		foreach($keys as $key) {
			$ret[$key] = $user[$key];
		}

		if(isset($ret['last_name']) && isset($ret['first_name'])) {
			$ret['name'] = $ret['last_name'].$ret['first_name'];
		}

		if(isset($ret['last_kana']) && isset($ret['first_kana'])) {
			$ret['kana'] = $ret['last_kana'].$ret['first_kana'];
		}

		if(!empty($ret['profile_image'])) {
			$ret['profile_image'] = Uri::base()."images/user/".$ret['profile_image'];
		} else {
			$ret['profile_image'] = Uri::base()."images/common/img_no-image.jpg";
		}

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
				$users[] = \Model_User::format($row);
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

	public static function getUserFromEmail($email){
		$user = \Model_User::find("first", array(
			'where' => array(
				'email' => $email,
			)
		));
		if($user) {
			return \Model_User::format($user);
		} else {
			return null;
		}	
	}

	public static function uploadProfileImage() {
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
	            return $files[0]['saved_as'];
	        }

	        // エラー有り
	        foreach (Upload::get_errors() as $file)
	        {
	            return null;
	        }
        } catch (Exception $e) {
        	return null;
        }
	}

	public static function saveUser($params) {
		\Model_User::uploadProfileImage();
		return \Model_User::saveAdminUser($params);
	}

	public static function saveAdminUser($params) {
		if(isset($params['id'])) {
			$id = $params['id'];
		} else {
			if(empty($params['username'])) {
				$params['username'] = sha1($params['email'].mt_rand());
			}
			if(!isset($params['admin'])) {
				$params['admin'] = 1;
			}
			$id = Auth::create_user(
	                $params['username'],
	                $params['password'],
	                $params['email']);
			$params['email_confirm'] = 0;
			$params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day"));
			$params['email_confirm_token'] = sha1($params['email'].$params['email_confirm_expired'].mt_rand());
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
				$params['user_id'] = $user['id'];
				\Model_User::saveSensor($params);
				return \Model_User::format($user);
			} else {
				return null;
			}				
		}
	}

	public static function sendEmail($params) {
		if(empty($params['from'])) {
			$params['from'] = Config::get("email.from");
		}
		$sendgrid = new SendGrid(Config::get("sendgrid"));
		$email = new SendGrid\Email();
		$email
		    ->addTo($params['to'])
		    ->setFrom($params['from'])
		    ->setSubject($params['subject'])
		    ->setHtml($params['text']);
		return $sendgrid->send($email);
	}

	public static function saveSensor($params) {
		if(isset($params['sensor_id'])) {
			$user_sensor = \Model_User_Sensor::find("first", array(
				'where' => array(
					'user_id' => $params['user_id'],
					'sensor_id' => $params['sensor_id'],
				),
			));
			//もし設定が無い場合は新規作成
			if(empty($user_sensor)){
				$user_sensor = \Model_User_Sensor::forge();
			}

			$user_sensor->set(array(
				'user_id' => $params['user_id'],
				'sensor_id' => $params['sensor_id'],
			));

			return $user_sensor->save();			
		}
	}

	public static function changePassword($params) {
		if(!empty($params['id'])) {
			$id = $params['id'];
			$user = \Model_User::find($id);
		}
		if($user) {
			if(Auth::change_password($params['password'], $params['new_password'], $user['username'])) {
				\Model_User::sendEmail($user);
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
				$user_sensor = $row->to_array();
				$user_sensor['id'] = $user_sensor['sensor_id'];
				unset($user_sensor['user_id']);
				unset($user_sensor['sensor_id']);
				if(isset($user_sensor['sensor'])) {
					$sensor = $user_sensor['sensor'];
					unset($user_sensor['sensor']);
					$sensors[] = array_merge($sensor, $user_sensor);
				} else {
					$sensors[] = $user_sensor;
				}				
			}
		}
		return $sensors;
	}

	public static function saveClients($user_id, $client_user_ids) {
        foreach($client_user_ids as $client_user_id => $value) {
        	//センサー機器の設定
        	$sensors = \Model_User::getSensors($client_user_id);
            if($value === "true") {
            	if(!empty($sensors[0])) {
		        	$params = array(
		        		'user_id' => $user_id,
		        		'sensor_id' => $sensors[0]['id'],
		        		'admin' => 1,
		        	);
	        		\Model_User_Sensor::saveUserSensor($params);
	        	}

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
            	if(!empty($sensors[0])) {
            		$sensor = \Model_User_Sensor::find('first' , array(
            			'where' => array(
            				'sensor_id' => $sensors[0]['id']
            			),
           			));
           			try {
           				$sensor->delete(false);
           			} catch(Exception $e) {
           			}
            	}
            	$user_client = \Model_User_Client::find("first", array(
                    'where' => array(
                        'user_id' => $user_id,
                        'client_user_id' => $client_user_id,
                    ),
                ));

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

	public static function sendConfirmEmail($user) {
		$url = Uri::base(false)."user/email_confirm?".Uri::build_query_string(array(
			'token' => $user['email_confirm_token'],
		));
		$params = array(
			'to' => $user['email'],
			'subject' => "新規登録確認",
			'text' => \View::forge('email/user/save_admin', array("url" => $url))
		);
		return \Model_User::sendEmail($params);
	}
}
		