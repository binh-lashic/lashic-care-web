<?php
class Presenter_Admin_Sensor_List extends Presenter
{
	private $typeName;
        
	public function before()
	{
            $this->typeName = Config::get('sensor_type');
	}
        
	public function view()
	{
            foreach($this->result as $sensor) {
                    $sensor = $sensor->to_array();
                    $sensor['type_name'] = $this->getTypeName($sensor['type']);
                    $user_sensors = Model_Sensor::getAdmins(["sensor_id" => $sensor['id']]);
                    $sensor['admins'] = [];
                    $sensor['clients'] = [];
                    
                    if(count($user_sensors) > 0)  {
                            foreach($user_sensors as $user_sensor) {
                                    $user = \Model_User::find($user_sensor['user_id']);
                                    if(isset($user)) {
                                            if($user['admin'] == 1) {
                                                    $sensor['admins'][] = $user;
                                            } else {
                                                    $sensor['clients'][] = $user;
                                            }	    				
                                    }
                            }
                    }
                    $sensors[] = $sensor;
            }
            
            $this->set('sensors', $sensors);
            $this->set('typeName', $this->typeName);
	}
        
	private function getTypeName($key)
	{
            return (isset($this->typeName[$key])) ? $this->typeName[$key] : '';
	}
}
