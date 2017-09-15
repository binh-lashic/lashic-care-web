<?php
/*
 *  過去のセンサーデータ取得API
 *  Controller_Api_Reportを継承
 */
class Controller_Api_Dailies extends Controller_Api_Report
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
            $year = Input::param('year');
            $month = Input::param('month'); 
            $data = (new \Model_Api_Sensors_Dailies())
                        ->factory($param['sensor_name'], $param['bedsensor_name'])
                        ->get($year, $month);

            return (!parent::isMock()) ? $data : $this->mock();
                
        } catch (Exception $e) {
            throw new Exception('センサーデータ取得に失敗しました。');
        }
    }
        
    /*
     * mock
     * 
     */
    protected function mock()
    {
            return [0 =>
                    ["activity" => "24.7",
                        "avg_sleep_time" => "00:00:00",
                        "avg_wake_up_time" => "09:00:00",
                        "cold" => 10.4,
                        "date" => "2017-09-01",
                        "discomfort" => 119.5,
                        "humidity" => "12.3223456733",
                        "illuminance" => "85",
                        "last_sleep_time" => "2017-08-31 23:00:00",
                        "sensor_id" => "0x8100d999",
                        "temperature" => "80.465789053211",
                        "wake_up_time" => "2017-09-01 09:30:00",
                        "wbgt" => 57
                    ],
                    1 => 
                    ["activity" => "39.7",
                        "avg_sleep_time" => "00:00:00",
                        "avg_wake_up_time" => "09:00:00",
                        "cold" => 10.4,
                        "date" => "2017-09-02",
                        "discomfort" => 119.5,
                        "humidity" => "23.343212",
                        "illuminance" => "85",
                        "last_sleep_time" => "2017-09-01 22:34:00",
                        "sensor_id" => "0x8100d999",
                        "temperature" => "60.4789666555",
                        "wake_up_time" => "2017-09-02 05:30:00",
                        "wbgt" => 57
                    ], 
                    2 => 
                    ["activity" => "11.5",
                        "avg_sleep_time" => "00:00:00",
                        "avg_wake_up_time" => "09:00:00",
                        "cold" => 10.4,
                        "date" => "2017-09-03",
                        "discomfort" => 119.5,
                        "humidity" => "12.3",
                        "illuminance" => "85",
                        "last_sleep_time" => "2017-09-02 19:34:00",
                        "sensor_id" => "0x8100d999",
                        "temperature" => "80.4",
                        "wake_up_time" => "2017-09-03 07:30:00",
                        "wbgt" => 57
                    ], 
                    3 => 
                    ["activity" => "11.5",
                        "avg_sleep_time" => "00:00:00",
                        "avg_wake_up_time" => "09:00:00",
                        "cold" => 10.4,
                        "date" => "2018-01-01",
                        "discomfort" => 119.5,
                        "humidity" => "12.3",
                        "illuminance" => "85",
                        "last_sleep_time" => "2017-12-31 23:37:00",
                        "sensor_id" => "0x8100d999",
                        "temperature" => "80.4",
                        "wake_up_time" => "2018-01-01 06:35:00",
                        "wbgt" => 57
                    ],
                ];
    }
}

