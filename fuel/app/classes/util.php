<?php
class Util {
    public static function format_week($week)
    {
    	$week_array = array(
    		'日',
    		'月',
    		'火',
    		'水',
    		'木',
    		'金',
    		'土',
    	);
        return $week_array[$week];
    }

    public static function calc_cold($humidity, $temperature)
    {
        // 「風邪ひき指数」＝(-3/4）×「湿度」−「温度」＋100
        $cold = -0.75 * $humidity - $temperature + 100;
        return $cold;
    }

    public static function functions_token($target)
    {
        $salt = $_SERVER['FUNCTIONS_SALT'];
        $iterations = intval($_SERVER['FUNCTIONS_ITERATIONS']);
        return self::create_token($target, $salt, $iterations);
    }

    public static function websocket_token($target)
    {
        $salt = $_SERVER['WEBSOCKET_SALT'];
        $iterations = intval($_SERVER['WEBSOCKET_ITERATIONS']);
        return self::create_token($target, $salt, $iterations);
    }
  
	/**
	 * ホスト名から本番かどうか判断する
	 * @return bool
	 * @throws FuelException
	 */
	public static function is_production()
	{
	  \Config::load('infic', true);
	  return ($_SERVER['HTTP_HOST'] == \Config::get('http_host_production'));
	}

    private static function create_token($target, $salt, $iterations)
    {
        $secret = $target.date('Ymd');
        Log::debug('secret:'.$secret);
        Log::debug('salt:'.$salt);
        Log::debug('iterations:'.$iterations);
        $hash = hash_pbkdf2('sha512', $secret, $salt, $iterations, 64, true);
        return base64_encode($hash);
    }
}
