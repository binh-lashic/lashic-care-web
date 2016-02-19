<?php
class Controller_Api_Sensor extends Controller_Api
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
		$id = Input::param('id');
		$sensor = \Model_Sensor::getSensor($id);
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
		$sensor = \Model_Sensor::saveSensor(Input::param());
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}
}