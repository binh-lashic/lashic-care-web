<?php
 /*
  * 見守られユーザー詳細
  */
class Presenter_Admin_User_Client_Detail extends Presenter
{
        /*
         * view
         * 
         * @access public
         */
	public function view()
	{
            $id = Input::param("id");
            $parent_id = Input::param("parent_id");
            
            if($this->doValidation(['id' => $id, 'parent_id' => $parent_id])) {
                try {
                    $user = Model_User::getUser($id);
                } catch (Exception $e) {
                    \Log::error('見守られユーザー詳細の取得に失敗しました。  ['.$e->getMessage().']');
                    throw new Exception($e);
                }     
            }
            
            $this->set('id', $id);
            $this->set('parent_id', $parent_id);
            $this->set('user', $user);
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
            $validation = Validation::forge('detail');
            $validation->add('id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            $validation->add('parent_id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            
            return $validation->run($rule);
        }
}
