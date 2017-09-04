<?php
/*
 * 見守られユーザー登録フォーム Presenter
 */

class Presenter_Admin_User_Client_Form extends Presenter
{
        use Trait_Admin_User_Regist;

	/*
	 * view
	 * 
	 * @access public
	 */
	public function view()
	{
            try {
                $id = Input::param("id");

                $this->set('data', []);
                $this->set('id', $id);
                $this->set('List', Trait_Admin_User_Regist::getConfig());
                $this->set('user', Trait_Admin_User_Regist::getUser($id));
                
            } catch (Exception $e) {
                \Log::error('見守られユーザー登録フォームに失敗しました。  ['.$e->getMessage().']');
                throw new Exception($e);
            }
        }
}