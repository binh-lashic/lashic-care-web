<?php
class Controller_User extends Controller_Page
{

	public function before() {
		$this->nologin_methods = array(
	        'login',
	    );
	    parent::before();
	}

	public function action_index()
	{
		/*
        $data = array(
        	'data' => \Model_Data::query()->where('sensor_id', $sensor_id)->order_by('date', 'desc')->connection("data")->get_one(),
        	'sensor' => \Model_Sensor::getSensorFromSensorName($sensor_id),
        );
        */
        $this->template->title = 'マイページ';
        $this->template->content = View::forge('user/index');
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
