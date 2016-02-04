<?php
class Controller_Api_Data extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'dashboard',
	        'graph',
	        'test',
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
		$sensor_id = Input::param("sensor_id");
		if(!$sensor_id) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else {
			$sql = "SELECT * FROM data WHERE sensor_id = '".$sensor_id."' ORDER BY date DESC OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY";
			$res = DB::query($sql)->execute("data");
			$rows = $res->as_array();
			$this->result = array(
				'sensor_id' => $sensor_id,
				'data' => array(),
			);
			if(isset($rows[0])) {
				$temperature = $rows[0]['temperature'];
				$humidity = $rows[0]['humidity'];
				$discomfort = 0.81 * $temperature + 0.01 * $humidity * (0.99 * $temperature - 14.3) + 46.3;
				$this->result['data'] = array(
						'temperature' => round($temperature, 1),
						'humidity' => round($humidity, 1),
						'active' => round($rows[0]['active'], 1),
						'illuminance' =>  (int)$rows[0]['illuminance'],
						'discomfort' => ceil($discomfort),
				);
			}
		}
		return $this->result();	
	}

	public function get_graph() {
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

			for($i = 0; $i <= $end; $i++) {
				$current_time = date("Y-m-d H:i:s", $start_time + $i * 60 * $span); 
				$data[] = array(
					'time' => $current_time,
					'value' => mt_rand(10, 40),
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
}
