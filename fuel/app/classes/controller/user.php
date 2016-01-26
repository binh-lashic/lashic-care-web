<?php
class Controller_User extends Controller_Template
{
	public function action_login()
	{
        $data = array();
        $this->template->title = 'ログインページ';
        $this->template->content = View::forge('user/index');
	}

	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
