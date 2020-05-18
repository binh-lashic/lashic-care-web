<?php
class Controller_Admin_Account extends Controller_Admin
{

	/**
	 * アカウント一覧画面
	 */
	public function action_index() {
	$this->data['users'] = \Model_Accounts::find('all', array('select' => array('id','email', 'created_at')));
        $this->template->title = 'システム管理者一覧';
        $this->template->content = View::forge('admin/account/sysadmin', $this->data);
    	}

	/**
	 * アカウント削除
	 */
	public function action_delete() {
		$id = Input::post("id_account");
        	$account = Model_Accounts::find($id);
		$account->delete();
		Session::set_flash('success', ['削除しました。']);
		return $this->action_index();
    	}

	/**
	 * アカウント登録画面
	 */
	public function action_create() {
            $this->template->title = 'アカウント登録画面';
	    $this->template->content = View::forge('admin/account/register');
    	}

 	/**
	 * アカウント登録
	 * @param $username
	 * @param $password
	 * @return Model_Accounts
	 */
    	public function action_register() {
        $username = Input::post("email");
		$password = Input::post("password");
		$data = array();

		$validator = Model_Accounts::validator();
		if (!$validator->run()) {
			$errors = [];
			foreach ($validator->error() as $error) {
				$errors[] = $error->get_message();
			}
			Log::debug(print_r($errors, true), __METHOD__);
			Session::set_flash('errors', $errors);
			return $this->action_create();
		}

			$pass = Auth::hash_password($password);
			$info = [
				'username' => sha1($username),
				'email' => $username,
				'password' => $pass,
			];
			$account = Model_Accounts::forge();
			$account->set($info);
			$account->save();
			Session::set_flash('success', ['管理者を登録しました。']);
	        return $this->action_index();
    	}

	/**
	 * アカウント編集画面
	 */
	public function action_edit() {
		$id = Input::get("id");
		$this->data = \Model_Accounts::getEmail($id);

        	$this->template->title = 'アカウント編集画面';
		$this->template->content = View::forge('admin/account/edit', $this->data);
	}

	/**
	 * アカウント更新
	 * @param $username
	 * @param $password
	 * @return Model_Accounts
	 */
	public function action_update() {
		$username = Input::post("email");
		$password = Input::post("password");
		$data = array();

		$validator = Model_Accounts::validator_edit();
		if (!$validator->run()) {
			$errors = [];
			foreach ($validator->error() as $error) {
				$errors[] = $error->get_message();
			}
			Log::debug(print_r($errors, true), __METHOD__);
			Session::set_flash('errors', $errors);
			return $this->action_index();
		}

		$pass = Auth::hash_password($password);
			$info = [
				'username' => sha1($username),
				'email' => $username,
				'password' => $pass,
			];
		$id = Input::post("id");
		$account_update = Model_Accounts::find($id);
		$account_update->set($info);
		$account_update->save();
		Session::set_flash('success', ['パスワードを更新しました。']);
        return $this->action_index();
	}
}
