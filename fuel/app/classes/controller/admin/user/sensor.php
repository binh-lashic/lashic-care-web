<?php
class Controller_Admin_User_Sensor extends Controller_Template
{
	public function action_create() {
		try {
			\Model_User_Sensor::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}
}