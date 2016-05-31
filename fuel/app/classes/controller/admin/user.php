<?php
class Controller_Admin_User extends Controller_Admin
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

    public function action_list() {
        $data = array();
        $data['admins'] = Model_User::getAdmins();
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/user/list', $data);
    }

    public function action_alert() {
        $data = array();
        $id = Input::param("id");
        if($id) {
            $data['user'] = Model_User::getUser($id);
        }
        $this->template->title = '管理ページ アラート設定';
        $this->template->content = View::forge('admin/user/alert', $data);
    }

	public function action_save() {
        $admin_user_id = Input::param("admin_user_id");
        $parmas = Input::param();
        if(empty($parmas['email'])) {
            $parmas['email'] = mt_rand()."@example.com";
            $parmas['password'] = sha1(mt_rand());
        }
		$user = Model_User::saveUser($parmas);
		if($user) {
            if($user['admin']) {
                Response::redirect('/admin/user/?admin_user_id='.$user['id']);
            } else {
                \Model_User::saveClients($admin_user_id, array($user['id'] => "true"));
                Response::redirect('/admin/user/?admin_user_id='.$admin_user_id);
            }
		}
	}

    public function action_alert_save() {
        $id = Input::param("id");
        $user = Model_User::saveUser(Input::param());
        if($user) {
            Response::redirect('/admin/user/alert?id='.$id);
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

    public function action_contract() {
        $id = Input::param("user_id");
        if($id) {
            $user = Model_User::find($id);
            $data['user'] = $user;
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/contract_list', $data);
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
                'admin' => 1,
           	));
           	try {
	           	if(!$user_sensor->save()) {
	           	}
	        } catch(Exception $e) {

	        }
    		$user = Model_User::getUser($user_id);
	        Response::redirect('/admin/user/?admin_user_id='.$user['id']);

    	}
    }

    public function action_client_list() {
        $user_id = Input::param("user_id");
        if($user_id) {
            $data['user'] = \Model_User::find($user_id);
            $users = \Model_User::getClients();
            $clients = \Model_User::getClients($user_id);
            foreach($clients as $client) {
                if(isset($client->id)) {
                    $client_keys[$client->id] = true;
                }
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