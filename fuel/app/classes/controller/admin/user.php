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
        $this->template->title = '管理ページ 親アカウント一覧';
	$this->template->content = Presenter::forge('admin/user/list');
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

    /*
     * 親アカウントセンサー機器の新規登録 
     * 
     * @access public
     */
    public function action_add_sensor()
    {
        $user_id = Input::param("user_id");
        
        $validation = Validation::forge('add_sensor');
        $validation->add_callable('sensorrules');
        $validation->add('sensor_names')
                    ->add_rule('is_empty');        
        $validation->set_message('is_empty', '機器IDが入力されていません。');

        if($validation->run()) {
            $sensor_names_data = Input::param("sensor_names");
            $sensor_names = explode(PHP_EOL, $sensor_names_data);

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
                    //管理者として登録
                    \Model_User_Sensor::saveUserSensor(array(
                        'user_id' => $user_id,
                        'sensor_id' => $sensor->id,
                        'admin' => 1,
                    ));
                }
            }
            
    	} else {
            Session::set_flash('error', $validation->error_message('sensor_names'));
        }
        
        $user = Model_User::getUser($user_id);
        Response::redirect('/admin/user/sensor?id='.$user['id']);
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
    
    /*
     * 見守られユーザー登録フォーム
     * 
     *  @access public
     *  @param none
     *  @return none
     */
    public function action_client_form()
    {
        $id = Input::param("id");
        $this->template->title = '管理ページ 見守られユーザ 新規登録';
        $this->template->content = Presenter::forge('admin/user/client/form')
                ->set('id', $id)
                ->set('data', []);
    }

    /*
     * 見守られユーザー登録完了
     * 
     * @access publbic
     * @param none
     * @return none
     */
    public function action_client_complete()
    {
        $id = Input::param("id");
        $this->template->title = '管理ページ 見守られユーザ 新規登録完了';
        
        $data = [];
        $validation = Validation::forge('client_complete');
        
        if(Input::post()) {
            $validation->add_callable('userclientrules');
            $validation->add('zip_code')
                    ->add_rule('check_zipcode');
            $validation->add('phone', '電話番号1')
                    ->add_rule('check_phone');
            $validation->add('cellular', '電話番号2')
                    ->add_rule('check_phone');
            $validation->add('email')
                    ->add_rule('check_email')
                    ->add_rule('duplicate_email');
            $validation->set_message('check_zipcode', '郵便番号の形式が正しくありません。');
            $validation->set_message('check_phone', ' :labelの形式が正しくありません。');
            $validation->set_message('check_email', 'メールアドレスの形式が正しくありません。');
            $validation->set_message('duplicate_email', 'メールアドレスは既に登録されています。');
            
            foreach([
                'last_name','first_name','last_kana',
                'first_kana','gender','year',
                'month','day','blood_type','zip_code',
                'prefecture','address','phone',
                'cellular','email'
            ] as $key) {
                $data[$key] = Input::param($key);
            }
                 
            if($validation->run()) {
                $data['birthday'] = sprintf('%d-%02d-%02d', $data['year'], $data['month'], $data['day']);
                $prefectureList = Config::get('prefectures');
                $data['prefecture'] = $prefectureList[$data['prefecture']];
                $data['admin'] = 0;
     
                try {
                    $user = Model_User::saveClientUser($id, $data);
                    return Response::redirect(sprintf('/admin/user/client/detail?id=%s&parent_id=%s', $user['id'], $id));
                    
                } catch (Exception $e) {
                    \Log::error('見守られユーザー登録に失敗しました。  ['.$e->getMessage().']');
                    throw new Exception($e);
                }
            }  
        }
        
        $this->template->content = Presenter::forge('admin/user/client/form')
                ->set('id', $id)
                ->set('data', $data)
                ->set('error', $validation->error_message());    
    }
    
    /*
     * 見守られユーザー削除
     * 
     * @access public
     * @params none
     * @return none
     */
    public function action_client_delete()
    {
        $validation = Validation::forge('client_delete');
        
        if(Input::post()) {
            $validation->add('id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            
            if($validation->run()) {
                try {
                    $user_id = Input::param('id');
                    Model_User_Client::deleteClients($user_id);
                    return Response::redirect('/admin/user/list');                    
                } catch (Exception $e) {
                    \Log::error('見守られユーザー削除に失敗しました。  ['.$e->getMessage().']');
                    throw new Exception($e);
                }
            }
        }
    }
}