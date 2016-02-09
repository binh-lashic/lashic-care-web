<?php
class Controller_Api_User extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'login',
	        'login_error',
	        'login_check',
	        'register',
	        'test',
	        'set_device_id',
	    );
	    parent::before();
	}

	//ユーザデータを取得
	public function post_get() {
		return $this->_get();
	}

	public function get_get() {
		return $this->_get();
	}

	public function _get() {
		$id = Input::param('id');
		if(!$id) {
			list($driver, $id) = Auth::get_user_id();
		}
		$user = \Model_User::getUser($id);
		$this->result = array(
			'data' => $user
		);
 		return $this->result();
	}

	private function index() {
		if (!Auth::check()) {
		    $profile = Auth::get_profile_fields();
		} else {
			$this->result = array(
				'message' => 'ログインしています',
				'data' => true,
			);
		}
 		return $this->result();
	}



	//ユーザデータを取得
	public function post_list() {
		return $this->_list();
	}

	public function get_list() {
		return $this->_list();
	}

	private function _list() {
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		$this->result = $res->as_array();
 		return $this->result();
	}

	public function get_login_error() {
		$this->result = array(
			'message' => 'ログインをしていません',
		);
 		return $this->result();
	}

	//ログインチェック
	public function post_login_check() {
		return $this->login_check();
	}

	public function get_login_check() {
		return $this->login_check();
	}

	private function login_check() {
		if (!Auth::check())
		{
		    $this->result = array(
	    		'message' => 'ログインをしていません',
	    		'data' => false,
		    );
		} else {
			$this->result = array(
				'message' => 'ログインしています',
				'data' => true,
			);
		}
 		return $this->result();
	}

	//ログイン処理
	public function post_login() {
		return $this->login();
	}

	public function get_login() {
		return $this->login();
	}

	private function login() {
		$username = Input::param("username");
		$password = Input::param("password");
		if (!Auth::login($username, $password)) {
			$this->errors[] = array(
				'message' => "ユーザー名かパスワードが間違っています",
				'data' => false,
			);
		} else {
			$this->result = array(
				'message' => 'ログインに成功しました',
				'data' => true,
			);			
		}
 		return $this->result();
	}

	//ログアウト処理
	public function post_logout() {
		return $this->logout();
	}

	public function get_logout() {
		return $this->logout();
	}

	private function logout() {
		Auth::logout();
		return $this->result();		
	}

	public function get_test() {
		$sql = "CREATE LOGIN infic_api WITH password=‘2scHOVO6'; CREATE USER infic_api FROM LOGIN infic_api; EXEC sp_addrolemember ‘dbmanager‘, ‘infic_api; EXEC sp_addrolemember ‘loginmanager‘, ‘infic_api';";
		//$sql = "SELECT * FROM sysobjects WHERE xtype = 'u'";
		$sql = "SELECT * FROM data";
		$res = DB::query($sql)->execute();
		print_r($res);
		exit;
 		return $this->result();
	}

	//認証
	public function post_set_device_id() {
		return $this->set_device_id();
	}

	public function get_set_device_id() {
		return $this->set_device_id();
	}

	private function set_device_id() {
		$username = Input::param("username");
		$password = Input::param("password");
		$device_id = Input::param("device_id");
		if (!Auth::login($username, $password)) {
			$this->errors[] = array(
				'message' => "ユーザー名かパスワードが間違っています",
				'data' => false,
			);
		} else {
			list($driver, $user_id) = Auth::get_user_id();
			$res = \Model_Device::saveDevice($user_id, $device_id);
			if($res) {
				$this->result = array(
					'message' => 'デバイスIDの設定に成功しました',
					'data' => true,
				);				
			}
		}
		return $this->result();
	}
	
	public function get_register()
	{
		try {
			DB::query("DROP TABLE users")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE users (
  id int NOT NULL IDENTITY (1, 1),
  username NVARCHAR(50),
  password NVARCHAR(255),
  name NVARCHAR(50),
  kana NVARCHAR(512),
  email NVARCHAR(512),
  `group` INT(1),
  profile_fields NVARCHAR(512),
  last_login NVARCHAR(512),
  login_hash NVARCHAR(512),
  gender NCHAR(1),
  phone NVARCHAR(512),
  cellular NVARCHAR(255),
  work_start_date DATE,
  memo NTEXT,
  created_at INT
) ON [PRIMARY];";

		DB::query($sql)->execute();
		$username = Input::param("username");
		$password = Input::param("password");
		$email = $username;
	    if (Input::param())
	    {
	    	try {
	    		if(Auth::create_user(
	                $username,
	                $password,
	                $email
            	)) {
				    $this->result = array('success' => true);
            	} else {
				    $this->result = array('success' => false);
            	}

	    	} catch(Exception $e) {
	    		$this->result = array('success' => false);
	    		$this->errors[] = array('message' => $e->getMessage());
	    		$this->errors[] = array('message' => $email);
	    	}
	    }
 		return $this->result();
	}	
}
