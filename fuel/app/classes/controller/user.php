<?php
class Controller_User extends Controller_Template
{

	public function action_index()
	{
        $data = array();
        $this->template->title = 'マイページ';
        $this->template->content = View::forge('user/index');
	}

	public function action_login()
	{
        $data = array();
        $this->template->title = 'ログインページ';
        $this->template->content = View::forge('user/login');
	}

	public function action_setting()
	{
        $data = array();
        $this->template->title = '設定ページ';
        $this->template->content = View::forge('user/setting');
	}
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
