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

    public static function createTable(){
        $sql = "CREATE TABLE data (
  id int NOT NULL IDENTITY (1, 1),
  corporate_id NVARCHAR(255),
  sensor_id NVARCHAR(255),
  date DATETIME,
  temperature FLOAT,
  humidity FLOAT,
  illuminance INT,
  active FLOAT
) ON [PRIMARY];";
        return DB::query($sql)->execute("data");
    }

    public static function getLatestData($sensor_name) {
        $data = \Model_Data::query()->where('sensor_id', $sensor_name)->where('date', '>', date("Y-m-d H:i:s", strtotime("-10minutes")))->order_by('date', 'desc')->connection("data")->get_one();
        return \Model_Data::format($data);
    }

    public static function format($data) {
        if($data) {
            $data['discomfort'] = 0.81 * $data['temperature'] + 0.01 * $data['humidity'] * (0.99 * $data['temperature'] - 14.3) + 46.3;
            $data['discomfort'] = round($data['discomfort'], 1);
            $data['discomfort'] = (string)$data['discomfort'];
            //熱中症指数＝ (0.3×温度+2.75)×(湿度-20)÷80 + 0.75×温度-0.75
            $data['wbgt'] = (0.3 * $data['temperature'] + 2.75) * ($data['humidity'] - 20) / 80 + 0.75 * $data['temperature'] - 0.75;
            $data['wbgt'] = round($data['wbgt'], 1);
            $data['wbgt'] = (string)$data['wbgt'];
        }
        return $data;
    }
}