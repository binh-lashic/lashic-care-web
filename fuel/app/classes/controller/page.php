<?php
class Controller_Page extends Controller_Template
{
	protected $nologin_methods = array();

	public function before()
	{
	    parent::before();
	    $method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods))
	    {     
		}
		else if (!Auth::check())
		{
	    	Response::redirect('/user/login');
		}
	}



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