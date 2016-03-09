<?php
class Controller_Admin_Data_Daily extends Controller_Admin
{

	public function action_create() {
		try {
			\Model_Data_Daily::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}
}