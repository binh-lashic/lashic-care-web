<?php
class Controller_Page extends Controller_Template
{
    //デフォルトのテンプレートのViewファイル
    public $template = 'template';

	protected $nologin_methods = array();

	public function before()
	{
	    $method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods))
	    {     
	    	$this->template = 'template_nologin';
		}
		else if (!Auth::check())
		{
	    	Response::redirect('/user/login');
		}
	    parent::before();
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