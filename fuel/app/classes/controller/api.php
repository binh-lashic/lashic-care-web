<?php
class Controller_Api extends Controller_Rest
{
	protected $errors;
	protected $format = 'json';
	protected $result;

	public function response($http_status = null) {
		$this->result['errors'] => $errors;
		$res = parent::response($this->result, $http_status);
		$res->set_header('Access-Control-Allow-Origin', '*');
		return $res;
	}
}