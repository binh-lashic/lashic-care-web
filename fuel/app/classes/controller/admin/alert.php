<?php
class Controller_Admin_Alert extends Controller_Admin
{

	public function action_create() {
		try {
			\Model_Alert::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
		echo "作成しました";
		exit;
	}

	public function action_list() {
        $data['alerts'] = \Model_Alert::find("all");
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/alert/list', $data);        
    }

}