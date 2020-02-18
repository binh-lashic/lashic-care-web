<?php 
class Model_Device extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'device_id',
		'os',
		'push_id'
	);

	public static function createTable(){
		$sql = "CREATE TABLE devices (
  id int NOT NULL IDENTITY (1, 1),
  user_id INT,
  device_id NVARCHAR(255)
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function saveDevice($params) {
		$device = \Model_Device::find("first", array(
			'where' => array(
					'device_id' => $params['device_id'],
				)
		));
		if(!$device) {
			$device = \Model_Device::forge();
		}
		$device->set($params);
		return $device->save();
	}

	public static function existDevice($device_id) {
		$device = \Model_Device::find('first', array(
			'where' => array(
				'device_id' => $device_id,
			)
		));
		
		if($device) {
			return $device['user_id'];
		} else {		
			return null;
		}
	}
}