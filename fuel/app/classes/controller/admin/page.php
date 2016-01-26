<?php
class Controller_Admin_Page extends Controller_Template
{
	public function action_index()
	{
        $data = array();
        try {
        	$data['admins'] = Model_User::getAdmins();
        } catch(Exception $e) {
        	
        }
        
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/index', $data);
	}
}
