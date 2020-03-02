<?php
/**
 * ランダム文字列生成ユーティリティクラス
 */

class Util_Random
{
	public static function random($length = 4)
	{
		return substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ0123456789'), 0, $length);
	}
}