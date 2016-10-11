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
				if(!empty($data_daily['wbgt_average'])) {
					$this->result['data']['wbgt']  = $data_daily['wbgt_average'];
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
					$this->result['data']['wbgt'] = $data['wbgt'];
					$this->result['data']['date'] = $data['date'];
				}
			}
		}
		return $this->result();	
	}

	public function get_graph_org() {
		return $this->_graph_org();
	}

	public function post_graph_org() {
		return $this->_graph_org();
	}

	public function _graph_org() {
		$type = Input::param("type");
		$date = Input::param("date");
		$span = Input::param("span");

		$types = array(
			'temperature' => true,					//温度
			'humidity' => true,						//湿度
			'illuminance' => true,					//照度
			'active' => true,						//運動
			'discomfort' => true,					//不快指数
			'wbgt' => true,							//熱中症指数
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
			//$sql = "SELECT SUBSTRING(CONVERT(NVARCHAR, date, 114),0,16) AS date, avg(active), avg(temperature) FROM data WHERE sensor_id = :sensor_name AND date BETWEEN :start_time AND :end_time GROUP BY SUBSTRING(CONVERT(NVARCHAR, date, 114),0,16)";
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
					'wbgt' => !empty($rows[$current_time]) ? $rows[$current_time]['wbgt'] : null,
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
			'wbgt' => true,							//熱中症指数
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
			//$results = $query->cached(60)->execute('data');
			$results = $query->execute('data');
			$rows = array();
			foreach($results as $result) {
				$result = Model_Data::format($result);
				$rows[$result['date']] = $result;
			}

			$end = 60 * 24; //10分毎に行う
			for($i = 0; $i <= $end; $i = $i + $span) {
				$time = $start_time + $i * 60;
				$temperature_total = 0;
				$humidity_total = 0;
				$illuminance_total = 0;
				$active_total = 0;
				$discomfort_total = 0;
				$wbgt_total = 0;
				$averages = array(
					'temperature' => null,
					'humidity' => null,
					'illuminance' => null,
					'active' => null,
					'discomfort' => null,
					'wbgt' => null,
				);
				$span_time = date("Y-m-d H:i:s", $time);
				$data_count = 0;
				for($j = 0; $j < $span; $j++) {
					$current_time = date("Y-m-d H:i:s", $start_time + ($i + $j)* 60);
					if(isset($rows[$current_time])) {
						$temperature_total += $rows[$current_time]['temperature'];
						$humidity_total += $rows[$current_time]['humidity'];
						$illuminance_total += $rows[$current_time]['illuminance'];
						$active_total += $rows[$current_time]['active'];
						$discomfort_total += $rows[$current_time]['discomfort'];
						$wbgt_total += $rows[$current_time]['wbgt'];
						$data_count++;
					}					
				}

				if($data_count > 0) {
					$averages['temperature'] = $temperature_total / $data_count;
					$averages['humidity'] = $humidity_total / $data_count;
					$averages['illuminance'] = $illuminance_total / $data_count;
					$averages['active'] = $active_total / $data_count;
					$averages['discomfort'] = $discomfort_total / $data_count;
					$averages['wbgt'] = $wbgt_total / $data_count;
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
					'wbgt' => $averages['wbgt'],
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

}