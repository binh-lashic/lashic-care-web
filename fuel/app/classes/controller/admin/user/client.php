<?php
class Controller_Admin_User_Client extends Controller_Admin
{
    public function action_index()
    {
        $user_id = Input::param("admin_user_id");
        $client_id = Input::param("client_user_id");
        $data['blood_types'] = Config::get("blood_types");
        if($user_id) {
            $data['user'] = Model_User::find($user_id);
            $data['sensors'] = \Model_User::getSensors($data['user']['id']);
            if($client_id) {
                $data['client'] = Model_User::find($client_id);
                $client_sensors = \Model_User::getSensors($data['client']['id']);
                if(!empty($client_sensors[0])) {
                    $data['client_sensor_id'] = $client_sensors[0]['id'];
                }
            }
        }

        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/client', $data);        
    }

    public function action_create()
    {
        try {
            \Model_User_Client::createTable();
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }
    
    /*
     * 見守られユーザ一覧
     *  
     * @access public
     */
    public function action_list()
    {
        $this->template->title = '管理ページ 見守られユーザー一覧';
        $this->template->content = Presenter::forge('admin/user/client/list');
    } 
    
    /*
     * 見守られユーザ詳細
     * 
     *  @access public
     */
    public function action_detail()
    {
        $this->template->title = '管理ページ 見守られユーザ';
        $this->template->content = Presenter::forge('admin/user/client/detail');
    }

    /*
     * 見守られユーザーセンサー機器割当 
     * 
     * @access public
     */
    public function action_sensor()
    {
        $this->template->title = '管理ページ 見守られユーザ センサー機器割当';
        $this->template->content = Presenter::forge('admin/user/client/sensor');
    }
    
    /*
     * 見守られユーザセンサー機器割登録 
     * 
     * @access public
     */
    public function action_add_sensor()
    {
        $user_id = Input::param('user_id');
        $parent_id = Input::param('parent_id');  
        $sensor = Input::param('sensor');
     
        $validation = Validation::forge('add_sensor');
        $validation->add_callable('sensorrules');
        $validation->add('sensor')
                ->add_rule('selected_sensortype', $user_id)
                ->add_rule('is_selected', $parent_id)
                ->add_rule('is_unshipped');
        $validation->set_message('selected_sensortype', '別のセンサーが割当られているため、登録できません');
        $validation->set_message('is_selected', 'センサー割当済みです。センサー割当を解除してください');
        $validation->set_message('is_unshipped', '出荷日が設定されていません');

        if($validation->run()) {
            if ($user_id && $sensor) {
                $result = \Model_User_Sensor::saveUserSensor([
                    'user_id' => $user_id,
                    'sensor_id' => $sensor,
                    'admin' => 0
                ]);
            }
        } else {
            Session::set_flash('error', $validation->error_message('sensor'));
        }

        Response::redirect(
                sprintf('/admin/user/client/sensor?id=%s&parent_id=%s&sensor=%s',$user_id, $parent_id, $sensor)
                );
    }
    
    /*
     * 見守られユーザーセンサー機器割当解除 
     * 
     * @access public
     */
    public function action_delete_sensor()
    {
        $id = Input::param('id');
        $sensor_id = Input::param('sensor');
        $parent_id = Input::param('parent_id');

        if($id && $sensor_id) {
            Model_User_Sensor::deleteUserSensor([
                'user_id' => $id, 
                'sensor_id' => $sensor_id
                    ]);
        }
        
        Response::redirect(
                sprintf('/admin/user/client/sensor?id=%s&parent_id=%s&sensor=%s',$id, $parent_id, $sensor_id)
                );
    }
}