<?php

abstract class Model_Api_Base extends Model {
	/**
	 * API の呼び出し結果からデータを取り出す
	 */
	protected static function get_contents($api_result) {
		if (empty($api_result)) {
			return null;
		}

		$status_code = \Arr::get($api_result, 'statusCode');
		if ($status_code == 200 &&
			\Arr::get($api_result, 'contents.result')) {

			$result = \Arr::get($api_result, 'contents.sensor');
			if (empty($result)) {
				$result = \Arr::get($api_result, 'contents.sensors');
			}
			return $result;
		} else if ($status_code == 404) {
			\Log::info("sensor data not found. statusCode:[{$status_code}] error:[" . \Arr::get($api_result, 'contents.error') . ']', __METHOD__);
		} else {
			\Log::warning("sensor api error occurred. " . print_r($api_result, true) , __METHOD__);
		}

		return null;
	}
}
