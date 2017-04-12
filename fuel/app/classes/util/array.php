<?php
/**
 * 配列操作用ユーティリティクラス
 */
class Util_Array
{
	/**
	 * 配列を null safe に文字列化する
	 * @param array $array
	 * @param string $delimiter
	 */
	public static function to_string(array $array, $delimiter = ',') {
		if (is_null($array)) {
			return "";
		}
		return implode($delimiter, $array);
	}
}
