<?php
class Controller_Shopping extends Controller_Base
{
    private $user;
    private $clients = array();
	private $data = array();

	public function before() {
		$this->nologin_methods = array(
	        'index',
            'cart',
            'user',
	    );
        $this->template = 'template_responsive';
	    parent::before();
        if(empty($this->user)) {
            list(, $user_id) = Auth::get_user_id(); 
            $this->user = \Model_User::getUser($user_id);
            $clients = \Model_User::getClients($user_id);
            foreach($clients as $client) {
                $this->clients[] = $client;
            }
        }

        $this->data = array(
            'user' => $this->user,
            'clients' => $this->clients,
        );
	}

	public function action_index()
	{
         if(!empty($this->param('affiliate'))) {
            if($this->param('affiliate') == "normal") {
                Session::delete('monitor');
                Cookie::delete('affiliate');
            } else {
                Cookie::set('affiliate', $this->param('affiliate'), 60 * 60 * 24 * 90);
            }
        }
        $this->template->title = 'LASHIC（ラシク）';
        $this->data['breadcrumbs'] = array($this->template->title);

        if(Cookie::get("affiliate") == "magokoro") {
            Session::set('monitor', Cookie::get("affiliate"));
            $this->data['monitor'] = true;
        }
        
        if(!empty(Session::get('login_error'))) {
            $this->data['login_error'] = Session::get('login_error');
            Session::delete('login_error');
        }
        
        $this->template->content = View::forge('shopping/index', $this->data);
	}

	public function action_cart()
	{
        if (!Auth::check()) {
            Response::redirect('/register/');
        } else {
            $this->data['plans'] = Session::get("plans");
            $this->template->title = 'カート';
            $this->data['breadcrumbs'] = array($this->template->title);
            $this->template->header = View::forge('header_client', $this->data);
            $this->template->content = View::forge('shopping/cart', $this->data);
        }
    }

    public function action_user()
    {
        $this->template->title = '見守り対象ユーザー設定';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('no_nav_header', $this->data);
        $this->template->content = View::forge('shopping/user', $this->data);
    }
   
    public function action_user_form()
    {
        $this->template->title = '見守り対象ユーザー設定';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('no_nav_header', $this->data);

        $this->data['eras'] = Config::get("eras");
        $this->data['prefectures'] = Config::get("prefectures");
        $this->data['blood_types'] = Config::get("blood_types");
        $this->data['genders'] = Config::get("gender");

        $this->data['client'] = array();

        if(Input::post()) {
            $params = Input::post();
            $val = \Model_User::validate("register_client");
            if(!$val->run()) {
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
                $this->template->content = View::forge('shopping/user_confirm', $this->data);
                return;
            }
        }
        $this->template->content = View::forge('shopping/user_form', $this->data);           
    } 

    public function action_user_complete() {
        if(Input::post()) {
            $params = Input::post();
            $client = \Model_User::createClient($params);
            $client_id = $client['id'];
            $contracts = \Model_Contract::getByUserId($this->user['id']);
            
            foreach($contracts as $contract) {
               $contract->client_user_id = $client_id;
               $contract->save();
            }
            
            $sensors = \Model_User::getSensors($this->user['id']);
  
            foreach($sensors as $sensor) {
              \Model_User_Sensor::saveUserSensor([
                'user_id' => $client_id,
                'sensor_id' => $sensor['id'],
                'admin' => 0
              ]);
            }
            
            Response::redirect('/user');
        }
    }

    public function action_destination()
    {
        $this->data['prefectures'] = Config::get("prefectures");

        $this->data['users'] = array();
        $this->data['users'][] = $this->user;

        $clients = \Model_User::getClients($this->user['id']);
        $this->data['users'] = array_merge($this->data['users'], $clients);

        if(Input::post()) {
            $params = Input::post();
            $val = \Model_Address::validate();

            if(!$val->run()) {
                foreach($val->error() as $key=>$value){
                    $this->data['errors'][$key] = $value;
                }
            }

            if(empty($this->data['errors'])) {
               $address = \Model_Address::forge();
               $params['user_id'] = $this->user['id'];
               $address->set($params);
               $address->save();
            } else {
                $this->data['data'] = $params;
            }
        }
        $this->data['addresses'] = \Model_Address::getAddresses(array("user_id" => $this->user['id']));


        $this->template->title = '送付先指定';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header_client', $this->data);
        $this->template->content = View::forge('shopping/destination', $this->data);
    }
    
