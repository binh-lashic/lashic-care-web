<?php
class Controller_Admin_Device extends Controller_Template
{

	public function action_create() {
		try {
			\Model_Device::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}
}