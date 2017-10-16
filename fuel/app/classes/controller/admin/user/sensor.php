<?php
class Controller_Admin_User_Sensor extends Controller_Admin
{
    public function action_create()
    {
        try {
            \Model_User_Sensor::createTable();
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }

    /*
     * 親アカウントセンサー機器割当一覧
     * 
     * @access public
     * 
     */
    public function action_index()
    {
        $this->template->title = '会員ページ';
        $this->template->content = Presenter::forge('admin/user/sensor/index');      
    }

    /*
     * センサー割当解除
     * 
     * @access public
     */
    public function action_delete()
    {
        $this->template->content = Presenter::forge(
                'admin/user/sensor/delete', 
                'view', 
                null, 
                'admin/user/sensor/index');
    }
}