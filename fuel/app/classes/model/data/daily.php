<?php 
class Model_Data_Daily extends Orm\Model{
	protected static $_table_name = 'data_daily';

	protected static $_properties = array(
		'id',
        'sensor_id',
        'date',
        'wake_up_time',
        'sleep_time',
    );

	public static function createTable() {
		try {
		    DB::query("DROP TABLE data_daily")->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
		}
        $sql = "CREATE TABLE data_daily (
		 id int NOT NULL IDENTITY (1, 1),
		 sensor_id INT,
		 date DATE,
		 wake_up_time TIME,
		 sleep_time TIME
		) ON [PRIMARY];";
		try {
			DB::query($sql)->execute();
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}
    
    public static function getLatestData($sensor_id) {
        $data = \Model_Data_Daily::query()->where('sensor_id', $sensor_id)->order_by('date', 'desc')->connection("data")->get_one();
        return $data;
    }
}
		