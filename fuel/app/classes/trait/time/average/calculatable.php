<?php

/**
 * Storage Table のデータから平均起床・就寝時間を算出する共通ロジックを抽出したトレイト
 * Model_Base_Storage_Table を継承したモデルでのみ使用可能
 */
trait Trait_Time_Average_Calculatable {
	/**
	 * 配列で渡されたレコードから、平均起床時間と平均就寝時間を返す
	 */
	public static function average_wake_up_and_sleep_in_array($sensor_name, $daily_data_list, $timezone) {
		Log::debug("sensor_name: [{$sensor_name}]", __METHOD__);

		$data_count = count($daily_data_list);
		Log::debug("sensor_name: [{$sensor_name}] record:[{$data_count}]", __METHOD__);
		if ($data_count <= 0) {
			Log::debug("sensor_name: [{$sensor_name}] sensordaily record not found.", __METHOD__);
			return [
				'count' => $data_count,
			];
		}

		$wake_up_times    = [];
		$last_sleep_times = [];
		foreach ($daily_data_list as $data) {

			# 起床時間
			$wake_up_hour = null;
			if (array_key_exists('wake_up_time', $data)) {
				# UTC の場合は渡されたタイムゾーンに戻す
				if ($data['wake_up_time']->getTimezone()->getName() === 'UTC') {
					$wake_up_time = $data['wake_up_time']->setTimezone($timezone);
				} else {
					$wake_up_time = $data['wake_up_time'];
				}
				list($wake_up_hour, $wake_up_minute, $wake_up_total_minutes) = static::to_minutes($wake_up_time);
				$wake_up_times[] = $wake_up_total_minutes;
			}

			# 就寝時間
			if (array_key_exists('last_sleep_time', $data)) {
				# UTC の場合は渡されたタイムゾーンに戻す
				if ($data['last_sleep_time']->getTimezone()->getName() === 'UTC') {
					$last_sleep_time = $data['last_sleep_time']->setTimezone($timezone);
				} else {
					$last_sleep_time = $data['last_sleep_time'];
				}
				list($last_sleep_hour, $last_sleep_minute, $last_sleep_total_minutes) = static::to_minutes($last_sleep_time, true, $wake_up_hour);
				$last_sleep_times[] = $last_sleep_total_minutes;
			}
		}

		$result = [
			'count' => $data_count,
			'averages' => [
				"avg_wake_up_time" => static::average_time($wake_up_times),
				"avg_sleep_time"   => static::average_time($last_sleep_times),
			]
		];

		return $result;
	}

	/**
	 * 時間を分に変換する
	 */
	private static function to_minutes($datetime, $is_sleep = false, $sleep_max_hour = 5) {
		# 時・分部分を取り出す。秒は捨てる
		list($hour, $minute) = static::extract_hour_and_minute($datetime);

		if ($is_sleep) {
			# 日付跨ぎ対策
			# 起床時間の方が前日の就寝時間より小さい場合(寝たのが 0 時過ぎ)は + 24 h する
			# 起床時間が無い場合は、AM 5:00 より小さい場合に日付跨ぎとし + 24 h する
			# (就寝判断設定の Max が 28時(AM 4:00)なので 5時とした)
			if ($sleep_max_hour > $hour) {
				$hour += 24;
			}
		}

		# 時間も分に変換
		$total_minute = $hour * 60 + $minute;
		return [$hour, $minute, $total_minute];
	}

	/**
	 * DateTime から時間・分を取り出し int の配列で返す
	 */
	private static function extract_hour_and_minute($datetime) {
		$hour   = (int) $datetime->format('H');
		$minute = (int) $datetime->format('i');
		return [$hour, $minute];
	}

	/**
	 * 時間(分数)の配列から平均時間の文字列を作成する
	 */
	private static function average_time($minutes) {
		$count = count($minutes);
		if ($count <= 0) {
			return null;
		}
		$avg_minutes = array_sum($minutes) / $count;
		$hour   = (int) ($avg_minutes / 60);
		$minute = (int) ($avg_minutes % 60);
		if ($hour >= 24) {
			$hour -= 24;
		}
		return sprintf("%02d:%02d:00", $hour, $minute);
	}
}
