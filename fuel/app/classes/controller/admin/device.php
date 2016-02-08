<?php
class Controller_Admin_Device extends Controller_Template
{

	public function action_create() {
		\Model_Device::create();
	}
}