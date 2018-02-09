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
	public static function find_by_sensor_name($sensor_name, $bedsensor_name, $limit = 1000) {
		$result = null;
		if ($sensor_name) {
			$result = self::get_sensor_data($sensor_name, $limit);
		} else if ($bedsensor_name) {
			$result = self::get_bed_sensor_data($bedsensor_name, $limit);
		}
		return $result; 
	}

	/**
	 * find_by_latest
	 * 
	 * @param string $sensor_name
	 * @param string $bedsensor_name
	 */
	public static function find_by_latest($sensor_name, $bedsensor_name)
	{
		$result = null;
		if ($sensor_name) {
			$result = self::get_sensor_latest($sensor_name);
		} else if ($bedsensor_name) {
			$result = self::get_bedsensor_latest($bedsensor_name);
		}
		return $result; 
	}
        
	/**
	 * センサーのデータを取得する(複数)
	 * @param string $sensor_name
	 * @return array
	 */
	private static function get_sensor_data($sensor_name, $limit) {
		$latests = null;
		$latests_api = new Sensor\Latests();

		\Log::debug("get latests data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$latests = $latests_api->get($sensor_name, $limit);
		\Log::debug("get latests data end. sensor_name:[{$sensor_name}] data:" . print_r($latests, true), __METHOD__);

		return self::get_contents($latests);
	}

	/**
	 * ベッドセンサーのデータを取得する(複数)
	 * @param string $sensor_name
	 * @return array
	 */
	private static function get_bed_sensor_data($sensor_name, $limit) {
		$latests = null;
		$latests_api = new BedSensor\Latests();

		\Log::debug("get latests data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$latests = $latests_api->get($sensor_name, $limit);
		\Log::debug("get latests data end. sensor_name:[{$sensor_name}] data:" . print_r($latests, true), __METHOD__);

		return self::get_contents($latests);
	}

        /**
         * get_sensor_latest
         * ベッドセンサーのデータを取得する
         * 
         * @param string $sensor_name
         */
	private static function get_sensor_latest($sensor_name)
	{
		$latests = null;
		$latests_api = new Sensor\Latest();

		\Log::debug("get sensor latest data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$latests = $latests_api->get($sensor_name, $limit);
		\Log::debug("get sensor latest data end. sensor_name:[{$sensor_name}] data:" . print_r($latests, true), __METHOD__);

		return self::get_contents($latests);
	}
        
        /**
         * get_bed_sensor_latest
         * ベッドセンサーのデータを取得する
         * 
         * @param string $sensor_name
         */
	private static function get_bedsensor_latest($sensor_name)
	{
		$latests = null;
		$latests_api = new BedSensor\Latest();

		\Log::debug("get bedsensor latest data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$latests = $latests_api->get($sensor_name, $limit);
		\Log::debug("get bedsensor latest data end. sensor_name:[{$sensor_name}] data:" . print_r($latests, true), __METHOD__);

		return self::get_contents($latests); 
	}
}
