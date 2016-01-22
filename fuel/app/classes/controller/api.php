<?php
class Controller_Api extends Controller_Rest
{
	protected $errors;
	protected $format = 'json';

	public function response($data = array(), $http_status = null) {
		$data['hoge'] = true;
		$res = parent::response($data, $http_status);
		$res->set_header('Access-Control-Allow-Origin', '*');
		return $res;
	}
}