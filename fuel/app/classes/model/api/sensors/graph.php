<?php

use Fascent\Careeye\Api\Client\Sensor as Sensor;
use Fascent\Careeye\Api\Client\BedSensor as BedSensor;

/**
 * Class Model_Api_Sensors_Graph
 */
class Model_Api_Sensors_Graph extends Model_Api_Base {
	/**
	 * @param string $sensor_name
	 * @param \DateTime $date
	 * @return array
	 */
	public static function find_by_sensor_name_and_date($sensor_name, $date) {
		$sensor_data = self::get_graph_data($sensor_name, $date);
		$result = self::to_formatted_result($sensor_data);
		return $result;
	}

	/**
	 * センサーのデータを取得する
	 * @param string $sensor_name
	 * @param \DateTime $date
	 * @return array
	 */
	private static function get_graph_data($sensor_name, $date) {
		$graphApi = new Sensor\Graph();

		\Log::debug("get graph data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$graph = $graphApi->get($sensor_name, $date);
		\Log::debug("get graph data end. sensor_name:[{$sensor_name}]", __METHOD__);

		return self::get_contents($graph);
	}


	/**
	 * API 取得結果を careeye-web の API 用に変換
	 */
	private static function to_formatted_result($sensor_data) {
		$timezone = new DateTimeZone('Asia/Tokyo');

		$result = array_map(function ($data) use($timezone) {
			$formatted = [];
			$formatted['time']        = $data['created_at'];
			$formatted['label']       = (new DateTime($data['created_at'], $timezone))->format('H:i');
			$formatted['temperature'] = round($data['temperature'], 1);
			$formatted['humidity']    = round($data['humidity'], 1);
			$formatted['illuminance'] = (int)$data['illuminance'];
			$formatted['active']      = round($data['activity'], 1);
			$formatted['discomfort']  = round($data['discomfort'], 1);
			$formatted['wbgt']        = round($data['wbgt'], 1);
			$formatted['cold']        = round($data['cold'], 1);
			return $formatted;
		}, $sensor_data);
		return $result;
	}
}
