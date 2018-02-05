<?php
/*
 * マンスリーレポートページ用の規定API Controller
 * Controller_Api_DailiesとController_Api_Monthliesは継承して使っています。
 */
abstract class Controller_Api_Report extends Controller_Api
{
    // Mockデータを使用する場合はtrue
    protected $isMock = false;
    
    public function before()
    {
        $this->nologin_methods = [
            'getTime'
            ];
        parent::before();
    }

    /*
     * post
     * 
     * @access public
     */
    public function post_get()
    {
        return $this->getContents();
    }

    /*
     * get
     * 
     * @access public
     */
    public function get_get()
    {
        return $this->getContents();
    }
    
    /*
     * 過去のセンサーデータ取得APIをコール 
     * 
     * @access protected
     * @return object $result
     */
    protected function getContents()
    {
        try {
            $data = $this->execute();
            $this->result = ['result' => $data];
            return $this->result;
        } catch (Exception $e) {
            $this->errors[] = ['message' => $e->getMessage()];
            return $this->result();  
        }
    }

    /*
     * ログインしているユーザIDを取得
     * 
     * @access protected
     * @return int $user_id
     */
    protected function getAuthUserId()
    {
        try {
            list(, $user_id) = Auth::get_user_id();
            if(!$user_id) {
               throw new Exception('auth user_id Getting Failed.'); 
            }
            return $user_id;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /*
     * 見守られユーザ情報取得 
     * 
     * @access protected
     * @param array $param
     * @return array $user_client
     * @throw
     */
    protected function getUserClients(array $param)
    {
        try {
            if(!$user_client = \Model_User_Client::getUserClient($param['user_id'], $param['client_user_id'])) {
                throw new Exception('センサーへのアクセスの許可がありません');
            }
            return $user_client;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }        
    }
    
    /*
     * 見守られユーザに紐づくセンサー情報取得 
     * 
     * @access protected
     * @param array $param
     * @return array
     */
    protected function getSensorsByClientUserId(array $param)
    {
        try {
            $sensor_name = null;
            $bedsensor_name = null;
            if(!$sensors = \Model_Sensor::getSensorsFromClientUserId($param['client_user_id'])) {
                throw new Exception('センサー情報の取得に失敗しました。');
            }
                
            foreach ($sensors as $sensor) {
                if ($sensor->type == \Model_Sensor::TYPE_SENSOR) {
                    $sensor_name = $sensor->name;
                } else if ($sensor->type == \Model_Sensor::TYPE_BED_SENSOR) {
                    $bedsensor_name = $sensor->name;
                }
            }
                
            if (empty($sensor_name)) {
                throw new Exception('センサーが割り当てられていません');
            }
            
            return [
                'sensor_name' => $sensor_name,
                'bedsensor_name' => $bedsensor_name
                    ];
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    /*
     * 依存処理の実行
     */
    abstract protected function execute();

    /*
     * Mock
     */
    protected function mock()
    {
        return;
    }    
    /*
     * Mockデータを返すかどうか
     */
    protected function isMock()
    {
        return ($this->isMock);
    }
}