<?php
class Controller_Api_Plan extends Controller_Api
{
	public function before() {
		$this->nologin_methods = array(
			'list',
			'get'
		);
	    parent::before();
	}

	public function post_list() {
		return $this->_list();
	}

	public function get_list() {
		return $this->_list();
	}

	public function _list() {
		$this->result = array(
			'data' => $plans
		);
 		return $this->result();
	}

	public function post_get() {
		return $this->_get();
	}

	public function get_get() {
		return $this->_get();
	}

	public function _get() {
        $id = Input::param('id');
        $plan = \Model_Plan::getPlan($id);
		$this->result = array(
			'data' => $plan
		);
 		return $this->result();
	}
}