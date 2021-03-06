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
        
        /*
         * 同一親アカウント内でセンサーが割当済みかチェック
         * 
         * @params int $sensor_id
         * @params int $user_id
         * @return bool
         */
        public function countByClientUser($sensor_id, $user_id)
        {
            $query = DB::query(
                    "SELECT COUNT(*) AS cnt "
                        . "FROM user_sensors AS us "
                        . "WHERE EXISTS ("
                        . " SELECT * FROM user_clients AS uc WHERE uc.user_id = :user_id AND us.user_id = uc.client_user_id"
                        . ") "
                        . "AND sensor_id = :sensor_id "
                        . "AND admin = 0 "
                );
                
            $rows = $query->parameters([
                    'user_id' => $user_id,
                    'sensor_id' => $sensor_id]
                    )->execute();
                
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
        
        /*
         * 出荷済みのデータを取得
         *  
         * @params array $params
         * @return array
         * @throw
         */
	public static function getAllSensorByShippingDate($user_id, $shippingDate)
        {
            try {
                $rows = self::find("all", [
                            'where' => [
                                ['user_id', '=', $user_id],
                                ['sensor.shipping_date', '<=', $shippingDate]
                            ],
                            'related' => [
                                'sensor' => ['order_by' => ['name' => 'asc']]
                            ],
			]);
 
                if($rows) {
                    $sensors = [];
                    foreach($rows as $row) {
                        $user_sensor = $row->to_array();
                        $user_sensor['id'] = $user_sensor['sensor_id'];
                        unset($user_sensor['user_id']);
                        unset($user_sensor['sensor_id']);
                        if(isset($user_sensor['sensor'])) {
                            $sensor = $user_sensor['sensor'];
                            unset($user_sensor['sensor']);
                            $sensors[] = array_merge($sensor, $user_sensor);
                        } else {
                            $sensors[] = $user_sensor;
                        }				
                    }
                    return $sensors;
                }
                return null;
                
            } catch(Exception $e) {
                \Log::error('Sensor list Getting Failed. [' . $e->getMessage(). ']');
                return null;
            }
	}
        
        /*
         * センサー機器割当リスト取得
         * 
         *  @params int $user_id
         *  @return array $rows
         *  @throw
         */
        public function getAllocationList($user_id)
        {
            try {
                $query = DB::query(
                        "SELECT d.id, us.user_id, d.name, u.last_name, u.first_name, d.shipping_date "
                        . "FROM user_sensors AS us "
                        . "LEFT JOIN ( "
                        . " SELECT * FROM user_sensors AS t2 WHERE user_id IN ( "
                        . "     SELECT client_user_id FROM user_clients WHERE user_id = :user_id "
                        . " ) AND t2.admin = 0 "
                        . ") AS t1 "
                        . "ON us.sensor_id = t1.sensor_id  "
                        . "LEFT JOIN users AS u ON t1.user_id = u.id "
                        . "LEFT JOIN sensors AS d ON us.sensor_id = d.id "
                        . "WHERE us.user_id = :user_id "
                        . "ORDER BY d.id "
                    );
                
                $rows = $query->parameters(['user_id' => $user_id])
                            ->execute()
                            ->as_array();
                return $rows;
            } catch (Exception $e) {
                \Log::error('Allocation List Getting Failed. [' . $e->getMessage(). ']');
                throw new Exception($e);
            }
        }
}