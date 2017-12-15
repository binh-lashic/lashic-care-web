<?php
/*
 *  過去６ヶ月分のセンサーデータ取得API
 *  Controller_Api_Reportを継承
 *  
 */
class Controller_Api_Monthlies extends Controller_Api_Report
{
    /*
     * 依存処理の実行
     * 
     * @access protected
     * @return array
     */
    protected function execute()
    {   
        try {
            $user_id = parent::getAuthUserId();
            $client_user_id = Input::param('user_id');           
            
            $user_client = parent::getUserClients(['user_id' => $user_id, 'client_user_id' => $client_user_id]);
            $sensors = parent::getSensorsByClientUserId(['client_user_id' => $client_user_id]);
            
            return $this->getData($sensors);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * APIからデータを取得
     * 
     * @access protected
     * @param array $param
     * @return array $data
     */
    protected function getData(array $param)
    {
        try {
            $data = \Model_Api_Sensors_Monthly::find_by_sensor_name($param['sensor_name'], $param['bedsensor_name']);
            return (!parent::isMock()) ? $data : $this->mock();
                
        } catch (Exception $e) {
            throw new Exception('センサーデータ取得に失敗しました。');
        }
    }
    
    /*
     * mock data
     *
     */
    protected function mock()
    {
        return [
            0 => 
            [
                "activity" => 54.403225806452, 
                "night_activity" => 44.98333333333334, 
                "month" => 4, 
                "sensor_id" => "0x888882", 
                "sleeping_time" =>  613, 
                "sleep_time" => "22:20:00", 
                "wake_up_time" => "06:42:00", 
                "year" => 2017
            ],
            1 => 
            [
                "activity" => 54.403225806452, 
                "night_activity" => 44.98333333333334, 
                "month" => 5, 
                "sensor_id" => "0x888882", 
                "sleeping_time" =>  613, 
                "sleep_time" => "22:20:00", 
                "wake_up_time" => "06:42:00", 
                "year" => 2017     
            ],
            2 => 
            [
                "activity" => 54.403225806452, 
                "night_activity" => 44.98333333333334, 
                "month" => 6, 
                "sensor_id" => "0x888882", 
                "sleeping_time" =>  613, 
                "sleep_time" => "22:20:00", 
                "wake_up_time" => "06:42:00", 
                "year" => 2017                
            ],
            3 => 
            [
                "activity" => 54.403225806452, 
                "night_activity" => 44.98333333333334, 
                "month" => 7, 
                "sensor_id" => "0x888882", 
                "sleeping_time" =>  613, 
                "sleep_time" => "22:20:00", 
                "wake_up_time" => "06:42:00", 
                "year" => 2017                
            ],
            4 => 
            [
                "activity" => 54.403225806452, 
                "night_activity" => 44.98333333333334, 
                "month" => 8, 
                "sensor_id" => "0x888882", 
                "sleeping_time" =>  613, 
                "sleep_time" => "22:20:00", 
                "wake_up_time" => "06:42:00", 
                "year" => 2017                
            ]
        ];
    }
}

