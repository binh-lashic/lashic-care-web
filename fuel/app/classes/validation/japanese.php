<?php

/**
 * 独自バリデーションを追加
 */
class Validation_Japanese
{
	/**
	 * 
	 */
	public static function _validation_hiragana($val)
	{
		if( empty($val) ){ return true; }
		if( static::_validation_hirakata($val) ){
			return mb_convert_kana($val, "HcV");
		}
		
		return false;
	}
	
	/**
	 * 
	 */
	public static function _validation_katakana($val)
	{
		if( empty($val) ){ return true; }
		if( static::_validation_hirakata($val) ){
			return mb_convert_kana($val, "KVC");
		}
		
		return false;
	}
	
	/**
	 * 
	 */
	public static function _validation_hirakata($val)
	{
		if( empty($val) ){ return true; }
		
		mb_regex_encoding("UTF-8");
		if (preg_match("/^[ 　ぁ-んァ-ヶーｦ-ﾟ｡-ﾟ0-9０-９]+$/u", $val)) {
		    return true;
		}
		
		return false;
	}
}