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
		$user['sensors'] = \Model_User::getSensors($id);
		$user['clients'] = \Model_User::getClients($id);
		$user['admins'] = \Model_User::getAdmins($id);
		$user['client'] = $this->is_client($id);
		$this->result = array(
			'data' => $user
		);
 		return $this->result();
	}

	public function post_update() {
		return $this->_update();
	}

	public function get_update() {
		return $this->_update();
	}

	public function _update() {
		$param = Input::param();
		if(empty($param['id'])) {
			list(, $param['id']) = Auth::get_user_id();
		}
		$user = \Model_User::saveUser($param);
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
 		return $this->result(401);
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
			list(, $user_id) = Auth::get_user_id();
			$user = \Model_User::getUser($user_id);
			$clients = \Model_User::getClients($user_id);
			$user['client'] = $this->is_client($user_id);
			
			$this->result = array(
				'message' => 'ログインに成功しました',
				'data' => $user,
			);
		}
 		return $this->result();
	}
	/**
	 * 見守り対象ユーザー有無をフラグで返す
	 * @param $user_id
	 * @return int
	 */
	private function is_client($user_id){
		$clients = \Model_User::getClients($user_id);
		if(empty($clients)){
			return \Model_User::NO_CLIENT;
		} else {
			return \Model_User::EXIST_CLIENT;
		}
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
		if(!empty($username) && !empty($password)) {
			if (!Auth::login($username, $password)) {
				$this->errors[] = array(
					'message' => "ユーザー名かパスワードが間違っています",
					'data' => false,
				);
				return $this->result();
			} 
		}
		list($driver, $user_id) = Auth::get_user_id();
		if($user_id) {
			$params = array(
				'user_id' => $user_id,
				'device_id' => $device_id,
				'push_id' => Input::param("push_id"),
				'os' => Input::param("os"),
			);
			$res = \Model_Device::saveDevice($params);
			if($res) {
				$this->result = array(
					'message' => 'デバイスIDの設定に成功しました',
					'data' => true,
				);				
			}
		}
		return $this->result();
	}

	public function post_save_clients() {
		return $this->_save_clients();
	}

	public function get_save_clients() {
		return $this->_save_clients();
	}

	public function _save_clients() {
        $user_id = Input::param("user_id");
        $client_user_ids = Input::param("client_user_ids");
        if(\Model_User::saveClients($user_id, $client_user_ids)) {

        }
        return $this->result();
	}

	public function post_save_admin() {
		return $this->_save_admin();
	}

	public function get_save_admin() {
		return $this->_save_admin();
	}

	public function _save_admin() {
		try {
			$params = Input::param();
			if(!empty($params['email']) && !empty($params['client_user_id'])) {
		        $user = \Model_User::saveShareUser($params);
				$this->result = array(
					'data' => $user
				);
		    } else {
				$this->errors['query'] = "パラメーターが足りません";
		    }
		} catch(Exception $e) {
			$this->errors[get_class($e)] = $e->getMessage();
		}
		return $this->result();
	}
}
