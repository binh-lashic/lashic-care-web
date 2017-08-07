<?php
class SensorRules
{
    /*
     * 同一の機器タイプが割当済みかチェック
     * 
     * @access public
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
     * 同一親アカウント内でセンサーが割当済みかチェック
     * 
     * @access public
     * @params int $val
     * @params int $user_id
     * @return boolean
     */
    public static function _validation_is_selected($val, $user_id)
    {
         return ! Model_User_Sensor::countByClientUser($val, $user_id);
    }
    
    /*
     * 未出荷かどうか判定 
     * 
     * @access public
     * @params int $sensor_id
     * @return bool
     */
    public static function _validation_is_unshipped($val)
    {
        return ! Model_Sensor::isUnShipped($val);
    }
    
    /*
     * 改行、タブ、スペースを除去して空かどうかを判定する 
     * 
     * @access public
     * @params string $val
     * @return bool
     */
    public static function _validation_is_empty($val)
    {
        $value = str_replace(["\r\n", "\r", "\n", ' ', '　'], '', $val);
        if($value === '' || $value === null) {
            return  false;
        } else {
            return true;
        }
    }
}
