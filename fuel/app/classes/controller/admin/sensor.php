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
    	$data['sensors'] = \Model_Sensor::getSearch(array('query' => Input::param('query')));
        $data['query'] = Input::param('query');
        $this->template->title = '管理ページ センサー一覧';
        $this->template->content = View::forge('admin/sensor/list', $data);
	}

	public function action_save() {
		$sensor = \Model_Sensor::saveSensor(Input::param());
        Response::redirect('/admin/sensor/list');
        $this->template->title = '管理ページ センサー設定';
        $data['sensor'] = $sensor;
        $this->template->content = View::forge('admin/sensor/index', $data);
	}

	public function action_register() {
		$sensor_names_data = Input::param("sensor_names");
		$sensor_names = explode(PHP_EOL, $sensor_names_data);
		foreach($sensor_names as $sensor_name) {
			$sensor = \Model_Sensor::saveSensor(array('name' => $sensor_name));
		}
        $this->template->title = '管理ページ センサー一覧';
     	$data['sensors'] = \Model_Sensor::getAll();
        $this->template->content = View::forge('admin/sensor/list', $data);
	}

	public function action_data() {
    	$data['sensor_name'] = Input::param("name");
    	$data['data'] = DB::select()
	    ->from('data')
	    ->where('sensor_id', $data['sensor_name'])
	    ->order_by('id', 'desc')
	    ->limit(100)
	    ->execute('data') // 引数で指定できる
	    ->as_array();

        $this->template->title = '管理ページ センサー一覧';
        $this->template->content = View::forge('admin/sensor/data', $data);
	}

}