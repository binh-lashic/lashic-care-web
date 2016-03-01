<?php
class Controller_Admin_User_Client extends Controller_Template
{

    public function action_index() {
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
                    $data['client_sensor_id'] = $client_sensors[0]->id;
                }
            }
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/client', $data);        
    }

	public function action_create() {
		try {
			\Model_User_Client::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}
}