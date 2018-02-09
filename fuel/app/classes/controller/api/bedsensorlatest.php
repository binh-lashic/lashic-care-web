<?php
/**
 *  現在のベッドセンサーデータ取得API
 *  Controller_Api_Reportを継承
 */
class Controller_Api_BedSensorLatest extends Controller_Api_Report
{
    /**
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

    /**
     * 現在のベッドセンサーデータ取得APIからデータを取得
     * 
     * @access protected
     * @param array $param
     * @return array $data
     */
    protected function getData(array $param)
    {
        try {
            $data = \Model_Api_Sensors_Latest::find_by_latest(null, $param['bedsensor_name']);
            return (!parent::isMock()) ? $data : $this->mock();
                
        } catch (Exception $e) {
            throw new Exception('センサーデータ取得に失敗しました。');
        }
    }
    
    /**
     * mock data
     *
     */
    protected function mock()
    {
        return [
                "sensor_id" => "0x81032684",
                "status" => "離床", 
                "pulse" => 72,
                "measurement_time" => "2018-02-02 13:58:51",
                "humans" => 0,
                "motion" => 0,
                "posture" => 0,
                "sleep" => 0,
                "rolling" => 0
        ];
    }
}

