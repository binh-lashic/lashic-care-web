<?php
class Controller_User extends Controller_Base
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
				$this->clients[] = $client;
			}   	
	    }

	    $this->data = array(
	    	'user' => $this->user,
	    	'clients' => $this->clients,
	    );

	    $client_id = Session::get("client_id");
	    if(empty($client_id ) && isset($this->clients[0])) {
	    	$client = $this->clients[0];
	    } else {
	    	$client = \Model_User::getUser($client_id);
	    }

    	$this->data['client'] = $client;
	    $this->data['admins'] = \Model_User::getAdmins($client['id']);

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

	    if(isset($this->data['client']['id'])) {
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
					'confirm_status' => 0,
				);
				$this->data['header_alerts'] = \Model_Alert::getAlerts($params);
				$params = array(
					'sensor_id' => $this->data['sensor']['id'],
					'confirm_status' => 0,
				);
				$this->data['header_alert_count'] = \Model_Alert::getAlertCount($params);
			}
		}
	}

	public function action_index()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/index', $this->data);
        $this->template->sidebar = View::forge('sidebar', $this->data);
	}

	public function action_list()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/list', $this->data);
	}

	public function action_account()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/account', $this->data);
    }

	public function action_account_basic_form()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->data['eras'] = Config::get("eras");
        $this->data['prefectures'] = Config::get("prefectures");
        
        $this->template->header = View::forge('header', $this->data);

        if(Input::post()) {
        	$val = \Model_User::validate("save");
        	if($val->run()) {
        		$params = Input::post();
				if(!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
					$params['birthday'] = $params['year']."-".$params['month']."-".$params['day'];
				}
				$this->data['data'] = $params;
        		$this->template->content = View::forge('user/account_basic_confirm', $this->data);
        		return;
        	} else {
        		$errors = $val->error();
        		foreach($errors as $key => $error) {
          			print_r($key);
        		}
        	}
        }

        if(empty($this->data['user']['birthday'])) {
        	$this->data['user']['year'] = "1945";
	        $this->data['user']['month'] = 1;
	        $this->data['user']['day'] = 1;
        } else {
	        $this->data['user']['year'] = date("Y", strtotime($this->data['user']['birthday']));
	        $this->data['user']['month'] = date("n", strtotime($this->data['user']['birthday']));
	        $this->data['user']['day'] = date("j", strtotime($this->data['user']['birthday']));
        }
        $this->template->content = View::forge('user/account_basic_form', $this->data);
    }

	public function action_account_basic_complete()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);

        if(Input::post()) {
        	\Model_User::saveUser(Input::post());
        }
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/account_basic_complete', $this->data);
    }

    public function action_account_mail_form()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        
        $this->template->header = View::forge('header', $this->data);

        if(Input::post()) {
        	$val = \Model_User::validate("save");
        	if(!Input::post('new_email')) {
        		$this->data['errors']['new_email'] = true;
        	}
        	if(!Input::post('new_email_confirm')) {
        		$this->data['errors']['new_email_confirm'] = true;
        	}
        	if(Input::post('new_email') != Input::post('new_email_confirm')) {
        		$this->data['errors']['new_email_confirm'] = true;
        	}
        	if(empty($this->data['errors'])) {
        		$this->data['data'] = Input::post();
	    		$this->template->content = View::forge('user/account_mail_confirm', $this->data);
        		return;
        	}
        	
			
			$this->data['data'] = Input::post();
    		$this->template->content = View::forge('user/account_mail_confirm', $this->data);
    		return;
        }
        $this->template->content = View::forge('user/account_mail_form', $this->data);
    }

	public function action_account_mail_complete()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);

        if(Input::post()) {
        	$params = Input::post();
        	$date = date("Y-m-d H:i:s", strtotime("+1day"));
        	$params['email_confirm_token'] = sha1($params['new_email'].$date);
        	$params['email_confirm_expired'] = $date;
        	\Model_User::saveUser($params);
        }
        $this->data['data'] = Input::post();
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/account_mail_complete', $this->data);
    }

    public function action_account_password_form()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        
        $this->template->header = View::forge('header', $this->data);
        if(Input::post()) {
         	if(!Input::post('password')) {
        		$this->data['errors']['password'] = true;
        	}
        	if(!Input::post('new_password')) {
        		$this->data['errors']['new_password'] = true;
        	}
        	if(!Input::post('new_password_confirm')) {
        		$this->data['errors']['new_password_confirm'] = true;
        	}
        	if(Input::post('new_password') != Input::post('new_password_confirm')) {
        		$this->data['errors']['new_password_confirm'] = true;
        	}
			$this->data['data'] = Input::post();
			if(empty($this->data['errors'])) {
	    		$this->template->content = View::forge('user/account_password_confirm', $this->data);
	    		return;
			}
        }
        $this->template->content = View::forge('user/account_password_form', $this->data);
    }

	public function action_account_password_complete()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);

        if(Input::post()) {
        	$params = Input::post();
        	$params['id'] = $this->user['id'];
        	\Model_User::changePassword($params);
        }
        $this->data['data'] = Input::post();
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/account_password_complete', $this->data);
    }

	public function action_info()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/info', $this->data);
    }

	public function action_info_basic_form()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);

		if(Input::post()) {
		    $params = Input::post();
			$params['profile_image'] = \Model_User::uploadProfileImage();
			if(!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
				$params['birthday'] = $params['year']."-".$params['month']."-".$params['day'];
			}
			$this->data['data'] = $params;
        	$this->template->content = View::forge('user/info_basic_confirm', $this->data);
        	return;
        }

		$this->data['eras'] = Config::get("eras");
        $this->data['blood_types'] = Config::get("blood_types");

        if(empty($this->data['client']['birthday'])) {
        	$this->data['client']['year'] = "1945";
	        $this->data['client']['month'] = 1;
	        $this->data['client']['day'] = 1;
        } else {
	        $this->data['client']['year'] = date("Y", strtotime($this->data['client']['birthday']));
	        $this->data['client']['month'] = date("n", strtotime($this->data['client']['birthday']));
	        $this->data['client']['day'] = date("j", strtotime($this->data['client']['birthday']));
        }
        $this->template->content = View::forge('user/info_basic_form', $this->data);
    }

    public function action_info_basic_complete() {
    	$this->template->title = 'マイページ';

        if(Input::post()) {
        	\Model_User::saveUser(Input::post());
        }
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/info_basic_complete', $this->data);
    }

	public function action_info_contact_form()
	{
		$this->template->title = 'マイページ';
		$this->template->header = View::forge('header', $this->data);

		$this->data['prefectures'] = Config::get("prefectures");
		if(Input::post()) {
		    $params = Input::post();
			$this->data['data'] = $params;
        	$this->template->content = View::forge('user/info_contact_confirm', $this->data);
        	return;
        }

        $this->template->title = 'マイページ';
        $this->template->content = View::forge('user/info_contact_form', $this->data);
    }

    public function action_info_contact_complete() {
    	$this->template->title = 'マイページ';

        if(Input::post()) {
        	\Model_User::saveUser(Input::post());
        }
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/info_contact_complete', $this->data);
    }
    
	public function action_info_option_form()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/info_option_form', $this->data);
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
				if(isset($this->data['confirm_status'])) {
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
        $this->template->sidebar = View::forge('sidebar', $this->data);
	}

	public function action_report_save()
	{
		$this->data['confirm_status'] = Input::param("confirm_status");
		$this->data['alerts'] = Input::post("alerts");
		list(, $user_id) = Auth::get_user_id();
		foreach($this->data['alerts'] as $alert_id) {
			$alert = \Model_Alert::find($alert_id);
			$params = array(
				'confirm_user_id' => $user_id,
				'confirm_status' => $this->data['confirm_status'],
			);
			$alert->set($params);
			$alert->save();
		}
		Response::redirect('/user/report');	
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

        $params = array(
        	'user_id' => $this->data['user']['id'],
        	'sensor_id' => $this->data['sensor']['id']
        );
        $this->data['user_sensor'] = \Model_User_Sensor::getUserSensor($params);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/setting', $this->data);
	}

	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}

	public function action_set_client() {
		$client_id = Input::param("id");
		Session::set("client_id", $client_id);
		Response::redirect('/user');
	}
}
