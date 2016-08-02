<?php
class Controller_Api_Gmo extends Controller_Api
{
	public function before() {
		$this->nologin_methods = array(
	        'result',
	    );
	    parent::before();
	}

	function get_result() {
		Log::info("GMO Result:".print_r(Input::post(), true));
	}
}
?>