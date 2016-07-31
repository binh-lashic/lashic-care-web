<?php
class Controller_Admin_Contract extends Controller_Admin
{

	public function action_list() {
		$data['contracts'] = \Model_Contract::getSearch();
        $this->template->title = '契約一覧';
        $this->template->content = View::forge('admin/contract/list', $data);
	}
}
?>