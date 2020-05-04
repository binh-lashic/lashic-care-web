<?php

namespace Fuel\Tasks;

use Internal\SlaveSensor\SleepTimeChecker  as SleepTimeChecker;
use Internal\SlaveSensor\WakeUpTimeChecker as WakeUpTimeChecker;

# TODO: 他のバッチを真似たがこれで正しいのか？
date_default_timezone_set('Asia/Tokyo');

/**
 * 就寝・起床時間判定 + 遅延アラートチェックバッチ(Storage Table 版)
 */
class Check_Sleep_And_Wake_Up
{
	/**
	 * 有効なセンサーのデータから起床・就寝時間を判定し、またそれらが遅延していた場合アラートの登録を行う
	 */
	public function run()
	{
		$target_datetime = new \DateTimeImmutable(null, new \DateTimeZone('Asia/Tokyo'));
		\Log::info("task [check_sleep_and_wake_up:run] start. target_date:[{$target_datetime->format('Y-m-d H:i:s')}] environment:[" . \Fuel::$env . "]", __METHOD__);

		try {
			# 就寝時間チェック
			(new SleepTimeChecker($target_datetime))->check();
			# 起床時間チェック
			(new WakeUpTimeChecker($target_datetime))->check();
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [check_sleep_and_wake_up:run] end. target_date:[{$target_datetime->format('Y-m-d H:i:s')}] environment:[" . \Fuel::$env . "]", __METHOD__);
		}
	}

}

namespace Internal\SlaveSensor;

/**
 * アクティブ時間の計測・遅延チェックを行うための親クラス
 */
abstract class ActiveTimeChecker {
	use \Trait_Retryable;

	/** 一度に処理するセンサーの数 */
	const SENSOR_CHUNK_SIZE = 500;

	public function __construct($target_datetime) {
		$this->target_datetime = $target_datetime;
	}

	public function get_row_key() {
		return $this->target_datetime->format('Ymd');
	}

	public function get_date_column_value() {
		return $this->target_datetime->format('Y-m-d');
	}
}

/**
 * 就寝時間の計測・遅延チェックを行うためのクラス
 */
class SleepTimeChecker extends ActiveTimeChecker {
	/**
	 * 就寝時間を求め、遅延アラートチェック処理を行う
	 */
	public function check() {

		# 有効なセンサーデータを取得
		$sensor_data = \Model_Batch_Data_Daily::find_activity_by_measurement_time($this->get_date_column_value(), 'sleep_started_at', 'sleep_ended_at', 'last_sleep_time_processed');
		\Log::debug(\DB::last_query('batch'), __METHOD__);
		\Log::info("target sensor data_daily count:[" . count($sensor_data) . "]", __METHOD__);

		# 閾値は設定ファイルから取得
		$alert_thresholds = \Config::get("sensor_levels." . \Model_Alert::TYPE_SLEEP);

		# 一度に処理する数を分割する
		$sensor_data_chunks = array_chunk($sensor_data, self::SENSOR_CHUNK_SIZE, true);
		foreach ($sensor_data_chunks as $sensor_data_chunk) {
			$sensor_names = array_keys($sensor_data_chunk);
			\Log::debug("target sensor data chunk count:[" . count($sensor_names) . "]", __METHOD__);

			# センサー毎のアラートレベル、アラート可否をまとめて取得
			$alert_settings = \Model_Sensor::get_alert_levels('sleep', $sensor_names);
			\Log::debug(\DB::last_query(), __METHOD__);

			$this->calculate_last_sleep_time_by_sensor_chunk($sensor_data_chunk, $alert_settings, $alert_thresholds);
		}
	}

	/**
	 * センサー複数台で共通の処理を行ってから個別センサーの算出処理を呼び出す
	 */
	private function calculate_last_sleep_time_by_sensor_chunk($sensor_data_chunk, $alert_settings, $alert_thresholds) {
		# センサー毎の算出処理
		foreach($sensor_data_chunk as $sensor_name => $sleep_time_data) {
			# 該当期間に該当センサーのデータが無い場合終了
			if (!count($sleep_time_data)) {
				\Log::warning("data_daily is not found. sensor_name:[{$sensor_names}]", __METHOD__);
				return;
			}
			$this->calculate_last_sleep_time_by_sensor($sensor_name, $sleep_time_data, $alert_settings, $alert_thresholds);
		}
	}

