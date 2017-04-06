<?php

/**
 * Class Util_Datetime
 */
class Util_Datetime {
	/**
	 * @param DateTime|string $date
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	public static function is_today($date) {
		$target_date = null;
		if ($date instanceof DateTime) {
			$target_date = clone($date);
		} elseif (is_string($date)) {
			$target_date = new DateTime($date);
		} else {
			throw new InvalidArgumentException("date is invalid");
		}

		$target_date->setTime(0, 0, 0);

		$today = new DateTime(null, $target_date->getTimezone());
		$today->setTime(0, 0, 0);
		return ($today->diff($target_date)->days == 0);
	}
}
