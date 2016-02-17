<?php
class Controller_Admin_User_Client extends Controller_Template
{
	public function action_create() {
		try {
			\Model_User_Client::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}
}