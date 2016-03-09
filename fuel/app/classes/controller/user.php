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

	    $this->data = array(
	    	'user' => $this->user,
	    	'clients' => $this->clients,
	    );

	    $client = Session::get("client");
	    if(empty($client) && isset($this->clients[0])) {
	    	$client = $this->clients[0];
	    	$this->data['client'] = $client;
		    $this->data['admins'] = \Model_User::getAdmins($client['id']);
	    }

	    if(Input::param("date")) {
	    	$this->data['date'] = Input::param("date");
	    } else {
	    	$this->data['date'] = date("Y-m-d");
	    }
	    $is_today = false;
	    if($this->data['date'] == date("Y-m-d")) {
	    	$is_today = true;
	    }

	    $this->data['prev_date'] = date("Y-m-d", strtotime($this->data['date']) - 60 * 60 * 24);
	    $this->data['next_date'] = date("Y-m-d", strtotime($this->data['date']) + 60 * 60 * 24);

	    if(Input::param("page")) {
	    	$this->data['page'] = Input::param("page");
	    } else {
	    	$this->data['page'] = 1;
	    }
	    $this->data['next_page'] = $this->data['page'] + 1;
	    $this->data['prev_page'] = $this->data['page'] - 1;

	    if(!empty($this->data['client']['id'])) {
			$sensors = \Model_User::getSensors($this->data['client']['id']);
			if(!empty($sensors)) {
				$this->data['sensor'] = $sensors[0];
				$this->data['data_daily'] = \Model_Data_Daily::getData($this->data['sensor']['id'], $this->data['date']);

				$this->data['data_latest'] = \Model_Data_Daily::getData($this->data['sensor']['id'], date("Y-m-d", strtotime("-1day")));

				if($is_today) {
					$this->data['data'] = \Model_Data::getLatestData($this->data['sensor']['name']);					
				} else {
					if(!empty($this->data['data_daily']['temperature_average'])) {
						$this->data['data'] = array(
							'temperature' => $this->data['data_daily']['temperature_average'],
							'humidity' => $this->data['data_daily']['humidity_average'],
							'active' => $this->data['data_daily']['active_average'],
							'illuminance' => $this->data['data_daily']['illuminance_average'],
							'discomfort' => $this->data['data_daily']['discomfort_average'],
						);						
					}
				}

				//$this->data['data_daily'] = \Model_Data_Daily::getLatestData($this->data['sensor']['id']);
				$params = array(
					'sensor_id' => $this->data['sensor']['id'],
					'limit' => Config::get("report_list_count"),
				);
				$this->data['header_alerts'] = \Model_Alert::getAlerts($params);
			}
		}
	}

	public function action_index()
	{
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
				$params = array(
					'sensor_id' => $sensors[0]['id'],
					'limit' => Config::get("report_list_count"),
				);
				if(!empty($this->data['page'])) {
					$params['page'] = $this->data['page'];
				}
				if($this->data['corresponding_status']) {
					$params['corresponding_status'] = $this->data['corresponding_status'];
				}
				if(!empty($this->data['confirm_status'])) {
					$params['confirm_status'] = $this->data['confirm_status'];
				}
				$this->data['alerts'] = \Model_Alert::getAlerts($params);
				$this->data['alert_count'] = \Model_Alert::getAlertCount($params);
				$this->data['page_count'] = ceil($this->data['alert_count'] / Config::get("report_list_count"));
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
