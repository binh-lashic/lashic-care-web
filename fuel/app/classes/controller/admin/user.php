<?php
class Controller_Admin_User extends Controller_Template
{
    public function action_index() {
        $data = array();
        try {
        	$data['admins'] = Model_User::getAdmins();
        	$id = Input::param("id");
        	if($id) {
        		$data['user'] = Model_User::getUser($id);
        		$data['sensors'] = \Model_User::getSensors($data['user']['id']);
        	}
        } catch(Exception $e) {
        	echo $e->getMessage();
        }
        
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/user/index', $data);
	}

	public function action_save() {
		$user = Model_User::saveUser(Input::param());
		if($user) {
            $this->template->title = '会員ページ';
            $this->template->content = View::forge('admin/user/index');	
		} else {
        	$this->template->title = '会員ページ';
        	$this->template->content = View::forge('admin/user/index');	
		}
	}

    public function action_sensors() {
        $id = Input::param("id");
        if($id) {
                $user = Model_User::find($id);
                $data['user'] = $user;
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/sensors', $data);
    }

    public function action_add_sensor() {
        $user_id = Input::param("user_id");
        $name = Input::param("name");
        if($user_id && $name) {
            $sensors = Model_Sensor::find("all" , array(
                'where' => array(
                        array('name', $name),
                    )
                ));
           	if(!$sensors) {
	            $sensor = Model_Sensor::forge();
	            $sensor->set(array('name' => $name));
	            if(!$sensor->save()) {
	            }
           	} else {
           		$sensor = array_shift($sensors);
           	}

           	$user_sensor = Model_User_Sensor::forge();
           	$user_sensor->set(array(
           		'user_id' => $user_id,
           		'sensor_id' => $sensor->id,
           	));
           	try {
	           	if(!$user_sensor->save()) {
	           	}
	        } catch(Exception $e) {

	        }
    		$data['user'] = Model_User::getUser($user_id);
    	}
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/index', $data);
    }
}