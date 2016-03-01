<?php
class Controller_User extends Controller_Page
{
	private $user;
	private $clients = array();
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'login',
	    );
	    parent::before();
	    if(empty($this->user)) {
			list(, $user_id) = Auth::get_user_id();
			$this->user = \Model_User::getUser($user_id);
			$clients = \Model_User::getClients($user_id);
			foreach($clients as $client) {
				$client['sensors'] = \Model_User::getSensors($client['id']);
				$now = date("Ymd");
				$birthday = date("Ymd", strtotime($client['birthday']));
				$client['age'] = (int)(floor((int)$now - (int)$birthday) / 10000);
				$this->clients[] = $client;
			}   	
	    }
	    $client = Session::get("client");
	    if(empty($client)) {
	    	$client = $this->clients[0];
	    }
	    $admins = \Model_User::getAdmins($client['id']);

	    $this->data = array(
	    	'user' => $this->user,
	    	'clients' => $this->clients,
	    	'client' => $client,
	    	'admins' => $admins,
	    );

	}

	public function action_index()
	{
		if(!empty($this->data['client']['id'])) {
			$sensors = \Model_User::getSensors($this->data['client']['id']);
			if(!empty($sensors)) {
				$this->data['sensor'] = $sensors[0];
				$this->data['data'] = \Model_Data::getLatestData($this->data['sensor']['name']);
			}
		}
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/index', $this->data);
        $this->template->footer = View::forge('footer', $this->data);
	}

	public function action_report()
	{
		$this->data['corresponding_status'] = Input::param("corresponding_status");
		$this->data['confirm_status'] = Input::param("confirm_status");
		if(!empty($this->data['client']['id'])) {
			$sensors = \Model_User::getSensors($this->data['client']['id']);
			if(!empty($sensors)) {
				$params = array('sensor_id' => $sensors[0]['id']);
				if($this->data['corresponding_status']) {
					$params['corresponding_status'] = $this->data['corresponding_status'];
				}
				if(!empty($this->data['confirm_status'])) {
					$params['confirm_status'] = $this->data['confirm_status'];
				}
				$this->data['alerts'] = \Model_Alert::getAlerts($params);
			}
		}
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/report', $this->data);
        $this->template->footer = View::forge('footer', $this->data);
	}

	public function action_login_form()
	{
        $data = array();
        $this->template->title = 'ログインページ';
        $this->template->content = View::forge('user/login');
	}

	public function action_login()
	{
		$username = Input::param("username");
		$password = Input::param("password");
		if (!Auth::login($username, $password)) {
        	$this->template->title = 'ログインページ';
        	$this->template->content = View::forge('user/login');			
		} else {
			list(, $user_id) = Auth::get_user_id();
			$user = \Model_User::getUser($user_id);
			Session::set('user', $user);
			Response::redirect('/user');		
		}
	}

	public function action_logout()
	{
		Auth::logout();
		Response::redirect('/user/login');
	}

	public function action_setting()
	{
        $data = array();
        $this->template->title = '設定ページ';
        $this->template->content = View::forge('user/setting');
	}
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
