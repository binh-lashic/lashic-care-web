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
}