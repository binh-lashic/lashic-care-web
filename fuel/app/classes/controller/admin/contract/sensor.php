<?php
class Controller_Admin_Contract_Sensor extends Controller_Admin
{
	public function action_create() {
		try {
			\Model_Contract_Sensor::createTable();
		} catch(Exception $e) {
			print_r($e->getMessage());
		}
	}

    public function action_index() {
        $id = Input::param("id");
        if($id) {
            $contract = Model_Contract::find($id);
            $data['contract'] = $contract;
            $sensors = \Model_Contract::getSensors($id);
            foreach($sensors as $sensor) {
                $contract_sensors = Model_Sensor::getAdmins(array("sensor_id" => $sensor['id']));
                $sensor['admins'] = array();
                $sensor['clients'] = array();
                if(count($contract_sensors) > 0)  {
                    foreach($contract_sensors as $contract_sensor) {
                        $_contract = \Model_Contract::find($contract_sensor['contract_id']);
                        if(isset($_contract)) {
                            if($_contract['admin'] == 1) {
                                $sensor['admins'][] = $_contract;
                            } else {
                                $sensor['clients'][] = $_contract;
                            }                       
                        }
                    }
                }
                $data['sensors'][] = $sensor;
            }
        }
        $this->template->title = '会員ページ';
        $this->template->content = View::forge('admin/contract/sensor', $data);
    }

    public function action_delete() {
        $contract_id = Input::param("contract_id");
        $sensor_id = Input::param("sensor_id");

        \Model_Contract_Sensor::deleteContractSensor(array('contract_id' => $contract_id, 'sensor_id' => $sensor_id));
        Response::redirect('/admin/contract/sensor?id='.$contract_id); 
    }
}