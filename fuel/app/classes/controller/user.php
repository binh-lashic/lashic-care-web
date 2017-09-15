<?php
class Controller_User extends Controller_Base
{
	private $user;
	private $clients = array();
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'login',
	        'email_confirm'
	    );
	    parent::before();
	    if(empty($this->user)) {
			list(, $user_id) = Auth::get_user_id();
			$this->user = \Model_User::getUser($user_id);
			if($this->user['master'] == 1) {
            	Session::set('master', 1);
				$clients = \Model_User::getClients();
			} else {
				$clients = \Model_User::getClients($user_id);
			}
			foreach($clients as $client) {
				$client['sensors'] = \Model_User::getSensors($client['id']);
				$this->clients[] = $client;
			}   	
	    }

	    $this->data = array(
	    	'user' => $this->user,
	    	'clients' => $this->clients,
	    );

        if(Input::param("set_client_id")) {
        	$client_id = Input::param("set_client_id");
			Session::set("client_id", $client_id);
        } else {
        	$client_id = Session::get("client_id");	
        }

	    if(empty($client_id ) && isset($this->clients[0])) {
	    	$client = $this->clients[0];
	    } else {
	    	$client = \Model_User::getUser($client_id);
	    }

    	$this->data['client'] = $client;
	    $this->data['admins'] = \Model_User::getAdmins($client['id']);

	    if(Input::param("page")) {
	    	$this->data['page'] = Input::param("page");
	    } else {
	    	$this->data['page'] = 1;
	    }
	    $this->data['next_page'] = $this->data['page'] + 1;
	    $this->data['prev_page'] = $this->data['page'] - 1;

		# ログインユーザに紐付く見守られユーザが存在する場合
		if(isset($this->data['client']['id'])) {
			\Log::debug("login user_id:[{$this->user['id']}] client_id:[{$this->data['client']['id']}]", __METHOD__);
			$sensors = \Model_User_Sensor::getAllSensorByShippingDate($this->data['client']['id'], date('Y-m-d'));
			if(!empty($sensors)) {
				\Log::debug("client_id:[{$this->data['client']['id']}] sensors:" . print_r($sensors, true), __METHOD__);
				foreach($sensors as $sensor) {
					switch($sensor['type']) {
						case \Model_Sensor::TYPE_SENSOR:
							if (!isset($this->data['sensor'])) { // 一つ目の要素を採用
								$this->data['sensor'] = $sensor;
							}
							break;
						case \Model_Sensor::TYPE_BED_SENSOR:
							if (!isset($this->data['bedsensor'])) { // 一つ目の要素を採用
								$this->data['bedsensor'] = $sensor;
							}
							break;
						default:
							\Log::warning("unknown sensor type:[{$sensor['type']}] login user_id:[{$this->user['id']}] client_id:[{$this->data['client']['id']}]", __METHOD__);
					}
				}
				$params = array(
					'sensor_id'      => $this->data['sensor']['id'],
					'limit'          => Config::get("report_list_count"),
					'confirm_status' => 0,
				);
				$this->data['header_alerts'] = \Model_Alert::getAlerts($params);
				$params = array(
					'sensor_id'      => $this->data['sensor']['id'],
					'confirm_status' => 0,
				);
				$this->data['header_alert_count'] = \Model_Alert::getAlertCount($params);
			} else {
				\Log::warning("client_id:[{$this->data['client']['id']}] sensors are not assigned.", __METHOD__);
			}
		} else {
			\Log::warning("login user_id:[{$this->user['id']}] client_id is not set.", __METHOD__);
		}

		$this->data['genders'] = Config::get("gender");
		$this->data['tax_rate'] = Config::get("tax_rate");
	}

	public function action_index()
	{
		if(count($this->data['clients']) == 0 && count(Session::get("plans")) > 0) {
			Response::redirect('/shopping/cart');
		}
	    if(Input::param("date")) {
	    	$this->data['date'] = Input::param("date");
	    } else {
	    	$this->data['date'] = date("Y-m-d");
	    }

	    if(Input::param("temperature")) {
	    	$this->data['temperature'] = true;
	    } 
	    if(Input::param("humidity")) {
	    	$this->data['humidity'] = true;
	    } 
	    if(Input::param("illuminance")) {
	    	$this->data['illuminance'] = true;
	    } 	  
	    if(Input::param("active")) {
	    	$this->data['active'] = true;
	    }   
	    if(Input::param("wake_up_time")) {
	    	$this->data['wake_up_time'] = true;
	    }   
	    if(Input::param("sleep_time")) {
	    	$this->data['sleep_time'] = true;
	    }   

	    $this->data['prev_date'] = date("Y-m-d", strtotime($this->data['date']) - 60 * 60 * 24);
	    $this->data['next_date'] = date("Y-m-d", strtotime($this->data['date']) + 60 * 60 * 24);

		$this->data['current_language'] = $this->language;

		$this->template->title   = 'マイページ';
		$this->template->header  = View::forge('header_client', $this->data);
		$this->template->content = View::forge('user/index', $this->data);
		$this->template->content->set('i18n', View::forge('i18n', $this->data));
		$this->template->sidebar = View::forge('sidebar', $this->data);
	}

	public function action_list()
	{
        $this->template->title = 'マイページ';
        $results = \Model_Contract::getClients(array("user_id" => $this->user->id));
        $contracts = array();
        foreach($results as $contract) {
        	if(empty($contracts[$contract['client_user_id']])) {
        		$contracts[$contract['client_user_id']] = array();
        	}
        	$contracts[$contract['client_user_id']][] = $contract;
        }
        foreach($this->data['clients'] as $key => $client) {
        	if(is_object($client)) {
	        	$this->data['clients'][$key] = $client->to_array();
	        	if(empty($contracts[$client['id']])) {
	        		$this->data['clients'][$key]['contracts'] = array();
	        	} else {
	        		$this->data['clients'][$key]['contracts'] = $contracts[$client['id']];
	        	}        		
        	}
        }
        
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/list', $this->data);
	}

	public function action_account()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/account', $this->data);
    }

	public function action_account_basic_form()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->data['eras'] = Config::get("eras");
        $this->data['prefectures'] = Config::get("prefectures");
        
        $this->template->header = View::forge('header_client', $this->data);

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
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/account_basic_complete', $this->data);
    }

    public function action_account_mail_form()
    {
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = [$this->template->title];
        
        $this->template->header = View::forge('header_client', $this->data);

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
        	if(Model_User::getOtherUserByEmail(Input::post('new_email'))) {
        		$this->data['errors']['email_duplicate'] = true;
        	}
                
        	$this->data['data'] = Input::post();
        	if(count($this->data['errors']) === 0) {
	    		$this->template->content = View::forge('user/account_mail_confirm', $this->data);
        		return;
        	}
        }
        
        $this->template->content = View::forge('user/account_mail_form', $this->data);
    }

    public function action_account_mail_complete()
    {
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = [$this->template->title];
        $this->data['data'] = Input::post();
        
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = Presenter::forge('account_mail_complete', 'view', null, 'user/account_mail_complete')
                ->set('data', $this->data['data']);
    }

    public function action_email_complete()
    {
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = [$this->template->title];
        
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = Presenter::forge('account_mail_success', 'view', null, 'user/email_complete' )
                ->set('token', Input::Param('token'));
    }
    
    public function action_account_password_form()
	{
        $this->template->title = 'マイページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        
        $this->template->header = View::forge('header_client', $this->data);
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
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/account_password_complete', $this->data);
    }

	public function action_info()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/info', $this->data);
    }

	public function action_info_basic_form()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header_client', $this->data);

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
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/info_basic_complete', $this->data);
    }

	public function action_info_contact_form()
	{
		$this->template->title = 'マイページ';
		$this->template->header = View::forge('header_client', $this->data);

		$this->data['prefectures'] = Config::get("prefectures");
		if(Input::post()) {
		    $params = Input::post();
			$this->data['data'] = $params;
        	$this->template->content = View::forge('user/info_contact_confirm', $this->data);
        	return;
        }
        $this->template->content = View::forge('user/info_contact_form', $this->data);
    }

    public function action_info_contact_complete() {
    	$this->template->title = 'マイページ';

        if(Input::post()) {
        	\Model_User::saveUser(Input::post());
        }
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('user/info_contact_complete', $this->data);
    }
    
	public function action_info_option_form()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header_client', $this->data);

		if(Input::post()) {
		    $params = Input::post();
			$this->data['data'] = $params;
        	$this->template->content = View::forge('user/info_option_confirm', $this->data);
        	return;
        }

        $this->template->content = View::forge('user/info_option_form', $this->data);
    }

	public function action_info_option_complete()
	{
        $this->template->title = 'マイページ';
        $this->template->header = View::forge('header_client', $this->data);

		if(Input::post()) {
		    $params = Input::post();
		    $client_params = array(
		    	'id'					 => $params['client_user_id'],
				'emergency_first_name_1' => $params['emergency_first_name_1'],
				'emergency_last_name_1'  => $params['emergency_last_name_1'],
				'emergency_first_kana_1' => $params['emergency_first_kana_1'],
				'emergency_last_kana_1'  => $params['emergency_last_kana_1'],
				'emergency_phone_1'      => $params['emergency_phone_1'],
				'emergency_cellular_1'   => $params['emergency_cellular_1'],
				'emergency_first_name_2' => $params['emergency_first_name_2'],
				'emergency_last_name_2'  => $params['emergency_last_name_2'],
				'emergency_first_kana_2' => $params['emergency_first_kana_2'],
				'emergency_last_kana_2'  => $params['emergency_last_kana_2'],
				'emergency_phone_2'      => $params['emergency_phone_2'],
				'emergency_cellular_2'   => $params['emergency_cellular_2'],
		    );
		    $client_user = \Model_User::saveUser($client_params);

		    if(!empty($params['email'])) {
			    $admin_params = array(
			    	'last_name' => $params['last_name'],
			    	'first_name' => $params['first_name'],
			    	'last_kana' => $params['last_kana'],
			    	'first_kana' => $params['first_kana'],
			    	'email' 	=> $params['email'],
			    	'client_user_id' => $params['client_user_id'],
			    );		    	
			    $admin_params['admin'] = 0;
		        $admin_params['password'] = sha1(mt_rand());
		        try { 
			        $admin_user = \Model_User::saveShareUser($admin_params);
		        } catch(Exception $e) {
		        	$this->data['errors']['users_count'] = $e->getMessage();
		        	$this->template->content = View::forge('user/info_option_form', $this->data);
		        	return;
		        }
		    }


        }

        $this->template->content = View::forge('user/info_option_complete', $this->data);
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
        $this->template->header = View::forge('header_client', $this->data);
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
		$username = Input::post("username");
		$password = Input::post("password");
		$data = array();
		if(Input::post()) {

			if (Auth::login($username, $password)) {
				list(, $user_id) = Auth::get_user_id();
				$user = \Model_User::getUser($user_id);
				Session::set('user', $user);
				Session::delete('client_id');
				Response::redirect('/user');		
			} else {
	        	$data['error'] = true;
			}			
		}
    	$this->template->title = 'ログインページ';
    	$this->template->content = View::forge('user/login', $data);			
	}

	public function action_logout()
	{
		Auth::logout();
		Session::delete('client_id');
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

		\Log::debug('params:' . print_r($params, true), __METHOD__);
        $this->data['sensor'] = \Model_User_Sensor::getUserSensor($params);
		\Log::debug(DB::last_query(), __METHOD__);
		\Log::debug('$this->data:' . print_r($this->data, true), __METHOD__);

        $this->template->header = View::forge('header_client', $this->data);
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

	public function action_email_confirm() {
		$user = \Model_User::find("first", array(
			'where' => array(
				'email_confirm_token' => Input::param("token"),
				array('email_confirm_expired', ">", date("Y-m-d H:i:s"))
			)
		));
		$user->set(array(
			"email_confirm" => 1,
			//"email_confirm_token" => null,
			//"email_confirm_expired" => null,
		));
		if($user->save()) {
			\Auth::force_login($user['id']);
			Response::redirect('/user');
		}
	}

	public function action_payment()
	{
        $data = array();
        $this->template->title = '購入・支払い履歴ページ';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->data['payments'] = \Model_Payment::find("all", array(
        	"where" => array(
        		'user_id' => $this->user['id'],
        	)
        ));
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/payment', $this->data);
	}

	public function action_contract()
	{
        $data = array();
        $this->template->title = '契約詳細確認ページ';
        $this->data['breadcrumbs'] = array($this->template->title);

	    $this->data['contract'] = \Model_Contract::find(Input::param("id"), array('related' => array(
	    	'plan' => array(
	    		'related' => array('options')
	    	)
	    )));
        $this->data['contract'] = $this->data['contract']->to_array();
        $this->data['contract_user'] = \Model_User::find($this->data['contract']['client_user_id']);

        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('user/contract', $this->data);
	}
        
        /*
         * マンスリーレポート 
         * 
         * @access public
         * @return none
         */
        public function action_monthly()
        {
            $this->template->title = 'マンスリーレポート ';
            $this->template->header = View::forge('header_client', $this->data);
            $this->template->content = Presenter::forge('user/monthly')
                                        ->set('data', $this->data);
            $this->template->content->set('i18n', View::forge('i18n', $this->data));
            $this->template->sidebar = View::forge('sidebar', $this->data);
        }                
}
