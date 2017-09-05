<?php
 /*
  * 見守られユーザー登録完了  Presenter
  */
class Presenter_Admin_User_Client_Complete extends Presenter
{
	use Trait_Admin_User_Regist;       
	private $validation;
            
	/*
	 * view
	 * 
	 * @access public
	 */
	public function view()
	{
            $data = [];
            $id = Input::param("id");
            if(Input::post()) {
                if($this->doValidation()) {
                    try {                    
                        Model_User::saveClientUserWithAdmin($id, Trait_Admin_User_Regist::setDataByClient());
                        return Response::redirect(sprintf('/admin/user/client/list?id=%s', $id));
                    } catch (Exception $e) {
                        \Log::error('見守られユーザー登録に失敗しました。  ['.$e->getMessage().']');
                        throw new Exception($e);
                    }
                } else {
                    \Log::error('Validation Error. [ID: '.$id.']');
                }
            }
            
            $this->set('id', $id);
            $this->set('List', Trait_Admin_User_Regist::getConfig());
            $this->set('user', Trait_Admin_User_Regist::getUser($id));
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
            $this->validation->add('id')
                        ->add_rule('required');
            $this->validation->add('zip_code')
                        ->add_rule('check_zipcode');
            $this->validation->add('phone', '電話番号1')
                        ->add_rule('check_phone');
            $this->validation->add('cellular', '電話番号2')
                        ->add_rule('check_phone');
            $this->validation->add('email')
                        ->add_rule('check_email')
                        ->add_rule('duplicate_email');
            $this->validation->set_message('check_zipcode', '郵便番号の形式が正しくありません。');
            $this->validation->set_message('check_phone', ' :labelの形式が正しくありません。');
            $this->validation->set_message('check_email', 'メールアドレスの形式が正しくありません。');
            $this->validation->set_message('duplicate_email', 'メールアドレスは既に登録されています。');
            
            return $this->validation->run();
	}
}