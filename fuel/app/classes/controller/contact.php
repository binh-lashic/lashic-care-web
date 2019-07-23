<?php
class Controller_Contact extends Controller_Base
{
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'index',
            'complete'
	    );
	    parent::before();
	}

	public function action_index()
	{
        $this->template->title = 'お問い合わせ';
        $this->data['breadcrumbs'] = array($this->template->title);
       	$this->template->header = View::forge('header', $this->data);
        
		$val = Validation::forge('contact');
		$val->add_callable('Validation_Japanese');
		$val->add_callable('usersrules');
		$val->add_field('name', 'お名前', 'required');  
		$val->add_field('kana', 'ふりがな', 'required|hiragana');  
		$val->add_field('email', 'メールアドレス', 'required|valid_email');
		$val->add_field('email_confirm', 'メールアドレス（確認）', 'required|check_confirm_email['.Input::post('email').']');
        $val->add_field('phone', '電話番号', 'required|check_phone');
		$val->add_field('detail', 'お問い合わせ内容', 'required');
		if(Input::post())
        {
			$this->data['data'] = Input::post();
			if ($val->run()) {
				$this->template->content = View::forge('contact/confirm', $this->data);
        		return;
			} else {
				foreach($val->error() as $key=>$value){
					$this->data['errors'][$key] = $value;
				}
			}
        }
        $this->template->content = View::forge('contact/form', $this->data);
	}

	public function action_complete()
	{
        $this->template->title = 'お問い合わせ';
        $this->data = Input::post();
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->data['date'] = date("Y年m月d日");

        $params['subject'] = "お問い合わせを受け付けました";
        $params['text'] = \View::forge('email/contact', $this->data);
        
        $sendgrid = new SendGrid(Config::get("sendgrid"));
        $email = new SendGrid\Email();
        $email
            ->addTo(Config::get("email.info"))
            ->setFrom(Input::post('email'))
            ->setSubject($params['subject'])
            ->setHtml($params['text']);
        try {
            $sendgrid->send($email);
            $email
                ->addTo(Input::post('email'))
                ->setFrom(Config::get("email.noreply"))
                ->setSubject($params['subject'])
                ->setHtml($params['text']);
            $sendgrid->send($email);

        } catch (Exception $e) {
            Log::error($e->getMessage(), 'sendEmail');
        }

       	$this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('contact/complete', $this->data);
	}
}
