<?php
class Controller_Api_User_Sensor extends Controller_Api
{
	public function before() {
		$this->nologin_methods = array();
	    parent::before();
	}

	public function post_get() {
		return $this->_get();
	}

	public function get_get() {
		return $this->_get();
	}

	public function _get() {
		$sensor = \Model_User_Sensor::getUserSensor(Input::param());
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}

	public function post_save() {
		return $this->_save();
	}

	public function get_save() {
		return $this->_save();
	}

	public function _save() {
		$params = Input::param();
		print_r($params);
		$sensor = \Model_User_Sensor::saveUserSensor($params);
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}
}