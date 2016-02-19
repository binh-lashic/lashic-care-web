<?php 
class Model_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'name',
		'temperature_upper_limit',
		'temperature_lower_limit',
		'temperature_duration',
		'fire_temperature_upper_limit',
		'heatstroke_wbgt_upper_limit',
		'heatstroke_duration',
		'humidity_upper_limit',
		'humidity_lower_limit',
		'humidity_duration',
		'mold_mites_humidity_upper_limit',
		'mold_mites_temperature_upper_limit',
		'mold_mites_duration',
		'illuminance_daytime_lower_limit',
		'illuminance_daytime_duration',
		'illuminance_daytime_start_time',
		'illuminance_daytime_end_time',
		'illuminance_night_lower_limit',
		'illuminance_night_duration',
		'illuminance_night_start_time',
		'illuminance_night_end_time',
		'disconnection_duration',
		'wake_up_period',
		'wake_up_delay_allowance_duration',
	);

	public static function createTable(){
		try {
		    DB::query("DROP TABLE sensors")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE sensors (
  id INT NOT NULL IDENTITY (1, 1),
  name NVARCHAR(50),
  temperature_upper_limit INT,
  temperature_lower_limit INT,
  temperature_duration INT,
  fire_temperature_upper_limit INT,
  heatstroke_wbgt_upper_limit INT,
  heatstroke_duration INT,
  humidity_upper_limit INT,
  humidity_lower_limit INT,
  humidity_duration INT,
  mold_mites_temperature_upper_limit INT,
  mold_mites_duration INT,
  illuminance_daytime_lower_limit INT,
  illuminance_daytime_duration INT,
  mold_mites_humidity_upper_limit INT,
  illuminance_daytime_start_time INT,
  illuminance_daytime_end_time INT,
  illuminance_night_lower_limit INT,
  illuminance_night_duration INT,
  illuminance_night_start_time INT,
  illuminance_night_end_time INT,
  disconnection_duration INT,
  wake_up_period INT,
  wake_up_delay_allowance_duration INT
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function getSensor($id){
		$sensor = \Model_Sensor::find($id);
		if($sensor) {
			return $sensor;
		} else {
			return null;
		}	
	}

	public static function getSensorsFromClientUserId($client_user_id) {
		$sensors = array();
		$_sensors = \Model_User_Sensor::find('all',array(
			'where' => array(
				'user_id' => $client_user_id,
			),
			'realated' => array('sensor'),
		));
		foreach($_sensors as $_sensor) {
			$sensors[] = $_sensor->sensor;
		}
		return $sensors;
	}

	public static function saveSensor($params) {
    	$sensor = \Model_Sensor::find($params['id']);
    	if($sensor) {
    		unset($sensor['q']);
    		unset($sensor['id']);
    		$sensor->set($params);
    		if($sensor->save()) {
    			return $sensor;
    		}
    	}
    	return null;
    }
}