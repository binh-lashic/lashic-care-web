<?php
class Controller_Admin_User extends Controller_Template
{
	public function action_list() {
		$data['admins'] = Model_User::getAdmins();
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('user/index', $data);
	}

	public function action_save() {
		$user = Model_User::forge();
	    $data = array(
					'username' => Input::param('username'),
					'password' => Input::param('password'),
					'email' => Input::param('email'),
					'gender' => Input::param('gender'),
					'kana' => Input::param('kana'),
					'phone' => Input::param('phone'),
					'mobile' => Input::param('mobile'),
					'work_start_date' => Input::param('work_start_date'),
					'memo' => Input::param('memo'),
				);
	    $user->set($data);
		if($user->save()) {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('user/index');	
		} else {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('user/index');	
		}
	}
}