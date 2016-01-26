<?php
class Controller_Admin_Page extends Controller
{
	public function action_index()
	{
		return Response::forge(View::forge('admin/index'));
	}
}
