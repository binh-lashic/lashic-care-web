<?php
class Controller_Admin_Agent extends Controller_Admin
{
    
	public function action_list()
	{
        $params = array();
		$data['agents'] = \Model_Agent::getSearch($params);
        
        $this->template->title = '代理店実績管理';
        $this->template->content = View::forge('admin/agent/list', $data);
	}
}