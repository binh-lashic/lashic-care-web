<?php
class Controller_Admin_Agent extends Controller_Admin
{

    public function action_list()
    {
        $params = array();
        $params['page'] = $data['page'] = Input::param('page') ?: 1;
        $params['limit'] = Config::get('display_limit.hundred');
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
        
        Session::set('store', $params['store']);
        Session::set('agent', $params['agent']);
        Session::set('from', $params['from']);
        Session::set('to', $params['to']);
        $this->template->title = '代理店実績管理';
        $this->template->content = View::forge('admin/agent/list', $data);
    }

    public function action_get_csv()
    {
        $params = array();
        $params['store'] = Session::get('store');
        $params['agent'] = Session::get('agent');
        $params['from'] = Session::get('from');
        $params['to'] = Session::get('to');
        $data['agents'] = \Model_Agent::getCsvData($params);
        if($params['store']){
            $file_name = $params['store']. "_";
        }
        if($params['agent']){
            $file_name = $file_name.$params['agent']. "_";
        }
        $file_name = $file_name.$params['from']. '〜' .$params['to'].".csv";
        $this->output_csv($data['agents'], $file_name);
    }
    
    private function output_csv($agents, $file_name)
    {
        $data = [];
        $data[] = ['代理店名','エージェント名','契約プラン名','契約アカウント名','金額','決済月','契約開始日','契約終了日'];
        foreach ($agents as $agent){
            $data[] = [
                $agent['store_name'],
                $agent['agent_name'],
                $agent['title'],
                $agent['last_name'].$agent['first_name'],
                number_format($agent['price']),
                $agent['date'],
                $agent['start_date'],
                $agent['end_date']
            ];
        }
        $this->template = null;
        $this->response = new Response();
        $this->response->set_header('Content-Type', 'application/csv; charset=S-JIS');
        $this->response->set_header('Content-Disposition', 'attachment; filename*=UTF-8\'\''.rawurlencode($file_name));
        $this->response->send(true);
        echo Format::forge()->to_csv($data);
    }
}