<?php
class SensorRules {
    /*
     * 同一の機器タイプが割当済みかチェック
     * 
     * @params int $val
     * @params int $user_id
     * @return boolean
     */
    public static function _validation_selected_sensortype($val, $user_id)
    {
         return ! Model_User_Sensor::checkSelectedSensorType([
                    'user_id' => $user_id, 
                    'sensor_id' => $val
                 ]);
    }
    
    /*
     * センサー割当済みチェック
     * 
     * @params int $val
     * @return boolean
     */
    public static function _validation_selected($val)
    {
         return ! Model_User_Sensor::count_by_client_user($val);
    }
}
