<?php
class Controller_Admin_User extends Controller_Template
{
	public function action_list() {
		$data['admins'] = Model_User::getAdmins();
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('user/index', $data);
	}

	public function action_save() {
		print_r(Input::param());

exit;
		$user = Model_User::saveUser(Input::param());
		if($user) {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('user/index');	
		} else {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('user/index');	
		}
	}
}