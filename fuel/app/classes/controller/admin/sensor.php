<?php
class Controller_Admin_Sensor extends Controller_Admin
{
	public function action_create() {
		try {
			\Model_Sensor::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
			exit;
		}
	}

	public function action_index() {
    	$id = Input::param("id");
    	$data['sensor'] = \Model_Sensor::find($id);
        $this->template->title = '管理ページ センサー設定';
        $this->template->content = View::forge('admin/sensor/index', $data);
	}

	public function action_list() {
    	$sensors = \Model_Sensor::getSearch(array('query' => Input::param('query')));
    	foreach($sensors as $sensor) {
    		$sensor = $sensor->to_array();
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
        $data['query'] = Input::param('query');
        $this->template->title = '管理ページ センサー一覧';
        $this->template->content = View::forge('admin/sensor/list', $data);
	}

	public function action_save() {
		$sensor = \Model_Sensor::saveSensor(Input::param());
        Response::redirect('/admin/sensor/list');
	}

	public function action_delete() {
		$sensor = \Model_Sensor::deleteSensor(Input::param());
        Response::redirect('/admin/sensor/list');
	}

	public function action_register() {
		$sensor_names_data = Input::param("sensor_names");
		$sensor_names = explode(PHP_EOL, $sensor_names_data);
		foreach($sensor_names as $sensor_name) {
			try {
				$sensor = \Model_Sensor::saveSensor(array('name' => $sensor_name));
			} catch (Exception $e) {

			}
		}
        $this->template->title = '管理ページ センサー一覧';
     	$data['sensors'] = \Model_Sensor::getAll();
        Response::redirect('/admin/sensor/list');
	}

	public function action_data() {
    	$data['sensor'] = \Model_Sensor::getSensorFromSensorName(Input::param("name"));
    	$data['data'] = DB::select()
	    ->from('data')
	    ->where('sensor_id', $data['sensor']['name'])
	    ->order_by('date', 'desc')
	    ->limit(100)
	    ->execute('data') // 引数で指定できる
	    ->as_array();

        $this->template->title = '管理ページ センサー一覧';
        $this->template->content = View::forge('admin/sensor/data', $data);
	}

	public function action_shipping() {
    	$data['sensor'] = \Model_Sensor::find(Input::param("id"));
        $this->template->title = '管理ページ 出荷日登録';
        $this->template->content = View::forge('admin/sensor/shipping', $data);
	}
}