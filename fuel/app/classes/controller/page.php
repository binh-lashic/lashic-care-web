<?php
class Controller_Page extends Controller_Template
{
    //デフォルトのテンプレートのViewファイル
    public $template = 'template';

	protected $nologin_methods = array();

	public function before()
	{
	    $method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods))
	    {     
	    	$this->template = 'template_nologin';
		}
		else if (!Auth::check())
		{
	    	Response::redirect('/user/login');
		}
	    parent::before();
	}

	public function action_index()
	{
        $data = array();
        $this->template->title = 'トップ';
        $this->template->header = View::forge('header');
        $this->template->content = View::forge('page/index');
        $this->template->footer = View::forge('footer');
	}

	public function action_news()
	{        
        $this->template->title = '運営者からのお知らせ';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/news');
        $this->template->footer = View::forge('footer');
	}

	public function action_news_list()
	{        
        $this->template->title = '運営者からのお知らせ';
        $this->data['breadcrumbs'] = array($this->template->title, "お知らせ　一覧");
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/news_list');
        $this->template->footer = View::forge('footer');
	}

	public function action_news_detail()
	{        
        $this->template->title = '運営者からのお知らせ';
        $this->data['breadcrumbs'] = array($this->template->title, "お知らせ　一覧");
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/news_detail');
        $this->template->footer = View::forge('footer');
	}

	public function action_news_maintenance_list()
	{        
        $this->template->title = '運営者からのお知らせ';
        $this->data['breadcrumbs'] = array($this->template->title, "メンテナンス・障害・その他　一覧");
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/news_maintenance_list');
        $this->template->footer = View::forge('footer');
	}

	public function action_news_maintenance_detail()
	{        
        $this->template->title = '運営者からのお知らせ';
        $this->data['breadcrumbs'] = array($this->template->title, "メンテナンス・障害・その他　一覧");
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/news_maintenance_detail');
        $this->template->footer = View::forge('footer');
	}


	public function action_terms()
	{        
        $this->template->title = '利用規約';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/terms');
        $this->template->footer = View::forge('footer');
	}

	public function action_privacy()
	{        
        $this->template->title = 'プライバシーポリシー';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/privacy');
        $this->template->footer = View::forge('footer');
	}

	public function action_contact()
	{        
        $this->template->title = 'お問い合わせ';
         $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/contact');
        $this->template->footer = View::forge('footer');
	}

	public function action_help()
	{        
        $this->template->title = 'ヘルプ';
         $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/help');
        $this->template->footer = View::forge('footer');
	}
}