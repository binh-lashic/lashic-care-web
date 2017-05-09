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
            $sensor = [];
            
            if($this->id) {
                $user = Model_User::getUser($this->id);
            }
            // プルダウン生成
            if($this->parent_id) {
                if($result = Model_User::getSensors($this->parent_id)) {
                    $sensor_list = $this->getList($result);
                }
            }

            $this->set('user', $user);
            $this->set('sensor_list', $sensor_list);
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
