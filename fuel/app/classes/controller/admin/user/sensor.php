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
            $data['sensors'] = \Model_User::getSensors($id);
            $data['user'] = $user;
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/user/sensor', $data);
    }
}