<?php
class Controller_Api_Data extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'test',
	        'analyze',
	        'alert',
	    );
	    parent::before();
	}

	public function get_dashboard() {
		return $this->_dashboard();
	}

	public function post_dashboard() {
		return $this->_dashboard();
	}

	public function isSensorAllowed($sensor) {
		list(, $user_id) = Auth::get_user_id();
		$master = Session::get("master");
		if(!empty($master)) {
			return true;
		} else if(!\Model_Sensor::isAllowed($sensor->id, $user_id)) {
			\Log::warning("user_id:[{$user_id}] sensor_id:[{$sensor->id}] is not allowed.", __METHOD__);
			$this->errors[] = array(
				'message' => 'センサーへのアクセスの許可がありません'
			);
			return false;
		} else {
			return true;
		}
	}
        
        /*
         * 出荷日を経過しているかどうか判定 
         * 
         * @param date $sippingDate
         * 
         * @return bool
         */
        public function isShippingDate($shippingDate)
        {
            if(strtotime($shippingDate) <= strtotime(Input::param('date'))) {
                return true;
            } else {
                \Log::warning("user_id:[{$user_id}] sensor_id:[{$sensor->id}] is not shipping_date.", __METHOD__);
                $this->errors[] = [
                            'message' => '未出荷または出荷日以前です。'
			];
                return false;
            }
        }

	public function _dashboard() {
		\Log::debug("Input::param - \n" . print_r(Input::param(), true), __METHOD__);

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

		$bedsensor = $this->get_bedsensor();
		
		if(!empty($sensor) && $this->isSensorAllowed($sensor) && $this->isShippingDate($sensor['shipping_date'])) {

			//日付を取得
			if(Input::param("date")) {
				$date = (new DateTime(Input::param("date"), new DateTimeZone('Asia/Tokyo')))->setTime(0, 0, 0);
			} else {
				$date = (new DateTime(null, new DateTimeZone('Asia/Tokyo')))->setTime(0, 0, 0);
			}

			$this->result = array(
				'sensor_id'   => $sensor->id,
				'sensor_name' => $sensor->name,
				'data'        => array("_dummy" => true),
			);

			if (!empty($bedsensor) && $this->isSensorAllowed($bedsensor)) {
				$bedsensor_name = $bedsensor->name;
				$this->result['bedsensor_id']   = $bedsensor->id;
				$this->result['bedsensor_name'] = $bedsensor_name;
			} else {
				$bedsensor_name = null;
			}

			//アラートの最新データ1件を取得する
			$alerts = \Model_Alert::getAlerts(array(
				'sensor_id'      => $sensor->id,
				'confirm_status' => 0,
				'limit'          => 1,
			));
			if(!empty($alerts[0])) {
				$this->result['data']['alert'] = $alerts[0];
			}
			// API からセンサーデータを取得
			$data = \Model_Api_Sensors_Daily::find_by_sensor_name_and_date($sensor->name, $bedsensor_name, $date);
			$this->result['data'] = array_merge($this->result['data'], $data);

			\Log::debug("result: " . print_r($this->result, true), __METHOD__);
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
		$sensor_name = Input::param("sensor_name");
		$sensor_id   = Input::param("sensor_id");
		if(empty($sensor_name) && empty($sensor_id)) {
			$this->errors[] = [
				'message' => 'センサーIDを指定してください'
			];
		} else if(!empty($sensor_name)) {
			$sensor = \Model_Sensor::getSensorFromSensorName($sensor_name);
		} else if(!empty($sensor_id)) {
			$sensor = \Model_Sensor::getSensor($sensor_id);
		}

		if(!empty($sensor) && $this->isSensorAllowed($sensor) && $this->isShippingDate($sensor['shipping_date'])) {
			$date = Input::param("date");
			if($date) {
				$date = (new DateTime($date, new DateTimeZone('Asia/Tokyo')))->setTime(0, 0, 0);
			} else {
				$date = (new DateTime(null, new DateTimeZone('Asia/Tokyo')))->setTime(0, 0, 0);
			}

			// API からセンサーデータを取得
			$data = \Model_Api_Sensors_Graph::find_by_sensor_name_and_date($sensor->name, $date);
			$this->result = [
				'sensor_id'   => $sensor->id,
				'sensor_name' => $sensor->name,
				'date'        => $date->format('Y-m-d'),
				'data'        => $data ?: [],
			];
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
			if($this->isSensorAllowed($sensor)) {

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
				if($hour >= 24) {
					$hour = $hour - 24;
				}
				$params['wake_up_time_average'] = $hour.":".$minutes.":00";				
			}

			if($sleep_time_count > 0) {
				$minutes = $sleep_time_total / $sleep_time_count;
				$hour = (int)($minutes / 60);
				$minutes = str_pad((int)($minutes - $hour * 60), 2, 0, STR_PAD_LEFT);
				if($hour >= 24) {
					$hour = $hour - 24;
				}
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

				Log::info($sensor->id."<>".$sensor->name, 'save analyze');
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
			try {
				$this->result['data'][] = array(
					'sensor_id' => $sensor->id,
					'disconnection' => $sensor->checkDisconnection(),				//通信断アラート
					'fire' => $sensor->checkFire(),									//火事アラート
					'temperature' => $sensor->checkTemperature(),					//室温異常通知
					'heatstroke' => $sensor->checkHeatstroke(),						//熱中症アラート
					'cold' => $sensor->checkCold(),						//風邪アラート
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
			} catch (Exception $e) {
				Log::info($e->getMessage(), 'alert error');
			}
        }
        return $this->result(); 
    }

	/**
	 * パラメータに bedsensor_name または bedsensor_id が存在する場合、ベッドセンサーを取得する
	 */
	private function get_bedsensor() {
		$bedsensor_name = Input::param("bedsensor_name");
		$bedsensor_id   = Input::param("bedsensor_id");
		if(!empty($bedsensor_name)) {
			return \Model_Sensor::getSensorFromSensorName($bedsensor_name);
		} else if(!empty($bedsensor_id)) {
			return \Model_Sensor::getSensor($bedsensor_id);
		}
		return null;
	}
}
