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

	public function post_get() {
        }

	public function get_get() {
		return $this->_get();
        }

	private function _get() {
		$user_id = Input::param('id');
		$clients = \Model_User_Client::getUserClients($user_id);
		$this->result = array(
			'data' => $clients
		);
		return $this->result();
        }
}
