<?php 
class Model_Sensor extends Orm\Model{
	private $time;

	public function setTime($_time) {
		$this->time = $_time;
	}

	protected static $_properties = array(
		'id',
		'name',
		/*
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
		'wake_up_threshold',
		'wake_up_duration',
		'wake_up_ignore_duration',
		'sleep_threshold',
		'sleep_duration',
		'sleep_ignore_duration',
		*/
		'wake_up_start_time',
		'wake_up_end_time',
		'sleep_start_time',
		'sleep_end_time',
		'temperature_level',
		'fire_level',
		'heatstroke_level',
		'mold_mites_level',
		'humidity_level',
		'illuminance_daytime_level',
		'illuminance_night_level',
		'wake_up_level',
		'sleep_level',
		'abnormal_behavior_level',
		'active_non_detection_level',
		'active_night_level',
		'enable',
		'shipping_date',
	);

	// Model_Post の中身は、多くのユーザーに属しています。
	// = ユーザーごとに複数のポストとポストごとに複数のユーザ（著者）があります。
	protected static $_many_many = array(
	    'users' => array(
	        'key_from' => 'id',
	        'key_through_from' => 'sensor_id', // テーブル間のカラム1は、posts.idと一致する必要があります
	        'table_through' => 'user_sensors', // アルファベット順にプレフィックスなしの複数のmodel双方に
	        'key_through_to' => 'user_id', // テーブル間のカラム2は、users.idと一致する必要があります
	        'model_to' => 'Model_User',
	        'key_to' => 'id',
	        'cascade_save' => true,
	        'cascade_delete' => false,
	    )
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
  wake_up_start_time INT,
  wake_up_end_time INT,
  wake_up_threshold INT,
  wake_up_duration INT,
  wake_up_ignore_duration INT,
  sleep_start_time INT,
  sleep_end_time INT,
  sleep_threshold INT,
  sleep_duration INT,
  sleep_ignore_duration INT,
  temperature_level INT DEFAULT 2,
  fire_level INT DEFAULT 2,
  heatstroke_level INT DEFAULT 2,
  humidity_level INT DEFAULT 2,
  mold_mites_level INT DEFAULT 2,
  illuminance_daytime_level INT DEFAULT 2,
  illuminance_night_level INT DEFAULT 2,
  wake_up_level INT DEFAULT 2,
  sleep_level INT DEFAULT 2,
  abnormal_behavior_level INT DEFAULT 2,
  active_non_detection_level INT DEFAULT 2,
  active_night_level INT DEFAULT 2,
  enable INT DEFAULT 1
) ON [PRIMARY];";
		return DB::query($sql)->execute();
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
			'order_by' => array('name' => 'asc')
		));
		foreach($_sensors as $_sensor) {
			$sensors[] = \Model_Sensor::format($_sensor);
		}
		return $sensors;
	}


	public static function saveSensor($params) {
		if(!empty($params['shipping_year']) && !empty($params['shipping_month']) && !empty($params['shipping_day'])) {
			$params['shipping_date'] = $params['shipping_year']."-".$params['shipping_month']."-".$params['shipping_day'];
		}
		if(isset($params['id'])) {
	    	$sensor = \Model_Sensor::find($params['id']);
		} else {
			$sensor = \Model_Sensor::forge();
			$params['temperature_level'] = 2;
			$params['fire_level'] = 2;
			$params['heatstroke_level'] = 2;
			$params['mold_mites_level'] = 2;
			$params['humidity_level'] = 2;
			$params['illuminance_daytime_level'] = 2;
			$params['illuminance_night_level'] = 2;
			$params['wake_up_level'] = 2;
			$params['sleep_level'] = 2;
			$params['abnormal_behavior_level'] = 2;
			$params['active_non_detection_level'] = 2;
			$params['active_night_level'] = 2;
			$params['enable'] = 0;
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

    public static function format($sensor) {
    	return $sensor;
    }

    //室温異常通知
    public function checkTemperature() {
    	$levels = Config::get("sensor_levels.temperature");
    	$level = $levels[$this->temperature_level - 1];

    	if($this->temperature_level > 0) {
	    	$sql = 'SELECT temperature FROM data WHERE sensor_id = :sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - $level['duration'] * 60)
			));
			$result = $query->execute('data');
			$count = count($result);
			$temperature_upper_limit_count = 0;
			$temperature_lower_limit_count = 0;

			if($count) {
				foreach($result as $row) {
					if($level['upper_limit'] < $row['temperature']) {
						$temperature_upper_limit_count++;
					} else if($level['lower_limit'] > $row['temperature']) {
						$temperature_lower_limit_count++;
					}
				}

				if($temperature_upper_limit_count == $count) {
					$params = array(
						'type' => 'temperature',
						'logs' => array(
							'temperature_upper_limit' => $level['upper_limit']
						),
					);
					return $this->alert($params);			
				} else if($temperature_lower_limit_count == $count) {
					$params = array(
						'type' => 'temperature',
						'logs' => array(
							'temperature_lower_limit' => $level['lower_limit']
						),
					);
					return $this->alert($params);	
				}			
			}
    	}
		return false;
	}

    //湿度異常通知
    public function checkHumidity() {
    	if(isset($this->humidity_duration) && isset($this->humidity_upper_limit) && isset($this->humidity_lower_limit )) {
	    	$sql = 'SELECT humidity FROM data WHERE sensor_id = :sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - $this->humidity_duration * 60)
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
						'logs' => array(
							'humidity_upper_limit' => $this->humidity_upper_limit
						),
					);
					return $this->alert($params);			
				} else if($humidity_upper_limit_count == $count) {
					$params = array(
						'type' => 'humidity',
						'logs' => array(
							'humidity_lower_limit' => $this->humidity_lower_limit,
						),
					);
					return $this->alert($params);	
				}			
			}    		
    	}
		return false;
	}

	//熱中症チェック
	public function checkHeatstroke() {
    	$levels = Config::get("sensor_levels.heatstroke");
    	$level = $levels[$this->heatstroke_level - 1];

		if($this->heatstroke_level > 0) {
	    	$sql = 'SELECT temperature,humidity FROM data WHERE sensor_id = :sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - $level['duration'] * 60)
			));
			$result = $query->execute('data');
			$count = count($result);
			if($count) {
				foreach($result as $row) {
					//温度×0.7＋湿度×0.3
					$wbgt = $row['temperature'] * 0.7 + $row['humidity'] * 0.3;
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
			}
		}
		return false;
	}

	//カビ・ダニ警報アラート
	public function checkMoldMites() {
		if(!empty($this->mold_mites_duration) && !empty($this->mold_mites_humidity_upper_limit) && !empty($this->mold_mites_temperature_upper_limit)) {
	    	$sql = 'SELECT temperature,humidity FROM data WHERE sensor_id = :sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - $this->mold_mites_duration * 60)
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
						'logs' => array(
							'mold_mites_humidity_upper_limit' => $this->mold_mites_humidity_upper_limit,
							'mold_mites_temperature_upper_limit' => $this->mold_mites_temperature_upper_limit,
						),
					);
					return $this->alert($params);			
				}	
			}			
		}

		return false;
	}

    //通信断のチェック
    public function checkDisconnection() {
    	if(empty($this->disconnection_duration)) {
    		$this->disconnection_duration = Config::get("sensor_default_setting.disconnection_duration");
    	}

     	$sql = 'SELECT COUNT(*) AS count FROM data WHERE sensor_id = :sensor_id AND date >= :date';
		$query = DB::query($sql);
		$query->parameters(array(
			'sensor_id' => $this->name,
			'date' => date("Y-m-d H:i:s", $this->time - $this->disconnection_duration * 60)
		));
		$result = $query->execute('data');
		if($result[0]['count'] == 0) {
			$title = "通信断";
			$description = "通信断";
			$params = array(
				'type' => 'disconnection',
				'title' => $title,
				'description' => $description,
				'logs' => array(
					'disconnection_duration' => $this->disconnection_duration,
				),
			);
			return $this->alert($params);
		}
		return false;
    }

    //室内照度異常（日中）
    public function checkIlluminanceDaytime() {
    	$levels = Config::get("sensor_levels.illuminance_daytime");
    	$level = $levels[$this->illuminance_daytime_level - 1];

		if($this->illuminance_daytime_level > 0) {
	    	$sql = 'SELECT illuminance,date FROM data WHERE sensor_id = :sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - $level['duration'] * 60)
			));
			$result = $query->execute('data');
			$count = 0;
			if(count($result)) {
				foreach($result as $row) {
					$hour = date("h", strtotime($row['date']));
					if($level['start_time'] < $hour && $level['end_time'] > $hour) {
						$count++;
						if($level['lower_limit'] < $row['illuminance']) {
							$count--;
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
							'illuminance_daytime_lower_limit' => $level['lower_limit,']
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
    	$levels = Config::get("sensor_levels.illuminance_night");
    	$level = $levels[$this->illuminance_night_level - 1];

		if($this->illuminance_night_level > 0) {
	    	$sql = 'SELECT illuminance,date FROM data WHERE sensor_id = :sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'date' => date("Y-m-d H:i:s", $this->time - $level['duration'] * 60)
			));
			$result = $query->execute('data');
			$count = 0;
			if(count($result)) {
				foreach($result as $row) {
					$hour = date("h", strtotime($row['date']));
					if($level['start_time'] < $hour && $level['end_time'] > $hour) {
						$count++;
						if($level['lower_limit'] < $row['illuminance']) {
							$count--;
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
							'illuminance_night_lower_limit' => $level['lower_limit'],
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
    	$levels = Config::get("sensor_levels.fire");
    	$level = $levels[$this->fire_level - 1];

    	if($this->fire_level > 0) {

	    	$sql = 'SELECT * FROM data WHERE sensor_id = :sensor_id AND temperature > :temperature AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $this->name,
				'temperature' => $level['temperature_upper_limit'],
				'date' => date("Y-m-d H:i:s", $this->time - 60)
			));
			$result = $query->execute('data');
			if(!empty($result['temperature'])) {
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

    	$sql = 'SELECT active,date FROM data WHERE sensor_id = :sensor_id AND date BETWEEN :start_date AND :end_date';
    	$query = DB::query($sql);
    	$start_date = date("Y-m-d H:i:s", strtotime($date." ".$this->wake_up_start_time.":00:00"));
    	$end_date = date("Y-m-d H:i:s", strtotime($date." ".$this->wake_up_end_time.":00:00"));
 		$query->parameters(array(
			'sensor_id' => $this->name,
			'start_date' => $start_date,
			'end_date' => $end_date,
		));  
		$result = $query->execute('data');
		$count = count($result);
		$active_count = 0;
		$nonactive_count = 0;
		if($count) {

			foreach($result as $row) {
				if($level['threshold'] < $row['active']) {
					if($active_count === 0) {
						$wake_up_time = $row['date'];
					}
					$active_count++;
					if($active_count == $level['duration']) {
						//起床時間の保存
						$minutes = $nonactive_count + $active_count;

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
					if($nonactive_count == $level['ignore_duration']) {
						$active_count = 0;
					}
				}
			}
		}
		return false;
	}

	//就寝時間のチェック
	public function checkSleep() {
    	$levels = Config::get("sensor_levels.sleep");
    	$level = $levels[$this->sleep_level - 1];

    	$date = date("Y-m-d");
    	$hour = date("h");
		$daily_data = \Model_Data_Daily::find('first', array('where' => array(
			'sensor_id' => $this->id,
			'date' => $date,
		)));
		
    	$sql = 'SELECT active,date FROM data WHERE sensor_id = :sensor_id AND date BETWEEN :start_date AND :end_date ORDER BY date ASC';
    	$query = DB::query($sql);

		/**
		 * 日替わり前
		 * 設定：22〜4時
		 * 現在時刻が23時
		 * 現在時刻が2時
		 */

		/**
		 * 日替わり後
		 * 設定：25〜4時
		 * 現在時刻が2時
		 */

    	if($this->sleep_end_time > 24) {
    		$yesterday = date("Y-m-d", strtotime("-1day"));
    		$start_date = $yesterday." ".$this->sleep_start_time.":00:00";
    		$end_date = $date." ".$this->sleep_end_time.":00:00";
    	} else {
    		$yesterday = date("Y-m-d", strtotime("-1day"));
    		$start_date = $yesterday." ".$this->sleep_start_time.":00:00";
    		$end_date = $yesterday." ".$this->sleep_end_time.":00:00";
    	}

    	$start_date = date("Y-m-d H:i:s", strtotime($start_date));
    	$end_date = date("Y-m-d H:i:s", strtotime($end_date));

 		$query->parameters(array(
			'sensor_id' => $this->name,
			'start_date' => $start_date,
			'end_date' => $end_date,
		));  
		$result = $query->execute('data');

		$count = count($result);
		$active_count = 0;
		$nonactive_count = 0;
echo \DB::last_query("data");
echo "<table>";
		if($count) {
			foreach($result as $row) {
echo "<tr>";
echo "<td>";
echo $row['date'];
echo "</td>";
echo "<td>";
echo $row['active'];
echo "</td>";

				if($level['threshold'] > $row['active']) {
					if($nonactive_count === 0) {
						$sleep_time = $row['date'];
					}
					$nonactive_count++;
					$active_count = 0;
echo "<td>◯</td>";

				} else {
echo "<td>×</td>";
					$active_count++;
					$nonactive_count++;
					if($active_count == $level['ignore_duration']) {
						$nonactive_count = 0;
					}
				}
echo "<td>".$nonactive_count."</td>";
echo "<td>".$active_count."</td>";
echo "</tr>";
			}
		}
echo "</table>";

		if($nonactive_count >= $level['duration'] && isset($sleep_time)) {
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

    public function alert($params) {
    	$params['date'] = date("Y-m-d H:i:s", $this->time);
    	$params['sensor_id'] = $this->id;
    	$params['category'] = "emergency";
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
	    	Log::info($data, 'no alert');
			return false;
		} else {
	    	Log::info($data, 'alert');

			$params['confirm_status'] = 0;

			$alert = \Model_Alert::forge();
    		$alert->set($params);

    		foreach($this->users as $user) {
	    		$this->send_alert(array(
	    			'email' => $user['email'],
	    			'title' => $params['title'],
	    			'description' => $params['description'],
	    			'logs' => $params['logs'],
	    		));
    		}
	    	return $alert->save();
		}
    }

    public function send_alert($params) {
		$sendgrid = new SendGrid(Config::get("sendgrid"));
		$email = new SendGrid\Email();
		$email
		    ->addTo($params['email'])
		    ->setFrom(Config::get("email.from"))
		    ->setSubject($params['title']." ".$this->name)
		    ->setText($params['description']);
		try {
		    $sendgrid->send($email);
		    return true;
		} catch(\SendGrid\Exception $e) {
		    return false;
		}
    }
}