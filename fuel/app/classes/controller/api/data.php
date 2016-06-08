<?php
class Controller_Api_Data extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'graph',
	        'test',
	        'analyze',
	        'alert',
	    );
	    parent::before();
	}

	public function get_test() {
		$sql = "SELECT * FROM data ORDER BY date DESC OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY";
		$res = DB::query($sql)->execute("data");
		$data = $res->as_array();
		$this->result = $data;
 		return $this->result();
	}

	public function get_dashboard() {
		return $this->_dashboard();
	}

	public function post_dashboard() {
		return $this->_dashboard();
	}

	public function _dashboard() {
		$sensor_name = Input::param("sensor_name");
		$sensor_id = Input::param("sensor_id");
		if(empty($sensor_name) && empty($sensor_id)) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else if(!empty($sensor_name)) {
			$sensor = \Model_Sensor::getSensorFromSensorName($sensor_name);
		} else if(!empty($sensor_id)) {
			$sensor = \Model_Sensor::getSensor($sensor_id);
		}
		
		if(!empty($sensor)) {
			//日付を取得
			if(Input::param("date")) {
				$date = date("Y-m-d", strtotime(Input::param("date")));
			} else {
				$date = date("Y-m-d");
			}

			$this->result = array(
				'sensor_id' => $sensor->id,
				'sensor_name' => $sensor->name,
				'data' => array("_dummy" => true),
			);

			//アラートの最新データ1件を取得する
			$alerts = \Model_Alert::getAlerts(array(
				'sensor_id' => $sensor->id,
				'confirm_status' => 0,
				'limit' => 1,
			));
			if(!empty($alerts[0])) {
				$this->result['data']['alert'] = $alerts[0];
			}

			$data_daily = \Model_Data_DAily::getData($sensor->id, $date);

			if(!empty($data_daily)) {
				if(!empty($data_daily['wake_up_time'])) {
					$this->result['data']['wake_up_time'] = date("H:i:s", strtotime($data_daily['wake_up_time']));
				}

				if(!empty($data_daily['wake_up_time_average'])) {
					$this->result['data']['wake_up_time_average'] = $data_daily['wake_up_time_average'];
				}

				if(!empty($data_daily['sleep_time'])) {
					$this->result['data']['sleep_time'] = date("H:i:s", strtotime($data_daily['sleep_time']));
				}

				if(!empty($data_daily['sleep_time_average'])) {
					$this->result['data']['sleep_time_average'] = $data_daily['sleep_time_average'];
				}
				
				if(!empty($data_daily['temperature_average'])) {
					$this->result['data']['temperature']  = round($data_daily['temperature_average'], 1);
				}
				if(!empty($data_daily['humidity_average'])) {
					$this->result['data']['humidity']  = round($data_daily['humidity_average'], 1);
				}
				if(!empty($data_daily['active_average'])) {
					$this->result['data']['active']  = round($data_daily['active_average'], 1);
				}
				if(!empty($data_daily['illuminance_average'])) {
					$this->result['data']['illuminance']  = (int)$data_daily['illuminance_average'];
				}
				if(!empty($data_daily['discomfort_average'])) {
					$this->result['data']['discomfort']  = $data_daily['discomfort_average'];
				}
			}

			//今日だったら最新データにする
			if($date === date("Y-m-d")) {
				$data = \Model_Data::getLatestData($sensor->name);
				if(!empty($data) && isset($sensor)) {
					$this->result['data']['temperature'] = round($data['temperature'], 1);
					$this->result['data']['humidity'] = round($data['humidity'], 1);
					$this->result['data']['active'] = round($data['active'], 1);
					$this->result['data']['illuminance'] =  (int)$data['illuminance'];
					$this->result['data']['discomfort'] = $data['discomfort'];
					$this->result['data']['date'] = $data['date'];
				}
			}
		}
		return $this->result();	
	}

	public function get_graph() {
		return $this->_graph();
	}

	public function post_graph() {
		return $this->_graph();
	}

	public function _graph() {
		$type = Input::param("type");
		$date = Input::param("date");
		$span = Input::param("span");

		$types = array(
			'temperature' => true,					//温度
			'humidity' => true,						//湿度
			'illuminance' => true,					//照度
			'active' => true,						//運動
			'discomfort' => true,					//不快指数
		);
		$sensor_name = Input::param("sensor_name");
		$sensor_id = Input::param("sensor_id");
		if(empty($sensor_name) && empty($sensor_id)) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else if(!empty($sensor_name)) {
			$sensor = \Model_Sensor::getSensorFromSensorName($sensor_name);
		} else if(!empty($sensor_id)) {
			$sensor = \Model_Sensor::getSensor($sensor_id);
		}

		if(!$type) {
			$this->errors[] = array(
				'message' => 'グラフのタイプを指定してください'
			);
		} else if(empty($types[$type])) {
			$this->errors[] = array(
				'message' => 'グラフのタイプが間違っています'
			);
		} else if(!empty($sensor)) {
			if(empty($date)) {
				$date = date("Y-m-d");
			} else {
				$date = date("Y-m-d", strtotime($date));
			}
			if(empty($span)) {
				$span = 10;
			} else if($span < 0) {
				$span = 1;
			} else if($span > 240) {
				$span = 240;
			}
			$data = array();
			$start_time = strtotime($date." 00:00:00");
			$end_time = strtotime($date." 24:00:00");
			$end = 60 * 24 / $span;

			$sql = 'SELECT * FROM data WHERE sensor_id=:sensor_name AND date BETWEEN :start_time AND :end_time';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_name' => $sensor->name,
				'start_time' => date("Y-m-d H:i:s", $start_time),
				'end_time' => date("Y-m-d H:i:s", $end_time),
			));
			$results = $query->execute('data');
			$rows = array();
			foreach($results as $result) {
				$result = Model_Data::format($result);
				$rows[$result['date']] = $result;
			}

			for($i = 0; $i <= $end; $i++) {
				$time = $start_time + $i * 60 * $span;
				$current_time = date("Y-m-d H:i:s", $time); 

				if(!empty($rows[$current_time])) {
					$value = $rows[$current_time][$type];
				} else {
					$value = null;
				}
				
				$data[] = array(
					'time' => $current_time,
					'label' => date("H:i", $time),
					'value' => $value,
					'temperature' => !empty($rows[$current_time]) ? $rows[$current_time]['temperature'] : null,
					'humidity' => !empty($rows[$current_time]) ? $rows[$current_time]['humidity'] : null,
					'illuminance' => !empty($rows[$current_time]) ? $rows[$current_time]['illuminance'] : null,
					'active' => !empty($rows[$current_time]) ? $rows[$current_time]['active'] : null,
					'discomfort' => !empty($rows[$current_time]) ? $rows[$current_time]['discomfort'] : null,
				);
			}
			$this->result = array(
				'sensor_id' => $sensor->id,
				'sensor_name' => $sensor->name,
				'type' => $type,
				'date' => $date,
				'span' => $span,
				'data' => $data,
			);
		}
		return $this->result();	
	}


	public function get_graph2() {
		return $this->_graph2();
	}

	public function post_graph2() {
		return $this->_graph2();
	}

	public function _graph2() {
		$type = Input::param("type");
		$date = Input::param("date");
		$span = Input::param("span");

		$types = array(
			'temperature' => true,					//温度
			'humidity' => true,						//湿度
			'illuminance' => true,					//照度
			'active' => true,						//運動
			'discomfort' => true,					//不快指数
		);
		$sensor_name = Input::param("sensor_name");
		$sensor_id = Input::param("sensor_id");
		if(empty($sensor_name) && empty($sensor_id)) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else if(!empty($sensor_name)) {
			$sensor = \Model_Sensor::getSensorFromSensorName($sensor_name);
		} else if(!empty($sensor_id)) {
			$sensor = \Model_Sensor::getSensor($sensor_id);
		}

		if(!$type) {
			$this->errors[] = array(
				'message' => 'グラフのタイプを指定してください'
			);
		} else if(empty($types[$type])) {
			$this->errors[] = array(
				'message' => 'グラフのタイプが間違っています'
			);
		} else if(!empty($sensor)) {
			if(empty($date)) {
				$date = date("Y-m-d");
			} else {
				$date = date("Y-m-d", strtotime($date));
			}
			if(empty($span)) {
				$span = 10;
			} else if($span < 0) {
				$span = 1;
			} else if($span > 240) {
				$span = 240;
			}
			$data = array();
			$start_time = strtotime($date." 00:00:00");
			$end_time = strtotime($date." 24:00:00");


			$sql = 'SELECT * FROM data WHERE sensor_id=:sensor_name AND date BETWEEN :start_time AND :end_time';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_name' => $sensor->name,
				'start_time' => date("Y-m-d H:i:s", $start_time),
				'end_time' => date("Y-m-d H:i:s", $end_time),
			));
			$results = $query->execute('data');
			$rows = array();
			foreach($results as $result) {
				$result = Model_Data::format($result);
				$rows[$result['date']] = $result;
			}

			$end = 60 * 24; //10分毎に行う
			for($i = 0; $i <= $end; $i = $i + 10) {
				$time = $start_time + $i * 60;
				$temperature_total = 0;
				$humidity_total = 0;
				$illuminance_total = 0;
				$active_total = 0;
				$discomfort_total = 0;
				$averages = array(
					'temperature' => null,
					'humidity' => null,
					'illuminance' => null,
					'active' => null,
					'discomfort' => null,
				);
				$span_time = date("Y-m-d H:i:s", $time);
				$data_count = 0;
				for($j = 0; $j < 10; $j++) {
					$current_time = date("Y-m-d H:i:s", $start_time + ($i + $j)* 60);
					if(isset($rows[$current_time])) {
						$temperature_total += $rows[$current_time]['temperature'];
						$humidity_total += $rows[$current_time]['humidity'];
						$illuminance_total += $rows[$current_time]['illuminance'];
						$active_total += $rows[$current_time]['active'];
						$discomfort_total += $rows[$current_time]['discomfort'];
						$data_count++;
					}					
				}

				if($data_count > 0) {
					$averages['temperature'] = $temperature_total / $data_count;
					$averages['humidity'] = $humidity_total / $data_count;
					$averages['illuminance'] = $illuminance_total / $data_count;
					$averages['active'] = $active_total / $data_count;
					$averages['discomfort'] = $discomfort_total / $data_count;
				}
				$value = $averages[$type];

				$data[] = array(
					'time' => $span_time,
					'label' => date("H:i", $time),
					'value' => $value,
					'temperature' => $averages['temperature'],
					'humidity' => $averages['humidity'],
					'illuminance' => $averages['illuminance'],
					'active' => $averages['active'],
					'discomfort' => $averages['discomfort'],
				);
			}
			$this->result = array(
				'sensor_id' => $sensor->id,
				'sensor_name' => $sensor->name,
				'type' => $type,
				'date' => $date,
				'span' => $span,
				'data' => $data,
			);
		}
		return $this->result();	
	}

	public function get_graph_daily() {
		return $this->_graph_daily();
	}

	public function post_graph_daily() {
		return $this->_graph_daily();
	}

	public function _graph_daily() {
		$date = Input::param("date");
		$sensor_name = Input::param("sensor_name");
		$sensor_id = Input::param("sensor_id");
		if(empty($sensor_name) && empty($sensor_id)) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else if(!empty($sensor_name)) {
			$sensor = \Model_Sensor::getSensorFromSensorName($sensor_name);
		} else if(!empty($sensor_id)) {
			$sensor = \Model_Sensor::getSensor($sensor_id);
		}

		if(!empty($sensor)) {
			if(empty($date)) {
				$start_date = date("Y-m-01");
				$date = date("Y-m");
			} else {
				$start_date = date("Y-m-01", strtotime($date));
			}
			$data = array();

			$sql = 'SELECT * FROM data_daily WHERE sensor_id=:sensor_id AND date BETWEEN :start_date AND :end_date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $sensor->id,
				'start_date' => $start_date,
				'end_date' => date("Y-m-t", strtotime($start_date)),
			));
			$results = $query->execute();

			$rows = array();
			foreach($results as $result) {
				$key = (int)date("d", strtotime($result['date']));
				$rows[$key] = $result;
			}			

			$end = date("t", strtotime($start_date));
			$month = date("Y-m", strtotime($start_date));
			$sleeping_hours_diff = array();
			for($current_time = 1; $current_time <= $end; $current_time++) {
				if(!empty($rows[$current_time]) && !empty($rows[$current_time]['wake_up_time']) && !empty($rows[$current_time]['sleep_time'])) {
					$diff = strtotime($rows[$current_time]['wake_up_time']) - strtotime($rows[$current_time]['sleep_time']);
					$sleeping_hours_diff[] = $diff;
					$sleeping_hours = gmdate("H:i:s", $diff);
				} else {
					$sleeping_hours = null;
				}

				$data[] = array(
					'date' => $month."-".$current_time,
					'label' => $current_time,
					'wake_up_time' => !empty($rows[$current_time]) ? $rows[$current_time]['wake_up_time'] : null,
					'sleep_time' => !empty($rows[$current_time]) ? $rows[$current_time]['sleep_time'] : null,
					'sleeping_hours' => $sleeping_hours,
				);
			}
			if($sleeping_hours_diff) {
				$sleeping_hours = gmdate("H:i:s", array_sum($sleeping_hours_diff) / count($sleeping_hours_diff));
			} else {
				$sleeping_hours = null;
			}
			$this->result = array(
				'sensor_id' => $sensor->id,
				'sensor_name' => $sensor->name,
				'date' => $date,
				'average' => array(
					'sleeping_hours' => $sleeping_hours,
				),
				'data' => $data,
			);
		}
		return $this->result();	
	}

	public function get_import() {
		$sensor_id = "0000c";
		$url = "http://infic.papaikuji.info/api/data/dashboard?sensor_name=".$sensor_id."&device_id=11111";
		$json = json_decode(file_get_contents($url), true);
		$params = $json['data'];
		$params['corporate_id'] = '00000';
		$params['sensor_id'] = $sensor_id;
		$params['date'] = date("Y-m-d H:i:00");

		unset($params['discomfort']);
		$data = \Model_Data::forge();
		$data->set($params);
		try {
			if($data->save()) {
				$this->result['data'] = $params;
			}
		} catch(Exception $e) {

		}

		return $this->result();	
	}

	//1日に1回24時に実行する
	public function get_analyze() {
		if(Input::param("date")) {
			$time = strtotime(Input::param("date"));
		} else {
    		$time = strtotime("-1day");
		}
    	$date = date("Y-m-d", $time);
    	$start_date = date("Y-m-d 00:00:00", $time);
		$end_date = date("Y-m-d 23:59:59", $time);	

		if(Input::param("sensor_id")) {
			$sensors = array(\Model_Sensor::find(Input::param("sensor_id")));
		} else {
			$sensors = \Model_Sensor::find("all", array(
				'where' => array(
					'enable' => 1,
				)
			));
		}
		foreach($sensors as $sensor) {
			$params = array(
				'sensor_id' => $sensor->id,
				'date' => $date,
			);
			$rows = \Model_Data_Daily::query()
				->where('sensor_id', $sensor->id)
				->where('date', 'between', array(
					date("Y-m-d", strtotime("-31day")),
					date("Y-m-d", strtotime("-1day"))
				))
				->get();
			$wake_up_time_total = 0;
			$sleep_time_total = 0;
			$wake_up_time_count = 0;
			$sleep_time_count = 0;
			foreach($rows as $row) {
				if(!empty($row['wake_up_time'])) {
					$wake_up_time_count++;
					$wake_up_time_total += (strtotime($row['wake_up_time']) - (strtotime($row['date']))) / 60;
					//$wake_up_time_total += date("h", strtotime($row['wake_up_time'])) * 60 + date("i", strtotime($row['wake_up_time']));
				}
				if(!empty($row['sleep_time'])) {
					$sleep_time_count++;
					$sleep_time_total += (strtotime($row['sleep_time']) - (strtotime($row['date']) - 60 * 60 * 24)) / 60;
				}
			}

			if($wake_up_time_count > 0) {
				$minutes = $wake_up_time_total / $wake_up_time_count;
				$hour = (int)($minutes / 60);
				$minutes = str_pad((int)($minutes - $hour * 60), 2, 0, STR_PAD_LEFT);
				$params['wake_up_time_average'] = $hour.":".$minutes.":00";				
			}

			if($sleep_time_count > 0) {
				$minutes = $sleep_time_total / $sleep_time_count;
				$hour = (int)($minutes / 60);
				$minutes = str_pad((int)($minutes - $hour * 60), 2, 0, STR_PAD_LEFT);
				$params['sleep_time_average'] = $hour.":".$minutes.":00";
			}

    		$sql = 'SELECT * FROM data WHERE sensor_id = :sensor_id AND date BETWEEN :start_date AND :end_date';
	    	$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $sensor->name,
				'start_date' => $start_date,
				'end_date' => $end_date,
			));
			$result = $query->execute('data');
			$rows = $result->as_array();
			$count = count($rows);
			if($count > 0) {
				$temperature_total = 0;
				$humidity_total = 0;
				$active_total = 0;
				$illuminance_total = 0;
				foreach($rows as $row) {
					$temperature_total += $row['temperature'];
					$humidity_total += $row['humidity'];
					$active_total += $row['active'];
					$illuminance_total += $row['illuminance'];
				}
				$params['temperature_average'] = $temperature_total / $count;
				$params['humidity_average'] = $humidity_total / $count;
				$params['active_average'] = $active_total / $count;
				$params['illuminance_average'] = $illuminance_total / $count;

				$data_daily = \Model_Data_Daily::find('first', array('where' => array(
					'sensor_id' => $sensor->id,
					'date' => $date,
				)));
				if(empty($data_daily)) {
					$data_daily =  \Model_Data_Daily::forge();
				}
				$data_daily->set($params);
				$data_daily->save();	
			}
		} 
		return $this->result();	
	}

	public function get_alert() {
		$time = strtotime(date("Y-m-d H:i:00"));
		//開通確認
		$sensors = \Model_Sensor::find("all", array(
			'where' => array(
				'enable' => 0,
				array('shipping_date', "<", date("Y-m-d H:i:s"))
			)
		));
		foreach($sensors as $sensor) {
			$result = DB::select("*")
					    ->from('data')
					    ->where('sensor_id', $sensor->name)
					    ->where('date', date("Y-m-d H:i:00", $time - 60))
					    ->execute('data');
			if(isset($result)) {
				$sensor->set(array('enable' => 1));
				$sensor->save();
			}
		}


		if(Input::param("sensor_id")) {
			$sensors = array(\Model_Sensor::find(Input::param("sensor_id")));
		} else {
			$sensors = \Model_Sensor::find("all", array(
				'where' => array(
					'enable' => 1,
				)
			));
		}
		foreach($sensors as $sensor) {
			$sensor->users;
			$sensor->setTime($time);
			$this->result['data'][] = array(
				'sensor_id' => $sensor->id,
				'disconnection' => $sensor->checkDisconnection(),				//通信断アラート
				'fire' => $sensor->checkFire(),									//火事アラート
				'temperature' => $sensor->checkTemperature(),					//室温異常通知
				'heatstroke' => $sensor->checkHeatstroke(),						//熱中症アラート
				'humidity' => $sensor->checkHumidity(),							//室内湿度異常アラート
				'mold_mites' => $sensor->checkMoldMites(),						//カビ・ダニ警報アラート
				'illuminance_daytime' => $sensor->checkIlluminanceDaytime(),	//室内照度異常（日中）
				'illuminance_night' => $sensor->checkIlluminanceNight(),		//室内照度異常（深夜）
				'wake_up' => $sensor->checkWakeUp(),							//起床時間 //平均起床時間遅延
				'sleep' => $sensor->checkSleep(),								//就寝時間 //平均睡眠時間遅延
				'abnormal_behavior' => $sensor->checkAbnormalBehavior(),		//異常行動（夜間、照明をつけずに動いている）
				'active_non_detection' => $sensor->checkActiveNonDetection(),	//一定時間人感センサー未感知
//通信復帰通知
                       );
               }
               return $this->result(); 
       }

}