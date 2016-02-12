<?php 
class Model_Sensor_User extends Orm\Model{
	protected static $_properties = array(
		'id',
		'sensor_id',
		'user_id',
	);

	protected static $_has_one = array('sensor'=> array(
        'model_to' => 'Model_User',
        'key_from' => 'user_id',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));

	public static function createTable(){
		try {
		    DB::query("DROP TABLE sensor_users")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE sensor_users (
  id INT NOT NULL IDENTITY (1, 1),
  sensor_id INT NOT NULL
  user_id INT NOT NULL,
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

}