	/**
	 * センサー毎の就寝時間算出・更新・遅延チェック処理
	 */
	private function calculate_last_sleep_time_by_sensor($sensor_name, $sleep_time_data, $alert_settings, $alert_thresholds) {
		# Storage Table から当日分のデータ取得
		$sensordaily = $this->retryable_execute(['\Model_Sensordaily','find'], [$sensor_name, $this->get_row_key()]);

		if (is_null($sensordaily)) {
			\Log::info("sensordaily record not found. sensor_name: [{$sensor_name}]", __METHOD__);
			return;
		}

		# 既に設定済みのセンサーはスキップ
		if (\Model_Sensordaily::is_already_set($sensordaily, 'last_sleep_time')) {
			\Log::debug("sensordaily.last_sleep_time is already set. sensor_name:[{$sensor_name}]", __METHOD__);
			return;
		}

		# alert 設定が存在しない
		if (!array_key_exists($sensor_name, $alert_settings)) {
			\Log::warning("alert settings is not found. sensor_name: [{$sensor_name}]", __METHOD__);
			return;
		}

		# 就寝時間計算
		$alert_setting   = $alert_settings[$sensor_name];
		$alert_threshold = $alert_thresholds[$alert_setting['alert_level']];
		$counter = new SleepTimeCounter($sensor_name, $alert_setting, $alert_threshold);

		foreach($sleep_time_data as $data) {
			$counter->count($data);
			if ($counter->define_time()) {
				break;
			}
		}

		# 就寝時間が定まった場合
		if ($counter->is_defined_time()) {
			\Log::debug("sensor_name:[{$sensor_name}] last_sleep_time:[{$counter->get_defined_time()->format('Y-m-d H:i:s')}]", __METHOD__);
			# Storage Table を更新
			$this->retryable_execute(
				['\Model_Sensordaily', 'update_entity'],
				[$sensordaily, ['last_sleep_time' => $counter->get_defined_time()]]
			);
			# 処理済みフラグを立てる
			\Model_Daily_Enable_Sensor::processed_last_sleep_time($sensor_name, $this->get_date_column_value());
			\Log::debug(\DB::last_query('batch'), __METHOD__);

			# 遅延アラートチェック
			$this->check_sleep_delay_alert($counter->get_defined_time(), $sensordaily, $alert_setting, $alert_threshold);
		} else {
			\Log::debug("sensor_name:[{$sensor_name}] was not possible to determine the last_sleep_time. active_minutes:[{$counter->active_minutes}] nonactive_minutes:[{$counter->nonactive_minutes}]", __METHOD__);
		}
	}

	/**
	 * 就寝時間遅延アラートチェック処理
	 */
	private function check_sleep_delay_alert($sleep_time, $sensordaily, $alert_setting, $alert_threshold) {
		$sensor_name = $sensordaily->getPartitionKey();

		# 30 日平均が無い場合アラートチェックは行わない
		$avg_30d_sleep_time = $sensordaily->getProperty('avg_30d_sleep_time');
		if (!$avg_30d_sleep_time || empty($avg_30d_sleep_time->getValue())) {
			\Log::info("avg_30d_sleep_time is not found. sensor_name:[{$sensordaily->getPartitionKey()}]", __METHOD__);
			return;
		}

		list($avg_hour, $avg_minute, $avg_second) = explode(':', $avg_30d_sleep_time->getValue());
		$delay_minutes = $alert_threshold['delay_duration'];

		# 睡眠の場合、23 時までなら前日、0時以降なら当日で閾値の日時を出す必要がある
		# 就寝判断設定の Max が 28時(AM 4:00)なので 5時より小さい場合に日付跨ぎとし当日の日付を使う
		if ((int)$avg_hour < 5) {
			$alert_threshold_time = $this->target_datetime->setTime($avg_hour, $avg_minute, $avg_second)->modify("+{$delay_minutes} minutes");
		} else {
			$alert_threshold_time = $this->target_datetime->modify('-1 day')->setTime($avg_hour, $avg_minute, $avg_second)->modify("+{$delay_minutes} minutes");
		}
		\Log::debug("sensor_name:[{$sensor_name}] sleep_time:[{$sleep_time->format('Y-m-d H:i:s')}] avg_30d_sleep_time: [{$avg_30d_sleep_time->getValue()}] alert_threshold_time: [{$alert_threshold_time->format('Y-m-d H:i:s')}]", __METHOD__);

		if ($sleep_time > $alert_threshold_time) {
			$sensor_id = $alert_setting['sensor_id'];
			$sensor = \Model_Sensor::find($sensor_id);

			if (is_null($sensor)) {
				\Log::info("sensor_id:[{$sensor_id}] is not found. sensor_name:[{$sensor_name}]", __METHOD__);
				continue;
			}
			\Log::info("[ALERT] sensor_id:[{$sensor_id}] sensor_name:[{$sensor_name}] sleep time delay. sleep_time:[{$sleep_time->format(DATE_ATOM)}] alert_threshold_time:[{$alert_threshold_time->format(DATE_ATOM)}] avg_30d_sleep_time:[{$avg_30d_sleep_time->getValue()}] delay_minutes:[{$delay_minutes}]", __METHOD__);

			# アラート処理は現在のロジックをそのまま使う
			# これにより新・旧両方のバッチが動いていても同種のアラートは二重には登録されない
			$sensor->setTime($this->target_datetime->getTimestamp());
			$alert_params = [
				'type' => \Model_Alert::TYPE_SLEEP,
			];
			$sensor->alert($alert_params);
		}
	}
}

