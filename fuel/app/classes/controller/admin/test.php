<?php
class Controller_Admin_Test extends Controller_Admin
{
	public function action_alert()
	{
        $alerts = Config::get("template.alert");
        foreach($alerts as $type => $_alert) {
            $params = array();
            $params['date'] = date("Y-m-d H:i:s");
            $params['sensor_id'] = 4;
            $params['category'] = "emergency";
            $params['type'] = $type;
            $params['title'] = $_alert['title'];
            $params['description'] = $_alert['description'];
            $params['confirm_status'] = 0;

            $alert = \Model_Alert::forge();
            $alert->set($params);
            $alert->save();
        }
        $this->template->title = '管理ページ トップ';
        $this->template->content = View::forge('admin/user/index');
	}

}