<?php 
class Model_User_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'sensor_id',
		'admin',
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
		'active_night_alert',
		'disconnection_alert',
		'reconnection_alert',
		'snooze_times',
		'snooze_interval',
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
			if(empty($user_sensor)) {
				$user_sensor = \Model_User_Sensor::forge();
				$params['temperature_alert'] = 1;
				$params['fire_alert'] = 1;
				$params['heatstroke_alert'] = 1;
				$params['humidity_alert'] = 1;
				$params['mold_mites_alert'] = 1;
				$params['illuminance_daytime_alert'] = 1;
				$params['illuminance_night_alert'] = 1;
				$params['wake_up_alert'] = 1;
				$params['sleep_alert'] = 1;
				$params['abnormal_behavior_alert'] = 1;
				$params['active_non_detection_alert'] = 1;
				$params['active_night_alert'] = 1;
				$params['disconnection_alert'] = 1;
				$params['reconnection_alert'] = 1;
				$params['snooze_times'] = 5;
				$params['snooze_interval'] = 60;
			}
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
			if(isset($params['user_id'])){
				$user_id = $params['user_id'];				
			} else {
				list(, $user_id) = Auth::get_user_id();
			}

			$user_sensor = \Model_User_Sensor::find("first", array(
				"where" => array(
					"user_id" => $user_id,
					"sensor_id" => $params['sensor_id'],
				),
				'related' => array('sensor'),
			));
		}
		if(isset($user_sensor)) {
			$user_sensor = $user_sensor->to_array();
		} else {
			$sensor = \Model_Sensor::find($params['sensor_id']);
			$user_sensor['sensor'] = $sensor->to_array();
		}
    	return \Model_User_Sensor::format($user_sensor);
    }

    public static function format($params) {
		$ret = array();
		$keys = array(
			'id',
			'user_id',
			'sensor_id',
			'admin',
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
			'active_night_alert',
			'disconnection_alert',
			'reconnection_alert',
			'snooze_times',
			'snooze_interval',
		);

		foreach($keys as $key) {
			if(!empty($params[$key])) {
				$ret[$key] = $params[$key];
			} else {
				$ret[$key] = "1";
			}
		}
		if(isset($params['sensor'])) {
			unset($params['sensor']['id']);
			$ret = array_merge($ret, $params['sensor']);
		}
		return $ret;
	}
}