<?php
 /*
  * パスワード変更
  */
class Controller_Password extends Controller_Base
{
    private $data = array();

    public function before()
    {
        $this->nologin_methods = array(
            'index',
            'form',
            'new_form'
        );
        parent::before();
    }

    public function action_index()
    {
        $this->template->title = '会員ID・パスワードをお忘れの方';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('password/index', $this->data);
    }

    /*
     *  パスワード変更
     */
    public function action_form()
    {
        $this->template->title = '会員ID・パスワードをお忘れの方';
        $this->data['breadcrumbs'] = array($this->template->title, "新パスワード発行　入力");

        if(Input::post()) {
            if(!Input::post("email")) {
                $this->data['errors']['email'] = "メールアドレスを入力してください";
            } else {
                $user = \Model_User::find('first', array(
                        'where' => array(
                            'email' => Input::post('email'),
                            'last_name' => Input::post('last_name'),
                            'first_name' => Input::post('first_name'),
                        )
                ));
                if(empty($user)) {
                    $this->data['errors']['email'] = "該当するデータはありませんでした";
                }
            }
                
            if(!Input::post("last_name")) {
                $this->data['errors']['last_name'] = "お名前（姓）を入力してください";
            }
            if(!Input::post("first_name")) {
                $this->data['errors']['first_name'] = "お名前（名）を入力してください";
            }
                
            $this->data['data'] = Input::post();
            //エラーが無ければ確認ページを表示
            if(empty($this->data['errors'])) {
                $this->data['breadcrumbs'] = array($this->template->title, "新パスワード設定メール　送信");
        		
                $this->data['date'] = date("Y年m月d日");
                $this->data['name'] = Input::post('last_name').Input::post('first_name');
                
                $user = \Model_User::find($user['id']);
                $params['email_confirm_expired'] = date("Y-m-d H:i:s", strtotime("+1day"));
                $params['email_confirm_token'] = sha1(Input::post('email').$params['email_confirm_expired'].mt_rand());
                $user->set($params);
                $user->save();

                $this->data['url'] = Uri::base(false)."password/new_form?".Uri::build_query_string(array(
                    'token' => $params['email_confirm_token'],
                ));

                $params['subject'] = "パスワード再設定のページをお知らせします";
                $params['text'] = \View::forge('email/password', $this->data);

                try {
                    $sendgrid = new SendGrid(Config::get("sendgrid"));
                    $email = new SendGrid\Email();
                    $email
                        ->addTo(Input::post('email'))
                        ->setFrom(Config::get("email.noreply"))
                        ->setSubject($params['subject'])
                        ->setHtml($params['text']);
                    $sendgrid->send($email);                        
                } catch (Exception $e) {
                    \Log::error('パスワード変更メール送信に失敗しました。  ['.$e->getMessage().']');
                }

                $this->template->header = View::forge('header', $this->data);
                $this->template->content = View::forge('password/complete', $this->data);
                return;
            }
        }
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('password/form', $this->data);
    }

    /*
     * パスワード変更確認画面 
     */
    public function action_new_form()
    {
        $this->template->title = '会員ID・パスワードをお忘れの方';
        $this->data['breadcrumbs'] = array($this->template->title, "新パスワード設定　入力");
        $user = \Model_User::find("first", array(
            'where' => array(
                'email_confirm_token' => Input::param("token"),
                array('email_confirm_expired', ">", date("Y-m-d H:i:s"))
            )
        ));
        
        $this->data['data'] = Input::param();
        $this->template->header = View::forge('header', $this->data);

        if(Input::post()) {
            if(!Input::post("password")) {
                $this->data['errors']['password'] = "パスワードを入力してください。";
            }
            if(!Input::post("password_confirm")) {
                $this->data['errors']['password_confirm'] = "パスワード 確認を入力してください。";
            }
            if(Input::post("password") && Input::post("password_confirm") && Input::post("password") != Input::post("password_confirm")) {
                $this->data['errors']['password_confirm'] = "新しいパスワードが一致しません。";
            }
            $this->data['data'] = Input::post();
            //エラーが無ければ確認ページを表示
            if(empty($this->data['errors'])) {
                $old_password = Auth::reset_password($user['username']);
                if(Auth::change_password($old_password, Input::post("password"), $user['username'])) {
                    $this->data['email'] = $user['email'];

                    $params['subject'] = "パスワードの変更が完了しました";
                    
                    $this->data['name'] = $user['last_name'].$user['first_name'];

                    $params['text'] = \View::forge('email/password_complete', $this->data);

                    try {
                        $sendgrid = new SendGrid(Config::get("sendgrid"));
                        $email = new SendGrid\Email();
                        $email
                            ->addTo($user['email'])
                            ->setFrom(Config::get("email.noreply"))
                            ->setSubject($params['subject'])
                            ->setHtml($params['text']);
                        $sendgrid->send($email);                        
                    } catch (Exception $e) {
                        \Log::error('パスワード確認メール送信に失敗しました。  ['.$e->getMessage().']');
                    }
                    $this->template->content = View::forge('password/new_complete', $this->data);
                }
                return;
            }

        }
        $this->template->content = View::forge('password/new_form', $this->data);
    }
}