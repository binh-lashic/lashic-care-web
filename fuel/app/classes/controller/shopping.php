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
        $this->template->title = 'CareEye（ケアアイ）';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->content = View::forge('shopping/index', $this->data);
	}

	public function action_cart()
	{
        if (!Auth::check()) {
            Response::redirect('/register/email');
        } else {
            $this->data['plans'] = Session::get("plans");
            $this->template->title = 'カート';
            $this->data['breadcrumbs'] = array($this->template->title);
            $this->template->header = View::forge('header', $this->data);
            $this->template->content = View::forge('shopping/cart', $this->data);
        }
    }

    public function action_user()
    {
        $this->template->title = '見守り対象ユーザー設定';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('shopping/user', $this->data);
    }
   
    public function action_user_form()
    {
        $this->template->title = '見守り対象ユーザー設定';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);

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
            Response::redirect('/shopping/user'); 
        }  
    }

    public function action_destination()
    {
        if(Input::param("client_user_id")) {
            $client = \Model_User::find(Input::param("client_user_id"));
            Session::set('client', $client);
        }

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
                    $this->data['errors'][$key] = true;
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
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/destination', $this->data);           
    }

    public function action_destination_confirm()
    {
        if(Input::param("user_id")) {
            $this->data['destination'] = \Model_User::find(Input::param("user_id"));
        }
        if(Input::param("address_id")) {
            $this->data['destination'] = \Model_Address::find(Input::param("address_id"));
        }
        if(preg_match("/北海道|沖縄/ui", $this->data['destination']['prefecture'])) {
            $this->data['destination']['shipping'] = 500;
        } else {
            $this->data['destination']['shipping'] = 0;
        }
        Session::set("destination", $this->data['destination']);
        $this->data['plans'] = Session::get("plans");
        $this->data['total_price'] = 0;
        foreach($this->data['plans'] as $plan) {
            $this->data['total_price'] += $plan['price'];
        } 
        $this->template->title = '配送とお支払い';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/destination_confirm', $this->data);           
    }

    public function action_payment()
    {
        $this->template->title = '配送とお支払い';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        echo "hoge";
        print_r(Input::post());
        if(Input::post()) {
            $params = Input::post();
            Session::set('card', $params);
            $this->data['card'] = $params;
            if($params['process'] == "registered") {
                if(!$params['security_code_registered'])
                {
                    $this->data['errors']['security_code_registered'] = true;
                }
                if(empty($this->data['errors'])) {
                    Response::redirect('/shopping/confirm');
                    return;
                }
            } else {
                if(!$params['number'])
                {
                    $this->data['errors']['number'] = true;
                }
                if(!$params['expire_month'] || !$params['expire_year'])
                {
                    $this->data['errors']['expire'] = true;
                } else {
                    $params['expire'] = substr($params['expire_year'], 2, 2).$params['expire_month'];
                }
                if(!$params['holder_name'])
                {
                    $this->data['errors']['holder_name'] = true;
                }
                if(empty($this->data['errors'])) {
                    //GMOペイメントの会員登録
                    $member = \Model_GMO::findMember($this->user['id']);
                    if(!$member->memberId) {
                        $member = \Model_GMO::saveMember($this->user['id']);
                    }
                    $params['member_id'] = $member->memberId;
                    print_r($member);
                    //カード情報の登録
                    print_r($params);
                    $result = \Model_GMO::saveCard($params);
                    echo "hoge2";
                    print_r($result);
                    exit;
                    Response::redirect('/shopping/payment');
                }
            }
        }

        $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
        print_r($card);
        $this->data['cards'] = $card->cardList;

        $this->template->content = View::forge('shopping/payment', $this->data);           
    }

    public function action_confirm()
    {
        $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
        $this->data['card'] = $card->cardList[0];
        $this->data['destination'] = Session::get("destination");
        $this->data['plans'] = Session::get("plans");
        $this->template->title = 'ご注文確認';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/confirm', $this->data);           
    }

    public function action_complete()
    {
        $plans = Session::get("plans");
        $client = Session::get("client");
        $destination = Session::get("destination");
        $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
        if(empty($client['id'])) {
            $this->data['errors']['client'] = true;
        }
        if(empty($plans)) {
            $this->data['errors']['plan'] = true;
        }
        if(empty($destination['zip_code'])) {
            $this->data['errors']['destination'] = true;
        }
        if(empty($this->data['errors'])) {
            foreach($plans as $plan) {
                if($plan['type'] == 'monthly') {
                    $renew_date = date('Y-m-d', mktime(0, 0, 0, date('m') + 2, 0, date('Y')));
                } else if($plan['type'] == '6monthly') {
                    $renew_date = date('Y-m-d', mktime(0, 0, 0, date('m') + 8, 0, date('Y')));
                } else if($plan['type'] == 'yearly') {
                    $renew_date = date('Y-m-d', mktime(0, 0, 0, date('m') + 14, 0, date('Y')));
                }
                $params = array(
                    'plan_id' => $plan['id'],
                    'user_id' => $this->user['id'],
                    'client_user_id' => $client['id'],
                    'start_date' => date("Y-m-d"),
                    'renew_date'=> $renew_date,
                    'price' => $plan['price'],
                    'shipping' => $destination['shipping'],
                    'zip_code' => $destination['zip_code'],
                    'prefecture' => $destination['prefecture'],
                    'address' => $destination['address'],
                );
                $contract = \Model_Contract::forge();
                $contract->set($params);
                if($contract->save()) {
                    if($plan['options'][0]['continuation'] != "1") {
                        $result = \Model_GMO::entry(array(
                            'order_id' => $contract->id,
                            'member_id' => $contract->user_id,
                            'amount' => $contract->price,
                            'tax' => $contract->shipping,
                        ));
                    }
                }
            }
            Session::delete("plans");
            Session::delete("client");
            Session::delete("destination");
        } else {
            echo '不正な処理です';
            exit;
        }
        
        $this->template->title = 'ご注文完了';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/complete', $this->data);           
    }
}