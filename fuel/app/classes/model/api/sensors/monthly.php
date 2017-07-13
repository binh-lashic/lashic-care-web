<?php

use Fascent\Careeye\Api\Client\Sensor as Sensor;
use Fascent\Careeye\Api\Client\BedSensor as BedSensor;

/**
 * Class Model_Api_Sensors_Monthly
 */
class Model_Api_Sensors_Monthly extends Model_Api_Base {
	/**
	 * @param string $sensor_name
	 * @param string $bedsensor_name
	 * @return array
	 */
	public static function find_by_sensor_name($sensor_name, $bedsensor_name) {
		$result = null;
		if ($sensor_name) {
			$result = self::get_sensor_data($sensor_name);
		} else if ($bedsensor_name) {
			$result = self::get_bed_sensor_data($bedsensor_name);
		}
		return $result; 
	}

	/**
	 * センサーのデータを取得する
	 * @param string $sensor_name
	 * @return array
	 */
	private static function get_sensor_data($sensor_name) {
		$monthlies = null;
		$monthlies_api = new Sensor\Monthlies();

		\Log::debug("get monthlies data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$monthlies = $monthlies_api->get($sensor_name);
		\Log::debug("get monthlies data end. sensor_name:[{$sensor_name}] data:" . print_r($monthlies, true), __METHOD__);

		return self::get_contents($monthlies);
	}

	/**
	 * ベッドセンサーのデータを取得する
	 * @param string $sensor_name
	 * @return array
	 */
	private static function get_bed_sensor_data($sensor_name) {
		$monthlies = null;
		$monthlies_api = new BedSensor\Monthlies();

		\Log::debug("get monthlies data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$monthlies = $monthlies_api->get($sensor_name);
		\Log::debug("get monthlies data end. sensor_name:[{$sensor_name}] data:" . print_r($monthlies, true), __METHOD__);

		return self::get_contents($monthlies);
	}
}
