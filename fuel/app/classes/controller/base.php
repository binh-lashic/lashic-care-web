<?php
class Controller_Base extends Controller_Template
{
    //デフォルトのテンプレートのViewファイル
    public $template = 'template';

	protected $nologin_methods = array();

	/** 使用言語 */
	protected $language = 'ja';

	public function before()
	{
	    $method = Request::active()->action;
	    if (in_array($method, $this->nologin_methods))
	    {
            if($method === "login") {
                $this->template = 'template_nologin';
            }
		}
		else if (!Auth::check())
		{
	    	Response::redirect('/user/login');
		}
		// 使用言語をリクエストパラメータから設定
		$lang = Input::param('lang');
		if (!$lang) {
			// リクエストパラメータに無ければセッションから取得
			$lang = Session::get('language');
		}
		if (!$lang) {
			// セッションにも無ければ Accept-Language ヘッダから自動判別
			$languages = Agent::languages();
			if (in_array('ja', $languages)) {
				$lang = 'ja';
			} else {
				// 日本語が含まれていなかったら英語
				$lang = 'en';
			}
		}
		Session::set('language', $lang);
		Config::set('language', $lang);
		Lang::load('labels');
		Lang::load('alerts');
		$this->language = $lang;

	    parent::before();
	}

}
