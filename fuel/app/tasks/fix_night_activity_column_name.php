<?php

namespace Fuel\Tasks;

# TODO: 他のバッチを真似たがこれで正しいのか？
date_default_timezone_set('Asia/Tokyo');

class Fix_Night_Activity_Column_Name
{
	const WRONG_COL_NAME = 'night_acitivity';
	const RIGHT_COL_NAME = 'night_activity';

	/** 引数で指定された日時 */
	private $_arg_ymd = null;

	/** タイムゾーン */
	private $_timezone = null;

	private $_current_sensor_log_path = null;
	private $_current_sensor_name  = null;
	private $_current_summary_date = null;

	/**
	 * daily report である sensordaily テーブルの night_activity の名前を間違えたのを修正する
	 * $ymd は Y-m-d 形式の文字列(ex. 2017-01-01)
	 */
	public function run($ymd = null)
	{
		$this->_arg_ymd  = $ymd;
		$this->_timezone = new \DateTimeZone('Asia/Tokyo');
		$this->_current_sensor_log_path = implode(DIRECTORY_SEPARATOR, [rtrim(APPPATH, DIRECTORY_SEPARATOR), 'tmp', 'fix_night_activity_column_name_current_sensor.txt']);
		list($this->_current_sensor_name, $this->_current_summary_date) = $this->read_current_sensor();

		# 集計の最大日時
		if ($this->_arg_ymd) {
			$max_datetime = new \DateTimeImmutable("{$ymd} 00:00:01", $this->_timezone);
		} else {
			// 引数で未指定時のデフォルトの Max は 2017-07-03
			$max_datetime = new \DateTimeImmutable('2017-07-03 00:00:01', $this->_timezone);
		}

		\Log::info("task [fix_night_activity_column_name:run] start. max_datetime:[{$max_datetime->format('Y-m-d')}] current_sensor_name:[{$this->_current_sensor_name}] current_summary_date:[{$this->_current_summary_date}]", __METHOD__);

		try {
			// shipping_date が入っている通常センサーの一覧を取得
			$target_sensors = \Model_Sensor::get_sensor_name_and_shipping_date(\Model_Sensor::TYPE_SENSOR);
			\Log::debug(\DB::last_query(), __METHOD__);
			\Log::debug('target sensors:' . print_r($target_sensors, true), __METHOD__);

			// レポート更新
			$this->fix_report($max_datetime, $target_sensors);
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [fix_night_activity_column_name:run] end. max_datetime:[{$max_datetime->format('Y-m-d')}]", __METHOD__);
		}
	}

	/**
	 * デイリーレポートを修正する
	 */
	private function fix_report($max_datetime, array $target_sensors) {

		foreach ($target_sensors as $sensor_name => $shipping_date) {
			$sensor_name   = trim($sensor_name);
			\Log::debug("sensor_name:[{$sensor_name}] shipping_date:[{$shipping_date}]", __METHOD__);

			if ($this->_current_sensor_name) {
				if ($this->_current_sensor_name !== $sensor_name) {
					\Log::debug("sensor_name:[{$sensor_name}] current_sensor_name:[{$this->_current_sensor_name}] skipped.", __METHOD__);
					continue;
				} else {
					$this->_current_sensor_name = null;
				}
			}

			if ($this->_current_summary_date) {
				$summary_date = new \DateTimeImmutable($this->_current_summary_date, $this->_timezone);
				$this->_current_summary_date = null;
			} else {
				$summary_date = new \DateTimeImmutable($shipping_date, $this->_timezone);
			}

			# 指定範囲の sensordaily を取得(既に sensordaily が存在する日のみが対象)
			$sensor_dailies = $this->retryable_execute(['\Model_Sensordaily', 'find_by_datetime_range'], [$sensor_name, 'summary_date', $summary_date, $max_datetime, false]);
			$this->fix_night_activities($sensor_dailies);
		}
	}

	private function fix_night_activities(array $sensor_dailies)
	{
		foreach ($sensor_dailies as $sensor_daily) {
			$sensor_name = $sensor_daily->getPartitionKey();
			$row_key     = $sensor_daily->getRowKey();

			$props = $sensor_daily->getProperties();
			if (!array_key_exists(static::WRONG_COL_NAME, $props)) {
				echo "sensor_name:[{$sensor_name}] row_key:[{$row_key}] " . static::WRONG_COL_NAME . " property is not found." . PHP_EOL;
				continue;
			}

			# 間違ったプロパティ名のプロパティを保存して配列からは削除
			$night_activity = $props[static::WRONG_COL_NAME];
			unset($props[static::WRONG_COL_NAME]);

			# 正しい名前で追加
			$props[static::RIGHT_COL_NAME] = $night_activity;

			$sensor_daily->setProperties($props);

			$this->retryable_execute(['\Model_Sensordaily', 'update'], [$sensor_daily]);

			echo "sensor_name:[{$sensor_name}] row_key:[{$row_key}] night_activity:[{$night_activity->getValue()}]" . PHP_EOL;

			# 処理完了した sensor_name と日時をファイルに保存しておく
			$summary_date_str = $sensor_daily->getProperty('summary_date')->getValue()->format('Y-m-d H:i:s');
			$this->write_current_sensor($sensor_name, $summary_date_str);
		}
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

	/**
	 * 現在処理中のセンサー情報をファイルに記録する
	 */
	private function write_current_sensor($sensor_name, $summary_date)
	{
		$message = "{$sensor_name},{$summary_date}";
		$fp = fopen($this->_current_sensor_log_path, 'w');
		if (flock($fp, LOCK_EX)) {
			fputs($fp, $message);
			flock($fp, LOCK_UN);
		}
		fclose($fp);
	}

	/**
	 * 現在処理中のセンサー情報ファイルが存在する場合に内容を返す
	 */
	private function read_current_sensor()
	{
		if (file_exists($this->_current_sensor_log_path)) {
			return explode(",", trim(file_get_contents($this->_current_sensor_log_path)));
		}
		return [null, null];
	}
}
/* End of file tasks/fix_night_activity_column_name.php */
