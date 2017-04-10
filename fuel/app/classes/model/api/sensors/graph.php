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
		$result = self::to_formatted_result($sensor_data, $date);
		\Log::debug("formatted api result : " . print_r($result, true), __METHOD__);
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
	private static function to_formatted_result($sensor_data, $date) {
		$timezone = new DateTimeZone('Asia/Tokyo');

		$result = self::initialize_formatted_result();

		foreach($sensor_data as $data) {
			$created_at = new DateTime($data['created_at'], $timezone);
			if (\Util_Datetime::is_same_day($date, $created_at)) {
				$time = $created_at->format('H:i');
			} else {
				// 翌日のデータ(00:00)が含まれた場合のキーは 24:00 とする
				$time = '24:00';
			}

			$formatted = [
				'time'        => $data['created_at'],
				'label'       => $time,
				'temperature' => round($data['temperature'], 1),
				'humidity'    => round($data['humidity'], 1),
				'illuminance' => (int)$data['illuminance'],
				'active'      => round($data['activity'], 1),
				'discomfort'  => round($data['discomfort'], 1),
				'wbgt'        => round($data['wbgt'], 1),
				'cold'        => round($data['cold'], 1),
			];
			$result[$time] = $formatted;
		}
		return array_values($result);
	}

	/**
	 * API 結果フォーマットの初期化処理
	 * 24H 分(00:00~24:00)までの空の連想配列を作成する
	 */
	private static function initialize_formatted_result() {
		$result  = [];
		$hours   = 0;
		$minutes = 0;

		do {
			$hours_str   = substr(('00' . $hours), -2);
			$minutes_str = substr(('00' . $minutes), -2);
			$time        = $hours_str . ":" . $minutes_str;

			$result[$time] = [
				'label' => $time,
			];

			$minutes += 10;
			if ($minutes >= 60) {
				$hours += 1;
				$minutes = 0;
			}
		} while (($hours <= 23) || ($hours === 24 && $minutes === 0));

		return $result;
	}
}
