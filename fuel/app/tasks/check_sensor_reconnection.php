<?php

namespace Fuel\Tasks;

# TODO: 他のバッチを真似たがこれで正しいのか？
date_default_timezone_set('Asia/Tokyo');

/**
 * 接続再開アラートチェックバッチ
 */
class Check_Sensor_Reconnection {

	/**
	 * 接続断アラートが発生したセンサーの再接続チェックを行う
	 * 再度接続が確認できたセンサーに対しては接続再開アラートを登録する
	 */
	public function run()
	{

		$target_datetime = new \DateTimeImmutable(null, new \DateTimeZone('Asia/Tokyo'));
		\Log::info("task [check_sensor_reconnection:run] start. target_date:[{$target_datetime->format('Y-m-d H:i:s')}]", __METHOD__);
		try {
			# センサー名でデータが飛んできているか確認
			# 5 分以内のレコードがあれば有効と判断
			$minutes_before = $target_datetime->modify('-5 minutes')->format('Y-m-d H:i:00');

			// 対象のセンサー一覧を取得
			$target_sensors = \Model_Sensor::get_disconnected_sensors();
			\Log::debug(\DB::last_query(), __METHOD__);

			$reconnected_all_sensors = [];

			# 通常センサーの接続再開チェック
			if (array_key_exists(\Model_Sensor::TYPE_SENSOR, $target_sensors)) {
				$disconnected_sensors = $target_sensors[\Model_Sensor::TYPE_SENSOR];
				\Log::info('disconnected sensors:[' . \Util_Array::to_string(array_keys($disconnected_sensors)) . ']', __METHOD__);

				$reconnected_sensors = $this->check_reconnection($disconnected_sensors, \Model_Sensor::TYPE_SENSOR, $minutes_before);
				$reconnected_all_sensors = array_merge($reconnected_all_sensors, $reconnected_sensors);
			}

			# ベッドセンサーの接続再開チェック
			if (array_key_exists(\Model_Sensor::TYPE_BED_SENSOR, $target_sensors)) {
				$disconnected_bedsensors = $target_sensors[\Model_Sensor::TYPE_BED_SENSOR];
				\Log::info('disconnected bed sensors:[' . \Util_Array::to_string(array_keys($disconnected_bedsensors)) . ']', __METHOD__);

				$reconnected_bedsensors = $this->check_reconnection($disconnected_bedsensors, \Model_Sensor::TYPE_BED_SENSOR, $minutes_before);
				$reconnected_all_sensors = array_merge($reconnected_all_sensors, $reconnected_bedsensors);
			}

			# アラート登録
			if (!empty($reconnected_all_sensors)) {
				$this->alert(\Arr::unique($reconnected_all_sensors), $target_datetime);
			} else {
				\Log::info('reconnected sensors not found.', __METHOD__);
			}
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [check_sensor_reconnection:run] end. target_date:[{$target_datetime->format('Y-m-d H:i:s')}]", __METHOD__);
		}
	}

	/**
	 * センサーの接続再開チェック
	 */
	private function check_reconnection(array $sensors, $sensor_type, $minutes_before) {
		$sensor_names = array_keys($sensors);

		if ($sensor_type === \Model_Sensor::TYPE_SENSOR) {
			$reconnected_sensor_names = \Model_Batch_Data_Daily::get_enabled_sensor_names_by_measurement_time_after($sensor_names, $minutes_before);
		} else if ($sensor_type === \Model_Sensor::TYPE_BED_SENSOR) {
			$reconnected_sensor_names = \Model_Batch_Bed_Data_Daily::get_enabled_sensor_names_by_measurement_time_after($sensor_names, $minutes_before);
		}
		\Log::debug(\DB::last_query('batch'), __METHOD__);
		\Log::info('reconnected sensor names:[' . \Util_Array::to_string($reconnected_sensor_names) . ']', __METHOD__);

		// 再接続のあったセンサー情報のみ返す
		$reconnected_sensors = [];
		foreach ($reconnected_sensor_names as $sensor_name) {
			$reconnected_sensors[$sensor_name] = $sensors[$sensor_name];
		}
		return $reconnected_sensors;
	}

	/**
	 * 対象のセンサーにアラート登録
	 */
	private function alert(array $sensors, $target_datetime) {
		foreach ($sensors as $sensor_info) {
			$sensor_id = $sensor_info['sensor_id'];
			$sensor = \Model_Sensor::find($sensor_id);

			if (is_null($sensor)) {
				\Log::info("sensor_id:[{$sensor->id}] is not found. sensor_name:[{$sensor->name}]", __METHOD__);
				continue;
			}
			\Log::info("[ALERT] sensor_id:[{$sensor->id}] sensor_name:[{$sensor->name}] reconnected.", __METHOD__);

			# アラート処理は現在のロジックをそのまま使う
			$sensor->setTime($target_datetime->getTimestamp());
			$alert_params = [
				'type'     => \Model_Alert::TYPE_RECONNECTION,
				'category' => \Model_Alert::CATEGORY_EMERGENCY, // TODO: カテゴリは「緊急」か？要検討
			];
			$sensor->alert($alert_params);
		}
	}
}
/* End of file tasks/check_sensor_reconnection.php */
