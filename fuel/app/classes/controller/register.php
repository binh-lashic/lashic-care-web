<?php
class Controller_Register extends Controller_Base
{
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'index',
	        'complete'
	    );
	    $this->template = 'template';

	    parent::before();
	}

	public function action_index()
	{
		$this->data['eras'] = Config::get("eras");
        $this->data['prefectures'] = Config::get("prefectures");
		
		$this->template->title = 'Care Eye 新規登録  >  アカウント情報　入力';
        $this->template->header = View::forge('header', $this->data);

        if(Input::post()) {
     		$params = Input::post();
     		$val = \Model_User::validate("register");
     		//メールアドレスチェック
        	if($val->run()) {
	     		$user = \Model_User::getUserFromEmail($params['email']);
	     		if(isset($user)){
	     			$this->data['errors']['email'] = true;
	     		}
        	} else {
			    // バリデーション失敗の場合ここに入ってくる
			    foreach($val->error() as $key=>$value){
			    	$this->data['errors'][$key] = true;
			    }
        	}
			if(!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
				$params['birthday'] = $params['year']."-".$params['month']."-".$params['day'];
				$params['birthday_display'] = $params['year']."年".$params['month']."月".$params['day']."日";
			} else {
				$this->data['errors']['birthday'] = true;
			}
			$this->data['data'] = $params;
			if(empty($this->data['errors'])) {
	        	$this->template->content = View::forge('register/confirm', $this->data);
	        	return;
			}
        }

        $this->template->content = View::forge('register/form', $this->data);
	}

	public function action_complete() {
		try {
			$user = \Model_User::saveUser(Input::post());
			if($user) {
				\Model_User::sendConfirmEmail($user);
			}			
		} catch(Exception $e) {
			
		}

		$this->template->title = 'Care Eye 新規登録  >  アカウント情報　入力';
        $this->template->header = View::forge('header', $this->data);
		$this->template->content = View::forge('register/complete', $this->data);
	}
}
