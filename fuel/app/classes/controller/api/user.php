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
		return $this->list();
	}

	public function get_list() {
		return $this->list();
	}

	private function list() {
		$users = Model_User::find("all");
		$this->result = $users;
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
				'message' => "ユーザー名かパスワードが間違っています"
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
  username NVARCHAR(50),
  password NVARCHAR(255),
  email NVARCHAR(512),
  profile_fields NVARCHAR(512),
  last_login NVARCHAR(512),
  login_hash NVARCHAR(512),
  created_at INT
);";
		DB::query($sql)->execute();

		$username = Input::param("username");
		$password = Input::param("password");
	    if (Input::param())
	    {
            echo Auth::create_user(
                $username,
                $password,
                'ikko615@gmail.com'
            );
            exit;
            Session::set_flash('success','success create your account.');
	    }
	    $ret = array('success' => true);
 		return $this->result($ret);
	}	
}
