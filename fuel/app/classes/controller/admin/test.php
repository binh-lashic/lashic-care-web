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
}