<?php
/*
 * 見守られユーザ一覧  Presenter
 */
class Presenter_Admin_User_Client_List extends Presenter
{
        /*
         * view
         * 
         * @access public
         */
	public function view()
	{
            $id = Input::param("id");
            if($this->doValidation(['id' => $id])) {
                try {
                    $user = Model_User::find($id);
                    $clients = Model_User_Client::getUserClientList($id);
                } catch (Exception $e) {
                    \Log::error('見守られユーザ一覧の取得に失敗しました。  ['.$e->getMessage().']');
                    throw new Exception($e);
                }
            }
            $this->set('id', $id);
            $this->set('clients', $clients);
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
            $validation = Validation::forge('list');
            $validation->add('id')
                    ->add_rule('required')
                    ->add_rule('valid_string','numeric');
            
            return $validation->run($rule);
        }
}
