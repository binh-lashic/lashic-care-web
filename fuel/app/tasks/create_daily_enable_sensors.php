<?php

namespace Fuel\Tasks;

date_default_timezone_set('Asia/Tokyo');

class Create_Daily_Enable_Sensors
{

	/**
	 * 有効なセンサー一覧を取得し、当日の起床・就寝判断開始・終了時間を求めて daily_enable_sensors に登録する
	 * Storage Table 上の sensordaily に施設版以外のセンサーの起床・就寝時間も更新するために必要なバッチ
	 */
	public function run()
	{
		$target_datetime = new \DateTimeImmutable(null, new \DateTimeZone('Asia/Tokyo'));
		\Log::info("task [create_daily_enable_sensors:run] start. target_date:[{$target_datetime->format('Y-m-d H:i:s')}]", __METHOD__);

		try {
			# daily_enable_sensors にレコード作成
			$this->create_daily_enable_sensors($target_datetime);
			\Log::debug(\DB::last_query('batch'), __METHOD__);
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - line:[$line]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [create_daily_enable_sensors:run] end. target_date:[{$target_datetime->format('Y-m-d H:i:s')}]", __METHOD__);
		}
	}

	/**
	 * 有効なセンサーの当日の起床・就寝判断開始・終了日時を求めて daily_enable_sensors に登録する
	 */
	private function create_daily_enable_sensors($target_datetime) {
		$today = $target_datetime->format('Y-m-d');
		# 有効なセンサー一覧を取得
		$enabled_sensor_names = \Model_Sensor::get_enable_sensor_name_and_times();
		\Log::debug(\DB::last_query(), __METHOD__);
		\Log::debug('enabled sensors:[' . \Util_Array::to_string(\Arr::pluck($enabled_sensor_names, 'name')) . ']', __METHOD__);

		# daily_enable_sensor にレコード作成
		foreach($enabled_sensor_names as $sensor) {
			list($wake_up_started_at, $wake_up_ended_at) = $this->calc_time($target_datetime, $sensor['wake_up_start_time'], $sensor['wake_up_end_time']);
			list($sleep_started_at,   $sleep_ended_at)   = $this->calc_time($target_datetime, $sensor['sleep_start_time'], $sensor['sleep_end_time'], true);
			\Model_Daily_Enable_Sensor::insert([
				'sensor_name'        => $sensor['name'],
				'date'               => $today,
				'sensor_type'        => \Model_Sensor::to_facility_sensor_type($sensor['sensor_type']),
				'wake_up_started_at' => $wake_up_started_at,
				'wake_up_ended_at'   => $wake_up_ended_at,
				'sleep_started_at'   => $sleep_started_at,
				'sleep_ended_at'     => $sleep_ended_at,
			]);
		}
	}

	/**
	 * 開始時刻・終了時刻からその範囲を表す日付文字列を生成して返す
	 */
	private function calc_time($target_datetime, $start_time, $end_time, $is_sleep = false) {
		// 睡眠の場合はベースとなる日時は前日
		if ($is_sleep) {
			$base_time = $target_datetime->modify('-1 day');
		} else {
			$base_time = $target_datetime;
		}
		$start_date = $base_time->setTime($start_time, 0, 0);

		# 就寝時間の場合のみ、24 時過ぎは当日をベースとする
		if ($is_sleep && $end_time >= 24) {
			$end_date = $target_datetime->setTime($end_time - 24, 0, 0);
		} else {
			$end_date = $base_time->setTime($end_time, 00, 00);
		}
		return [$start_date->format('Y-m-d H:i:s'), $end_date->format('Y-m-d H:i:s')];
	}
}
/* End of file tasks/create_daily_enable_sensors.php */
