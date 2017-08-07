<?php
class Controller_Admin_User_Sensor extends Controller_Admin
{
    public function action_create()
    {
        try {
            \Model_User_Sensor::createTable();
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }

    /*
     * 親アカウントセンサー機器割当一覧
     * 
     * @access public
     * 
     */
    public function action_index()
    {
        $this->template->title = '会員ページ';
        $this->template->content = Presenter::forge('admin/user/sensor');      
    }

    public function action_delete()
    {
        $user_id = Input::param("user_id");
        $sensor_id = Input::param("sensor_id");

        \Model_User_Sensor::deleteUserSensor(array('user_id' => $user_id, 'sensor_id' => $sensor_id));

        $client = \Model_Sensor::getClient(array('sensor_id' => $sensor_id));
        if(isset($client)) {
            \Model_User_Client::deleteUserClient(array('user_id' => $user_id, 'client_user_id' => $client->id));
        }
        Response::redirect('/admin/user/sensor?id='.$user_id); 
    }
}