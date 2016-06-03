<?php
class Controller_Admin_Test extends Controller_Admin
{
    //86
    public function action_alert() {
        $sensor = \Model_Sensor::find(Input::param("sensor_id"));
        $params = array(
            'type' => 'temperature',
        );
        $sensor->alert($params);
        exit;        
    }

    public function action_wake_up() {
        $sensor = \Model_Sensor::find(Input::param("sensor_id"));
        $sensor->checkWakeUp();
        exit;
    }

    public function action_sleep() {
        $sensor = \Model_Sensor::find(Input::param("sensor_id"));
        $sensor->checkSleep();
        exit;
    }

    public function action_active() {
        $sensor = \Model_Sensor::find(Input::param("sensor_id"));
        $sensor->checkActiveNonDetection();
        exit;
    }

    public function action_disconnection() {
        $sensor = \Model_Sensor::find(Input::param("sensor_id"));
        $time = strtotime(date("Y-m-d H:i:00"));
        $sensor->setTime($time);
        $sensor->checkDisconnection();
        exit;
    }

    public function action_save_sensor() {
        $user_id = 87;
        $params['sensor_id'] = 5;

        $user_sensor = \Model_User_Sensor::find("first", array(
            "where" => array(
                "user_id" => $user_id,
                "sensor_id" => $params['sensor_id'],
            )
        ));
        $params['fire_alert'] = 0;
        unset($params['q']);
        unset($params['id']);
        unset($params['user_id']);
        unset($params['sensor_id']);
        $user_sensor->set($params);
        $user_sensor->save(false);
    }
    
}