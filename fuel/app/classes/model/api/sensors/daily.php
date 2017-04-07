<?php

use Fascent\Careeye\Api\Client\Sensor as Sensor;
use Fascent\Careeye\Api\Client\BedSensor as BedSensor;

/**
 * Class Model_Api_Sensors_Daily
 */
class Model_Api_Sensors_Daily extends Model_Api_Base {
	/**
	 * @param string $sensor_name
	 * @param string $bedsensor_name
	 * @param \DateTime $date
	 * @return array
	 */
	public static function find_by_sensor_name_and_date($sensor_name, $bedsensor_name, $date) {
		$sensor_data = self::get_sensor_data($sensor_name, $date);

		$daily  = $sensor_data['daily'];
		$latest = $sensor_data['latest'];

		$result = self::get_formatted_sleeping_data($daily, $bedsensor_name, $date);

		// latest データが有る場合はそちらを使う
		if (!empty($latest)) {
			$result = array_merge($result, static::to_formatted_result($latest));
			// latest の場合は date に現在日時を入れる
			$result['date'] = (new DateTime(null, new DateTimeZone('Asia/Tokyo')))->format('Y-m-d');
		} else if(!empty($daily)) {
			$result = array_merge($result, static::to_formatted_result($daily));
		}
		return $result;
	}

	/**
	 * センサーのデータを取得する
	 * @param string $sensor_name
	 * @param \DateTime $date
	 * @return array
	 */
	private static function get_sensor_data($sensor_name, $date) {
		$latest = null;
		if (Util_Datetime::is_today($date)) {
			$latest_api = new Sensor\Latest();

			\Log::debug("get latest data start. sensor_name:[{$sensor_name}]", __METHOD__);
			$latest = $latest_api->get($sensor_name);
			\Log::debug("get latest data end. sensor_name:[{$sensor_name}] data:" . print_r($latest, true), __METHOD__);
		}
		$daily_api = new Sensor\Daily();

		\Log::debug("get daily data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$daily = $daily_api->get($sensor_name, $date);
		\Log::debug("get daily data end. sensor_name:[{$sensor_name}] data:" . print_r($daily, true), __METHOD__);

		return [
			'latest' => self::get_contents($latest),
			'daily'  => self::get_contents($daily),
		];
	}

	/**
	 * ベッドセンサーのデータを取得する
	 * @param string $sensor_name
	 * @param \DateTime $date
	 * @return array
	 */
	private static function get_bed_sensor_data($sensor_name, $date) {
		$latest = null;
		if (Util_Datetime::is_today($date)) {
			$latest_api = new BedSensor\Latest();

			\Log::debug("get latest data start. sensor_name:[{$sensor_name}]", __METHOD__);
			$latest = $latest_api->get($sensor_name);
			\Log::debug("get latest data end. sensor_name:[{$sensor_name}] data:" . print_r($latest, true), __METHOD__);
		}
		$daily_api = new BedSensor\Daily();

		\Log::debug("get daily data start. sensor_name:[{$sensor_name}]", __METHOD__);
		$daily = $daily_api->get($sensor_name, $date);
		\Log::debug("get daily data end. sensor_name:[{$sensor_name}] data:" . print_r($daily, true), __METHOD__);

		return [
			'latest' => self::get_contents($latest),
			'daily'  => self::get_contents($daily),
		];
	}

	/**
	 * API 取得結果を careeye-web の API 用に変換
	 */
	private static function to_formatted_result($data) {
		$result = [];
		$result['temperature'] = round($data['temperature'], 1);
		$result['humidity']    = round($data['humidity'], 1);
		$result['active']      = round($data['activity'], 1);
		$result['illuminance'] = (int)$data['illuminance'];
		$result['discomfort']  = $data['discomfort'];
		$result['wbgt']        = $data['wbgt'];
		$result['cold']        = $data['cold'];
		$result['date']        = $data['date'];
		return $result;
	}

	/**
	 * 起床・就寝のデータを careeye-web API 用に取得・変換する
	 * @param array $daily
	 * @param string $bedsensor_name
	 * @param \DateTime $date
	 * @return array
	 */
	private static function get_formatted_sleeping_data($daily, $bedsensor_name, $date) {
		$result = [];

		// ベッドセンサーを持つユーザの場合はここで取得
		if ($bedsensor_name) {
			$bedsensor_data = self::get_bed_sensor_data($bedsensor_name, $date);
			$beddaily = $bedsensor_data['daily'];
		}

		// ベッドセンサーのデータがあればそちらを採用
		if (isset($beddaily)) {
			\Log::info("bed sensor data exists. sensor_name:[{$bedsensor_name}]", __METHOD__);
			$result = array_merge($result, static::to_formatted_sleeping_data($beddaily));
		} elseif(!empty($daily)) {
			// ベッドセンサーのが無く通常センサーのデータがあればそちらを採用
			$result = array_merge($result, static::to_formatted_sleeping_data($daily));
		}
		return $result;
	}

	/**
	 * API 取得結果の起床・就寝時間部分を careeye-web の API 用に変換
	 */
	private static function to_formatted_sleeping_data($data) {
		$result = [];

		if(!empty($data['wake_up_time'])) {
			$result['wake_up_time'] = (new DateTime($data['wake_up_time'], new DateTimeZone('Asia/Tokyo')))->format("H:i:s");
		}

		if(!empty($data['last_sleep_time'])) {
			$result['sleep_time'] = (new DateTime($data['last_sleep_time'], new DateTimeZone('Asia/Tokyo')))->format("H:i:s");
		}

		if(!empty($data['avg_sleep_time'])) {
			$result['sleep_time_average'] = $data['avg_sleep_time'];
		}

		if(!empty($data['avg_wake_up_time'])) {
			$result['wake_up_time_average'] = $data['avg_wake_up_time'];
		}

		return $result;
	}
}
