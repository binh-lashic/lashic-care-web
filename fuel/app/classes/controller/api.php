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

            // 使用言語をリクエストパラメータから設定
            $lang = Input::param('lang');
            if (!$lang) {
                    // リクエストパラメータに無ければセッションから取得
                    $lang = Session::get('language');
            }
            if (!$lang) {
                    // セッションにも無ければ Accept-Language ヘッダから自動判別
                    $languages = array_map('strtolower', Agent::languages());
                    if (in_array('ja', $languages) || in_array('ja-jp', $languages)) {
                            $lang = 'ja';
                    } else {
                            // 日本語が含まれていなかったら英語
                            $lang = 'en';
                    }
            }
            Session::set('language', $lang);
            Config::set('language', $lang);
            Lang::load('labels');
            Lang::load('alerts');
            Lang::load('monthlyreport');
            $this->language = $lang;

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
	    }
	}

	public function _error($msg = 'ログインをしていません') {
	    Response::redirect('/api/user/login_error');
	}

	public function result($http_status = null) {
		if(isset($this->errors)) {
			$this->result['success'] = false;
			$this->result['errors'] = $this->errors;
		} else {
			$this->result['success'] = true;
		}

	   	$method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods)) {  
			$this->result['session_error'] = false;
	    } else {
			if (Auth::check()) {
				$this->result['session_error'] = false;
			} else {
				$this->result['session_error'] = true;
			}
	    }

		$res = parent::response($this->result, $http_status);
		$res->set_header('Access-Control-Allow-Origin', '*');
		return $res;
	}
}
