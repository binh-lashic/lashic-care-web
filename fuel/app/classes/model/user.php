<?php 
class Model_User extends Orm\Model{

	public static function getAdmins(){
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		return $res->as_array();
	}

	public static function getUsers(){
		$sql = "SELECT * FROM users;";
		$res = DB::query($sql)->execute();
		return $res->as_array();
	}

	public static function getUser($id){
		$sql = "SELECT * FROM users WHERE id = :id;";
		$query = DB::query($sql);
		$query->parameters(array('id' => $id));
		$res = $query->execute();
		if($res[0]) {
			return $res[0];
		} else {
			return null;
		}	
	}

	public static function setDeviceId($id){
		$sql = "UPDATE users SET device_id WHERE id = :id;";
		$query = DB::query($sql);
		$query->parameters(array('id' => $id));
		$res = $query->execute();
		if($res[0]) {
			return $res[0];
		} else {
			return null;
		}	
	}

}