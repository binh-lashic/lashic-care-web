<?php
class Controller_Api_Beddata extends Controller_Api
{
    public function before() {
        $this->nologin_methods = array(
            'test',
            'analyze',
            'alert',
        );
        parent::before();
    }

    public function get_dashboard() {
        return $this->_dashboard();
    }

    public function post_dashboard() {
        return $this->_dashboard();
    }

    public function isSensorAllowed($sensor) {
        list(, $user_id) = Auth::get_user_id();
        $master = Session::get("master");
        if(empty($master) && !\Model_Sensor::isAllowed($sensor->id, $user_id)) {
            $this->errors[] = array(
                'message' => 'センサーへのアクセスの許可がありません'
            );
            return false;
        }
	return true;
    }

    public function _dashboard() {
        $sensor_name = Input::param("sensor_name");
        $sensor_id = Input::param("sensor_id");
        if(empty($sensor_name) && empty($sensor_id)) {
            $this->errors[] = array(
                'message' => 'センサーIDを指定してください'
            );
        }

//        if(!empty($sensor) && $this->isSensorAllowed($sensor)) {
            //日付を取得
            if(Input::param("date")) {
                $date = date("Y-m-d", strtotime(Input::param("date")));
                $data = \Model_Data_Bedsensor::getDailyData($sensor_id, $date);
            } else {
                $data = \Model_Data_Bedsensor::getLatestData($sensor_id);
            }
            $this->result['data'] = $data;             
//        }
        return $this->result();	
    }
}
