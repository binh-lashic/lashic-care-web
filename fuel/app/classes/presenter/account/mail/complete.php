<?php
class Presenter_Account_Mail_Complete extends Presenter
{
	private $user;
        
	public function view()
	{
            if(Input::post()) {
                $params = $this->data;
                $date = date("Y-m-d H:i:s", strtotime("+1day"));
                $params['email_confirm_token'] = sha1($params['new_email'].$date);
                $params['email_confirm_expired'] = $date;

                if($this->user = Model_User::saveUser($params)) {
                    $this->sendConfirmMail();
                }
            }
	}
        
	private function sendConfirmMail()
	{
            $url = Uri::base(false)."user/email_complete?".Uri::build_query_string([
                        'token' => $this->user['email_confirm_token'],
                    ]);

            $sendParams = [
                'url'      => $url,
                'date'     => date('Y年m月d日'),
                'name'    => $this->user['name'],
            ];

            return Model_User::sendEmail([
                'to' => $this->user['new_email'],
                'subject' => "メールアドレスの変更確認",
                'text' => \View::forge('email/email_confirm', $sendParams)
            ]);
	}
}
