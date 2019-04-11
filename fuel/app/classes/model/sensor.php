<?php 
class Model_Sensor extends Orm\Model{
	// 機器タイプ
    /** 機器タイプ: WiFi */
	const TYPE_WIFI       = 'wifi';
	/** 機器タイプ: 通常センサー */
	const TYPE_SENSOR     = 'sensor';
	/** 機器タイプ: ベッドセンサー */
	const TYPE_BED_SENSOR = 'bedsensor';

	// 施設版センサータイプ
	/** センサータイプ:子機 */
	const FACILITY_TYPE_SLAVE_SENSOR  = '1';
	/** センサータイプ:ベッドセンサー */
	const FACILITY_TYPE_BED_SENSOR_1  = '2';
	/** センサータイプ:ベッドセンサー */
	const FACILITY_TYPE_BED_SENSOR_2  = '3';
	/** センサータイプ:ベッドセンサー */
	const FACILITY_TYPE_BED_SENSOR_3  = '5';

	private $time;
	private $data;
	private $count;

	public function setTime($_time) {
		$this->time = $_time;
	}

	public function loadData() {
		$where = 'sensor_name = :sensor_name AND measurement_time >= :measurement_time';
		$params = [
			'sensor_name'      => $this->name,
			'measurement_time' => date("Y-m-d H:i:s", $this->time - 60 * 60) // 60分で固定
		];
		$this->data  = \Model_Batch_Data_Daily::find_converted_data_by_conditions($where, $params);
		\Log::debug(\DB::last_query('batch'), __METHOD__);
		$this->count = count($this->data);
	}

	protected static $_properties = array(
		'id',
		'name',
		'serial',
		'wake_up_start_time' => array('default' => 5),
		'wake_up_end_time' => array('default' => 9),
		'sleep_start_time' => array('default' => 21),
		'sleep_end_time' => array('default' => 26),
		'temperature_level' => array('default' => 2),
		'fire_level' => array('default' => 2),
		'heatstroke_level' => array('default' => 2),
		'cold_level' => array('default' => 2),
		'mold_mites_level' => array('default' => 2),
		'humidity_level' => array('default' => 2),
		'illuminance_daytime_level' => array('default' => 2),
		'illuminance_night_level' => array('default' => 2),
		'wake_up_level' => array('default' => 2),
		'sleep_level' => array('default' => 2),
		'abnormal_behavior_level' => array('default' => 2),
		'active_non_detection_level' => array('default' => 2),
		'active_night_level' => array('default' => 2),
		'enable' => array('default' => 0),
		'shipping_date',
		'type' => array('default' => 'sensor'),
	);

