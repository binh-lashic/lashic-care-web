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

    public function action_reconnection() {
        $sensor = \Model_Sensor::find(Input::param("sensor_id"));
        $time = strtotime(date("Y-m-d H:i:00"));
        $sensor->setTime($time);
        $sensor->checkReconnection();
        exit;
    }

    public function action_save_sensor() {
$sensors = explode(PHP_EOL, "0005b
0005c
0005d
0005e
0005f
00060
00061
00062
00063
00064
00065
00066
00067
00068
00069
0006a
0006b
0006c
0006d
0006e
0006f
00070
00071
00072
00073
00074
00075
00076
00077
00078
00079
0007a
0007b
0007c
0007d
0007e
0007f
00080
00081
00082
00083
00084
00085
00086
00087
00088
00089
0008a
0008b
0008c
0008d
0008e
0008f
00090
00091
00092
00093
00094
00095
00096
00097
00098
00099
0009a
0009b
0009c
0009d
0009e
0009f
000a0
000a1
000a2
000a3
000a4
000a5
000a6
000a7
000a8
000a9
000aa
000ab
000ac
000ad
000ae
000af
000b0
000b1
000b2
000b3
000b4
000b5
000b6
000b7
000b8
000b9
000ba
000bb
000bc
000bd
000be");
$users = array(110, 111, 112);
foreach($users as $user) {
    foreach($sensors as $_sensor) {
        $client = null;
        $sensor = \Model_Sensor::find("first", array(
            "where" => array(
                "name" => $_sensor
            )
        ));
        if($sensor) {
            $_user_sensors = \Model_User_Sensor::find("all", array(
                "where" => array(
                    "sensor_id" => $sensor->id,
                )
            ));
            if(count($_user_sensors)) {
                foreach($_user_sensors as $_user_sensor) {
                    $_user = \Model_User::find($_user_sensor['user_id']);
                    if($_user['admin'] == 0) {
                        $client = $_user;
                    }
                }

                //もし見守られユーザが一人もいないのであれば新規登録
                
                if(empty($client)) {
                    $params = array(
                        'username' => $sensor->id."-".$_sensor,
                        'password' => sha1($sensor->id."-".$_sensor.mt_rand()),
                        'email' => $sensor->id."-".$_sensor."@example.com",
                    );
                    try {
                        $user_id = Auth::create_user(
                                $params['username'],
                                $params['password'],
                                $params['email']);

                        $client = \Model_User::find($user_id);
                        $client->set(array(
                            'admin' => 0,
                        ));
                        $client->save();
                        echo "User:",$user_id," saved\n";
                    } catch (Exception $e) {
                        $client = \Model_User::find("first", array(
                            'where' => array(
                                "email" => $params['email'],
                            )
                        ));
                    }
                    try {
                        $user_sensor = \Model_User_Sensor::forge();
                        $user_sensor->set(array(
                            'user_id' => $client->id,
                            'sensor_id' => $sensor->id,
                        ));
                        $user_sensor->save();
                        echo "UserSensor:",$user_id,"->",$sensor->id," saved\n";                      
                    } catch(Exception $e) {

                    }
                }
                if(!empty($client)) {
                    try {
                        $user_client = \Model_User_Client::forge();
                        $user_client->set(array(
                                'user_id' => $user,
                                'client_user_id' => $client->id,
                        ));
                        $user_client->save();
                    } catch(Exception $e) {
                    }                    
                }

            }

            $user_sensor = \Model_User_Sensor::find("first", array(
                "where" => array(
                    "user_id" => $user,
                    "sensor_id" => $sensor->id,
                )
            ));
            if($user_sensor) {
                echo "UserSensor:",$user, "->",$sensor->id," is already set.\n";
            } else {
                $user_sensor = \Model_User_Sensor::forge();
                $user_sensor->set(array(
                    'user_id' => $user,
                    'sensor_id' => $sensor->id,
                ));
                $user_sensor->save(false);
                echo "UserSensor:",$user, "->",$sensor->id," saved.\n";
            }            
        } else {
            echo "Sensor:",$user, "->",$_sensor," is not found.\n";
        }

    }    
}

exit;
/*
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

        */
    }
    
}