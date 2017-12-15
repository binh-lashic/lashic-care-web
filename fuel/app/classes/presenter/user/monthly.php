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
        $this->set('month_first', date('Y/m/d', strtotime('first day of' . date("Y-m",strtotime("-1 month")))));
        $this->set('month_last', date('Y/m/d', strtotime('last day of' . date("Y-m",strtotime("-1 month")))));
        $this->set('year', date("Y",strtotime("-1 month")));
        $this->set('month', date('n',strtotime("-1 month")));
        $this->set('user', $this->data['user']);
        $this->set('client', $this->data['client']);
    }
}
