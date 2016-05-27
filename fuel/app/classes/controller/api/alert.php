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

	public function get_snooze() {
		return $this->_snooze();
	}

	public function _snooze() {
		$alert = \Model_Alert::saveAlert(Input::param());
		$this->result = array(
			'data' => $alert
		);
 		return $this->result();
	}

	public function get_test() {
		return $this->_test();
	}

	public function post_test() {
		return $this->_test();
	}

	public function _test(){
		require_once APPPATH.'vendor/ApnsPHP/Autoload.php';

        $push = new ApnsPHP_Push(
	            ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
                    APPPATH.'vendor/ApnsPHP/certificates/careeye_push.pem'
                );
        $push->setRootCertificationAuthority(APPPATH.'vendor/ApnsPHP/certificates/entrust_root_certification_authority.pem');
        $push->connect();

        $message = new ApnsPHP_Message("1b1ca6c9607c33734175fb828160f45e2dfa39f20f02e9644db3866d0699242d");
        $message->setText("test");
        $message->setSound();
        $message->setExpiry(30);
        $push->add($message);
        $push->send();
        $push->disconnect();
	}
}