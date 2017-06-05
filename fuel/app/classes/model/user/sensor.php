<?php 
class Model_User_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'sensor_id',
		'admin' => array('default' => 0),
		'temperature_alert' => array('default' => 1),
		'fire_alert' => array('default' => 1),
		'heatstroke_alert' => array('default' => 1),
		'cold_alert' => array('default' => 1),
		'humidity_alert' => array('default' => 1),
		'mold_mites_alert' => array('default' => 1),
		'illuminance_daytime_alert' => array('default' => 1),
		'illuminance_night_alert' => array('default' => 1),
		'wake_up_alert' => array('default' => 1),
		'sleep_alert' => array('default' => 1),
		'abnormal_behavior_alert' => array('default' => 1),
		'active_non_detection_alert' => array('default' => 1),
		'active_night_alert' => array('default' => 1),
		'disconnection_alert' => array('default' => 1),
		'reconnection_alert' => array('default' => 1),
	);

	protected static $_belongs_to = array('sensor'=> array(
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
	cold_alert INT DEFAULT 1,
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
				\Log::debug("user_sensors not found. user_id:[{$user_id}] sensor_id:[{$params['sensor_id']}]", __METHOD__);
				$user_sensor = \Model_User_Sensor::forge();
			}
		}
    	if($user_sensor) {
    		unset($params['q']);
    		unset($params['id']);
    		$user_sensor->set($params);
    		if($user_sensor->save(false)) {
				\Log::debug("user_sensors saved. user_id:[{$user_sensor->user_id}] sensor_id:[{$user_sensor->sensor_id}]", __METHOD__);
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
			if(!empty($sensor)) {
				$user_sensor['sensor'] = $sensor->to_array();
			}
		}
    	return \Model_User_Sensor::format($user_sensor);
    }

    public static function deleteUserSensor($params) {
		if(isset($params['id'])) {
	    	$user_sensor = \Model_User_Sensor::find($params['id']);
		} else {
			$user_sensor = \Model_User_Sensor::find("first", array(
				"where" => array(
					"user_id" => $params['user_id'],
					"sensor_id" => $params['sensor_id'],
				)
			));
		}
    	if($user_sensor) {
    		if($user_sensor->delete(false)) {
    			return $user_sensor;
    		}
    	}
    	return null;
    }

    public static function format($params) {
		$ret = array();
		$keys = array(
			'user_id',
			'sensor_id',
			'admin',
			'temperature_alert',
			'fire_alert',
			'heatstroke_alert',
			'cold_alert',
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
		);

		foreach($keys as $key) {
			if(isset($params[$key])) {
				$ret[$key] = $params[$key];
			} else {
				$ret[$key] = "1";
			}
		}
		if(isset($params['sensor'])) {
			$ret = array_merge($ret, $params['sensor']);
		}
		return $ret;
	}
        
        public function count_by_client_user($sensor_id)
        {
            $rows = DB::select([DB::expr('COUNT(*)'), 'cnt'])
                        ->from(['user_sensors', 'us'])
                        ->where(DB::expr('EXISTS (SELECT * FROM user_clients AS uc WHERE us.user_id = uc.client_user_id)'))
                        ->and_where('sensor_id', '=', $sensor_id)
                        ->and_where('admin', '=', 0)
                        ->execute();

            return ($rows->get('cnt') > 0);
        }
        
         /*
          * 同一の機器タイプが割当済みかチェック
          * 
          *  @param array $params
          *  @return boolean
          */
        public function checkSelectedSensorType($params)
        {
                $query = DB::query(
                    "SELECT COUNT(*) AS cnt "
                        . "FROM user_sensors AS us "
                        . "LEFT JOIN sensors AS s ON us.sensor_id = s.id "
                        . "WHERE s.type = ( "
                        . "SELECT type FROM sensors AS tmp WHERE tmp.id = :sensor_id "
                        . ") "
                        . "AND us.user_id = :user_id"
                    );
                
                $rows = $query->parameters([
                    'sensor_id' => $params['sensor_id'], 
                    'user_id' => $params['user_id']]
                        )->execute();
     
            return ($rows->get('cnt') > 0);
        }
}