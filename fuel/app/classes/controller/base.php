<?php
class Controller_Base extends Controller_Template
{
    //デフォルトのテンプレートのViewファイル
    public $template = 'template';

	protected $nologin_methods = array();

	public function before()
	{
	    $method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods))
	    {
            if($method === "login") {
                $this->template = 'template_nologin';
            }
		}
		else if (!Auth::check())
		{
	    	Response::redirect('/user/login');
		}
	    parent::before();
	}

}