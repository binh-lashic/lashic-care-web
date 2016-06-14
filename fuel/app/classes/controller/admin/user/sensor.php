<?php
class Controller_Admin_User_Sensor extends Controller_Admin
{
	public function action_create() {
		try {
			\Model_User_Sensor::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}

    public function action_index() {
        $id = Input::param("id");
        if($id) {
            $user = Model_User::find($id);
            $sensors = \Model_User::getSensors($id);
            foreach($sensors as $sensor) {
                $user_sensors = Model_Sensor::getAdmins(array("sensor_id" => $sensor['id']));
                $sensor['admins'] = array();
                $sensor['clients'] = array();
                if(count($user_sensors) > 0)  {
                    foreach($user_sensors as $user_sensor) {
                        $user = \Model_User::find($user_sensor['user_id']);
                        if(isset($user)) {
                            if($user['admin'] == 1) {
                                $sensor['admins'][] = $user;
                            } else {
                                $sensor['clients'][] = $user;
                            }                       
                        }
                    }
                }
                $data['sensors'][] = $sensor;
            }
            $data['user'] = $user;
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/sensor', $data);
    }
}