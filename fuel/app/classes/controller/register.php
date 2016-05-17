<?php
class Controller_Register extends Controller_Base
{
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'index',
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
			if(!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
				$params['birthday'] = $params['year']."-".$params['month']."-".$params['day'];
			}
			$this->data['data'] = $params;
        	$this->template->content = View::forge('register/confirm', $this->data);
        	return;
        }

        $this->template->content = View::forge('register/form', $this->data);
	}

	public function action_complete() {
		\Model_User::saveUser(Input::post());
		$this->template->title = 'Care Eye 新規登録  >  アカウント情報　入力';
        $this->template->header = View::forge('header', $this->data);
		$this->template->content = View::forge('register/complete', $this->data);
	}
}
