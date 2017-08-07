<?php
/*
 * 見守られユーザーセンサー機器割当  Presenter
 * 
 */
class Presenter_Admin_User_Client_Sensor extends Presenter
{
        /*
         * view
         * 
         * @params none
         * @throw
         */
	public function view()
	{
            $user = [];
            $sensor_list = [];
            
            $id = Input::param('id');
            $parent_id = Input::param('parent_id');
            
            if($this->doValidation(['id' => $id, 'parent_id' => $parent_id])) {
                try {
                    $user = Model_User::getUser($id);
                    if($sensors = Model_User::getSensors($user['id'])) {
                        foreach ($sensors as $key => $value) {
                            $value['type'] = self::getTypeName($value['type']);
                            $sensors[$key] = $value;
                        }
                    }

                    // プルダウン生成
                    if($result = Model_User::getUnselectedSensorList($parent_id)) {
                        $sensorList = self::getList($result);
                    }                

                } catch (Exception $e) {
                    \Log::error('見守られユーザーセンサー機器割当の取得に失敗しました。  ['.$e->getMessage().']');
                    throw new Exception($e);
                }    
            }

            $this->set('isDisplay', ($result) ? true : false);
            $this->set('user', $user);
            $this->set('sensor_list', $sensorList);
            $this->set('sensors', $sensors);
            $this->set('id', $id);
            $this->set('parent_id', $parent_id);
        }
        
        /*
         * センサー機器プルダウン取得 
         * 
         * @access private.static
         * @params array $sensors
         * @return array $list
         */
	private static function getList($sensors)
	{
            $list = [];
            foreach ($sensors as $sensor) {
                $list[$sensor['id']] = sprintf('%s(%s)', $sensor['name'], self::getTypeName($sensor['type']));
            }
            return $list;
	}
       
        /*
         * 機器タイプを取得 
         * 
         * @access private.static
         * @params string $key
         * @return
         */
	private static function getTypeName($key)
	{
            $typeName = Config::get('sensor_type');
            return (isset($typeName[$key])) ? $typeName[$key] : '';
	}
        
        /*
         * Validation 
         * 
         * @access private
         * @param array $rule
         * @return bool
         */
        private function doValidation(array $rule)
        {
            $validation = Validation::forge('sensor');
            $validation->add('id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            $validation->add('parent_id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            
            return $validation->run($rule);
        }
}
