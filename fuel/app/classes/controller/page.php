<?php
class Controller_Page extends Controller_Template
{
    public function before() {
        $this->nologin_methods = array(
            'index',
            'news',
            'news_list',
            'news_detail',
            'news_maintenance_list',
            'news_maintenance_detail',
            'terms',
            'privacy',
            'contact',
            'help'
        );
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
        Response::redirect('http://www.infic-c.net/LASHIC/kiyaku.html');
        return;
        $this->template->title = '利用規約';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/terms');
        $this->template->footer = View::forge('footer');
    }
    public function action_privacy()
    {        
        Response::redirect('http://www.infic-c.net/LASHIC/privacy.html');
        return;
        $this->template->title = 'プライバシーポリシー';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/privacy');
        $this->template->footer = View::forge('footer');
    }
    public function action_help()
    {        
        Response::redirect('http://www.infic-c.net/LASHIC/qa.html');
        return;
        $this->template->title = 'Q &amp; A';
        $this->data['breadcrumbs'] = array($this->template->title);
        $this->template->header = View::forge('header', $this->data);
        $this->template->content = View::forge('page/help');
        $this->template->footer = View::forge('footer');
    }
    public function action_about() {
        $this->template->title = 'ラシクとは';
        $this->template->header = View::forge('header');
        $this->template->content = View::forge('more_info');
        $this->template->footer = View::forge('footer');
    }
    public function action_infic() {
        echo "infic";
    }
}
