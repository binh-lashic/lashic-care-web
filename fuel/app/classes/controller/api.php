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
	    } else if (!Auth::check()) {
	        Response::redirect('api/user/login_error');
	    }
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