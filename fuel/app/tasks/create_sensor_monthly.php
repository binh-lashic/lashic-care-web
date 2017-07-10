<?php

namespace Fuel\Tasks;

# TODO: 他のバッチを真似たがこれで正しいのか？
date_default_timezone_set('Asia/Tokyo');

class Create_Sensor_Monthly
{

	/** 引数で指定された日時 */
	private $_arg_ym = null;

	/** タイムゾーン */
	private $_timezone = null;

	/**
	 * monthly report である sensormonthly テーブルにレコードを作成する
	 * $ym は Y-m 形式の文字列(ex. 2017-01)
	 */
	public function run($ym = null)
	{
		$this->_arg_ym = $ym;
		$this->_timezone = new \DateTimeZone('Asia/Tokyo');

		if ($this->_arg_ym) {
			$target_datetime = new \DateTimeImmutable("{$ym}-01 00:00:00", $this->_timezone);
		} else {
			// 引数で未指定時のデフォルトの集計対象は実行月の前月(月初に前月分の集計が走る
			$target_datetime = new \DateTimeImmutable('-1 month', $this->_timezone);
		}

		\Log::info("task [create_sensor_monthly:run] start. target_month:[{$target_datetime->format('Y-m')}]", __METHOD__);

		try {
			// 有効な通常センサーの一覧を取得
			$target_sensor_names = \Model_Sensor::get_enable_sensor_names_by_type(\Model_Sensor::TYPE_SENSOR);
			\Log::debug(\DB::last_query(), __METHOD__);
			\Log::debug('enabled sensors:[' . \Util_Array::to_string($target_sensor_names) . ']', __METHOD__);

			// レポート作成
			$this->create_report($target_datetime, $target_sensor_names);
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [create_sensor_monthly:run] end. target_date:[{$target_datetime->format('Y-m')}]", __METHOD__);
		}
	}

	/**
	 * マンスリーレポートを作成する
	 */
	private function create_report($target_datetime, array $target_sensor_names) {

		$current_month = $target_datetime->format('Ym');

		$from = $target_datetime->setTime(0, 0, 0);
		$to   = $from->modify('+1 month');
		foreach ($target_sensor_names as $sensor_name) {
			$sensor_name = trim($sensor_name);
			\Log::debug("sensor_name:[{$sensor_name}]", __METHOD__);
			$daily_data_list = \Model_Sensordaily::find_by_datetime_range($sensor_name, 'summary_date', $from, $to);

			$activity            = 0;
			$activity_count      = 0;

			$sleeping_time       = 0;
			$sleeping_time_count = 0;

			$night_activity       = 0;
			$night_activity_count = 0;

			foreach ($daily_data_list as $daily_data) {
				if (array_key_exists('avg_activity', $daily_data)) {
					$activity += $daily_data['avg_activity'];
					$activity_count++;
				}

				if (array_key_exists('last_sleep_time', $daily_data) &&
					array_key_exists('wake_up_time', $daily_data)) {

					$last_sleep_time = $daily_data['last_sleep_time']->setTimezone($this->_timezone);
					$wake_up_time    = $daily_data['wake_up_time']->setTimezone($this->_timezone);
					$sleeping_minutes = ($wake_up_time->getTimestamp() - $last_sleep_time->getTimestamp());
					$sleeping_time += $sleeping_minutes;
					$sleeping_time_count++;
				}

				if (array_key_exists('night_activity', $daily_data)) {
					$night_activity += $daily_data['night_activity'];
					$night_activity_count++;
				}
			}

			$properties = [];

			if ($activity_count > 0) {
				$properties['avg_activity'] = (double) $activity / $activity_count;
			}

			if ($sleeping_time_count > 0) {
				$properties['avg_sleeping_time'] = (int) round($sleeping_time / $sleeping_time_count / 60);
			}

			if ($night_activity_count > 0) {
				$properties['avg_night_activity'] = (double) $night_activity / $night_activity_count;
			}

			$wake_up_and_sleep = \Model_Sensordaily::average_wake_up_and_sleep_in_array($sensor_name, $daily_data_list, $this->_timezone);
			if (array_key_exists('averages', $wake_up_and_sleep)) {
				$properties = array_merge($properties, $wake_up_and_sleep['averages']);
			}

			# レコード作成日を追加
			# 検索用フィールドなので見た目上 JST になるようにした日付を入れる
			$properties['created_at'] = \Model_Sensormonthly::pseudo_jst_datetime();

			# 集計日時を追加
			# こちらも検索用フィールドなので見た目上 JST になるようにした日付を入れる
			$properties['summary_date'] = \Model_Sensormonthly::pseudo_jst_datetime($target_datetime)->setTime(0, 0, 0);

			\Log::debug("sensor_name: [{$sensor_name}] properties:\n" . print_r($properties, true), __METHOD__);

			\Model_Sensormonthly::upsert($sensor_name, $current_month, $properties);
		}
	}
}
/* End of file tasks/create_sensor_monthly.php */
