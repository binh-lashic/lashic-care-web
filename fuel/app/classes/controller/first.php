<?php
class Controller_First extends Controller_Base
{
    private $data = array();
    
    public function before()
    {
        $this->nologin_methods = array(
            'index',
            'confirm',
            'complete'
        );
        $this->template = 'template_responsive';
        parent::before();
    }

    public function action_index()
    {
        if(Input::post()) {
            $params = Input::post();
            $val = \Model_User::validate("first");
            if(!$val->run()) {
                // バリデーション失敗の場合ここに入ってくる
                foreach($val->error() as $key=>$value){
                    $this->data['errors'][$key] = $value;
                }
            }
            
            $this->data['data'] = $params;
            if(empty($this->data['errors'])) {
                $this->template->title = '初めて利用される方はこちら >  アカウント情報　確認';
                $this->data['breadcrumbs'] = array($this->template->title);
                $this->template->header = View::forge('header', $this->data);
                $this->template->content = View::forge('first/confirm', $this->data);
                return;
            }
        }
        
        if(empty(Input::get('token'))) {
          throw new HttpNotFoundException;
        }
        
        $token = Input::get('token');
        $payment = \Model_Payment::find_by_token($token);
        Session::set('payment_id', $payment['id']);
        
        if(empty($payment)){
          throw new HttpNotFoundException;
        }
        
        //申込情報から初期値読み込み
        $this->data['data']['first_name'] = $payment['first_name'];
        $this->data['data']['last_name'] = $payment['last_name'];
        $this->data['data']['first_kana'] = $payment['first_kana'];
        $this->data['data']['last_kana'] = $payment['last_kana'];
        $this->data['data']['phone'] = $payment['phone'];
        $this->data['data']['email'] = $payment['email'];
        $this->data['data']['token'] = $token;
        
        $this->template->title = '初めて利用される方はこちら >  アカウント情報　入力';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('first/form', $this->data);
    }
    
    public function action_confirm()
    {
        $this->template->title = '初めて利用される方はこちら >  アカウント情報　確認';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        
        if(Input::post()) {
            $params = Input::post();
            $this->data['data'] = $params;
            if(empty($this->data['errors'])) {
                $this->template->content = View::forge('first/complete', $this->data);
                return;
            }
        }
        
        $this->template->content = View::forge('first/confirm', $this->data);
    }
    
    public function action_complete()
    {
      try {
            \DB::start_transaction();
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
                  'subject' => "LASHIC新規アカウント登録",
                  'text' => \View::forge('email/admin/register', $data)
              );
              \Model_User::sendEmail($params);
            }

            $payment_id = Session::get('payment_id');

            //paymentsにuser_idをセット
            \DB::update('payments')
                  ->value('user_id', $user['id'])
                  ->where('id', '=', $payment_id)
                  ->execute();

            //contractにuser_idをセット
            \Model_Contract::update_user_id_by_payment_id($user['id'], $payment_id);

            \DB::commit_transaction();
        } catch(Exception $e) {
            \DB::rollback_transaction();
            $params = Input::post();
            unset($params['password']);
            Log::error($e->getMessage(), 'first_complete');
            throw new Exception;
        }
        
        Session::delete('contract_id');
        
        $this->template->title = '初めて利用される方はこちら  >  アカウント登録完了';
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('first/complete', $this->data);
    }
}
