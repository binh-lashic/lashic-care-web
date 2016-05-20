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
    	$id = Input::param("id");
    	$data['sensors'] = \Model_Sensor::getAll();
        $this->template->title = '管理ページ センサー設定';
        $this->template->content = View::forge('admin/sensor/list', $data);
	}

	public function action_save() {
		$sensor = \Model_Sensor::saveSensor(Input::param());
        $this->template->title = '管理ページ センサー設定';
        $data['sensor'] = $sensor;
        $this->template->content = View::forge('admin/sensor/index', $data);
	}
}