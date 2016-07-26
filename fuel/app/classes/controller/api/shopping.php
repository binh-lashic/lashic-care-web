<?php
class Controller_Api_Shopping extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'get',
	    );
	    parent::before();
	}

	//ユーザデータを取得
	public function post_get() {
		return $this->_get();
	}

	public function get_get() {
		return $this->_get();
	}

	public function _get() {
		$data = array();
		$data['plans'] = Session::get("plans");

		$this->result = array(
			'data' => $data,
		);
 		return $this->result();
	}

	//ユーザデータを取得
	public function post_set_plans() {
		return $this->_set_plans();
	}

	public function get_set_plans() {
		return $this->_set_plans();
	}

	public function _set_plans() {
		$plan_ids = Input::param("plan_ids");
		$data = array();
		foreach($plan_ids as $plan_id) {
			$plan = \Model_Plan::getPlan($plan_id);
			$plans[] = $plan;
		}
		echo json_encode($plans);
		exit;
		try {
			Session::set("plans", json_encode($plans));
		} catch(Exception $e) {
			echo $e->getMessage();
			exit;
		}

		$data['plans'] = $plans;
		$this->result = array(
			'data' => $data,
		);
 		return $this->result();
	}
}