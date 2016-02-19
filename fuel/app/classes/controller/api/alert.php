<?php
class Controller_Api_Alert extends Controller_Api
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
		$sensor = \Model_Alert::getAlert($id);
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}

	public function post_list() {
		return $this->_list();
	}

	public function get_list() {
		return $this->_list();
	}

	public function _list() {
		$alerts = \Model_Alert::getAlerts(Input::param());
		$this->result = array(
			'data' => $alerts
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
		$alert = \Model_Alert::saveAlert(Input::param());
		$this->result = array(
			'data' => $alert
		);
 		return $this->result();
	}
}