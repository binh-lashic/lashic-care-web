<?php
class Controller_Admin_Page extends Controller_Template
{
	public function action_index()
	{
                $data = array();
                try {
                	$data['admins'] = Model_User::getAdmins();
                	$id = $this->param("id");
                	if($id) {
                		$data['user'] = Model_User::getUser($id);
                	}
                } catch(Exception $e) {

                }
                
                $this->template->title = '管理ページ トップ';
                $this->template->content = View::forge('admin/user/index', $data);
	}

        public function action_master()
        {
                $this->template->title = '管理ページ マスター';
                $this->template->content = View::forge('admin/page/master');
       