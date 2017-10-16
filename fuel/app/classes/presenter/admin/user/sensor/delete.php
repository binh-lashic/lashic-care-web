<?php
/*
 * センサー機器割当解除  Presenter
 * 
 */
class Presenter_Admin_User_Sensor_Delete extends Presenter
{
        /*
         * view
         * 
         * @params none
         * @throw
         */
	public function view()
	{
            $user_id = Input::param("user_id");
            $sensor_id = Input::param("sensor_id");

            try {

                if($this->doValidation(['user_id' => $user_id, 'sensor_id' => $sensor_id])) {
                    $result = \Model_User_Sensor::deleteUserSensor([
                        'user_id' => $user_id, 
                        'sensor_id' => $sensor_id]);
            
                    if(is_null($result)) {
                        throw new Exception('sensor delete failed. ');
                    }

                } else {
                    throw new Exception('Validation Error. (' . __METHOD__ . ':' . __LINE__ . ') [INFO] user_id: '. $user_id. ' sensor_id: '. $sensor_id);
                }
                
            } catch (Exception $e) {
                Session::set_flash('error_sensor_delete', 'センサー割当解除に失敗しました。');
                \Log::error('センサー割当解除に失敗しました。 (' . __METHOD__ . ':' . __LINE__ . ') [INFO] ' . $e->getMessage());
            }
            
            return Response::redirect('/admin/user/sensor?id='.$user_id);
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
            $validation = Validation::forge('sensor_delete');
            $validation->add('user_id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            $validation->add('sensor_id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            
            return $validation->run($rule);
        }
}
