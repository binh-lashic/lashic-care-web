<?php

use Fascent\Careeye\Api\Client\Sensor as Sensor;
use Fascent\Careeye\Api\Client\BedSensor as BedSensor;

/**
 * Class Model_Api_Sensors_Latest
 */
class Model_Api_Sensors_Latest extends Model_Api_Base {
	/**
	 * @param string $sensor_name
	 * @param string $bedsensor_name
	 * @return array
	 */
	public static function find_by_sensor_name($sensor_name, $bedsensor_name, $limit) {
		$result = null;
		if ($sensor_name) {
			$result = self::get_sensor_data($sensor_name, $limit);
		} else if ($bedsensor_name) {
			$result = self::get_bed_sensor_data($bedsensor_name, $limit);
		}
		return $result; 
	}

	/**
	 * センサーのデータを取得する
	 * @param string $sensor_name
	 * @return array
	 */
	private static function get_sensor_data($sensor_name, $limit = 100) {
		$latests = null;
		$latests_api = new Sensor\Latests();

		\Log::debug("get latests data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$latests = $latests_api->get($sensor_name, $limit);
		\Log::debug("get latests data end. sensor_name:[{$sensor_name}] data:" . print_r($latests, true), __METHOD__);

		return self::get_contents($latests);
	}

	/**
	 * ベッドセンサーのデータを取得する
	 * @param string $sensor_name
	 * @return array
	 */
	private static function get_bed_sensor_data($sensor_name, $limit = 100) {
		$latests = null;
		$latests_api = new BedSensor\Latests();

		\Log::debug("get latests data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$latests = $latests_api->get($sensor_name, $limit);
		\Log::debug("get latests data end. sensor_name:[{$sensor_name}] data:" . print_r($latests, true), __METHOD__);

		return self::get_contents($latests);
	}
}
