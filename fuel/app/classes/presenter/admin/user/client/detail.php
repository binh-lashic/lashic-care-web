<?php
class Presenter_Admin_User_Client_Detail extends Presenter
{
	public function view()
	{
            if($this->id) {
                    $user = Model_User::getUser($this->id);
            }
            $this->set('user', $user);
        }
}