    public function action_payment()
    {
      if(Session::get("destination")) {
        $this->data['destination'] = Session::get("destination");
      } else if(Input::param("address_id")) {
        $this->data['destination'] = \Model_Address::find(Input::param("address_id"));
      } else if(Input::param("user_id")) {
        $this->data['destination'] = \Model_User::find(Input::param("user_id"));
      }
      
      if(!Session::get('monitor')) {
        $shippings = Config::get("shipping");
        $this->data['destination']['shipping'] = 0;
        foreach($shippings as $shipping) {
          if(preg_match("/".$shipping['key']."/ui", $this->data['destination']['prefecture'])) {
            $this->data['destination']['shipping'] = $shipping['price'];
            break;
          }
        }
      }
  
      Session::set("destination", $this->data['destination']);
      
        if(Session::get('monitor')) {
            Response::redirect('/shopping/confirm');
        }
        $this->template->title = '配送とお支払い';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header_client', $this->data);

        $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
        $this->data['cards'] = $card->cardList;

        if(Input::post()) {
            $params = Input::post();
            Session::set('card', $params);
            $this->data['card'] = $params;
            if($params['process'] == "registered") {
                // GMO非保持化対応により必ずprocessがregisterdでPHP側にくるようになりました
                // カード情報登録の場合は、$params['token']に値が存在します。
                if (!empty($params['token'])) {
                    //GMOペイメントの会員登録
                    $member = \Model_GMO::findMember($this->user['id']);
                    if(!$member->memberId) {
                        $member = \Model_GMO::saveMember($this->user['id']);
                    }
                    if(!empty($member)) {
                        $params['member_id'] = $member->memberId;
                    } else {
                        $this->data['errors']['gmo'] = true;
                    }
                    //既に登録しているカードがある場合はシーケンス番号を与える
                    if(!empty($card->cardList)) {
                        $params['sequence'] = 0;
                    }
                    $result = \Model_GMO::saveCard($params);
                }
                if(empty($this->data['errors'])) {
                    Response::redirect('/shopping/confirm');
                    return;
                }
            }
        }

        $this->template->content = View::forge('shopping/payment', $this->data);           
    }

    public function action_confirm()
    {
        if(!Session::get('monitor')) {
            $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
            $this->data['card'] = $card->cardList[0];
        }

        $this->data['destination'] = Session::get("destination");
        $this->data['plans'] = Session::get("plans");

        $this->data['total_price'] = 0;
        $this->data['subtotal_price'] = 0;
        foreach($this->data['plans'] as $plan) {
            $this->data['subtotal_price'] += $plan['price'];
        } 
        $this->data['tax'] = floor(($this->data['subtotal_price'] + $this->data['destination']['shipping']) * Config::get("tax_rate"));
        $this->data['total_price'] = $this->data['subtotal_price'] + $this->data['destination']['shipping'] + $this->data['tax'];

        $this->template->title = 'ご注文確認';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header_client', $this->data); 
        $this->template->content = View::forge('shopping/confirm', $this->data);           
    }

