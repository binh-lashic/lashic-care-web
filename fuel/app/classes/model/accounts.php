<?php
class Model_Accounts extends Orm\Model{

	protected static $_properties = array(
		    'id',
        	'username',
        	'email',
        	'password',
        	'last_login',
        	'login_hash',
        	'updated_at',
        	'created_at',
	);

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
        ),
    );

    /**
     * ログインされているアカウントのidを取得
     */
    public static function getAccount($id) {
        $sql = "SELECT * FROM accounts WHERE id = :id;";
		$query = DB::query($sql);
		$query->parameters(array('id' => $id));
		$res = $query->execute();
		return $id;
    }

    /**
     * 選択したアカウントのEmailを取得
     */
    public static function getEmail($user_id) {
        $email = DB::select('id','email')
        ->from('accounts')
        ->where('id', '=', $user_id)
        ->execute()
        ->as_array();
        return $email;
    }

    /**
     * 登録時のバリデーション設定
     */
    public static function validator($id = null) {

		$val = Validation::forge();

		$val->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('match_field', 'email_confirmation')
			->add_rule('valid_email')
			->add_rule(function($email) use($id) {
				if (!$email) {
					return true;
				}
				$query = Model_Accounts::query()->where('email', strtolower($email));

				$account = $query->get_one();
				if ($account) {
					Validation::active()->set_message('closure', '既に存在するメールアドレスです。');
					return false;
				}
				return true;
			}
		);

		$val->add_field('email_confirmation',    'メールアドレス(確認)', ['valid_email']);

		$val->add_field('password', 'パスワード', ['match_field[password_confirmation]']);

		$val->add_field('password', 'パスワード', ['required', 'match_field[password_confirmation]']);

		return $val;
    }

    /**
     * 更新時のバリデーション設定
     */
    public static function validator_edit($id = null) {
		$val = Validation::forge();

		$val->add('email', 'メールアドレス')
			->add_rule('required')
			->add_rule('match_field', 'email_confirmation')
			->add_rule('valid_email')
			->add_rule(function($email) use($id) {
				if (!$email) {
					return true;
				}

				$query = Model_Accounts::query()->where('email','=', strtolower($email));

				$account = $query->get_one();
				if (empty($account)) {
					Validation::active()->set_message('closure', 'システム管理者編集でエラーが発生しました。');
					return false;
				}
				return true;
			}
		);

		$val->add_field('email_confirmation',    'メールアドレス(確認)', ['valid_email']);

		$val->add_field('password', 'パスワード', ['match_field[password_confirmation]']);

		$val->add_field('password', 'パスワード', ['required', 'match_field[password_confirmation]']);

		return $val;
    }
}
