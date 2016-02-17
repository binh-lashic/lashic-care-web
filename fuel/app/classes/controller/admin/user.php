<?php
class Controller_Admin_User extends Controller_Template
{
	public function action_create() {
		try {
			\Model_User::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}

    public function action_index() {
        $data = array();
    	$data['admins'] = Model_User::getAdmins();
    	$id = Input::param("admin_user_id");
    	if($id) {
    		$data['user'] = Model_User::getUser($id);
    		$data['sensors'] = \Model_User::getSensors($data['user']['id']);
            $data['clients'] = Model_User::getClients($id);
    	}
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/user/index', $data);
	}

	public function action_save() {
        $admin_user_id = Input::param("admin_user_id");
		$user = Model_User::saveUser(Input::param());
		if($user) {
            if($user['admin']) {
                Response::redirect('/admin/user/?admin_user_id='.$admin_user_id);
            } else {
                Response::redirect('/admin/user/client?admin_user_id='.$admin_user_id.'&client_user_id='.$user['id']);
            }
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
    		$user = Model_User::getUser($user_id);
	        Response::redirect('/admin/user/?id='.$user['id']);

    	}
    }

    public function action_client() {
        $user_id = Input::param("admin_user_id");
        $client_id = Input::param("client_user_id");
        $data['blood_types'] = Config::get("blood_types");
        if($user_id) {
            $data['user'] = Model_User::find($user_id);
            $data['sensors'] = \Model_User::getSensors($data['user']['id']);
            if($client_id) {
                $data['client'] = Model_User::find($client_id);
                $client_sensors = \Model_User::getSensors($data['client']['id']);
                $data['client_sensor_id'] = $client_sensors[0]->id;
            }
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/client', $data);        
    }

    public function action_client_list() {
        $user_id = Input::param("user_id");
        if($user_id) {
            $data['user'] = \Model_User::find($user_id);
            $users = \Model_User::getClients();
            $clients = \Model_User::getClients($user_id);
            foreach($clients as $client) {
                $client_keys[$client->id] = true;
            }
            foreach($users as $user) {
                $user = $user->to_array(true);
                if(isset($client_keys[$user['id']])) {
                    $user['flag'] = true;
                }
                $data['users'][] = $user;
            }
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/client_list', $data);        
    }

    public function action_add_client() {
        $user_id = Input::param("id");
        $client_user_ids = Input::param("client_user_ids");
        \Model_User::saveClients($user_id, $client_user_ids);
        Response::redirect('/admin/user/client_list?user_id='.$user_id);
    }
}