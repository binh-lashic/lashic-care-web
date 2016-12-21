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
}
