<?php
class Controller_Page extends Controller_Template
{
	public function action_index()
	{
        $data = array();
        try {
        } catch(Exception $e) {

        }
        
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/page/index', $data);
	}
}