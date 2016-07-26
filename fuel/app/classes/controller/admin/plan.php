<?php
class Controller_Admin_Plan extends Controller_Admin
{
	public function action_create() {
		try {
			\Model_Plan::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
			exit;
		}
	}

	public function action_index() {
    	$id = Input::param("id");
    	$data['plan'] = \Model_Plan::find($id);
        $this->template->title = '管理ページ プラン設定';
        $this->template->content = View::forge('admin/plan/index', $data);
	}

	public function action_list() {
		$data['page'] = Input::param("page") ? Input::param("page") : 1;
    	$plans = \Model_Plan::getSearch(array(
    		'query' => Input::param('query'),
    		'limit' => 10,
    		'page' => $data['page'],
    	));
    	foreach($plans as $plan) {
    		$plan = $plan->to_array();
	        $data['plans'][] = $plan;
    	}
        $data['query'] = Input::param('query');
        $this->template->title = '管理ページ プラン一覧';
        $this->template->content = View::forge('admin/plan/list', $data);
	}

	public function action_save() {
		$plan = \Model_Plan::savePlan(Input::param());
        Response::redirect('/admin/plan/list');
	}

	public function action_delete() {
		$plan = \Model_Plan::deletePlan(Input::param());
        Response::redirect('/admin/plan/list');
	}

	public function action_register() {
		$plan_names_data = Input::param("plan_names");
		$plan_names = explode(PHP_EOL, $plan_names_data);
		foreach($plan_names as $plan_name) {
			try {
				$plan = \Model_Plan::savePlan(array('name' => $plan_name));
			} catch (Exception $e) {

			}
		}
        $this->template->title = '管理ページ プラン一覧';
     	$data['plans'] = \Model_Plan::getAll();
        Response::redirect('/admin/plan/list');
	}

	public function action_data() {
    	$data['plan'] = \Model_Plan::getPlanFromPlanName(Input::param("name"));
    	$data['data'] = DB::select()
	    ->from('data')
	    ->where('plan_id', $data['plan']['name'])
	    ->order_by('date', 'desc')
	    ->limit(100)
	    ->execute('data') // 引数で指定できる
	    ->as_array();

        $this->template->title = '管理ページ プラン一覧';
        $this->template->content = View::forge('admin/plan/data', $data);
	}

	public function action_shipping() {
    	$data['plan'] = \Model_Plan::find(Input::param("id"));
        $this->template->title = '管理ページ 出荷日登録';
        $this->template->content = View::forge('admin/plan/shipping', $data);
	}
}