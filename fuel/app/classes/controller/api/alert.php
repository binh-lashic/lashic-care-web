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

	public function post_snooze() {
		return $this->_snooze();
	}

	public function _snooze() {
		$alerts = \Model_Alert::find("all", array(
			'where' => array(
				'confirm_status' => 0,
				array("date", ">", time() - 60 * 60 * 10)
			),
		));
		foreach($alerts as $alert) {
			$user_sensors = \Model_User_Sensor::find("all", array(
				'where' => array(
					'sensor_id' => $alert['sensor_id'],
				)
			));
			foreach($user_sensors as $user_sensor) {
				if($user_sensor[$alert['type']."_alert"] == 1) {
					$devices = \Model_Device::find('all', array(
						'where' => array(
							'user_id' => $user_sensor['user_id'],
						),
					));
					foreach($devices as $device) {
						\Model_Alert::pushAlert(array(
							'push_id' => $device['push_id'],
							'text' => $alert['description'],
						));
					}
				}
				print_r();
			}
		}
		exit;
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

        $push = new ApnsPHP_Push(ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION, APPPATH.'vendor/ApnsPHP/certificates/careeye_push.pem');
        $push->setRootCertificationAuthority(APPPATH.'vendor/ApnsPHP/certificates/entrust_root_certification_authority.pem');
        $push->connect();

        $message = new ApnsPHP_Message("19a67c020ec7071ca16fa7f15e494dde43f6611d85b73010d30c4701725cf1e6");
        $message->setText("test");
        $message->setSound();
        $message->setExpiry(30);
        $push->add($message);
        $push->send();
        $push->disconnect();
	}
}