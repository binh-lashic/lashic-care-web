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
date_default_timezone_set('Asia/Tokyo');

class Robots
{


	/**
	 * 登録されたセンサーの有効性チェック(データ着信チェック)とアラートチェック処理を行うバッチ
	 * 起床・就寝のアラートはこのバッチでは行わないので注意。
	 */
	public function alert() {
		$start = date("Y-m-d H:i:s");
		\Log::info("task [robots:alert] start. start:[{$start}] environment:[" . \Fuel::$env . "]", __METHOD__);
		echo "start:",$start,"\n";

		try {
			$time = strtotime(date("Y-m-d H:i:00"));
			//開通確認
			$sensors = \Model_Sensor::find("all", array(
				'where' => array(
					'enable' => 0,
					array('shipping_date', "<", date("Y-m-d H:i:s"))
				)
			));
			foreach($sensors as $sensor) {
				if($sensor->enable == 0) {
					# 一分以内のセンサーデータが存在したら enable = 1 に更新
					$where = 'sensor_name = :sensor_name AND measurement_time >= :measurement_time';
					$params = [
						'sensor_name'      => $sensor->name,
						'measurement_time' => date("Y-m-d H:i:00", $time - 60),
					];
					$result = \Model_Batch_Data_Daily::find_converted_data_by_conditions($where, $params);
					\Log::debug(\DB::last_query('batch'), __METHOD__);
					if(isset($result)) {
						$sensor->set(array('enable' => 1));
						$sensor->save();
					}
				}
			}

			$sensors = \Model_Sensor::find("all", array(
				'where' => array(
					'enable' => 1,
					'type' => \Model_Sensor::TYPE_SENSOR
				)
			));
			foreach($sensors as $sensor) {
				$sensor->users;
				$sensor->setTime($time);
				$sensor->loadData();
				try {
					$this->result['data'][] = array(
						'sensor_id' => $sensor->id,
						'fire' => $sensor->checkFire(),									//火事アラート
						'temperature' => $sensor->checkTemperature(),					//室温異常通知
						'heatstroke' => $sensor->checkHeatstroke(),						//熱中症アラート
						'cold' => $sensor->checkCold(),						//風邪アラート
						'humidity' => $sensor->checkHumidity(),							//室内湿度異常アラート
						'mold_mites' => $sensor->checkMoldMites(),						//カビ・ダニ警報アラート
						'disconnection' => $sensor->checkDisconnection(),				//通信断アラート
						'illuminance_daytime' => $sensor->checkIlluminanceDaytime(),	//室内照度異常（日中）
						'illuminance_night' => $sensor->checkIlluminanceNight(),		//室内照度異常（深夜）
						'abnormal_behavior' => $sensor->checkAbnormalBehavior(),		//異常行動（夜間、照明をつけずに動いている）
						'active_non_detection' => $sensor->checkActiveNonDetection(),	//一定時間人感センサー未感知
					);
					echo $sensor->id."<>".$sensor->name."\n";
				} catch (PhpErrorException $e) {
					echo $e->getMessage()."\n";
					\Log::info($e->getMessage(), 'alert error');
				}
			}
			echo "end:",date("Y-m-d H:i:s"),"\n";
			return ; 
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [robots:alert] end. start:[{$start}] environment:[" . \Fuel::$env . "]", __METHOD__);
		}
    }

	/**
	 * 起床・就寝時刻の算出と遅延アラート送信を行うバッチ
	 */
	public function analyze_minutes() {
		$start = date("Y-m-d H:i:s");
		\Log::info("task [robots:analyze_minutes] start. start:[{$start}] environment:[" . \Fuel::$env . "]", __METHOD__);
		echo "start:", $start,"\n";
		try {
			$time = strtotime(date("Y-m-d H:i:00"));

			$sensors = \Model_Sensor::find("all", array(
				'where' => array(
					'enable' => 1,
				)
			));

			foreach($sensors as $sensor) {
				$sensor->setTime($time);
				$sensor->checkWakeUp();
				$sensor->checkSleep();
			}
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [robots:analyze_minutes] end. start:[{$start}] environment:[" . \Fuel::$env . "]", __METHOD__);
		}
	}

	/**
	 * 日次集計を行うバッチ
	 * バッチ用DB のデータを集計して data_daily に入れる
	 */
	public static function analyze_daily($date = null)
	{
		if($date) {
			$time = strtotime($date);
		} else {
    		$time = strtotime("-1day");
		}
    	$date = date("Y-m-d", $time);
    	$start_date = date("Y-m-d 00:00:00", $time);
		$end_date = date("Y-m-d 23:59:59", $time);	

		\Log::info("task [robots:analyze_daily] start. start_date:[{$start_date}] end_date:[{$end_date}] environment:[" . \Fuel::$env . "]", __METHOD__);
		try {
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

				$where = 'sensor_name = :sensor_name AND measurement_time BETWEEN :start_date AND :end_date';
				$data_daily_params = [
					'sensor_name' => trim($sensor->name),
					'start_date'  => $start_date,
					'end_date'    => $end_date,
				];
				$result = \Model_Batch_Data_Daily::find_converted_data_by_conditions($where, $data_daily_params);
				\Log::debug(\DB::last_query('batch'), __METHOD__);

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
					if($data_daily->save()) {
						echo $sensor->id."<>".$sensor->name."<>success\n";
					} else {
						echo $sensor->id."<>".$sensor->name."<>error\n";
					}
					echo print_r($params, true);
					echo \DB::last_query();
					echo "\n";
				}
			} 
			return;
		} catch(\Exception $e) {
			 // 未処理例外はログを記録して再 throw する
			$code    = $e->getCode();
			$message = $e->getMessage();
			$file    = $e->getFile();
			$line    = $e->getLine();
			\Log::error("Error code:[{$code}] Error message:[{$message}] - file:[{$file}:{$line}]", __METHOD__);
			throw $e;
		} finally {
			\Log::info("task [robots:analyze_daily] end. start_date:[{$start_date}] end_date:[{$end_date}] environment:[" . \Fuel::$env . "]", __METHOD__);
		}
	}

}

/* End of file tasks/robots.php */
