<?php
class Presenter_Admin_User_Client_Sensor extends Presenter
{
	private $typeName;
        
	public function before()
	{
            $this->typeName = Config::get('sensor_type');
	}
        
	public function view()
	{
            $user = [];
            $sensor_list = [];
            $isDisplay = false;
            
            if($this->id) {
                $user = Model_User::getUser($this->id);
                if($sensors = Model_User::getSensors($user['id'])) {
                    foreach ($sensors as $key => $value) {
                        $value['type'] = $this->getTypeName($value['type']);
                        $sensors[$key] = $value;
                    }
                }
            }

            // プルダウン生成
            if($this->parent_id) {
                if($result = Model_User::getUnselectedSensorList($this->parent_id)) {
                    $isDisplay = true;
                    $sensor_list = $this->getList($result);
                }
            }
      
            $this->set('isDisplay', $isDisplay);
            $this->set('user', $user);
            $this->set('sensor_list', $sensor_list);
            $this->set('sensors', $sensors);
        }
        
	private function getList($sensors)
	{
            $list = [];
            foreach ($sensors as $sensor) {
                $list[$sensor['id']] = $sensor['name']."(". $this->getTypeName($sensor['type']).")";
            }
            return $list;
	}
       
	private function getTypeName($key)
	{
            return (isset($this->typeName[$key])) ? $this->typeName[$key] : '';
	}
}
