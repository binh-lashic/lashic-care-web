<?php 
class Model_Data_Bedsensor extends Orm\Model{
	protected static $_table_name = 'bed_sensor_trigger_data';

	protected static $_properties = array(
            'id',
            'sensor_id',
            'measurement_time',
            'humans',
            'motion',
            'posture',
            'sleep',
            'rolling',
            'pulse',
            'created_at',
            'updated_at',
        );

    public static function getdailyData($sensor_id, $date=null) {
    }

    public static function getLatestData($sensor_id) {
        $data = \Model_Data_Bedsensor::query()
                    ->where('sensor_id', $sensor_id)
//                    ->where('measurement_time', '>', date("Y-m-d H:i:s", strtotime("-10minutes")))
                    ->order_by('measurement_time', 'desc')
                    ->connection("data")
                    ->get_one();
        return \Model_Data_Bedsensor::format($data);
    }

    public static function format($data) {
        if($data) {
        } else {
        }
        return $data;
    }
}
		
