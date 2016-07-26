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
    	$id = Input::param("id");
    	if($id) {
    		$data['user'] = Model_User::getUser($id);
    	}
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/user/index', $data);
	}

    public function action_login() {
        if (Auth::force_login(Input::param('id')))
        {
            Session::delete('client');
            Response::redirect('/user');
        }
    }

    public function action_list() {
        $data = array();
        $data['page'] = Input::param("page") ? Input::param("page") : 1;
        $query = array(
            'admin' => 1,
            'limit' => 10,
            'page' => $data['page'],
        );
        if(Input::param('query')) {
             $query['query'] = Input::param('query');
        }
        $admins = Model_User::getSearch($query);

        foreach($admins as $admin) {
            $sensors = \Model_User::getSensors($admin['id']);
            $admin['sensors'] = $sensors;
            $data['admins'][] = $admin;
        }
        $data['query'] = Input::param('query');
        $this->template->title = '管理ページ 親アカウント一覧';
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
        $sensor_names_data = Input::param("sensor_names");
        $sensor_names = explode(PHP_EOL, $sensor_names_data);

        if($user_id && $sensor_names) {
            foreach($sensor_names as $name) {
                $name = trim($name);
                //センサーを新規登録
                $sensor = Model_Sensor::find("first" , array(
                    'where' => array(
                            array('name', $name),
                        )
                    ));
                if(!$sensor) {
                    $sensor = Model_Sensor::forge();
                    $sensor->set(array('name' => $name));
                    $sensor->save();
                }

                if($sensor->id > 0) {
                    if(empty($client)) {
                        $client = \Model_Sensor::getClient(array('sensor_id' => $sensor->id));
                    }
                    if(empty($client)) {
                        //見守られユーザを新規作成
                        $client = \Model_User::createClientWithSensor($sensor);
                    }

                    //見守られユーザを登録
                    \Model_User_Client::saveUserClient(array(
                        'user_id' => $user_id,
                        'client_user_id' => $client->id,
                    ));

                    //管理者として登録
                    \Model_User_Sensor::saveUserSensor(array(
                        'user_id' => $user_id,
                        'sensor_id' => $sensor->id,
                        'admin' => 1,
                    ));
                }
            }
    		$user = Model_User::getUser($user_id);
	        Response::redirect('/admin/user/sensor?id='.$user['id']);

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