/**
 * 起床時間の計測・遅延チェックを行うためのクラス
 */
class WakeUpTimeChecker extends ActiveTimeChecker {
	/**
	 * 起床時間を求め、遅延アラートチェック処理を行う
	 */
	public function check() {

		# 有効なセンサーデータを取得
		$sensor_data = \Model_Batch_Data_Daily::find_activity_by_measurement_time($this->get_date_column_value(), 'wake_up_started_at', 'wake_up_ended_at', 'wake_up_time_processed');
		\Log::debug(\DB::last_query('batch'), __METHOD__);
		\Log::info("target sensor data_daily count:[" . count($sensor_data) . "]", __METHOD__);

		# 閾値は設定ファイルから取得
		$alert_thresholds = \Config::get("sensor_levels." . \Model_Alert::TYPE_WAKE_UP);

		# 一度に処理する数を分割する
		$sensor_name_chunks = array_chunk($sensor_data, self::SENSOR_CHUNK_SIZE, true);
		foreach ($sensor_name_chunks as $sensor_data_chunk) {
			$sensor_names = array_keys($sensor_data_chunk);
			\Log::debug("target sensor data chunk count:[" . count($sensor_names) . "]", __METHOD__);

			# センサー毎のアラートレベル、アラート可否をまとめて取得
			$alert_settings = \Model_Sensor::get_alert_levels('wake_up', $sensor_names);
			\Log::debug(\DB::last_query(), __METHOD__);
			
			$this->calculate_wake_up_time_by_sensor_chunk($sensor_data_chunk, $alert_settings, $alert_thresholds);
		}
	}

	/**
	 * センサー複数台で共通の処理を行ってから個別センサーの算出処理を呼び出す
	 */
	private function calculate_wake_up_time_by_sensor_chunk($sensor_data_chunk, $alert_settings, $alert_thresholds) {
		# センサー毎の算出処理
		foreach($sensor_data_chunk as $sensor_name => $wake_up_time_data) {
			# 該当期間に該当センサーのデータが無い場合終了
			if (!count($wake_up_time_data)) {
				\Log::warning("data_daily is not found. sensor_name:[{$sensor_name}]", __METHOD__);
				return;
			}
			$this->calculate_wake_up_time_by_sensor($sensor_name, $wake_up_time_data, $alert_settings, $alert_thresholds);
		}
	}

