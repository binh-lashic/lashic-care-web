<?php 
class Model_User extends Orm\Model{
	
	/** 仮アカウントのステータス **/
	const REGULAR_USER = 0;
	const TEMPORARY_USER = 1;
	
	/** 見守り対象ユーザが存在するかどうか **/
	const NO_CLIENT = 0;
	const EXIST_CLIENT = 1;
	
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
		'master' => array('default' => 0),
		'affiliate'
	);

    public static function validate($factory, $options = null)
	{
		$val = Validation::forge($factory);
		$val->add_callable('Validation_Japanese');
		$val->add_callable('usersrules');
		switch($factory) {
			case "register":
				$val->add_field('last_name', 'お名前 姓', 'required|max_length[45]');
				$val->add_field('last_kana', 'ふりがな 姓', 'required|hiragana|max_length[45]');
				$val->add_field('first_name', 'お名前 名', 'required|max_length[45]');
				$val->add_field('first_kana', 'ふりがな 名', 'required|hiragana|max_length[45]');
				$val->add_field('phone', '電話番号', 'required|valid_string[numeric]|max_length[45]');
				$val->add_field('email', 'メールアドレス', 'required|valid_email|duplicate_email|max_length[512]');
				$val->add_field('password', 'パスワード', 'required|min_length[8]|valid_string[alpha,numeric]|max_length[255]');
				$val->add_field('password_confirm', 'パスワード（確認）', 'required|match_value['.Input::post('password').']');
				break;
			case "register_client":
				$val->add_field('last_name', 'お名前 姓', 'required|max_length[45]');
				$val->add_field('last_kana', 'ふりがな 姓', 'required|hiragana|max_length[45]');
				$val->add_field('first_name', 'お名前 名', 'required|max_length[45]');
				$val->add_field('first_kana', 'ふりがな 名', 'required|hiragana|max_length[45]');
				$val->add_field('gender', '性別', 'required');
				$val->add_field('zip_code', '郵便番号', 'check_zipcode');
				$val->add_field('phone', '電話番号', 'required|valid_string[numeric]|max_length[45]');
				$val->add_field('cellular', '電話番号2', 'valid_string[numeric]|max_length[45]');
				$val->add_field('prefecture', '都道府県', 'required');
				$val->add_field('address', '都道府県以下', 'required');
				break;
			case "basic":
				$val->add_field('last_name', 'お名前 姓', 'required|max_length[45]');
				$val->add_field('last_kana', 'ふりがな 姓', 'required|hiragana|max_length[45]');
				$val->add_field('first_name', 'お名前 名', 'required|max_length[45]');
				$val->add_field('first_kana', 'ふりがな 名', 'required|hiragana|max_length[45]');
				$val->add_field('gender', '性別', 'required');
				break;
			case "email":
				$val->add_field('email', '', 'required|max_length[512]');
				break;
			case "email_update":
				$val->add_field('new_email', 'メールアドレス', 'required|valid_email|duplicate_email|max_length[512]');
				$val->add_field('new_email_confirm', 'メールアドレス（確認）', 'required|check_confirm_email['.Input::post('new_email').']');
				break;
			case "account_basic":
				$val->add_field('last_name', 'お名前 姓', 'required|max_length[45]');
				$val->add_field('last_kana', 'ふりがな 姓', 'required|hiragana|max_length[45]');
				$val->add_field('first_name', 'お名前 名', 'required|max_length[45]');
				$val->add_field('first_kana', 'ふりがな 名', 'required|hiragana|max_length[45]');
				$val->add_field('gender', '性別', 'required');
				$val->add_field('zip_code', '郵便番号', 'check_zipcode');
				$val->add_field('prefecture', '都道府県', 'required');
				$val->add_field('address', '都道府県以下', 'required');
				$val->add_field('phone', '電話番号1', 'required|valid_string[numeric]|max_length[45]');
				$val->add_field('cellular', '電話番号2', 'valid_string[numeric]|max_length[45]');
				break;	
			case "info_contact":
				$val->add_field('zip_code', '郵便番号', 'check_zipcode');
				$val->add_field('prefecture', '都道府県', 'required');
				$val->add_field('address', '都道府県以下', 'required');
				$val->add_field('phone', '電話番号1', 'required|valid_string[numeric]|max_length[45]');
				$val->add_field('cellular', '電話番号2', 'valid_string[numeric]|max_length[45]');
				break;
			case "info_option":
				$val->add_field('emergency_first_name_1', 'お名前 名', 'max_length[45]');
				$val->add_field('emergency_last_name_1', 'お名前 姓', 'max_length[45]');
				$val->add_field('emergency_first_kana_1', 'ふりがな 名', 'hiragana|max_length[45]');
				$val->add_field('emergency_last_kana_1', 'ふりがな 姓', 'hiragana|max_length[45]');
				$val->add_field('emergency_phone_1', '電話番号1', 'valid_string[numeric]|max_length[45]');
				$val->add_field('emergency_cellular_1', '電話番号2', 'valid_string[numeric]|max_length[45]');
				$val->add_field('emergency_first_name_2', 'お名前 名', 'max_length[45]');
				$val->add_field('emergency_last_name_2', 'お名前 姓', 'max_length[45]');
				$val->add_field('emergency_first_kana_2', 'ふりがな 名', 'hiragana|max_length[45]');
				$val->add_field('emergency_last_kana_2', 'ふりがな 姓', 'hiragana|max_length[45]');
				$val->add_field('emergency_phone_2', '電話番号1', 'valid_string[numeric]|max_length[45]');
				$val->add_field('emergency_cellular_2', '電話番号2', 'valid_string[numeric]|max_length[45]');
				$val->add_field('last_name', 'お名前 姓', 'max_length[45]');
				$val->add_field('first_name', 'お名前 名', 'max_length[45]');
				$val->add_field('last_kana', 'ふりがな 姓', 'hiragana|max_length[45]');
				$val->add_field('first_kana', 'ふりがな 名', 'hiragana|max_length[45]');
				$val->add_field('email', 'メールアドレス', 'valid_email|max_length[512]');
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
			'master',
			'affiliate'
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
			$ret['birthday_display'] = date('Y年m月d日', strtotime($ret['birthday']));
		} else {
			$ret['age'] = null;
		}

		if(isset($ret['gender'])) {
			$gender = Config::get("gender");
			$ret['gender_display'] = $gender[$ret['gender']];
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
				$user = $row->to_array();
				if($user['admin']['master'] != 1) {
					$users[] = \Model_User::format($user['admin']);
				}
			}
		} else {
			$rows = \Model_User::find("all", array(
				'where' => array(
					'admin' => 1,
				)
			));
			foreach($rows as $row) {
				$users[] = \Model_User::format($row);
			}			
		}
		return $users;
	}

	public static function getSearch($params) {
		$query = \Model_User::query();
		if(isset($params['admin'])) {
			$query->where('admin', '=', $params['admin']);
		}
		if(isset($params['query'])) {
			$query->and_where_open()
				  ->or_where_open()
				  ->where('last_name', 'LIKE', '%'.$params['query'].'%')
				  ->or_where_close()
				  ->or_where_open()
				  ->where('first_name', 'LIKE', '%'.$params['query'].'%')
				  ->or_where_close()
				  ->or_where_open()
				  ->where('last_kana', 'LIKE', '%'.$params['query'].'%')
				  ->or_where_close()
				  ->or_where_open()
				  ->where('first_kana', 'LIKE', '%'.$params['query'].'%')
				  ->or_where_close()
				  ->and_where_close();
		}
		if(isset($params['limit'])) {
			$query->limit($params['limit']);
			if(isset($params['page'])) {
				$query->offset($params['limit'] * ($params['page'] - 1));
			}
		}
		$rows = $query->order_by('id', 'desc')->from_cache(false)->get();
		$users = array();
		foreach($rows as $row) {
			$users[] = \Model_User::format($row);
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
	
	public static function getTempUserFromEmail($email){
		return \Model_User::find("first", array(
			'where' => array(
				'email' => $email,
				'email_confirm' => 0
			)
		));
	}

	public static function getOtherUserByEmail($email){
		list($tmp, $user_id) = Auth::get_user_id();
		$user = \Model_User::find("first", [
			'where' => [
				['id', "!=", $user_id],
				'email' => $email,
			]
		]);
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
			'max_size' => Config::get('img_config.properties.size')*1024*1024, //MB->byte
			'ext_whitelist' => Config::get('img_config.properties.type'),
			);
		$result = ['error' => false, 'data' => null];
		Lang::load('validation', 'validation');
		try {
			Upload::process($config);
			if (Upload::is_valid())
			{
				Upload::save();
				$files = Upload::get_files();
				$result['data'] = $files[0]['saved_as'];
				return $result;
			}
			// エラー有り
			foreach (Upload::get_errors() as $file)
			{
				$error = $file['errors'][0];
				$error_code = $error['error'];
				return self::getUploadErrorCode($error_code);
			}
		} catch (Exception $e) {
			Log::error($e->getMessage());
			return  ['error' => true, 'data' => Lang::get('validation.image_upload_false')];
		}
	}
	/**
	 * getUploadErrorCode function
	 *
	 * @param [int] $error_code
	 * @return [array] $result
	 */
	private function getUploadErrorCode($error_code) {
		$img_upload_error = Config::get("img_config.upload_error");
		if (array_key_exists($error_code, $img_upload_error)) {
			$msg = $img_upload_error[$error_code];
			if (empty($msg)) $error = false;
			else $error = true;
		} else {
			$error = true;
			$msg = Lang::get('validation.image_upload_false');
		}
		return ['error' => $error, 'data' => $msg];
	}

	public static function saveEmail($params) {
		$params['username'] = sha1($params['email'].mt_rand());
		$params['password'] = sha1($params['email'].mt_rand());
		$params['admin'] = 1;
		$id = Auth::create_user(
                $params['username'],
                $params['password'],
                $params['email']);
		$params['email_confirm'] = 0;
		$params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day"));
		$params['email_confirm_token'] = sha1($params['email'].$params['email_confirm_expired'].mt_rand());
		
		//新規のときだけアフィリエイトを登録
		if(!empty(Cookie::get("affiliate"))) {
			$params['affiliate'] = Cookie::get("affiliate"); 
			Cookie::delete("affiliate");
		}

		$user = \Model_User::find($id);
		unset($params['id']);
		unset($params['username']);
		unset($params['password']);
		unset($params['email']);
		if($user) {
			$user->set($params);
			if($user->save()) {
				return \Model_User::format($user);
			}			
		}
		return null;
	}

	public static function saveUser($params) {
		return \Model_User::saveAdminUser($params);
	}

	public static function saveAdminUser($params)
	{
	  if (isset($params['id'])) {
		$id = $params['id'];
	  } else {
		if (empty($params['username'])) {
		  $params['username'] = sha1($params['email'] . mt_rand());
		}
		if (!isset($params['admin'])) {
		  $params['admin'] = 1;
		}
		$id = Auth::create_user(
			$params['username'],
			$params['password'],
			$params['email']);
		$params['email_confirm'] = 0;
		$params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day"));
		$params['email_confirm_token'] = sha1($params['email'] . $params['email_confirm_expired'] . mt_rand());
		//新規のときだけアフィリエイトを登録
		if (!empty(Cookie::get("affiliate"))) {
		  $params['affiliate'] = Cookie::get("affiliate");
		  Cookie::delete("affiliate");
		}
	  }
	  
	  $user = \Model_User::find($id);
	  unset($params['id']);
	  unset($params['username']);
	  unset($params['password']);
	  unset($params['email']);
	  if ($user) {
		$user->set($params);
		if ($user->save()) {
		  //センサーを保存
		  $params['user_id'] = $user['id'];
		  \Model_User::saveSensor($params);
		  return \Model_User::format($user);
		} else {
		  return null;
		}
	  }
	}
 
	public static function updateUser($params) {
		$user = \Model_User::find($params['id']);
		$old_password = Auth::reset_password($user['username']);
		Auth::change_password($old_password, $params['password'], $user['username']);
		unset($params['id']);
		unset($params['password']);
		$user->set($params);
		if($user->save()) {
		  return \Model_User::format($user);
		} else {
		  return null;
		}
	}
	
	public static function updateTempUser($params) {
		$user = \Model_User::getTempUserFromEmail($params['email']);
		$old_password = Auth::reset_password($user['username']);
		Auth::change_password($old_password, $params['password'], $user['username']);
		$params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day"));
		unset($params['password']);
		$user->set($params);
		
		if($user->save()) {
			return \Model_User::format($user);
		} else {
			return null;
		}
	}
	
        /*
         * 管理画面から親アカウント登録
         *
         * @access public.static
         * @params array $params
         * @return array $user
         */
        public static function saveUserWithAdmin(array $params)
        {
            try {
                return self::authCreateUser($params);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        
        /*
         * 管理画面から見守られユーザー登録
         * 
         * @param int $user_id
         * @param array $params
         */
        public static function saveClientUserWithAdmin($user_id, array $params)
        {
            try {
                $user = self::authCreateUser($params);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
            
            try {
                \Model_User_Client::createUserClient([
                    'user_id' => $user_id,
                    'client_user_id' => $user['id'],
                    'admin' => 1
                ]);
                
                return $user;
                    
            } catch (Exception $e) {
                throw new Exception('create user_clients failed. ['.$e->getMessage().']');
            }
        }
        
        /*
         * authCreateUser
         * Auth::create_user経由でusersへ登録後、他の項目をUPDATE
         * 
         * @access private.static
         * @params array $params
         * @return array $user
         */
        private static function authCreateUser(array $params)
        {
            if(isset($params['id'])) {
                $id = $params['id'];
            } else {
                if(!isset($params['email']) || empty($params['email'])) {
                    $params['email'] = sha1(mt_rand())."@example.com";
                }
                if(!isset($params['username']) || empty($params['username'])) {
                    $params['username'] = sha1($params['email'].mt_rand());
                }
                if(!isset($params['password']) || empty($params['password'])) {
                    $params['password'] = sha1(mt_rand());
                }
                if(!isset($params['email_confirm'])) {
                    $params['email_confirm'] = 0;
                }
                
                try {
                    $id = Auth::create_user(
                        $params['username'],
                        $params['password'],
                        $params['email'],
                        $params['email_confirm'],
                        $params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day")),
                        $params['email_confirm_token'] = sha1($params['email'].$params['email_confirm_expired'].mt_rand())
                    );
                } catch (Exception $e) {
                    throw new Exception('create_user failed. ['.$e->getMessage().']');
                }
                if(!isset($params['admin'])) {
                    $params['admin'] = 1;
                }                
            }
            
            try {
                foreach (['id', 'username', 'password', 'email'] as $key) {
                    unset($params[$key]);
                }
                
                $user = \Model_User::find($id);
                $user->set($params);
                $user->save();
 
                return \Model_User::format($user);
             } catch (Exception $e) {
                throw new Exception('create users failed. ['.$e->getMessage().']');
            }
        }
        
	public static function saveShareUser($params) {
		//連絡共有先人数を取得
		$admins = \Model_User::getAdmins($params['client_user_id']);
		if(count($admins) >= 3) {
			throw new Exception('連絡共有先は3人まで共有できます');
		}

		$params['username'] = sha1($params['email'].mt_rand());
		$params['password'] = sha1($params['email'].mt_rand());
		$user = \Model_User::getUserFromEmail($params['email']);
		list(, $user_id) = Auth::get_user_id();
		$admin = \Model_User::getUser($user_id);
		if(isset($user)) {
			$user = \Model_User::find($user['id']);
		} else {
			$id = Auth::create_user(
	                $params['username'],
	                $params['password'],
	                $params['email']);

			$params['email_confirm'] = 0;
			$params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day"));
			$params['email_confirm_token'] = sha1($params['email'].$params['email_confirm_expired'].mt_rand());
			unset($params['id']);
			unset($params['username']);
			unset($params['password']);
			unset($params['email']);
			$user = \Model_User::find($id);
			$user->set($params);
			if($user->save()) {
				$url = Uri::base(false)."user/email_confirm?".Uri::build_query_string(array(
					'token' => $user['email_confirm_token'],
				));
		        $data = array(
		        			'user'	   => $admin,
		                    'url'      => $url,
		                    'name'     => $user['last_name'].'　'.$user['first_name'],
		                    'date'     => date('Y年m月d日'),
		                    'address'  => $user['prefecture'].$user['address'],
		                    'phone'    => $user['phone'],
		                    'email'    => $user['email'],
		                );
				\Model_User::sendEmail(array(
					'to' => $user['email'],
					'subject' => "LASHIC サービスご利用、".$admin['last_name'].$admin['first_name']."様からのご招待",
					'text' => \View::forge('email/user/invite', $data)
				));
			}
		}

		if(isset($user) && isset($params)) {
			\Model_User::saveClients($user['id'], array($params['client_user_id'] => "true"));
			return \Model_User::format($user);	
		}
		return null;
	}

	//見守られユーザの自動作成
	public static function createClient($params) {
		list(, $user_id) = Auth::get_user_id();
		if($user_id)
		{
	        try {
	            $client_user_id = Auth::create_user(
	                    sha1(mt_rand()),	//username
	                    sha1(mt_rand()),	//password
	                    sha1(mt_rand())."@example.com"
	                );	//email

	            $client = \Model_User::find($client_user_id);

	            $client->set($params);
	            if($client->save()) {
	            	\Model_User::saveClients($user_id, array($client_user_id => "true"));	
	            }
	            return $client;
	        } catch (Exception $e) {
	            \Log::error(__METHOD__.'['.$e->getMessage().']');
	        }
		}

	}

	//見守られユーザの自動作成
	public static function createClientWithSensor($params) {
		$sensor_id = $params['id'];
		$sensor_name = $params['name'];

        $params = array(
            'username' => $sensor_id."-".$sensor_name,
            'password' => sha1($sensor_id."-".$sensor_name.mt_rand()),
            'email' => $sensor_id."-".$sensor_name."@example.com",
        );
        try {
            $user_id = Auth::create_user(
                    $params['username'],
                    $params['password'],
                    $params['email']);

            $client = \Model_User::find($user_id);
            $client->set(array(
                'admin' => 0,
                'memo' => $sensor_name,
            ));
            if($client->save()) {
	            $user_sensor = \Model_User_Sensor::forge();
	            $user_sensor->set(array(
	                'user_id' => $client->id,
	                'sensor_id' => $sensor_id,
	                'admin' => 0,
	            ));
	            $user_sensor->save();           	
            }

            return $client;
        } catch (Exception $e) {
        	print_r($e);
        	exit;
        }
	}

	public static function sendEmail($params)
	{
            if(empty($params['from'])) {
                $params['from'] = Config::get("email.from");
            }
            try {
                $sendgrid = new SendGrid(Config::get("sendgrid"));
                $email = new SendGrid\Email();
                $email
                        ->addTo($params['to'])
                        ->setFrom($params['from'])
                        ->setSubject($params['subject'])
                        ->setHtml($params['text']);

                return $sendgrid->send($email);
            } catch (Exception $e) {
                Log::error($e->getMessage(), 'sendEmail');
                return;
            }
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

	public static function changePassword($params)
	{
            if(!empty($params['id'])) {
                $id = $params['id'];
                $user = \Model_User::find($id);
            }
            if($user) {
                if(Auth::change_password($params['password'], $params['new_password'], $user['username'])) {
                    $params = [
                        'to' => $user['email'],
                        'subject' => "パスワードの変更が完了しました",
                        'text' => \View::forge(
                            'email/password_complete', [
                            'email' => $user['email'],
                            'name' => $user['last_name'].$user['first_name']
                        ])
                    ];
                    \Model_User::sendEmail($params);
                    return true;
                }
            }
            return false;
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
		        		'admin' => 0,
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

	public static function sendRegisterConfirmEmail($user) {
		$url = Uri::base(false)."user/email_confirm?".Uri::build_query_string(array(
			'token' => $user['email_confirm_token'],
		));
        $data = array(
                    'url'      => $url,
                    'date'     => date('Y年m月d日'),
                    'email'    => $user['email'],
                );
		$params = array(
			'to' => $user['email'],
			'subject' => "新規登録確認",
			'text' => \View::forge('email/register/email_confirm', $data)
		);
		return \Model_User::sendEmail($params);
	}

	public static function sendConfirmEmail($user) {
		$url = Uri::base(false)."user/email_confirm?".Uri::build_query_string(array(
			'token' => $user['email_confirm_token'],
		));
        $gender = Config::get("gender");
        $data = array(
                    'url'      => $url,
                    'name'     => $user['last_name'].'　'.$user['first_name'],
                    'date'     => date('Y年m月d日'),
                    'address'  => $user['prefecture'].$user['address'],
                    'phone'    => $user['phone'],
                    'email'    => $user['email'],
                );
        if(!empty($user['gender'])) { 
        	$data['gender'] = $gender[$user['gender']];
        }
        if(!empty($user['birthday'])) {
        	$data['birthday'] = date('Y年m月d日', strtotime($user['birthday']));
        }
		$params = array(
			'to' => $user['email'],
			'subject' => "新規登録確認",
			'text' => \View::forge('email/user/save_admin', $data)
		);
		return \Model_User::sendEmail($params);
	}

        /*
         * 同一親アカウントの見守られユーザーに紐づいているセンサー機器を除外したリストを取得
         * 
         *  @param int $user_id
         *  @return array $sensors
         */
        public function getUnselectedSensorList($user_id)
        {
            $rows = DB::select('*')
                        ->from(['user_sensors', 'us'])
                        ->join(['sensors', 's'], 'LEFT')
                        ->on('us.sensor_id', '=', 's.id')
                        ->where(DB::expr('us.sensor_id NOT IN ( SELECT t1.sensor_id FROM user_sensors AS t1 WHERE EXISTS ( SELECT * FROM user_clients AS t2 WHERE t2.user_id = us.user_id AND t1.user_id = t2.client_user_id ) AND t1.sensor_id = us.sensor_id AND t1.admin = 0 )'))
                        ->and_where('us.user_id', '=', $user_id)
                        ->execute()->as_array();

            foreach($rows as $row) {
                $row['id'] = $row['sensor_id'];
                unset($row['user_id']);
                unset($row['sensor_id']);
                if(isset($row['sensor'])) {
                    $sensor = $row['sensor'];
                    unset($row['sensor']);
                    $sensors[] = array_merge($sensor, $row);
                } else {
                    $sensors[] = $row;
                }			
            }
            return $sensors;
        }
        
        /*
         * センサーIDから紐づく見守られユーザーを取得する 
         * ・センサーと見守られユーザーは1:N
         * ・ただし同一親アカウントの見守られユーザー間で同じセンサーが紐づくことはない
         * 
         * @access public
         * @params int $sensor_id   センサー ID
         * @params int $user_id     親アカウントID
         * @return array[0]
         */
        public static function getClientUserWithUserSensors($sensor_id, $user_id)
        {
            $rows = DB::select('*')
                        ->from(['user_clients', 'uc'])
                        ->join(['user_sensors', 'us'], 'LEFT')
                        ->on('uc.client_user_id', '=', 'us.user_id')
                        ->join(['users', 'u'], 'LEFT')
                        ->on('uc.client_user_id', '=', 'u.id')
                        ->and_where('uc.user_id', '=', $user_id)
                        ->and_where('us.sensor_id', '=', $sensor_id)
                        ->execute()->as_array();
            return  reset($rows);
        }
}
