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

/*
	public static function saveUser($params) {

		if(isset($params['id'])) {
			$sql = "UPDATE users (username, password, email, gender, kana, phone, mobile, work_start_date, memo) VALUES (:username, :password, :email, :gender, :kana, :phone, :mobile, :work_start_date, :memo);";
			$query = DB::query($sql);
			$query->parameters(array(
				'username' => $params['username'],
				'password' => $params['password'],
				'email' => $params['email'],
				'gender' => $params['gender'],
				'kana' => $params['kana'],
				'phone' => $params['phone'],
				'mobile' => $params['mobile'],
				'work_start_date' => $params['work_start_date'],
				'memo' => $params['memo'],
			));
		} else {
			$sql = "INSERT users (username, password, email, gender, kana, phone, mobile, work_start_date, memo) VALUES (:username, :password, :email, :gender, :kana, :phone, :mobile, :work_start_date, :memo);";
			$query = DB::query($sql);
			$query->parameters(array(
				'username' => $params['username'],
				'password' => $params['password'],
				'email' => $params['email'],
				'gender' => $params['gender'],
				'kana' => $params['kana'],
				'phone' => $params['phone'],
				'mobile' => $params['mobile'],
				'work_start_date' => $params['work_start_date'],
				'memo' => $params['memo'],
			));			
		}

		$res = $query->execute();
		if($res) {
			return $res;
		} else {
			return null;
		}
	}
	*/
}