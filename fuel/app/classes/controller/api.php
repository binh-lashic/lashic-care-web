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
	   	$method = implode("/", Uri::segments());
	    if (in_array($method, $this->nologin_methods)) {     
	    } else if (!Auth::check()) {
	        Response::redirect('api/user/login_error');
	    }
	}

	public function result($http_status = null) {
		$this->result['errors'] = $this->errors;
		$res = parent::response($this->result, $http_status);
		$res->set_header('Access-Control-Allow-Origin', '*');
		return $res;
	}
}