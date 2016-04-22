<?php
class Controller_Admin_Contract extends Controller_Admin
{

	public function action_create() {
		try {
			\Model_Contract::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
		echo "作成しました";
		exit;
	}
}