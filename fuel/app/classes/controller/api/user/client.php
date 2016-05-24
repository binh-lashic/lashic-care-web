<?php
class Controller_Api_User_Client extends Controller_Api
{
	public function before() {
		$this->nologin_methods = array();
	    parent::before();
	}

	public function post_save() {
		return $this->_save();
	}

	public function get_save() {
		return $this->_save();
	}

	public function _save() {
		$sensor = \Model_User_Client::saveUserClient(Input::param());
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}
}