<?php
class Controller_Api extends Controller_Rest
{
	protected $errors;
	protected $format = 'json';
	protected $result;

	public function before()
	{
	    parent::before();
	    if (!Auth::check()) {
	        Response::redirect('api/login/error');
	    }
	}

	public function result($http_status = null) {
		$this->result['errors'] = $this->errors;
		$res = parent::response($this->result, $http_status);
		$res->set_header('Access-Control-Allow-Origin', '*');
		return $res;
	}
}