<?php 
class Model_Data extends Orm\Model{
	protected static $_table_name = 'data';

	protected static $_properties = array(
		'id',
        'corporate_id',
        'sensor_id',
        'date',
        'temperature',
        'humidity',
        'illuminance',
        'active',
	);

    public static function getLatestData($sensor_name) {
        $data = \Model_Data::query()->where('sensor_id', $sensor_name)->order_by('date', 'desc')->connection("data")->get_one();
        return \Model_Data::format($data);
    }

    public static function format($data) {
        if($data) {
            $data['discomfort'] = 0.81 * $data->temperature + 0.01 * $data->humidity * (0.99 * $data->temperature - 14.3) + 46.3;
            $data['discomfort'] = round($data['discomfort'], 1);
        }
        return $data;
    }
}
		