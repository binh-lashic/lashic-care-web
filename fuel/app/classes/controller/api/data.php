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
		$sensor_name = Input::param("sensor_name");
		if(!$sensor_name) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else {
			$data = \Model_Data::getLatestData($sensor_name);
			$sensor = \Model_Sensor::getSensorFromSensorName($sensor_name);
			$this->result = array(
				'sensor_name' => $sensor_name,
				'data' => array(),
			);
			if(isset($data) && isset($sensor)) {
				$temperature = $data['temperature'];
				$humidity = $data['humidity'];
				$this->result['data'] = array(
						'temperature' => round($temperature, 1),
						'temperature_average' => $sensor->temperature_average,
						'temperature_week_average' => $sensor->temperature_week_average,
						'humidity' => round($humidity, 1),
						'humidity_average' => $sensor->humidity_average,
						'humidity_week_average' => $sensor->humidity_week_average,
						'active' => round($data['active'], 1),
						'illuminance' =>  (int)$data['illuminance'],
						'discomfort' => $data['discomfort'],
						'wake_up_time' => '07:32:51',
						'wake_up_time_average' => '07:25:22',
						'sleep_time' => '22:33:43',
						'sleep_time_average' => '22:22:15',
				);
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
		$sensor_id = Input::param("sensor_id");
		$span = Input::param("span");

		$types = array(
			'temperature' => true,					//温度
			'humidity' => true,						//湿度
			'illuminance' => true,					//照度
			'lighting' => true,						//点灯
			'active' => true,						//運動
			'temperature_average' => true,			//温度平均
			'humidity_average' => true,				//湿度平均
			'illuminance_average' => true,  		//照度平均
			'lighting_average' => true,				//点灯平均
			'active_average' => true,				//運動平均
			'temperature_week_average' => true,		//温度曜日平均
			'humidity_week_average' => true,		//湿度曜日平均
			'illuminance_week_average' => true,  	//照度曜日平均
			'lighting_week_average' => true,		//点灯曜日平均
			'active_week_average' => true,			//運動曜日平均
			'sleep_time' => true,					//起寝時間
			'sleep_time_average' => true,			//起寝平均
			'sleep_time_week_average' => true,		//起寝曜日平均
		);

		if(!$type) {
			$this->errors[] = array(
				'message' => 'グラフのタイプを指定してください'
			);
		} else if(empty($types[$type])) {
			$this->errors[] = array(
				'message' => 'グラフのタイプが間違っています'
			);
		} else if(!$sensor_id) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else {
			if(empty($date)) {
				$date = date("Y-m-d");
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

			$sensor = \Model_Sensor::find($sensor_id);

			$sql = 'SELECT * FROM data WHERE sensor_id=:sensor_id AND date BETWEEN :start_time AND :end_time';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $sensor->name,
				'start_time' => date("Y-m-d H:i:s", $start_time),
				'end_time' => date("Y-m-d H:i:s", $end_time),
			));
			$results = $query->execute('data');
			$rows = array();
			foreach($results as $result) {
				$rows[$result['date']] = $result;
			}

			for($i = 0; $i <= $end; $i++) {
				$time = $start_time + $i * 60 * $span;
				$current_time = date("Y-m-d H:i:s", $time); 
				$data[] = array(
					'time' => $current_time,
					'label' => date("H:i", $time),
					'value' => !empty($rows[$current_time]) ? $rows[$current_time]['temperature'] : null,
					'temperature' => !empty($rows[$current_time]) ? $rows[$current_time]['temperature'] : null,
					'humidity' => !empty($rows[$current_time]) ? $rows[$current_time]['humidity'] : null,
					'illuminance' => !empty($rows[$current_time]) ? $rows[$current_time]['illuminance'] : null,
					'active' => !empty($rows[$current_time]) ? $rows[$current_time]['active'] : null,
				);
			}
			$this->result = array(
				'sensor_id' => $sensor_id,
				'type' => $type,
				'date' => $date,
				'span' => $span,
				'data' => $data,
			);
		}
		return $this->result();	
	}

	public function get_import() {
		$sensor_id = "00001";
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

	public function get_analyze() {
		/*
起床時間の定義

関連するパラメータの予定デフォルト値

起床判断開始時間：未定
起床判断終了時間：未定
運動量閾値：未定
起床判断期間：5分
起床不感帯期間：30分
起床判断期間以上継続して、運動量が運動量閾値を超えた場合に、同連続して運動量閾値を超えた期間の最初の時間を起床時間と定義する。
なお、途中でセンサーから外れる（運動量がゼロになる）場合などがあるため、起床不感帯期間を設ける。
起床判断中（起床時間が決定しておらず、運動量が運動量閾値を超えている最中）に、運動量閾値を下回ったとしても、起床不感帯期間以内に運動量が運動量閾値を超えた場合、起床判断を継続する。


就寝時間の定義

関連するパラメータの予定デフォルト値

就寝判断開始時間：未定
就寝判断終了時間：未定
運動量閾値：
就寝判断期間：5分
就寝不感帯期間：30分
就寝判断期間以上継続して、運動量が運動量閾値を超えた場合に、同連続して運動量閾値を下回った期間の最初の時間を就寝時間と定義する。
なお、途中でセンサーから外れる（運動量がゼロになる）場合などがあるため、就寝不感帯期間を設ける。
就寝判断中（就寝時間が決定しておらず、運動量が運動量閾値を超えている最中）に、運動量閾値を下回ったとしても、就寝不感帯期間以内に運動量が運動量閾値を下回った場合、起床判断を継続する。
		*/
		$sensors = \Model_Sensor::find("all");
		foreach($sensors as $sensor) {
			$sql = 'SELECT * FROM data WHERE sensor_id=:sensor_id AND date >= :date';
			$query = DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $sensor->name,
				'date' => date("Y-m-d H:i:s", strtotime("-30days"))
			));
			$result = $query->execute('data');
			$rows = $result->as_array();
			$count = count($rows);
			if($count > 0) {
				$temperature_total = 0;
				$temperature_average = 0;
				$humidity_total = 0;
				$humidity_average = 0;
				$temperature_week_total = array(0, 0, 0, 0, 0, 0, 0);
				$temperature_week_count = array(0, 0, 0, 0, 0, 0, 0);
				$temperature_week_average = array(0, 0, 0, 0, 0, 0, 0);
				$humidity_week_total = array(0, 0, 0, 0, 0, 0, 0);
				$humidity_week_count = array(0, 0, 0, 0, 0, 0, 0);
				$humidity_week_average = array(0, 0, 0, 0, 0, 0, 0);
				foreach($rows as $row) {
					$temperature_total += $row['temperature'];
					$humidity_total += $row['humidity'];
					$week = date("w", strtotime($row['date']));
					$temperature_week_total[$week] += $row['temperature'];
					$temperature_week_count[$week]++;
					$humidity_week_total[$week]  += $row['humidity'];
					$humidity_week_count[$week]++;
				}
				$temperature_average = $temperature_total / $count;
				$humidity_average = $humidity_total / $count;
				foreach($temperature_week_total as $week => $val) {
					if($temperature_week_count[$week] === 0) {
						$temperature_week_average[$week] = 0;
					} else {
						$temperature_week_average[$week] = $temperature_week_total[$week] / $temperature_week_count[$week];
					}
					if($humidity_week_count[$week] === 0) {
						$humidity_week_average[$week] = 0;
					} else {
						$humidity_week_average[$week] = $humidity_week_total[$week] / $humidity_week_count[$week];
					}					
				}
				$sensor->set(array(
					'temperature_average' => $temperature_average,
					'humidity_average' => $humidity_average,
					'temperature_week_average' => json_encode($temperature_week_average),
					'humidity_week_average' => json_encode($humidity_week_average),
				));
				$sensor->save();
			}
		} 
		return $this->result();	
	}

	public function get_alert() {
		if(Input::param("sensor_id")) {
			$sensors = array(\Model_Sensor::find(Input::param("sensor_id")));
		} else {
			$sensors = \Model_Sensor::find("all");
		}
		foreach($sensors as $sensor) {
			$this->result['data'][] = array(
				/*
				'sensor_id' => $sensor->id,
				'disconnection' => $sensor->checkDisconnection(),				//通信断アラート
				'fire' => $sensor->checkFire(),									//火事アラート
				'temperature' => $sensor->checkTemperature(),					//室温異常通知
				'heatstroke' => $sensor->checkHeatstroke(),						//熱中症アラート
				'humidity' => $sensor->checkHumidity(),							//室内湿度異常アラート
				'mold_mites' => $sensor->checkMoldMites(),						//カビ・ダニ警報アラート
				'illuminance_daytime' => $sensor->checkIlluminanceDaytime(),	//室内照度異常（日中）
				'illuminance_night' => $sensor->checkIlluminanceNight(),		//室内照度異常（深夜）
				*/
				'wake_up' => $sensor->checkWakeUp(),							//起床時間
				'sleep' => $sensor->checkSleep(),								//就寝時間

//低体温症アラート（要確認）
//通信復帰通知
//平均起床時間遅延
                       );
               }
               return $this->result(); 
       }

}