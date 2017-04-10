<?php

/**
 * Class Util_Datetime
 */
class Util_Datetime {
	/**
	 * 引数の DateTime が今日を表しているかどうかを返す
	 * @param DateTime|string $date
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	public static function is_today($date) {
		$target_date = self::to_datetime($date);
		$target_date->setTime(0, 0, 0);

		$today = new DateTime(null, $target_date->getTimezone());
		$today->setTime(0, 0, 0);
		return self::is_same_day($today, $target_date);
	}

	/**
	 * 2つの DateTime が同じ日を表しているかどうかを返す
	 * @param DateTime|string $date1
	 * @param DateTime|string $date2
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	public static function is_same_day($date1, $date2) {
		$target_date1 = self::to_datetime($date1);
		$target_date1->setTime(0, 0, 0);

		$target_date2 = self::to_datetime($date2);
		$target_date2->setTime(0, 0, 0);
		return ($target_date1->diff($target_date2)->days == 0);
	}

	/**
	 * 文字列または DateTime を受取り DateTime を返す
	 * DateTime の場合は clone した別オブジェクトを返す
	 * @param DateTime|string $date
	 * @return DateTime
	 * @throws InvalidArgumentException
	 */
	public static function to_datetime($date) {
		$target_date = null;
		if ($date instanceof DateTime) {
			$target_date = clone($date);
		} elseif (is_string($date)) {
			$target_date = new DateTime($date);
		} else {
			throw new InvalidArgumentException("date is invalid");
		}
		return $target_date;
	}
}
