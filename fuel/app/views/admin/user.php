<?php
class Controller_Admin_User extends Controller
{

	public function list() {
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		$res->as_array();
 		return Response::forge(View::forge('admin/user/list'));
	}
}