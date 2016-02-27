<?php 
class Model_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'name',
		'temperature_upper_limit',
		'temperature_lower_limit',
		'temperature_duration',
		'fire_temperature_upper_limit',
		'heatstroke_wbgt_upper_limit',
		'heatstroke_duration',
		'humidity_upper_limit',
		'humidity_lower_limit',
		'humidity_duration',
		'mold_mites_humidity_upper_limit',
		'mold_mites_temperature_upper_limit',
		'mold_mites_duration',
		'illuminance_daytime_lower_limit',
		'illuminance_daytime_duration',
		'illuminance_daytime_start_time',
		'illuminance_daytime_end_time',
		'illuminance_night_lower_limit',
		'illuminance_night_duration',
		'illuminance_night_start_time',
		'illuminance_night_end_time',
		'disconnection_duration',
		'wake_up_period',
		'wake_up_delay_allowance_duration',
		'temperature_average',
		'humidity_average',
		'temperature_week_average',
		'humidity_week_average',
	);

	public static function createTable(){
		try {
		    DB::query("DROP TABLE sensors")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE sensors (
  id INT NOT NULL IDENTITY (1, 1),
  name NVARCHAR(50),
  temperature_upper_limit INT,
  temperature_lower_limit INT,
  temperature_duration INT,
  fire_temperature_upper_limit INT,
  heatstroke_wbgt_upper_limit INT,
  heatstroke_duration INT,
  humidity_upper_limit INT,
  humidity_lower_limit INT,
  humidity_duration INT,
  mold_mites_temperature_upper_limit INT,
  mold_mites_duration INT,
  illuminance_daytime_lower_limit INT,
  illuminance_daytime_duration INT,
  mold_mites_humidity_upper_limit INT,
  illuminance_daytime_start_time INT,
  illuminance_daytime_end_time INT,
  illuminance_night_lower_limit INT,
  illuminance_night_duration INT,
  illuminance_night_start_time INT,
  illuminance_night_end_time INT,
  disconnection_duration INT,
  wake_up_period INT,
  wake_up_delay_allowance_duration INT,
  temperature_average FLOAT,
  humidity_average FLOAT,
  temperature_week_average NTEXT,
  humidity_week_average NTEXT
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function getSensor($id){
		$sensor = \Model_Sensor::find($id);
		if($sensor) {
			return \Model_Sensor::format($sensor);
		} else {
			return null;
		}	
	}

	public static function getSensorsFromClientUserId($client_user_id) {
		$sensors = array();
		$_sensors = \Model_User_Sensor::find('all',array(
			'where' => array(
				'user_id' => $client_user_id,
			),
			'realated' => array('sensor'),
		));
		foreach($_sensors as $_sensor) {
			$sensors[] = \Model_Sensor::format($_sensor->sensor);
		}
		return $sensors;
	}

	public static function getSensorFromSensorName($sensor_name) {
		$sensor = \Model_Sensor::find('first',array(
			'where' => array(
				'name' => $sensor_name,
			)
		));
		return \Model_Sensor::format($sensor);
	}

	public static function saveSensor($params) {
    	$sensor = \Model_Sensor::find($params['id']);
    	if($sensor) {
    		unset($params['q']);
    		unset($params['id']);
    		$sensor->set($params);
    		if($sensor->save()) {
    			return \Model_Sensor::format($sensor);
    		}
    	}
    	return null;
    }

    public static function format($sensor) {
    	$sensor['temperature_week_average'] = json_decode($sensor['temperature_week_average'], true);
    	$sensor['humidity_week_average'] = json_decode($sensor['humidity_week_average'], true);
    	return $sensor;
    }

    //室温異常通知
    public function checkTemperature() {
    	$sql = 'SELECT temperature FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->temperature_duration * 60)
		));
		$result = $query->execute('data');
		$count = count($result);
		$temperature_upper_limit_count = 0;
		$temperature_lower_limit_count = 0;

		if($count) {
			foreach($result as $row) {
				if($this->temperature_upper_limit < $row['temperature']) {
					$temperature_upper_limit_count++;
				} else if($this->temperature_lower_limit > $row['temperature']) {
					$temperature_lower_limit_count++;
				}
			}

			if($temperature_upper_limit_count == $count) {
				$params = array(
					'type' => 'temperature',
					'title' => '室温異常',
					'description' => '室温異常',
				);
				return $this->alert($params);			
			} else if($temperature_upper_limit_count == $count) {
				$params = array(
					'type' => 'temperature',
					'title' => '室温異常',
					'description' => '室温異常',
				);
				return $this->alert($params);	
			}			
		}
		return false;
	}

    //湿度異常通知
    public function checkHumidity() {
    	$sql = 'SELECT humidity FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->humidity_duration * 60)
		));
		$result = $query->execute('data');
		$count = count($result);
		$humidity_upper_limit_count = 0;
		$humidity_lower_limit_count = 0;

		if($count) {
			foreach($result as $row) {
				if($this->humidity_upper_limit < $row['humidity']) {
					$humidity_upper_limit_count++;
				} else if($this->humidity_lower_limit > $row['humidity']) {
					$humidity_lower_limit_count++;
				}
			}

			if($humidity_upper_limit_count == $count) {
				$params = array(
					'type' => 'humidity',
					'title' => '湿度異常',
					'description' => '湿度異常',
				);
				return $this->alert($params);			
			} else if($humidity_upper_limit_count == $count) {
				$params = array(
					'type' => 'humidity',
					'title' => '湿度異常',
					'description' => '湿度異常',
				);
				return $this->alert($params);	
			}			
		}
		return false;
	}

	//熱中症チェック
	public function checkHeatstroke() {
    	$sql = 'SELECT temperature,humidity FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->heatstroke_duration * 60)
		));
		$result = $query->execute('data');
		$count = count($result);
		if($count) {
			foreach($result as $row) {
				//温度×0.7＋湿度×0.3
				$wbgt = $row['temperature'] * 0.7 + $row['humidity'] * 0.3;
				if($this->heatstroke_wbgt_upper_limit < $wbgt) {
					$count--;
				}
			}
			if($count == 0) {
				$params = array(
					'type' => 'heatstroke',
					'title' => '熱中症',
					'description' => '熱中症',
				);
				return $this->alert($params);			
			}	
		}
		return false;
	}

	//カビ・ダニ警報アラート
	public function checkMoldMites() {
    	$sql = 'SELECT temperature,humidity FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->mold_mites_duration * 60)
		));
		$result = $query->execute('data');
		$count = count($result);
		if($count) {
			foreach($result as $row) {
				if($this->mold_mites_humidity_upper_limit < $row['humidity'] && $this->mold_mites_temperature_upper_limit < $row['temperature']) {
					$count--;
				}
			}
			if($count == 0) {
				$params = array(
					'type' => 'mold_mites',
					'title' => 'カビ・ダニ',
					'description' => 'カビ・ダニ',
				);
				return $this->alert($params);			
			}	
		}
		return false;
	}

    //通信断のチェック
    public function checkDisconnection() {
    	$sql = 'SELECT COUNT(*) AS count FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->disconnection_duration * 60)
		));
		$result = $query->execute('data');
		if($result[0]['count'] == 0) {
			$params = array(
				'type' => 'disconnection',
				'title' => '通信断',
				'description' => '通信断',
			);
			return $this->alert($params);
		}
		return true;
    }

    //室内照度異常（日中）
    public function checkIlluminanceDaytime() {
    	$sql = 'SELECT illuminance,date FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->illuminance_daytime_duration * 60)
		));
		$result = $query->execute('data');
		$count = 0;
		if(count($result)) {
			foreach($result as $row) {
				$hour = date("h", strtotime($row['date']));
				if($this->illuminance_daytime_start_time < $hour && $this->illuminance_daytime_end_time > $hour) {
					$count++;
					if($this->illuminance_daytime_lower_limit < $row['illuminance']) {
						$count--;
					}					
				}

			}
			if($count == 0) {
				$params = array(
					'type' => 'illuminance_daytime',
					'title' => '室内照度異常（日中）',
					'description' => '室内照度異常（日中）',
				);
				return $this->alert($params);			
			}	
		}
		return false;
    }

    //室内照度異常（深夜）
    public function checkIlluminanceNight() {
    	$sql = 'SELECT illuminance,date FROM `data` WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->illuminance_night_duration * 60)
		));
		$result = $query->execute('data');
		$count = 0;
		if(count($result)) {
			foreach($result as $row) {
				$hour = date("h", strtotime($row['date']));
				if($this->illuminance_night_start_time < $hour && $this->illuminance_night_end_time > $hour) {
					$count++;
					if($this->illuminance_night_lower_limit < $row['illuminance']) {
						$count--;
					}					
				}

			}
			if($count == 0) {
				$params = array(
					'type' => 'illuminance_night',
					'title' => '室内照度異常（深夜）',
					'description' => '室内照度異常（深夜）',
				);
				return $this->alert($params);			
			}	
		}
		return false;
    }


    //火事のチェック
    public function checkFire() {
    	$sql = 'SELECT * FROM `data` WHERE sensor_id = :sensor_id AND temperature > :temperature AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'temperature' => $this->fire_temperature_upper_limit,
			'date' => date("Y-m-d H:i:s", -60)
		));
		$result = $query->execute('data');
		if($result) {
			$params = array(
				'type' => 'fire',
				'title' => '火事',
				'description' => '火事',
			);
			return $this->alert($params);
		}
		return true;
    }

    public function alert($params) {
    	$params['date'] = date("Y-m-d H:i:s");
    	$params['sensor_id'] = $this->id;

    	//既にアラートが出ているかチェック
		if(\Model_Alert::existsAlert($params)) {
			//スヌーズ処理が5回以上なら再度通知
			return false;
		} else {
	    	$alert = \Model_Alert::forge();
	    	$alert->set($params);
	    	return $alert->save();
		}

    }
}