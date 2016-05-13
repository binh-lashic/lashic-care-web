<?php
class Controller_Register extends Controller_Base
{
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'index',
	    );
	    $this->template = 'template';

	    parent::before();
	}

	public function action_index()
	{
		$this->data['eras'] = Config::get("eras");
        $this->data['prefectures'] = Config::get("prefectures");

		$this->template->title = 'Care Eye 新規登録  >  アカウント情報　入力';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('register/form', $this->data);
	}
}
