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
		 wake_up_time_average TIME,
		 sleep_time_average TIME,
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

    public static function getData($sensor_id, $date=null) {
        $data = \Model_Data_Daily::query()->where('sensor_id', $sensor_id)->where('date', $date)->order_by('date', 'desc')->get_one();
        return \Model_Data_Daily::format($data);
    }

    public static function getLatestData($sensor_id) {
        $data = \Model_Data_Daily::query()->where('sensor_id', $sensor_id)->order_by('date', 'desc')->get_one();
        return \Model_Data_Daily::format($data);
    }

    public static function format($data) {
        if($data) {
            $data['discomfort_average'] = 0.81 * $data->temperature_average + 0.01 * $data->humidity_average * (0.99 * $data->temperature_average - 14.3) + 46.3;
            $data['discomfort_average'] = round($data['discomfort_average'], 1);
            $data['wbgt_average'] =  (0.3 * $data->temperature_average + 2.75) * ($data->humidity_average - 20) / 80 + 0.75 * $data->temperature_average - 0.75;
            $data['wbgt_average'] = round($data['wbgt_average'], 1);
        } else {
            $data['discomfort_average'] = "";
            $data['wbgt_average'] = "";
        }
        return $data;
    }
}
		