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
		$user = $res[0];
		if($user) {
			unset($user['password']);
			unset($user['last_login']);
			unset($user['login_hash']);
			unset($user['created_at']);
			unset($user['profile_fields']);
			return $user;
		} else {
			return null;
		}	
	}

	public static function saveUser($params) {
		if(empty($params['email'])) {
			$params['email'] = $params['username'];
		}
		try {
			if($id = Auth::create_user(
		                $params['username'],
		                $params['password'],
		                $params['email'])) {
			} else if($params['id']) {
				$id = $params['id'];
			} else {

			}
			$user = \Model_User::find($id);
			unset($params['id']);
			unset($params['username']);
			unset($params['password']);
			unset($params['email']);
			$user->set($params);
			if($user->save()) {
				return $user;
			} else {
				return null;
			}
		} catch(Exception $e) {

		}


	}
}