	/**
	 * センサー毎の起床時間算出・更新・遅延チェック処理
	 */
	private function calculate_wake_up_time_by_sensor($sensor_name, $wake_up_time_data, $alert_settings, $alert_thresholds) {
		# Storage Table から当日分のデータ取得
		$sensordaily = $this->retryable_execute(['\Model_Sensordaily','find'], [$sensor_name, $this->get_row_key()]);

		if (is_null($sensordaily)) {
			\Log::info("sensordaily record not found. sensor_name: [{$sensor_name}]", __METHOD__);
			return;
		}

		# 既に設定済みのセンサーはスキップ
		if (\Model_Sensordaily::is_already_set($sensordaily, 'wake_up_time')) {
			\Log::info("sensordaily.wake_up_time is already set. sensor_name:[{$sensor_name}]", __METHOD__);
			return;
		}

		# alert 設定が存在しない
		if (!array_key_exists($sensor_name, $alert_settings)) {
			\Log::warning("alert settings is not found. sensor_name: [{$sensor_name}]", __METHOD__);
			return;
		}

		# 起床時間計算
		$alert_setting   = $alert_settings[$sensor_name];
		$alert_threshold = $alert_thresholds[$alert_setting['alert_level']];
		$counter = new WakeUpTimeCounter($sensor_name, $alert_setting, $alert_threshold);

		foreach($wake_up_time_data as $data) {
			$counter->count($data);
			if ($counter->define_time()) {
				break;
			}
		}

		# 起床時間が定まった場合
		if ($counter->is_defined_time()) {
			\Log::debug("sensor_name:[{$sensor_name}] wake_up_time:[{$counter->get_defined_time()->format('Y-m-d H:i:s')}]", __METHOD__);
			# Storage Table を更新
			$this->retryable_execute(
				['\Model_Sensordaily', 'update_entity'],
				[$sensordaily, ['wake_up_time' => $counter->get_defined_time()]]
			);
			# 処理済みフラグを立てる
			\Model_Daily_Enable_Sensor::processed_wake_up_time($sensor_name, $this->get_date_column_value());
			\Log::debug(\DB::last_query('batch'), __METHOD__);

			# 遅延アラートチェック
			$this->check_wake_up_delay_alert($counter->get_defined_time(), $sensordaily, $alert_setting, $alert_threshold);
		} else {
			\Log::debug("sensor_name:[{$sensor_name}] was not possible to determine the wake_up_time. active_minutes:[{$counter->active_minutes}] nonactive_minutes:[{$counter->nonactive_minutes}]", __METHOD__);
		}
	}

	/**
	 * 起床時間遅延アラートチェック処理
	 */
	private function check_wake_up_delay_alert($wake_up_time, $sensordaily, $alert_setting, $alert_threshold) {
		$sensor_name = $sensordaily->getPartitionKey();

		# 30 日平均が無い場合アラートチェックは行わない
		$avg_30d_wake_up_time = $sensordaily->getProperty('avg_30d_wake_up_time');
		if (!$avg_30d_wake_up_time || empty($avg_30d_wake_up_time->getValue())) {
			\Log::info("avg_30d_wake_up_time is not found. sensor_name:[{$sensordaily->getPartitionKey()}]", __METHOD__);
			return;
		}

		list($avg_hour, $avg_minute, $avg_second) = explode(':', $avg_30d_wake_up_time->getValue());
		$delay_minutes = $alert_threshold['delay_duration'];

		$alert_threshold_time = $this->target_datetime->setTime($avg_hour, $avg_minute, $avg_second)->modify("+{$delay_minutes} minutes");
		\Log::debug("sensor_name:[{$sensor_name}] wake_up_time:[{$wake_up_time->format('Y-m-d H:i:s')}] avg_30d_wake_up_time: [{$avg_30d_wake_up_time->getValue()}] alert_threshold_time: [{$alert_threshold_time->format('Y-m-d H:i:s')}]", __METHOD__);

		if ($wake_up_time > $alert_threshold_time) {
			$sensor_id = $alert_setting['sensor_id'];
			$sensor = \Model_Sensor::find($sensor_id);

			if (is_null($sensor)) {
				\Log::info("sensor_id:[{$sensor_id}] is not found. sensor_name:[{$sensor_name}]", __METHOD__);
				continue;
			}
			\Log::info("[ALERT] sensor_id:[{$sensor_id}] sensor_name:[{$sensor_name}] wake up time delay. wake_up_time:[{$wake_up_time->format(DATE_ATOM)}] alert_threshold_time:[{$alert_threshold_time->format(DATE_ATOM)}] avg_30d_wake_up_time:[{$avg_30d_wake_up_time->getValue()}] delay_minutes:[{$delay_minutes}]", __METHOD__);

			# アラート処理は現在のロジックをそのまま使う
			# これにより新・旧両方のバッチが動いていても同種のアラートは二重には登録されない
			$sensor->setTime($this->target_datetime->getTimestamp());
			$alert_params = [
				'type' => \Model_Alert::TYPE_WAKE_UP,
			];
			$sensor->alert($alert_params);
		}
	}
}


