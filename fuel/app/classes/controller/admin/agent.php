<?php
class Controller_Admin_Agent extends Controller_Admin
{
    
    public function action_list()
    {
        $params = array();
        $params['page'] = $data['page'] = Input::param('page') ?: 1;
        $params['limit'] = 100;
        $params['store'] = Input::param('store');
        $params['agent'] = Input::param('agent');
        $params['from'] = date('Y-m-01', strtotime(Input::param('from_year').sprintf('%02d', Input::param('from_month')).'01'));
        $params['to'] = date('Y-m-t', strtotime(Input::param('to_year').sprintf('%02d', Input::param('to_month')).'01'));
                        
        $data['agents'] = \Model_Agent::getSearch($params);
        if($params['from']){
            $data['filter'] = \Model_Agent::getFilter($params);
        }
        $data['storeList'] = \Model_Agent::getStores();
        $data['agentList'] = \Model_Agent::getAgents();
        $data['default_store'] = Input::param('store') ?: '---'; 
        $data['default_agent'] = Input::param('agent') ?: '---';
        $data['years'] = Config::get('years');
        $data['months'] = Config::get('months');
        $data['default_from_year'] = Input::param('from_year') ?: date('Y'); 
        $data['default_from_month'] = Input::param('from_month') ?: date('n');
        $data['default_to_year'] = Input::param('to_year') ?: date('Y'); 
        $data['default_to_month'] = Input::param('to_month') ?: date('n');
        
        $this->template->title = '代理店実績管理';
        $this->template->content = View::forge('admin/agent/list', $data);
    }
    
    public function action_submit_select()
	{
		$params = Input::post();
		$submit_type = $params['submit_type'];
		$this->action_get_csv($params);
	}
}