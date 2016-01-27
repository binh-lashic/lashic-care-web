<?php
class Controller_Api_Data extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'dashboard',
	        'graph',
	    );
	    parent::before();
	}

	public function get_dashboard() {
		$sensor_id = Input::param("sensor_id");
		if(!$sensor_id) {
			$this->errors[] = array(
				'message' => 'センサーIDを指定してください'
			);
		} else {
			$this->result = array(
				'sensor_id' => $sensor_id,
				'data'	=>	array(
					'temperature' => 14.1,
					'humidity' => 41.7,
					'active' => 69.1,
					'iluminance' =>  1000,
					'discomfort' => 58,
				)
			);
		}
		return $this->result();	
	}

	public function get_graph() {
		$type = Input::param("type");
		$date = Input::param("date");
		$sensor_id = Input::param("sensor_id");

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
			$data = array();
			$start_time = strtotime($date." 00:00:00");
			$end_time = strtotime($date." 24:00:00");
			for($i = 0; $i <= 144; $i++) {
				$current_time = date("Y-m-d H:i:s", $start_time + $i * 60 * 10); 
				$data[] = array(
					'time' => $current_time,
					'value' => mt_rand(10, 40),
				);
			}
			$this->result = array(
				'sensor_id' => $sensor_id,
				'type' => $type,
				'date' => $date,
				'data' => $data,
			);
		}
		return $this->result();	
	}
}
