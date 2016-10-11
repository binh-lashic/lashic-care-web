<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Tasks;

/**
 * Robot example task
 *
 * Ruthlessly stolen from the beareded Canadian sexy symbol:
 *
 *		Derek Allard: http://derekallard.com/
 *
 * @package		Fuel
 * @version		1.0
 * @author		Phil Sturgeon
 */

class Robots
{
	/**
	 * This method gets ran when a valid method name is not used in the command.
	 *
	 * Usage (from command line):
	 *
	 * php oil r robots
	 *
	 * or
	 *
	 * php oil r robots "Kill all Mice"
	 *
	 * @return string
	 */
	public static function analyze($date = null)
	{
		if($date) {
			$time = strtotime($date);
		} else {
    		$time = strtotime("-1day");
		}
    	$date = date("Y-m-d", $time);
    	$start_date = date("Y-m-d 00:00:00", $time);
		$end_date = date("Y-m-d 23:59:59", $time);	

		$sensors = \Model_Sensor::find("all", array(
			'where' => array(
				'enable' => 1,
			)
		));

		foreach($sensors as $sensor) {
			$params = array(
				'sensor_id' => $sensor->id,
				'date' => $date,
			);
			$rows = \Model_Data_Daily::query()
				->where('sensor_id', $sensor->id)
				->where('date', 'between', array(
					date("Y-m-d", strtotime("-31day")),
					date("Y-m-d", strtotime("-1day"))
				))
				->get();
			$wake_up_time_total = 0;
			$sleep_time_total = 0;
			$wake_up_time_count = 0;
			$sleep_time_count = 0;
			foreach($rows as $row) {
				if(!empty($row['wake_up_time'])) {
					$wake_up_time_count++;
					$wake_up_time_total += (strtotime($row['wake_up_time']) - (strtotime($row['date']))) / 60;
					//$wake_up_time_total += date("h", strtotime($row['wake_up_time'])) * 60 + date("i", strtotime($row['wake_up_time']));
				}
				if(!empty($row['sleep_time'])) {
					$sleep_time_count++;
					$sleep_time_total += (strtotime($row['sleep_time']) - (strtotime($row['date']) - 60 * 60 * 24)) / 60;
				}
			}

			if($wake_up_time_count > 0) {
				$minutes = $wake_up_time_total / $wake_up_time_count;
				$hour = (int)($minutes / 60);
				$minutes = str_pad((int)($minutes - $hour * 60), 2, 0, STR_PAD_LEFT);
				if($hour >= 24) {
					$hour = $hour - 24;
				}
				$params['wake_up_time_average'] = $hour.":".$minutes.":00";				
			}

			if($sleep_time_count > 0) {
				$minutes = $sleep_time_total / $sleep_time_count;
				$hour = (int)($minutes / 60);
				$minutes = str_pad((int)($minutes - $hour * 60), 2, 0, STR_PAD_LEFT);
				if($hour >= 24) {
					$hour = $hour - 24;
				}
				$params['sleep_time_average'] = $hour.":".$minutes.":00";
			}

    		$sql = 'SELECT * FROM data WHERE sensor_id = :sensor_id AND date BETWEEN :start_date AND :end_date';
	    	$query = \DB::query($sql);
			$query->parameters(array(
				'sensor_id' => $sensor->name,
				'start_date' => $start_date,
				'end_date' => $end_date,
			));
			$result = $query->execute('data');
			$rows = $result->as_array();
			$count = count($rows);
			if($count > 0) {
				$temperature_total = 0;
				$humidity_total = 0;
				$active_total = 0;
				$illuminance_total = 0;
				foreach($rows as $row) {
					$temperature_total += $row['temperature'];
					$humidity_total += $row['humidity'];
					$active_total += $row['active'];
					$illuminance_total += $row['illuminance'];
				}
				$params['temperature_average'] = $temperature_total / $count;
				$params['humidity_average'] = $humidity_total / $count;
				$params['active_average'] = $active_total / $count;
				$params['illuminance_average'] = $illuminance_total / $count;

				$data_daily = \Model_Data_Daily::find('first', array('where' => array(
					'sensor_id' => $sensor->id,
					'date' => $date,
				)));
				if(empty($data_daily)) {
					$data_daily =  \Model_Data_Daily::forge();
				}
				$data_daily->set($params);
				$data_daily->save();

				\Log::info($sensor->id."<>".$sensor->name, 'save analyze');
				echo $sensor->id."<>".$sensor->name."\n";
			}
		} 
		return;
	}

}

/* End of file tasks/robots.php */
