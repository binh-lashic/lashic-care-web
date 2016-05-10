<?php
class Controller_Contact extends Controller_Base
{
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'index',
	    );
	    parent::before();
	}

	public function action_index()
	{
        $this->template->title = 'お問い合わせ';
        $this->data['breadcrumbs'] = array($this->template->title);
       	$this->template->header = View::forge('header', $this->data);
        if(Input::post())
        {
        	if(!Input::post("name"))
        	{
        		$this->data['errors']['name'] = true;
        	}

        	if(!Input::post("kana"))
        	{
        		$this->data['errors']['kana'] = true;
        	}

         	if(!Input::post("email"))
        	{
        		$this->data['errors']['email'] = true;
        	}

        	if(Input::post("email") != Input::post("email_confirm"))
        	{
        		$this->data['errors']['email_confirm'] = true;
        	}

        	if(!Input::post("phone"))
        	{
        		$this->data['errors']['phone'] = true;
        	}

        	if(!Input::post("detail"))
        	{
        		$this->data['errors']['detail'] = true;
        	}
        	$this->data['data'] = Input::post();
        	//エラーが無ければ確認ページを表示
        	if(empty($this->data['errors']))
        	{
        		$this->template->content = View::forge('contact/confirm', $this->data);
        		return;
        	}
        }
        $this->template->content = View::forge('contact/form', $this->data);
	}

	public function action_complete()
	{
        $this->template->title = 'お問い合わせ';
        $this->data['breadcrumbs'] = array($this->template->title);
       	$this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('contact/complete', $this->data);
	}
}