	protected static $_many_many = array(
	    'users' => array(
	        'key_from' => 'id',
	        'key_through_from' => 'sensor_id', 
	        'table_through' => 'user_sensors',
	        'key_through_to' => 'user_id',
	        'model_to' => 'Model_User',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
	);

	/**
	 * 通常版 -> 施設版へのタイプ値変換
	 */
	public static function to_facility_sensor_type($sensor_type) {
		switch ($sensor_type) {
			case self::TYPE_SENSOR:
				return self::FACILITY_TYPE_SLAVE_SENSOR;
			case self::TYPE_BED_SENSOR:
				return self::FACILITY_TYPE_BED_SENSOR_1;
		}
	}

	/**
	 * 有効なセンサー名と起床・就寝判断開始・終了時間の一覧を取得する
	 */
	public static function get_enable_sensor_name_and_times() {
		return DB::select(['sensors.name', 'name'])
					->select(['type', 'sensor_type'])
					->select('wake_up_start_time')
					->select('wake_up_end_time')
					->select('sleep_start_time')
					->select('sleep_end_time')
					->from('sensors')
					->where('enable', '=', 1)
					->where('type', 'IN', [self::TYPE_SENSOR, self::TYPE_BED_SENSOR])
					->execute()->as_array();
	}

	/**
	 * 指定されたタイプの有効なセンサー名一覧を配列で返す
	 * @param string $sensor_type sensors.type の値
	 */
	public static function get_enable_sensor_names_by_type($sensor_type) {
		$sensor_names =  DB::select(['sensors.name', 'sensor_name'])
							->from('sensors')
							->where('enable', '=', 1)
							->where('type', '=', $sensor_type)
							->execute()->as_array();
		return \Arr::pluck($sensor_names, 'sensor_name');
	}

	public static function get_sensor_name_and_shipping_date($sensor_type)
	{
		$results =  DB::select(['sensors.name', 'sensor_name'])
						->select('sensors.shipping_date')
						->from('sensors')
						->where('shipping_date', '!=', null)
						->where('type', '=', $sensor_type)
						->order_by('id', 'ASC')
						->execute()->as_array();
		return array_column($results, 'shipping_date', 'sensor_name');
	}

	/**
	 * 指定されたセンサー名の指定されたアラートタイプのアラート設定情報を取得する
	 * @param string $alert_type
	 * @param array $sensor_names
	 */
	public static function get_alert_levels($alert_type, $sensor_names) {
		$sql = <<<SQL
SELECT
  s.id as sensor_id,
  s.name as sensor_name,
  '{$alert_type}' as alert_type,
  s.{$alert_type}_level as alert_level,
  us.{$alert_type}_alert as alert,
  u.id as user_id,
  u.email as email
FROM
  sensors s JOIN user_sensors us ON s.id = us.sensor_id
  JOIN users u ON us.user_id = u.id
WHERE
  ISNULL(u.master, 0) != 1
AND
  s.name IN :sensor_names
ORDER BY
  s.name
SQL;

		$query = DB::query($sql);
		$query->parameters([
			'sensor_names' => $sensor_names,
		]);
		$result = $query->execute()->as_array();

		# sensor_name をキーとした配列に変換して返す
		# 一つのセンサーに複数ユーザが紐付いている(=見守っている)事が有り得るのでユーザ情報は配列で持つ
		$alert_levels = [];
		foreach($result as $elem) {
			if (array_key_exists($elem['sensor_name'], $alert_levels)) {
				$alert_levels[$elem['sensor_name']]['users'][]= [
					'user_id' => $elem['user_id'],
					'alert'   => $elem['alert'],
					'email'   => $elem['email'],
				];
			} else {
				$alert_levels[$elem['sensor_name']] = [
					'sensor_id'   => $elem['sensor_id'],
					'sensor_name' => $elem['sensor_name'],
					'alert_type'  => $elem['alert_type'],
					'alert_level' => $elem['alert_level'],
					'users'       => [
						[
							'user_id' => $elem['user_id'],
							'alert'   => $elem['alert'],
							'email'   => $elem['email'],
						]
					]
				];
			}
		}
		return $alert_levels;
	}

	/**
	 * 最新のアラートが接続断アラートになっているセンサー情報を取得する
	 *
	 * 接続断アラートは直近60分以内のデータ受信が無い場合に記録される
	 * なので、そのセンサーの最新のアラートは必ず接続断になるはず
	 *
	 * @return array sensor_name をキーにした連想配列
	 */
	public static function get_disconnected_sensors() {
		$sql = <<<SQL
SELECT
  t1.sensor_id,
  s.name AS sensor_name,
  s.type AS sensor_type,
  t1.date AS alerted_at,
  t1.type AS alert_type,
  t1.confirm_status
FROM
  (
    SELECT
      a1.sensor_id,
      a1.date,
      a1.type,
      a1.confirm_status
    FROM
      alerts a1 JOIN alerts a2 ON (a1.sensor_id = a2.sensor_id)
    GROUP BY a1.sensor_id, a1.date, a1.type, a1.confirm_status
    HAVING a1.date = MAX(a2.date)
       AND a1.type = :alert_type
  ) t1 JOIN sensors s ON t1.sensor_id = s.id
ORDER BY sensor_name
SQL;

		$query = DB::query($sql);
		$query->parameters([
			'alert_type'     => \Model_Alert::TYPE_DISCONNECTION,
		]);
		$disconnected_sensors = $query->execute()->as_array();

		$result = [];
		foreach ($disconnected_sensors as $sensor) {
			switch ($sensor['sensor_type']) {
				case self::TYPE_SENSOR:
					$result[self::TYPE_SENSOR][$sensor['sensor_name']] = $sensor;
					break;
				case self::TYPE_BED_SENSOR:
					$result[self::TYPE_BED_SENSOR][$sensor['sensor_name']] = $sensor;
					break;
				default:
					throw new \UnexpectedValueException("sensor_type:[{$sensor['sensor_type']}] is unexpected.");
			}
		}
		return $result;
	}

	public static function getSensor($id){
		try {
			$sensor = \Model_Sensor::find($id);
		} catch(Exception $e) {
			return null;
		}
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

	public static function getAll() {
		$_sensors = \Model_Sensor::find('all',array(
			'order_by' => array('name' => 'desc')
		));
		foreach($_sensors as $_sensor) {
			$sensors[] = \Model_Sensor::format($_sensor);
		}
		return $sensors;
	}

	public static function getSearch($params) {
		$query = array(
			'where' => array(
				array('name', 'LIKE', '%'.$params['query'].'%'),
			),
			'order_by' => array('name' => 'desc')
		);
		if(!empty($params['limit'])) {
			$query['limit'] = $params['limit'];
			if(!empty($params['page']) && $params['page'] > 1) {
				$query['offset'] = $params['limit'] * ($params['page'] - 1);
			}
		}
		if(isset($params['limit'])) {
			
		}
		$_sensors = \Model_Sensor::find('all', $query);
		$sensors = array();
		foreach($_sensors as $_sensor) {
			$sensors[] = \Model_Sensor::format($_sensor);
		}
		return $sensors;
	}

	public static function getAdmins($params) {
		$user_sensors = \Model_User_Sensor::find('all', array(
			'where' => array(
				'sensor_id' => $params['sensor_id'],
			),
		));
		return $user_sensors;
	}

	public static function getClient($params) {
		$user_sensor = \Model_User_Sensor::find('first', array(
			'where' => array(
				'sensor_id' => $params['sensor_id'],
				'admin' => 0,
			),
		));
		$user = \Model_User::find($user_sensor['user_id']);
		if($user['admin'] == 0) {
			return $user;
		}

		return null;
	}

	public static function isAllowed($sensor_id, $user_id)
	{
		$user_sensor = \Model_User_Sensor::find('first', array(
			'where' => array(
				'sensor_id' => $sensor_id,
				'user_id' => $user_id,
			),
		));
		if(!empty($user_sensor)) {
			return true;
		} else {
			return false;
		}
	}

	public static function saveSensor($params) {
		if(!empty($params['shipping_year']) && !empty($params['shipping_month']) && !empty($params['shipping_day'])) {
			$params['shipping_date'] = $params['shipping_year']."-".$params['shipping_month']."-".$params['shipping_day'];
		}
		if(isset($params['id'])) {
	    	$sensor = \Model_Sensor::find($params['id']);
		} else if(isset($params['name'])) {
			$sensor = \Model_Sensor::getSensorFromSensorName($params['name']);
			if(empty($sensor)) {
				$sensor = \Model_Sensor::forge();
			}
		}
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

    public static function deleteSensor($params) {
		if(isset($params['id'])) {
	    	$sensor = \Model_Sensor::find($params['id']);
		}
    	if($sensor) {
    		if($sensor->delete()) {
    			return \Model_Sensor::format($sensor);
    		}
    	}
    	return null;
    }

    public static function format($sensor) {
    	return $sensor;
    }

    //室温異常通知
    public function checkTemperature() {
    	if($this->temperature_level > 0) {
   		  	echo "Check Temperature\n";
   		  	echo "Temperature Level ".$this->temperature_level."\n";

	   		$levels = Config::get("sensor_levels.temperature");
    		$level = $levels[$this->temperature_level - 1];

			$temperature_upper_limit_count = 0;
			$temperature_lower_limit_count = 0;

			if($this->count && isset($level)) {
				try {
					foreach($this->data as $row) {
							if($level['upper_limit'] < $row['temperature']) {
								$temperature_upper_limit_count++;
							} else if($level['lower_limit'] > $row['temperature']) {
								$temperature_lower_limit_count++;
							}

					}

					if($temperature_upper_limit_count == $this->count) {
						$params = array(
							'type' => 'temperature',
							'logs' => array(
								'temperature_upper_limit' => $level['upper_limit']
							),
						);
						return $this->alert($params);			
					} else if($temperature_lower_limit_count == $this->count) {
						$params = array(
							'type' => 'temperature',
							'logs' => array(
//								'temperature_lower_limit' => $level['lower_limit']
							),
						);
						return $this->alert($params);	
					}
				} catch(Exception $e) {
					echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
				}
	
			}
    	}
		return false;
	}

    //湿度異常通知
    public function checkHumidity() {
    	if($this->humidity_level > 0) {
	     	echo "Check Humidity\n";
	     	echo "Level ".$this->humidity_level."\n";
	   		$levels = Config::get("sensor_levels.humidity");
	    	$level = $levels[$this->humidity_level - 1];

			$humidity_upper_limit_count = 0;
			$humidity_lower_limit_count = 0;

			if($this->count && isset($level)) {
				try {
					foreach($this->data as $row) {

						if($level['upper_limit'] < $row['humidity']) {
							$humidity_upper_limit_count++;
						} else if($level['lower_limit'] > $row['humidity']) {
							$humidity_lower_limit_count++;
						}
					}

					if($humidity_upper_limit_count == $this->count) {
						$params = array(
							'type' => 'humidity',
							'logs' => array(
								'humidity_upper_limit' => $level['upper_limit']
							),
						);
						return $this->alert($params);			
					} else if($humidity_upper_limit_count == $this->count) {
						$params = array(
							'type' => 'humidity',
							'logs' => array(
//								'humidity_lower_limit' => $level['lower_limit'],
							),
						);
						return $this->alert($params);	
					}
				} catch(Exception $e) {
					echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
				}	
			}    		
    	}
		return false;
	}

	//熱中症チェック
	public function checkHeatstroke() {
		if($this->heatstroke_level > 0) {
	     	echo "Check Heatstroke\n";
	     	echo "Level ".$this->heatstroke_level."\n";

    		$levels = Config::get("sensor_levels.heatstroke");
	    	$level = $levels[$this->heatstroke_level - 1];

			$count = count($this->data);
			if($count && isset($level)) {
				try {
					foreach($this->data as $row) {
						$wbgt = (0.3 * $row['temperature'] + 2.75) * ($row['humidity'] - 20) / 80 + 0.75 * $row['temperature'] - 0.75;
						//$wbgt = $row['temperature'] * 0.7 + $row['humidity'] * 0.3;
						if($level['wbgt_upper_limit'] < $wbgt) {
							$count--;
						}
					}
					if($count == 0) {
						$params = array(
							'type' => 'heatstroke',
							'logs' => array(
								'heatstroke_wbgt_upper_limit' => $level['wbgt_upper_limit'],
							),
						);
						return $this->alert($params);			
					}	
				} catch(Exception $e) {
					echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
				}	
			}
		}
		return false;
	}

        //風邪ひき指数チェック
        public function checkCold() {
                if($this->cold_level > 0) {
                echo "Check Cold\n";
                echo "Level ".$this->cold_level."\n";

                $levels = Config::get("sensor_levels.cold");
                $level = $levels[$this->cold_level - 1];

                        $count = count($this->data);
                        if($count && isset($level)) {
                                try {
                                        foreach($this->data as $row) {
                                                $cold = \Util::calc_cold($row['humidity'], $row['temperature']);
                                                if($level['cold_upper_limit'] < $cold) {
                                                        $count--;
                                                }
                                        }
                                        if($count == 0) {
                                                $params = array(
                                                        'type' => 'cold',
                                                        'logs' => array(
                                                                'cold_upper_limit' => $level['cold_upper_limit'],
                                                        ),
                                                );
                                                return $this->alert($params);
                                        }
                                } catch(Exception $e) {
                                        echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
                                }
                        }
                }
                return false;
        }

	//カビ・ダニ警報アラート
	public function checkMoldMites() {
		if($this->mold_mites_level > 0) {
	     	echo "Check Mold Mites\n";

    		$levels = Config::get("sensor_levels.mold_mites");
	    	$level = $levels[$this->mold_mites_level - 1];

			$count = count($this->data);
			if($count && isset($level)) {
				try {
					foreach($this->data as $row) {
						if($level['humidity_upper_limit'] < $row['humidity'] && $level['temperature_upper_limit'] < $row['temperature']) {
							$count--;
						}
					}
					if($count == 0) {
						$params = array(
							'type' => 'mold_mites',
							'logs' => array(
								'mold_mites_humidity_upper_limit' => $level['humidity_upper_limit'],
								'mold_mites_temperature_upper_limit' => $level['temperature_upper_limit'],
							),
						);
						return $this->alert($params);			
					}	
				} catch(Exception $e) {
					echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
				}	
			}			
		}

		return false;
	}

    //通信断のチェック
    public function checkDisconnection() {
    	echo "Check Disconnection\n";

    	$this->disconnection_duration = Config::get("sensor_default_setting.disconnection_duration");

		if(count($this->data) == 0) {
			$params = array(
				'type' => 'disconnection',
				'logs' => array(
					'disconnection_duration' => $this->disconnection_duration,
				),
			);
			return $this->alert($params);
		}
		return false;
    }

    //再通信のチェック
    public function checkReconnection() {
    	echo "Check Reconnection\n";

     	$sql = 'SELECT COUNT(*) AS count FROM data WHERE sensor_id = :sensor_id AND date = :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->time)
		));
		$result = $query->execute('data');
		if($result[0]['count'] != 0) {
      		$sql = 'SELECT COUNT(*) AS count FROM data WHERE sensor_id = :sensor_id AND date = :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - 60)
			));
			$result = $query->execute('data');      		
			if($result[0]['count'] == 0) {
				$params = array(
					'type' => 'reconnection',
				);
				return $this->alert($params);
			}
		}
		return false;
    }

    //室内照度異常（日中）
    public function checkIlluminanceDaytime() {
		if($this->illuminance_daytime_level > 0) {
     		echo "Check Illuminance Daytime\n";
     		echo "Illuminance Daytime Level ".$this->illuminance_daytime_level."\n";

	   		$levels = Config::get("sensor_levels.illuminance_daytime");
	    	$level = $levels[$this->illuminance_daytime_level - 1];

			$count = 0;
			if(count($this->data) && isset($level)) {
				foreach($this->data as $row) {
					$hour = (int)date("H", strtotime($row['date']));
					if($level['start_time'] < $hour && $level['end_time'] > $hour) {
						$count++;
						try {
							if($level['lower_limit'] < $row['illuminance']) {
								$count--;
							}		
						} catch(Exception $e) {
							echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
						}
			
					} else {
						$count++;
					}

				}
				if($count == 0) {
					$params = array(
						'type' => 'illuminance_daytime',
						'logs' => array(
							'illuminance_daytime_start_time' => $level['start_time'],
							'illuminance_daytime_end_time' => $level['end_time'],
							'hour' => $hour,
//							'illuminance_daytime_lower_limit' => $level['lower_limit,']
						),
					);
					return $this->alert($params);			
				}	
			}
			return false;    		
    	}
    }

    //室内照度異常（深夜）
    public function checkIlluminanceNight() {
		if($this->illuminance_night_level > 0) {
     		echo "Check Illuminance Night\n";
     		echo "Illuminance Night Level ".$this->illuminance_night_level."\n";

    		$levels = Config::get("sensor_levels.illuminance_night");
	    	$level = $levels[$this->illuminance_night_level - 1];

			$count = 0;
			if(count($this->data) && isset($level)) {
				foreach($this->data as $row) {
					$hour = (int)date("H", strtotime($row['date']));
					if($level['start_time'] < $hour && $level['end_time'] > $hour) {
						$count++;
						try {
							if($level['lower_limit'] > $row['illuminance']) {
								$count--;
							}	
						} catch(Exception $e) {
							echo $e->getFile()." - ".$e->getLine()." - ".$e->getMessage()."\n";
						}
				
					} else {
						$count++;
					}

				}
				if($count == 0) {
					$params = array(
						'type' => 'illuminance_night',
						'logs' => array(
							'illuminance_night_start_time' => $level['start_time'],
							'illuminance_night_end_time' => $level['end_time'],
							'hour' => $hour,
//							'illuminance_night_lower_limit' => $level['lower_limit'],
						),
					);
					return $this->alert($params);			
				}	
			}

    	}
		return false;   
    }


    //火事のチェック
    public function checkFire() {
    	if($this->fire_level > 0) {
    		echo "Check Fire\n";

    		$levels = Config::get("sensor_levels.fire");
		   	$level = $levels[$this->fire_level - 1];

			$where = 'sensor_name = :sensor_name AND temperature > :temperature AND measurement_time >= :measurement_time';
			$params = [
				'sensor_name'      => trim($this->name),
				'temperature'      => $level['temperature_upper_limit'],
				'measurement_time' => date("Y-m-d H:i:s", $this->time - 60)
			];
			$result = \Model_Batch_Data_Daily::find_converted_data_by_conditions($where, $params);
			\Log::debug(\DB::last_query('batch'), __METHOD__);

			if(!empty($result) && !empty($result[0]['temperature'])) {
				$params = array(
					'type' => 'fire',
					'logs' => array(
						'fire_temperature_upper_limit' => $level['temperature_upper_limit'],
					),
				);
				return $this->alert($params);
			}
    	}
		return false;
    }

	//起床時間のチェック
	public function checkWakeUp() {
		if($this->wake_up_level < 1) {
			return null;
		}
		echo "Check Wakeup: {$this->name}\n";

    	$levels = Config::get("sensor_levels.wake_up");
    	$level = $levels[$this->wake_up_level - 1];

		if(Input::param("date")) {
	    	$date = Input::param("date");
		} else {
    		$date = date("Y-m-d");
		}
		$daily_data = \Model_Data_Daily::find('first', array('where' => array(
			'sensor_id' => $this->id,
			'date' => $date,
		)));

		//既に起床時間が登録されていたらスキップする
		if(!empty($daily_data['wake_up_time'])) {
			return true;
		}

		$where = 'sensor_name = :sensor_name AND measurement_time BETWEEN :start_date AND :end_date';
		$start_date = date("Y-m-d H:i:s", strtotime($date . " " . $this->wake_up_start_time . ":00:00"));
		$end_date   = date("Y-m-d H:i:s", strtotime($date . " " . $this->wake_up_end_time . ":00:00"));
		$params = [
			'sensor_name' => trim($this->name),
			'start_date'  => $start_date,
			'end_date'    => $end_date,
		];
		\Log::debug("wake_up_start_time and wake_up_end_time: " . print_r($params, true), __METHOD__);
		$result = \Model_Batch_Data_Daily::find_converted_data_by_conditions($where, $params);
		\Log::debug(\DB::last_query('batch'), __METHOD__);

		$count = count($result);
		$active_count = 0;
		$nonactive_count = 0;
		$wake_up_time = null;

		if($count) {

			foreach($result as $row) {

				if($level['threshold'] < $row['active']) {

					if(empty($wake_up_time)) {
						$active_count = 0;
						$wake_up_time = $row['date'];
					}
					$active_count++;
					if($active_count >= $level['duration'] && isset($wake_up_time)) {
						if(!$daily_data) {
							$daily_data = \Model_Data_Daily::forge();
						} 
						$params = array(
							'sensor_id' => $this->id,
							'wake_up_time' => $wake_up_time,
							'date' => $date,
						);
						$daily_data->set($params);
						$daily_data->save();
						return true;
					}
					$nonactive_count = 0;
				} else {

					$nonactive_count++;
					$active_count++;
					if($nonactive_count == $level['ignore_duration']) {
						$active_count = 0;
						$nonactive_count = 0;
						$wake_up_time = null;
					}
				}
	
			}//foreach

			//平均起床時間遅延アラート
			if(isset($daily_data['wake_up_average'])) {
				if($this->time - strtotime($date." ".$daily_data['wake_up_average']) >= $level['delay_duration']){
					$params = array(
						'type' => 'wake_up',
					);
					return $this->alert($params);
				}							
			}
		}//if
		return false;
	}

	//就寝時間のチェック
	public function checkSleep() {
		if($this->sleep_level < 1) {
			return null;
		}
		echo "Check Sleep: {$this->name}\n";
    	$levels = Config::get("sensor_levels.sleep");
    	$level = $levels[$this->sleep_level - 1];

		if(Input::param("date")) {
	    	$date = Input::param("date");
		} else {
    		$date = date("Y-m-d");
		}

		$daily_data = \Model_Data_Daily::find('first', array('where' => array(
			'sensor_id' => $this->id,
			'date' => $date,
		)));

		$yesterday = date("Y-m-d", strtotime($date) - 60 * 60 * 24);
		if ($this->sleep_end_time > 24) {
			$sleep_end_time = $this->sleep_end_time - 24;
			$start_date     = $yesterday . " " . $this->sleep_start_time . ":00:00";
			$end_date       = $date . " " . $sleep_end_time . ":00:00";
		} else {
			$start_date = $yesterday . " " . $this->sleep_start_time . ":00:00";
			$end_date   = $yesterday . " " . $this->sleep_end_time . ":00:00";
		}

		$start_date = date("Y-m-d H:i:s", strtotime($start_date));
		$end_date   = date("Y-m-d H:i:s", strtotime($end_date));
		$where = 'sensor_name = :sensor_name AND measurement_time BETWEEN :start_date AND :end_date';
		$params = [
			'sensor_name' => trim($this->name),
			'start_date'  => $start_date,
			'end_date'    => $end_date,
		];
		\Log::debug("sleep_start_time and sleep_end_time: " . print_r($params, true), __METHOD__);
		$result = \Model_Batch_Data_Daily::find_converted_data_by_conditions($where, $params);
		\Log::debug(\DB::last_query('batch'), __METHOD__);

		$count = count($result);
		$active_count = 0;
		$nonactive_count = 0;
		$sleep_time = null;

		if($count) {
			foreach($result as $row) {

				if($level['threshold'] > $row['active']) {

					if(empty($current_sleep_time)) {
						$nonactive_count = 0;
						$current_sleep_time = $row['date'];
					}
					$nonactive_count++;
					$active_count = 0;
				} else {

					$active_count++;
					$nonactive_count++;
					if($active_count == $level['ignore_duration']) {
						$nonactive_count = 0;
						$active_count = 0;
						$current_sleep_time = null;
					}
				}
				if($nonactive_count >= $level['duration'] && isset($current_sleep_time)) {
					$sleep_time = $current_sleep_time;
				}

			}
		}
		if(isset($sleep_time)) {
			if(!$daily_data) {
				$daily_data = \Model_Data_Daily::forge();
			} 
			$params = array(
				'sensor_id' => $this->id,
				'sleep_time' => $sleep_time,
				'date' => $date,
			);
			$daily_data->set($params);
			$daily_data->save();
			return true;
		}
		return false;
	}


	public function checkActiveNight() {
		if($this->active_non_detection_level > 0) {
			echo "Check Active Night\n";

	    	$levels = Config::get("sensor_levels.active_non_detection_level");
		 	$level = $levels[$this->active_non_detection_level- 1];
			if(Input::param("date")) {
		    	$date = Input::param("date");
			} else {
	    		$date = date("Y-m-d");
			}
    		$sql = 'SELECT active,date FROM data WHERE sensor_id = :sensor_id AND date BETWEEN :start_date AND :end_date ORDER BY date ASC';
	    	$query = DB::query($sql);
    		$start_date = $date." 00:00:00";
    		$end_date = $date." 04:00:00";

	 		$query->parameters(array(
				'sensor_id' => $this->name,
				'start_date' => $start_date,
				'end_date' => $end_date,
			));  
			$result = $query->execute('data');

			$count = count($result);

			if($count) {
				$start_time = null;
				$end_time = null;
				$times = array();
				foreach($result as $row) {
					if($level['threshold'] < $row['active']) {
						if(empty($start_time)) {
							$start_time = $row['date'];
						}
					} else {
						if(isset($start_time)) {
							$end_time = $row['date'];
						}
					}
					if(isset($start_time) && isset($end_time)) {
						$times[] = array(
							'start_time' => $start_time,
							'end_time' => $end_time,
						);
						$start_time = null;
						$end_time = null;
					}
				}
			}
			print_R($times);
			exit;
		}
		return false;		
	}

	//異常行動（夜間、照明をつけずに動いている）
	//	照度下限：50lux
	//	人感閾値：5
	//	時間帯：24時〜4時
	//	継続時間：30分
	public function checkAbnormalBehavior() {
		if($this->abnormal_behavior_level > 0) {
			echo "Check Abnormal Behavior\n";

			if(Input::param("date")) {
		    	$date = Input::param("date");
			} else {
	    		$date = date("Y-m-d");
			}
			$start_date = $date." 00:00:00";
    		$end_date = $date." 04:00:00";

			if($this->time > strtotime($date." 00:00:00") && $this->time <= strtotime($date." 00:00:00")) {
	    		$levels = Config::get("sensor_levels.abnormal_behavior_level");
			 	$level = $levels[$this->abnormal_behavior_level- 1];

				if($this->count) {
					$active_count = 0;
					foreach($this->data as $row) {
						if($level['active_threshold'] < $row['active'] && $level['illuminance_threshold'] < $row['illuminance'] ) {
							$active_count++;
							if($active_count >= $level['duration'] ) {
								$params = array(
									'type' => 'abnormal_behavior',
								);
								return $this->alert($params);
							}
						} else {
							$active_count = 0;
						}
					}
				}				
			}

		 }
		return false;
	}

	//一定時間人感センサー未感知
	public function checkActiveNonDetection() {
		if($this->active_non_detection_level > 0) {
			echo "Check Active Non Detection\n";

	    	$levels = Config::get("sensor_levels.active_non_detection_level");
		 	$level = $levels[$this->active_non_detection_level - 1];

			if($this->count) {
				$nonactive_count = 0;
				foreach($this->data as $row) {
					if($level['threshold'] > $row['active']) {
						$nonactive_count++;
						if($nonactive_count >= $level['duration'] ) {
							$params = array(
								'type' => 'active_non_detection',
							);
							return $this->alert($params);
						}
					} else {
						$nonactive_count = 0;
					}
				}
			}
		 }
		return false;
	}

    public function alert($params) {
    	$params['date'] = date("Y-m-d H:i:s", $this->time);
    	$params['sensor_id'] = $this->id;
		// カテゴリ未指定の場合は「emergency」を入れる
		if (!array_key_exists('category', $params)) {
			$params['category'] = \Model_Alert::CATEGORY_EMERGENCY;
		}
    	$params['confirm_status'] = 0;
		$params['logs']['sensor_name'] = $this->name;
		$params['logs']['sql'] = \DB::last_query("data");

		$template = Config::get("template.alert");
		if(isset($template[$params['type']])) {                                     
			$params['title'] = $template[$params['type']]['title'];                        
			$params['description'] = $template[$params['type']]['description'];
		}

		$tmp = $params;
		$tmp['logs'] = implode("<>", $tmp['logs']);
		$data = implode("<>", $tmp);

    	//既にアラートが出ているかチェック
    	$alert = \Model_Alert::getLatestAlert($params);
		if(isset($alert)) {
			//スヌーズ処理が5回以上なら再度通知
	    	Log::info($data, 'no alert', __METHOD__);
			return false;
		}
		 else {
	    	Log::info($data, 'alert', __METHOD__);

			$alert = \Model_Alert::forge();
    		$alert->set($params);
                            
    		foreach($this->users as $user) {
    			if($user['master'] != 1) { // システム管理者以外に通知
	    			$user_sensor = \Model_User_Sensor::find('first', array(
	    				'where' => array(
	    					'user_id' => $user['id'],
	    					'sensor_id' => $this->id,
	    				),
	    			))->to_array();
	    			if(isset($user_sensor)) {
	    				if($user_sensor[$params['type']."_alert"] == 1) {
	    					$devices = \Model_Device::find('all', array(
	    						'where' => array(
	    							'user_id' => $user['id'],
	    						),
	    					));
	    					foreach($devices as $device) {
	    						\Model_Alert::pushAlert(array(
	    							'push_id' => $device['push_id'],
	    							'text' => $params['description'],
	    						));
	    					}

                                                // 見守られユーザを取得
                                                $client_users = Model_User::getClientUserWithUserSensors($this->id, $user['id']);
                                                $description = sprintf(
                                                    Config::get("template.alert_mail_format"), 
                                                    $client_users['last_name'], 
                                                    $client_users['first_name'], 
                                                    $params['description']
                                                );
                                                
			  	    		$this->send_alert(array(
				    			'email' => $user['email'],
				    			'title' => $params['title'],
				    			'description' => $description,
				    		));  	    					
	    				}
	    			}    				
    			}
    		}
	    	return $alert->save();
		}
    }

    public function send_alert($params) {
		\Log::debug("send email:[{$params['email']}]", __METHOD__);
		$sendgrid = new SendGrid(Config::get("sendgrid"));
		$email = new SendGrid\Email();
		$email
		    ->addTo($params['email'])
		    ->setFrom(Config::get("email.noreply"))
		    ->setSubject($params['title'])
		    ->setText($params['description']);
		try {
		    $sendgrid->send($email);
		    return true;
		} catch(\SendGrid\Exception $e) {
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
		    return false;
		}
    }
    
    /*
     * 未出荷かどうかを判定
     *  
     * @params int $id
     * @return bool
     */
    public static function isUnShipped($id)
    {
        $sensor = self::find('first', [
                        'where' => [
                            'id' => $id
			],
                    ]);
        if(is_null($sensor['shipping_date'])) {
            return true;
        }
        return false;
    }
}
