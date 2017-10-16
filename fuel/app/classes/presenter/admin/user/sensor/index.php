<?php
/*
 * 親アカウントセンサー機器割当一覧 Presenter
 * 
 */
class Presenter_Admin_User_Sensor_Index extends Presenter
{
        /*
         * view
         * 
         * @access public
         * @return none
         */
	public function view()
	{
            $id = Input::param("id");
            if($this->doValidation(['id' => $id])) {
                $data = [];
                try {
                    $user = Model_User::find($id);
                    $sensors = Model_User_Sensor::getAllocationList($id);
                } catch (Exception $e) {
                    \Log::error('親アカウントセンサー機器割当一覧の取得に失敗しました。  ['.$e->getMessage().']');
                    throw new Exception($e);
                }
            }
            
            $this->set('user', $user);
            $this->set('sensors', $sensors);
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
            $validation = Validation::forge('index');
            $validation->add('id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            
            return $validation->run($rule);
        }
}