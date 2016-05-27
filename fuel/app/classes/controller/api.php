<?php
class Controller_Api extends Controller_Rest
{
	protected $errors;
	protected $format = 'json';
	protected $result;
	protected $nologin_methods = array();

	public function before()
	{
	    parent::before();

	   	$method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods)) {    
	    } else if (Input::param("device_id")){
	    	$device_id = Input::param("device_id");
	    	if($user_id = \Model_Device::existDevice($device_id)) {
	    		\Auth::instance()->force_login((int) $user_id);
	    	} else {
    	        $this->_error();
	    	}
	    } else if (!Auth::check()) {
	    	$this->_error();
//	    	Response::redirect('/api/user/login_error');
//	    	return;
	    }
	}

	public function _error($msg = 'ログインをしていません') {
		$this->result = array(
			'message' => $msg,
		);
 		return $this->result();
	}

	public function result($http_status = null) {
		if(isset($this->errors)) {
			$this->result['success'] = false;
			$this->result['errors'] = $this->errors;
		} else {
			$this->result['success'] = true;
		}

		$res = parent::response($this->result, $http_status);
		$res->set_header('Access-Control-Allow-Origin', '*');
		return $res;
	}
}