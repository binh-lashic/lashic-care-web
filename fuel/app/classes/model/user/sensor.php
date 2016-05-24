<?php 
class Model_User_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'sensor_id',
		'temperature_alert',
		'fire_alert',
		'heatstroke_alert',
		'humidity_alert',
		'mold_mites_alert',
		'illuminance_daytime_alert',
		'illuminance_night_alert',
		'wake_up_alert',
		'sleep_alert',
		'abnormal_behavior_alert',
		'active_non_detection_alert',
		'active_night_alert'
	);

	protected static $_has_one = array('sensor'=> array(
        'model_to' => 'Model_Sensor',
        'key_from' => 'sensor_id',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ));

	public static function createTable(){
		try {
		    DB::query("DROP TABLE user_sensors")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE user_sensors (
  id INT NOT NULL IDENTITY (1, 1),
  user_id INT NOT NULL,
  sensor_id INT NOT NULL,
	temperature_alert INT DEFAULT 1,
	fire_alert INT DEFAULT 1,
	heatstroke_alert INT DEFAULT 1,
	humidity_alert INT DEFAULT 1,
	mold_mites_alert INT DEFAULT 1,
	illuminance_daytime_alert INT DEFAULT 1,
	illuminance_night_alert INT DEFAULT 1,
	wake_up_alert INT DEFAULT 1,
	sleep_alert INT DEFAULT 1,
	abnormal_behavior_alert INT DEFAULT 1,
	active_non_detection_alert INT DEFAULT 1
	active_night_alert INT DEFAULT 1
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function saveUserSensor($params) {
		if(isset($params['id'])) {
	    	$user_sensor = \Model_User_Sensor::find($params['id']);
		} else {
			if(isset($params['user_id'])){
				$user_id = $params['user_id'];				
			} else {
				list(, $user_id) = Auth::get_user_id();
			}

			$user_sensor = \Model_User_Sensor::find("first", array(
				"where" => array(
					"user_id" => $user_id,
					"sensor_id" => $params['sensor_id'],
				)
			));
		}
    	if($user_sensor) {
    		unset($params['q']);
    		unset($params['id']);
    		$user_sensor->set($params);
    		if($user_sensor->save()) {
    			return $user_sensor;
    		}
    	}
    	return null;
    }

    public static function getUserSensor($params) {
		if(!empty($params['id'])) {
	    	$user_sensor = \Model_User_Sensor::find($params['id']);
		} else {
			$user_sensor = \Model_User_Sensor::find("first", array(
				"where" => array(
					"user_id" => $params['user_id'],
					"sensor_id" => $params['sensor_id'],
				)
			));
		}
    	return $user_sensor;
    }

    public static function format($user) {
		$ret = array();
		$keys = array(
			'temperature_alert',
			'fire_alert',
			'heatstroke_alert',
			'humidity_alert',
			'mold_mites_alert',
			'illuminance_daytime_alert',
			'illuminance_night_alert',
			'wake_up_alert',
			'sleep_alert',
			'abnormal_behavior_alert',
			'active_non_detection_alert',
		);
		foreach($keys as $key) {
			$ret[$key] = $user[$key];
		}
		$ret['profile_image'] = Uri::base()."images/user/".$ret['profile_image'];
		if(isset($ret['birthday'])) {
			$now = date("Ymd");
			$birthday = date("Ymd", strtotime($ret['birthday']));
			$ret['age'] = (int)(floor((int)$now - (int)$birthday) / 10000);
		} else {
			$ret['age'] = null;
		}
		return $ret;
	}
}