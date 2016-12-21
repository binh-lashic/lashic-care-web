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
            $status = '-';
            // 在・不在
            if ($data->humans == 0) {
                $status = '不明';
            } else if ($data->humans == 16) {
                $status = '離床';
            } else if ($data->humans == 17) {
                $status = '検出中';
            } else if ($data->humans == 32) {
                // 姿勢
                if ($data->posture == 0) {
                    $status = '横になっています';
                } else if ($data->posture == 48) {
                    $status = '起上り';
                } else if ($data->posture == 64) {
                    $status = '離床注意';
                } else if ($data->posture == 32) {
                    $status = '座っています';
                } else if ($data->posture == 16) {
                    // 寝返り
                    if ($data->rolling == 0) {
                        $status = '横になっています';
                    } else if ($data->rolling == -32) {
                        $status = '左寝返り';
                    } else if ($data->rolling == -16) {
                        $status = '左移動';
                    } else if ($data->rolling == 16) {
                        $status = '右移動';
                    } else if ($data->rolling == 32) {
                        $status = '右寝返り';
                    }
                }
            }
            $data->status = $status;
        }
        return $data;
    }
}
		