/**
 * アクティブ時間判定用カウンタの親クラス
 */
abstract class ActiveTimeCounter {
	public function __construct($sensor_name, $alert_setting, $alert_threshold) {
		$this->sensor_name       = $sensor_name;
		$this->active_minutes    = 0;
		$this->nonactive_minutes = 0;
		$this->alert_setting     = $alert_setting;
		$this->alert_threshold   = $alert_threshold;
		$this->temporary_time    = null;
		$this->defined_time      = null;
	}

	public function get_defined_time() {
		if ($this->defined_time) {
			# DB から取得した日時型は文字列型になっているので DateTime に変換
			return new \DateTime($this->defined_time, new \DateTimeZone('Asia/Tokyo'));
		}
		return null;
	}

	public function is_defined_time() {
		return !is_null($this->defined_time);
	}
}

/**
 * 就寝時間判定用カウンタクラス
 */
class SleepTimeCounter extends ActiveTimeCounter {

	public function __construct($sensor_name, $alert_setting, $alert_threshold) {
		parent::__construct($sensor_name, $alert_setting, $alert_threshold);
	}
	/**
	 * activity が就寝判定の閾値を下回った分数をカウントする
	 */
	public function count($data) {
		if ($data['activity'] < $this->alert_threshold['threshold']) {
			$this->nonactive_minutes++;
			$this->active_minutes = 0;
			# 一番最初に下回った時刻を就寝時間候補として保存しておく
			if (is_null($this->temporary_time)) {
				$this->temporary_time = $data['measurement_time'];
			}
		} else {
			# 判定途中で閾値を上回った場合、就寝不感帯期間の間は判断を継続
			$this->active_minutes++;
			$this->nonactive_minutes++;
			# 就寝不感帯期間を超えて上回っていた場合、一旦ここで就寝判断をリセット
			if ($this->active_minutes > $this->alert_threshold['ignore_duration']) {
				$this->nonactive_minutes = 0;
				$this->active_minutes = 0;
				$this->temporary_time = null;
			}
		}
	}

	/**
	 * 一定時間就寝時間判定の閾値を下回ったかを判定し就寝時間を決定する
	 */
	public function define_time() {
		if ($this->nonactive_minutes >= $this->alert_threshold['duration'] && $this->temporary_time) {
			$this->defined_time = $this->temporary_time;
			return true;
		}
		return false;
	}
}

/**
 * 起床時間判定用カウンタクラス
 */
class WakeUpTimeCounter extends ActiveTimeCounter {

	public function __construct($sensor_name, $alert_setting, $alert_threshold) {
		parent::__construct($sensor_name, $alert_setting, $alert_threshold);
	}

	/**
	 * activity が就寝判定の閾値を下回った分数をカウントする
	 */
	public function count($data) {
		if ($data['activity'] > $this->alert_threshold['threshold']) {
			$this->active_minutes++;
			$this->nonactive_minutes = 0;
			# 一番最初に上回った時刻を起床時間候補として保存しておく
			if (is_null($this->temporary_time)) {
				$this->temporary_time = $data['measurement_time'];
			}
		} else {
			# 判定途中で閾値を下回った場合、起床不感帯期間の間は判断を継続
			$this->nonactive_minutes++;
			$this->active_minutes++;
			# 起床不感帯期間を超えて上回っていた場合、一旦ここで起床判断をリセット
			if ($this->nonactive_minutes > $this->alert_threshold['ignore_duration']) {
				$this->active_minutes = 0;
				$this->nonactive_minutes = 0;
				$this->temporary_time = null;
			}
		}
	}

	/**
	 * 一定時間起床時間判定の閾値を上回ったかを判定し起床時間を決定する
	 */
	public function define_time() {
		if ($this->active_minutes >= $this->alert_threshold['duration'] && $this->temporary_time) {
			$this->defined_time = $this->temporary_time;
			return true;
		}
		return false;
	}
}


/* End of file tasks/check_sleep_and_wake_up.php */
