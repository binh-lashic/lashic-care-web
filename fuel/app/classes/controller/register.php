<?php
class Controller_Register extends Controller_Base
{
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'email',
	        'index',
	        'complete'
	    );
	    $this->template = 'template_responsive';
	    parent::before();
	}

	public function action_index()
	{
		$this->data['eras'] = Config::get("eras");
        $this->data['prefectures'] = Config::get("prefectures");
		
		$this->template->title = 'LASHIC 新規登録  >  アカウント情報　入力';
        $this->template->header = View::forge('header', $this->data);

        if(Input::post()) {
     		$params = Input::post();
     		$val = \Model_User::validate("register");
     		//メールアドレスチェック
        	if($val->run()) {
	     		$user = \Model_User::getUserFromEmail($params['email']);
	     		if(isset($user)){
	     			$this->data['errors']['email'] = "エラー：既に登録されているメールアドレスです";
	     		}
        	} else {
			    // バリデーション失敗の場合ここに入ってくる
			    foreach($val->error() as $key=>$value){
			        $this->data['errors'][$key] = $value;
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

	public function action_email()
	{		
		$this->template->title = 'LASHIC 新規登録  >  メールアドレス入力';
		$this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);

        if(Input::post()) {
     		$params = Input::post();
     		//メールアドレスチェック
     		if(empty($params['email'])){
     			$this->data['errors']['email'] = "エラー：メールアドレスを入力してください";
     		} else {
	     		$user = \Model_User::getUserFromEmail($params['email']);
	     		if(isset($user)){
	     			$this->data['errors']['email'] = "エラー：既に登録されているメールアドレスです";
	     		}     			
     		}
     		if(empty($params['term'])){
     			$this->data['errors']['term'] = true;
     		}

			$this->data['data'] = $params;
			if(empty($this->data['errors'])) {
				$user = \Model_User::saveEmail($params);
				if($user) {
					\Model_User::sendRegisterConfirmEmail($user);
				}
	        	$this->template->content = View::forge('register/email_complete', $this->data);
	        	return;
			}
        }

        $this->template->content = View::forge('register/email', $this->data);
	}

	public function action_complete() {
		try {
			$user = \Model_User::saveUser(Input::post());
			if($user) {
				\Model_User::sendConfirmEmail($user);
				//管理用メールの送信
                $data = array(
                            'user'  => $user,
                            'date'  => date('Y年m月d日'),
                            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                        );
                $params = array(
                    'to' => $_SERVER['EMAIL_MASTER'],
                    'subject' => "LASHIC新規アカウント登録・購入情報",
                    'text' => \View::forge('email/admin/register', $data)
                );
                \Model_User::sendEmail($params);
			}			
		} catch(Exception $e) {
			$params = Input::post();
			unset($params['password']);
			Log::error($e->getMessage(), 'register_complete');
			Log::error(print_r($params, true), 'register_complete');
		}

		$this->template->title = 'LASHIC 新規登録  >  アカウント情報　入力';
        $this->template->header = View::forge('header', $this->data);
		$this->template->content = View::forge('register/complete', $this->data);
	}
}
