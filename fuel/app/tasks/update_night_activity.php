<?php

namespace Fuel\Tasks;

# TODO: 他のバッチを真似たがこれで正しいのか？
date_default_timezone_set('Asia/Tokyo');

class Update_Night_Activity
{

	/** 引数で指定された日時 */
	private $_arg_ymd = null;

	/** タイムゾーン */
	private $_timezone = null;

	/**
	 * daily report である sensordaily テーブルの night_activity を計算する
	 * $ymd は Y-m-d 形式の文字列(ex. 2017-01-01)
	 */
	public function run($ymd = null)
	{
		$this->_arg_ymd  = $ymd;
		$this->_timezone = new \DateTimeZone('Asia/Tokyo');

		# 集計の最大日時
		if ($this->_arg_ymd) {
			$max_datetime = new \DateTimeImmutable("{$ymd} 00:00:01", $this->_timezone);
		} else {
			// 引数で未指定時のデフォルトの Max は 2017-07-03
			$max_datetime = new \DateTimeImmutable('2017-07-03 00:00:01', $this->_timezone);
		}

		\Log::info("task [update_night_activity:run] start. max_datetime:[{$max_datetime->format('Y-m-d')}]", __METHOD__);

		try {
			// shipping_date が入っている通常センサーの一覧を取得
			$target_sensors = \Model_Sensor::get_sensor_name_and_shipping_date(\Model_Sensor::TYPE_SENSOR);
			\Log::debug(\DB::last_query(), __METHOD__);
			\Log::debug('target sensors:' . print_r($target_sensors, true), __METHOD__);

			// レポート更新
			$this->update_report($max_datetime, $target_sensors);
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [update_night_activity:run] end. max_datetime:[{$max_datetime->format('Y-m-d')}]", __METHOD__);
		}
	}

	/**
	 * デイリーレポートを更新する
	 */
	private function update_report($max_datetime, array $target_sensors) {

		foreach ($target_sensors as $sensor_name => $shipping_date) {
			$sensor_name   = trim($sensor_name);
			\Log::debug("sensor_name:[{$sensor_name}] shipping_date:[{$shipping_date}]", __METHOD__);

			$shipping_date = new \DateTimeImmutable($shipping_date, $this->_timezone);

			# 指定範囲の sensordaily を取得(既に sensordaily が存在する日のみが対象)
			$sensor_dailies = $this->retryable_execute(['\Model_Sensordaily', 'find_by_datetime_range'], [$sensor_name, 'summary_date', $shipping_date, $max_datetime]);
			$this->update_night_activities($sensor_dailies);
		}
	}

	private function update_night_activities(array $sensor_dailies)
	{
		foreach ($sensor_dailies as $sensor_daily) {
			$summary_date = new \DateTimeImmutable($sensor_daily['summary_date']->format('Y-m-d H:i:s'), $this->_timezone);

			$sensor_name = $sensor_daily['PartitionKey'];
			$row_key     = $sensor_daily['RowKey'];

			# 前日 22:00 以降
			$from = $summary_date->modify('-1 days')->setTime(22, 00, 00);
			# 当日 05:00 まで
			$to   = $summary_date->setTime(05, 00, 01);

			$sensor_logs     = $this->retryable_execute(['\Model_Sensorlogs', 'find_by_datetime_range'], [$sensor_name, 'measurement_time', $from, $to]);
			$night_acitivity = $this->sum_activities($sensor_logs);

			\Log::debug("sensor_name:[{$sensor_name}] row_key:[{$row_key}] from:[{$from->format('Y-m-d H:i:s')}] to:[{$to->format('Y-m-d H:i:s')}] night_acitivity:[{$night_acitivity}]", __METHOD__);

			echo "sensor_name:[{$sensor_name}] row_key:[{$row_key}] night_activity:[{$night_acitivity}]" . PHP_EOL;

			$properties = [
				'night_acitivity' => $night_acitivity,
			];
			$this->retryable_execute(['\Model_Sensordaily', 'merge_property'], [$sensor_name, $row_key, $properties]);
		}
	}

	private function sum_activities(array $sensor_logs)
	{
		$night_activity = 0;
		foreach ($sensor_logs as $sensor_log) {
			$night_activity += $sensor_log['activity'];
		}
		return $night_activity;
	}

	/**
	 * Storage Table へのクエリで接続エラー等の回復可能エラーが発生した際のリトライ処理を行う
	 */
	private function retryable_execute(array $callback, array $args, $retry_count = 6) {
		while(true) {
			try {
				if ($retry_count > 0) {
					$result = call_user_func_array($callback, $args);
					return $result;
				} else {
					\Log::error('Retry count over', __METHOD__);
					throw new RuntimeException('Retry count over');
				}
			} catch (\GuzzleHttp\Exception\ConnectException $e) {
				$this->logging_exception($e);
				sleep(10);
				$retry_count--;
				continue;
			} catch (\GuzzleHttp\Exception\RequestException $e) {
				$this->logging_exception($e);
				sleep(20);
				$retry_count--;
				continue;
			}
		}
	}

	/**
	 * 例外のロギング
	 */
	private function logging_exception($e) {
		$code    = $e->getCode();
		$message = $e->getMessage();
		$file    = $e->getFile();
		$line    = $e->getLine();
		\Log::warning("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
	}
}
/* End of file tasks/create_sensor_monthly.php */
