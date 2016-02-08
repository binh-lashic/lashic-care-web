<?php 
class Model_Device extends Orm\Model{

	public static function createTable(){
		$sql = "CREATE TABLE devices (
  id int NOT NULL IDENTITY (1, 1),
  user_id INT,
  device_id NVARCHAR(255)
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function saveDevice($user_id, $device_id) {
		$sql = "SELECT * FROM devices WHERE user_id = :user_id AND device_id = :device_id;";
		$query = DB::query($sql);
		$query->parameters(array('user_id' => $user_id, 'device_id' => $device_id));
		$res = $query->execute();
		if($res[0]) {
			throw new Exception("既にデバイスは登録されています。");
		} else {
			$sql = "INSERT INTO devices (user_id, device_id) VALUES (:user_id, :device_id);";
			$query = DB::query($sql);
			$query->parameters(array('user_id' => $user_id, 'device_id' => $device_id));
			$res = $query->execute();			
			return $res;
		}
	}

	public static function existDevice($device_id) {
		$sql = "SELECT * FROM devices WHERE device_id = :device_id;";
		$query = DB::query($sql);
		$query->parameters(array('device_id' => $device_id));
		$res = $query->execute();
		if($res[0]) {
			return $res[0]->user_id;
		} else {		
			return null;
		}
	}
}