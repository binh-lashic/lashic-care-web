<?php
class Controller_Admin_User extends Controller_Template
{

	public function action_list() {
		$data['admins'] = Model_User::getAdmins();
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('user/index', $data);
	}
}