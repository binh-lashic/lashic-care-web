<?php
class Presenter_Account_Mail_Success extends Presenter
{
	private $user = null;
        private $isSuccess = false;
        
	public function view()
	{
            if($this->token) {
                $this->user = \Model_User::find("first", [
                            'where' => [
                                'email_confirm_token' => $this->token,
                                ['email_confirm_expired', ">", date("Y-m-d H:i:s")]
                            ]
                        ]);
            }

            if($this->user) {
                if($this->saveEmail()) {
                    $this->sendCompleteMail();
                }               
                $this->isSuccess = true;
            }
            
            $this->set('isSuccess', $this->isSuccess);
	}
        
	private function saveEmail()
	{
            // new_emailをemailへ更新してexpiredを過去日にして無効化 
            $this->user->set([
                        'email' => $this->user['new_email'],
                        'email_confirm_expired' => date("Y-m-d H:i:s", strtotime("-1day")),
                    ]);
            return $this->user->save();        
	}
        
	private function sendCompleteMail()
	{
            $user = \Model_User::format($this->user);
            $sendParams = [
                'date' => date('Y年m月d日'),
                'name' => $user['name'],
            ];

            return Model_User::sendEmail([
                'to' => $user['email'],
                'subject' => "メールアドレスの変更が完了しました",
                'text' => \View::forge('email/email_complete', $sendParams)
            ]);
	}
}
