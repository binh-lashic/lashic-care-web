<?php
class Presenter_Admin_Sensor_List extends Presenter
{
	private $typeName = [
                    'parent' => '親機',
                    'sensor' => 'センサー',
                    'wifi' => 'WiFi',
                    'bedsensor' => 'ベッドセンサー',
	];
        
	public function view()
	{
            foreach($this->result as $sensor) {
                    $sensor = $sensor->to_array();
                    $sensor['type'] = $this->getTypeName($sensor['type']);
                    $user_sensors = Model_Sensor::getAdmins(array("sensor_id" => $sensor['id']));
                    $sensor['admins'] = array();
                    $sensor['clients'] = array();
                    
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
