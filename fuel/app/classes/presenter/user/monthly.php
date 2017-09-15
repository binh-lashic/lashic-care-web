<?php
/*
 * マンスリーレポート Presenter
 */
class Presenter_User_Monthly extends Presenter
{
    /*
     * view
     * 
     * @access public
     * @param none
     */
    public function view()
    {
        $this->set('month_first', date('Y/m/d', strtotime('first day of' . date('Y-m'))));
        $this->set('month_last', date('Y/m/d', strtotime('last day of' . date('Y-m'))));
        $this->set('year', date('Y'));
        $this->set('month', date('n'));
        $this->set('user', $this->data['user']);
        $this->set('client', $this->data['client']);
    }
}
