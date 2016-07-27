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
            Response::redirect('/register');
        } else {
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
        $this->data['users'] = array();
        $this->data['users'][] = $this->user;
        $this->data['users'][] = \Model_User::find(Input::param("client_user_id"));
        $this->template->title = '送付先指定';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/destination', $this->data);           
    }

    public function action_destination_confirm()
    {
        $this->data['destination'] = \Model_User::find(Input::param("user_id"));
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

        $card = \Model_GMO::findCard(array('member_id' => $this->user['id']));
        $this->data['cards'] = $card->cardList;
        if(Input::post()) {
            $params = Input::post();
            $this->data['card'] = $params;
            if(!$params['number'])
            {
                $this->data['errors']['number'] = true;
            }
            if(!$params['expire_month'] || !$params['expire_year'])
            {
                $this->data['errors']['expire'] = true;
            } else {
                $params['expire'] = $params['expire_month'].substr($params['expire_year'], 2, 2);
            }
            if(!$params['holder_name'])
            {
                $this->data['errors']['holder_name'] = true;
            }
            if(!$params['security_code'])
            {
                $this->data['errors']['security_code'] = true;
            }

            Session::set('card', $params);
            if(empty($this->data['errors'])) {
                //GMOペイメントの会員登録
                $member = \Model_GMO::findMember($this->user['id']);
                if($member) {
                    $params['member_id'] = $member->memberId;
                }

                //カード情報の登録
                \Model_GMO::saveCard($params);

                $params['amount'] = 10000;
                $output = Model_Gmo::exec($params);
                $this->template->content = View::forge('shopping/confirm', $this->data);
                return;
            }
        }
        $this->template->content = View::forge('shopping/payment', $this->data);           
    }

    public function action_confirm()
    {
        $this->template->title = 'ご注文確認';
        $this->data['breadcrumbs'] = array("カート", $this->template->title);
        $this->template->header = View::forge('header', $this->data); 
        $this->template->content = View::forge('shopping/confirm', $this->data);           
    }
}