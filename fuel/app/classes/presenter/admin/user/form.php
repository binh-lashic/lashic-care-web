<?php
 /*
  * 親アカウント新規登録  Presenter
  */
class Presenter_Admin_User_Form extends Presenter
{
	use Trait_Admin_User_Regist;

	/*
	 * view
	 * 
	 * @access public
	 * @return none
	 */
	public function view()
	{
            $this->set('List', Trait_Admin_User_Regist::getConfig());
            $this->set('data', []);
	}
}