    public function action_complete()
    {
        $plans = Session::get("plans");
        $destination = Session::get("destination");
        $post = Input::post();
        $remarks = $post['remarks'];
        $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
        if(empty($plans)) {
            $this->data['errors']['plan'] = true;
			\Log::warning('plans not found in session. session_id:[' . Session::key() . ']', __METHOD__);
        }
        if(empty($this->data['errors'])) {
            //支払い処理を行う
            $payment = \Model_Payment::forge();
            $subtotal_price = 0;
            foreach($plans as $plan) {
                $subtotal_price += $plan['price'];
            }
            $tax = floor(($subtotal_price + $destination['shipping']) * Config::get("tax_rate"));
            $payment->set(array(
                'user_id' => $this->user['id'],
                'date' => date("Y-m-d"),
                'price' => $subtotal_price,
                'tax' => $tax,
                'shipping' => $destination['shipping'],
                'title' => 'ラシク初期費用',
                'type' => 'initial',
            ));
            if($payment->save()) {
                if(!Session::get('monitor')) {
                    $result = \Model_GMO::entry(array(
                        'order_id' => $payment->id,
                        'member_id' => $payment->user_id,
                        'amount' => $subtotal_price + $destination['shipping'] ,
                        'tax' => $tax,
                    ));
                    if($result['error']) {
                        Session::set_flash('gmo_errors', $result['error_code']);
                        Response::redirect('/shopping/confirm');
                        return;
                    }                    
                }
                foreach($plans as $plan) {
                    if($plan['span'] == 1) {
                        $renew_date = date('Y-m-d', mktime(0, 0, 0, date('m') + 2, 0, date('Y')));
                    } else if($plan['span'] == 6) {
                        $renew_date = date('Y-m-d', mktime(0, 0, 0, date('m') + 8, 0, date('Y')));
                    } else if($plan['span'] == 12) {
                        $renew_date = date('Y-m-d', mktime(0, 0, 0, date('m') + 14, 0, date('Y')));
                    }

                    //継続課金ではないデータに送料を付ける
                    if($plan['span'] == 0){
                        $shipping = $destination['shipping'];
                        $renew_date = null;
                    } else {
                        $shipping = 0;
                    }
                    $params = array(
                        'plan_id' => $plan['id'],
                        'user_id' => $this->user['id'],
                        'start_date' => date("Y-m-d"),
                        'renew_date'=> $renew_date,
                        'price' => $plan['price'],
                        'shipping' => $shipping,
                        'zip_code' => $destination['zip_code'],
                        'prefecture' => $destination['prefecture'],
                        'address' => $destination['address'],
                        'remarks' => $remarks
                    );
                    if(!empty(Cookie::get("affiliate"))) {
                        $params['affiliate'] = Cookie::get("affiliate"); 
                    }
                    $contract = \Model_Contract::forge();
                    $contract->set($params);
                    if($contract->save()) {
                        $contract_payment = \Model_Contract_Payment::forge();
                        $contract_payment->set(array(
                            'contract_id' => $contract->id,
                            'payment_id' => $payment->id, 
                        ));
                        $contract_payment->save();
                    }
                }
                //メールの送信
                $data = array(
                            'user'  => $this->user,
                            'destination' => $destination,
                            'plans' => $plans,
                            'card' => $card->cardList[0],
                            'subtotal_price' => $subtotal_price,
                            'tax' => $tax,
                            'total_price' => $subtotal_price + $destination['shipping'] + $tax,
                            'date'  => date('Y年m月d日'),
                            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                        );
                $params = array(
                    'to' => $this->user['email'],
                    'subject' => "LASHICアカウント登録、サービス購入のご連絡",
                    'text' => \View::forge('email/contract', $data)
                );
                \Model_User::sendEmail($params);

                //管理者用メール
                $params = array(
                    'to' => $_SERVER['EMAIL_MASTER'],
                    'subject' => "LASHICアカウント登録、サービス購入のご連絡",
                    'text' => \View::forge('email/admin/contract', $data)
                );
                \Model_User::sendEmail($params);
            }
            Session::delete("plans");
            Session::delete("destination");
            Cookie::delete("affiliate");
        } else {
            echo '不正な処理です';
			\Log::warning('不正な処理です. session_id:[' . Session::key() . ']', __METHOD__);
            exit;
        }
        
        $this->template->title = 'ご注文完了';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/complete', $this->data);           
    }
}
