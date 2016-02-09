<?php
class Controller_Admin_User extends Controller_Template
{
	public function action_index() {
        $data = array();
        try {
        	$data['admins'] = Model_User::getAdmins();
        	$id = Input::param("id");
        	if($id) {
        		$data['user'] = Model_User::getUser($id);
        	}
        } catch(Exception $e) {

        }
        
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/user/index', $data);
	}

	public function action_save() {
		$user = Model_User::saveUser(Input::param());
		if($user) {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('admin/user/index');	
		} else {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('admin/user/index');	
		}
	}
}