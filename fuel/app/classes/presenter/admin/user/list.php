<?php
class Presenter_Admin_User_List extends Presenter
{
	public function view()
	{
            $data = array();
            $data['page'] = Input::param("page") ?: 1;
            $query = array(
                'admin' => 1,
                'limit' => 10,
                'page' => $data['page'],
            );
            if (Input::param('query')) {
                $query['query'] = Input::param('query');
            }
            
            $admins = \Model_User::getSearch($query);

            foreach ($admins as $admin) {
                $admin['sensors'] = \Model_User::getSensors($admin['id']);
                $admin['clients'] = \Model_User::getClients($admin['id']);
                $data['admins'][] = $admin;
            }
            $data['query'] = Input::param('query');

            $this->set('admins', $data['admins']);
            $this->set('page', $data['page']);
            $this->set('query', $data['query']);
        }
}
