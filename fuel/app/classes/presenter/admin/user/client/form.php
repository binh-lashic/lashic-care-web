<?php
/*
 * 見守られユーザー登録フォーム ViewModel
 */
class Presenter_Admin_User_Client_Form extends Presenter
{
        private $List;
        
    	public function before()
	{
            foreach(['gender','eras', 'months', 'days', 'blood_type', 'prefectures'] as $value) {
                $this->List[$value] = Config::get($value);
            }
	}
        
	public function view()
	{
            $this->getUser();
            
            $this->set('List', $this->List);
            $this->set('data', $this->data);
            $this->set('id', $this->id);
            
            if(isset($this->error)) {
                $this->set('error', $this->error);
            }    
        }
        
        private function getUser()
        {
            if($this->id) {
    		$user = Model_User::getUser($this->id);
            }
            $this->set('user', $user);
            return;
        }
}