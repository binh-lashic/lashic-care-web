<?php 
class Model_Data_Daily extends Orm\Model{
	protected static $_table_name = 'data_daily';

	protected static $_properties = array(
		'id',
        'sensor_id',
        'date',
        'wake_up_time',
        'sleep_time',
        'wake_up_time_average',
        'sleep_time_average',
        'temperature_average',
        'humidity_average',
        'active_average',
        'illuminance_average',
    );

	public static function createTable() {
		try {
		    DB::query("DROP TABLE data_daily")->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
        $sql = "CREATE TABLE data_daily (
		 id int NOT NULL IDENTITY (1, 1),
		 sensor_id INT,
		 date DATE,
		 wake_up_time DATETIME,
		 sleep_time DATETIME,
		 wake_up_time_average FLOAT,
		 sleep_time_average FLOAT,
		 temperature_average FLOAT,
		 humidity_average FLOAT,
		 active_average FLOAT,
		 illuminance_average INT
		) ON [PRIMARY];";
		try {
			DB::query($sql)->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}
    
    public static function getLatestData($sensor_id) {
        $data = \Model_Data_Daily::query()->where('sensor_id', $sensor_id)->order_by('date', 'desc')->get_one();
        return $data;
    }
}
		