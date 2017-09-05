<?php
 /*
  * 親アカウント新規登録登録完了  Presenter
  */
class Presenter_Admin_User_Complete extends Presenter
{
	use Trait_Admin_User_Regist;
        
	private $validation;
            
	/*
	 * view
	 * 
	 * @access public
	 * @return none
	 */
	public function view()
	{
            $data = [];
            if(Input::post()) {
                if($this->doValidation()) {
                    try {
                        Model_User::saveUserWithAdmin(Trait_Admin_User_Regist::setDataByAdmin());
                        return Response::redirect('/admin/user/list');

                    } catch (Exception $e) {
                        \Log::error('親アカウント登録に失敗しました。  ['.$e->getMessage().']');
                        throw new Exception($e);
                    }
                } else {
                    \Log::error('Validation Error.');
                }
            }
            
            $this->set('List', Trait_Admin_User_Regist::getConfig());
            $this->set('data', Input::param());
            $this->set('error', $this->validation->error_message());
        }
        
	/*
	 * Validation 
	 * 
	 * @access private
	 * @return bool
	 */
	private function doValidation()
	{
            $this->validation = Validation::forge('complete');
            $this->validation->add_callable('usersrules');
            $this->validation->add('zip_code')
                        ->add_rule('check_zipcode');
            $this->validation->add('phone', '電話番号1')
                        ->add_rule('check_phone');
            $this->validation->add('cellular', '電話番号2')
                        ->add_rule('check_phone');
            $this->validation->add('email')
                        ->add_rule('check_email')
                        ->add_rule('duplicate_email');
            $this->validation->add('password', 'パスワード')
                        ->add_rule('required');
            $this->validation->set_message('check_zipcode', '郵便番号の形式が正しくありません。');
            $this->validation->set_message('check_phone', ' :labelの形式が正しくありません。');
            $this->validation->set_message('check_email', 'メールアドレスの形式が正しくありません。');
            $this->validation->set_message('duplicate_email', 'メールアドレスは既に登録されています。');
            $this->validation->set_message('required', ':labelが入力されていません');
            
            return $this->validation->run();
	}
}