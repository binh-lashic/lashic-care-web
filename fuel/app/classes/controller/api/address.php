<?php
class Controller_Api_Address extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array();
	    parent::before();
	}

	public function post_delete() {
		return $this->_delete();
	}

	public function get_delete() {
		return $this->_delete();
	}

	public function _delete() {
		$id = Input::param('id');
		$address = \Model_Address::find($id);
		$address->delete();
		$this->result = array(
			'data' => $address
		);
 		return $this->result();
	}
}