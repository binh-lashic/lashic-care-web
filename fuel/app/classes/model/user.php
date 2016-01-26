<?php 
class Model_User extends Orm\Model{

	public function getAdmins(){
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		return $res->as_array();
	}

	public function getUsers(){
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		return $res->as_array();
	}
}