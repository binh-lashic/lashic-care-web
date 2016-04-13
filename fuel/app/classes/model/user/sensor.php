<?php 
class Model_User_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'sensor_id',
		'temperature_alert',
		'fire_alert',
		'heatstroke_alert',
		'hypothermia_alert',
		'humidity_alert',
		'mold_mites_alert',
		'illuminance_daytime_alert',
		'illuminance_night_alert',
		'disconnection_alert',
		'reconnection_alert',
		'wake_up_alert',
		'abnormal_behavior_alert',
		'active_non_detection_alert',
	);

	protected static $_has_one = array('sensor'=> array(
        'model_to' => 'Model_Sensor',
        'key_from' => 'sensor_id',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ));

	public static function createTable(){
		try {
		    DB::query("DROP TABLE user_sensors")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE user_sensors (
  id INT NOT NULL IDENTITY (1, 1),
  user_id INT NOT NULL,
  sensor_id INT NOT NULL
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

}