<?php
class Controller_Admin_User extends Controller_Template
{

	public function action_list() {
 		return Response::forge(View::forge('admin/user/list'));
	}
}