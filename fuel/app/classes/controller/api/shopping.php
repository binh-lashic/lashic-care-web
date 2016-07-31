<?php
class Controller_Api_Shopping extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
	        'get',
	        'get_plans',
	        'set_plans',
	        'delete_plan',
	        'delete_plans',
	    );
	    parent::before();
	}

	public function post_get_plans() { return $this->_get_plans(); }
	public function get_get_plans()  { return $this->_get_plans(); }
	public function _get_plans() {
		$data = array();
		$data['plans'] = Session::get("plans");
		$data['total_price'] = 0;
		foreach($data['plans'] as $plan) {
			$data['total_price'] += $plan['price'];
		}
		$this->result = array(
			'data' => $data,
		);
 		return $this->result();
	}

	public function post_delete_plan() { return $this->_delete_plan(); }
	public function get_delete_plan()  { return $this->_delete_plan(); }
	public function _delete_plan() {
		$data = array();
		$plan_id = Input::param("plan_id");
		$plans = Session::get("plans");
		$new_plans = array();
		foreach($plans as $plan) {
			if($plan['id'] != $plan_id) {
				$new_plans[] = $plan;
			}
		}
		if(empty($new_plans)) {
			$new_plans = null;
		}
		Session::set("plans", $new_plans);
		$data['plans'] = $new_plans;
		$this->result = array(
			'data' => $data,
		);
 		return $this->result();
	}

	public function post_delete_plans() { return $this->_delete_plans(); }
	public function get_delete_plans()  { return $this->_delete_plans(); }
	public function _delete_plans() {
		$data = array();
		Session::set("plans", null);
		$data['plans'] = null;
		$this->result = array(
			'data' => $data,
		);
 		return $this->result();
	}

	//ユーザデータを取得
	public function post_set_plans() { return $this->_set_plans(); }
	public function get_set_plans() { return $this->_set_plans(); }
	public function _set_plans() {
		$plan_ids = Input::param("plan_ids");
		$data = array();
		foreach($plan_ids as $plan_id) {
			$plan = \Model_Plan::getPlan($plan_id);
			$plans[] = $plan;
		}
		Session::set("plans", $plans);
		$data['plans'] = $plans;
		$this->result = array(
			'data' => $data,
		);
 		return $this->result();
	}
}