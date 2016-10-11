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


	public function alert() {
		$time = strtotime(date("Y-m-d H:i:00"));
		//開通確認
		$sensors = \Model_Sensor::find("all", array(
			'where' => array(
				'enable' => 0,
				array('shipping_date', "<", date("Y-m-d H:i:s"))
			)
		));
		foreach($sensors as $sensor) {
			$result = DB::select("*")
					    ->from('data')
					    ->where('sensor_id', $sensor->name)
					    ->where('date', date("Y-m-d H:i:00", $time - 60))
					    ->execute('data');
			if(isset($result)) {
				$sensor->set(array('enable' => 1));
				$sensor->save();
			}
		}

		$sensors = \Model_Sensor::find("all", array(
			'where' => array(
				'enable' => 1,
			)
		));
		foreach($sensors as $sensor) {
			$sensor->users;
			$sensor->setTime($time);
			try {
				$this->result['data'][] = array(
					'sensor_id' => $sensor->id,
					'disconnection' => $sensor->checkDisconnection(),				//通信断アラート
					'fire' => $sensor->checkFire(),									//火事アラート
					'temperature' => $sensor->checkTemperature(),					//室温異常通知
					'heatstroke' => $sensor->checkHeatstroke(),						//熱中症アラート
					'humidity' => $sensor->checkHumidity(),							//室内湿度異常アラート
					'mold_mites' => $sensor->checkMoldMites(),						//カビ・ダニ警報アラート
					'illuminance_daytime' => $sensor->checkIlluminanceDaytime(),	//室内照度異常（日中）
					'illuminance_night' => $sensor->checkIlluminanceNight(),		//室内照度異常（深夜）
					'wake_up' => $sensor->checkWakeUp(),							//起床時間 //平均起床時間遅延
					'sleep' => $sensor->checkSleep(),								//就寝時間 //平均睡眠時間遅延
					'abnormal_behavior' => $sensor->checkAbnormalBehavior(),		//異常行動（夜間、照明をつけずに動いている）
					'active_non_detection' => $sensor->checkActiveNonDetection(),	//一定時間人感センサー未感知
																					//通信復帰通知
            	);
			} catch (Exception $e) {
				\Log::info($e->getMessage(), 'alert error');
			}
        }
        return ; 
    }
    
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
