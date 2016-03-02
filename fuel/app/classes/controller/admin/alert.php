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
}