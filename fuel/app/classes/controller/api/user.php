<?php
class Controller_Api_User extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'api/user/login',
	        'api/user/login_error',
	        'api/user/login_check',
	        'api/user/register',
	    );
	    parent::before();
	}

	//ユーザデータを取得
	public function post_index() {
		return $this->login_check();
	}

	public function get_index() {
		return $this->login_check();
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

	public function get_register()
	{
		
		DB::query("DROP TABLE users")->execute();
		$sql = "CREATE TABLE users (
  id int NOT NULL IDENTITY (1, 1),
  username NVARCHAR(50),
  password NVARCHAR(255),
  name NVARCHAR(50),
  email NVARCHAR(512),
  profile_fields NVARCHAR(512),
  last_login NVARCHAR(512),
  login_hash NVARCHAR(512),
  created_at INT
) ON [PRIMARY];";
		DB::query($sql)->execute();

		$username = Input::param("username");
		$password = Input::param("password");
	    if (Input::param())
	    {
	    	try {
	    		if(Auth::create_user(
	                $username,
	                $password,
	                $username + 'ikko615@gmail.com'
            	)) {
				    $this->result = array('success' => true);
            	} else {
				    $this->result = array('success' => false);
            	}

	    	} catch(Exception $e) {
	    		$this->result = array('success' => false);
	    		$this->errors[] = array('message' => $e->getMessage());
	    	}
	    }
 		return $this->result();
	}	
}
