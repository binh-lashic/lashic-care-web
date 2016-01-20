<?php
class Controller_User extends Controller
{
	public function action_index()
	{
		return Response::forge(View::forge('user/index'));
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
