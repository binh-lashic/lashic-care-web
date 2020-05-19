<?php
 /**
 * 管理画面のログインセッション用コントローラ
 */

class Controller_Admin_Login extends Controller_Sessions
{

	public function before() {
		$this->nologin_methods = array(
	        'admin',
	    );
	    parent::before();
    }

    /**
	 * ログイン画面
	 */
	public function action_index()
	{
		$view      = 'admin/account/login';
		return View::forge($view);
	}

	/**
	 * ログイン処理
	 */
	public function action_login()
	{
		$username = Input::post("username");
		$password = Input::post("password");
		$data = array();

		if (!Auth::login()) {
			Log::debug("ログインに失敗しました。username:[" . Input::post('username') . "]", __METHOD__);
			Session::set_flash('errors', ['メールアドレスまたはパスワードが違います。']);
			return $this->action_index();
		}

		if (Input::param('remember_me', false)) {
			Auth::remember_me();
		} else {
			Auth::dont_remember_me();
		}

		if(Input::post()) {
			if (Auth::login($username, $password)) {
				list(, $user_id) = Auth::get_user_id();
				$id = \Model_Accounts::getAccount($user_id);

				Session::set('account', $username);
				Session::set('admin', $id);
				$session = Session::get('admin');
				Response::redirect('/admin/user/list');
			} else {
				Session::set('login_error', true);
				Response::redirect('/admin');
			}
		}
	}

    /**
	 * ログアウト処理
	 */
	public function action_logout()
	{
		Auth::logout();
		Auth::dont_remember_me();
		Session::delete('admin');
		Response::redirect('/admin');
	}
}
