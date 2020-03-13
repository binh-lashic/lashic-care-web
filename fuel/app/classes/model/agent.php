<?php 
class Model_Agent extends Orm\Model{

    protected static $_properties = array(
        'store_name',
        'agent_name',
        'start_date',
        'end_date',
        'price',
        'date',
        'agent_code',
        'updated_at',
        'created_at'
    );

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
        ),
    );

    protected static $_has_one = array(
        'plan' => array(
            'key_from' => 'plan_id',
            'model_to' => 'Model_Plan',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

    public function getSearch($params) {
        $sql = "SELECT c.id,c.price,c.shipping,c.start_date,c.renew_date,c.end_date,c.status,u.last_name,u.first_name,
                p.title,st.store_name,ag.agent_name,pay.date,p.type,count(s.shipping_date) AS shipping_count,count(s.id) AS sensor_count ".
               " FROM contracts c ".
               " LEFT JOIN users u ON c.user_id = u.id ".
               " LEFT JOIN plans p ON c.plan_id = p.id ".
               " LEFT JOIN agents ag ON c.agent_code = ag.agent_code".
               " LEFT JOIN stores st ON ag.store_id = st.id".
               " LEFT JOIN payments pay ON c.user_id = pay.user_id".
               " LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               " LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " WHERE p.type != 'initial' AND p.type != 'discount'";
        if(!empty($params['status'])) {
            $sql .= " AND status = '".$params['status']."'";
        }

        if(isset($params['client_user_id'])) {
            $sql .= " AND c.client_user_id = ".$params['client_user_id'];
        }
        $sql .= " GROUP BY c.id,c.price,c.shipping,c.start_date,c.renew_date,c.end_date,c.status,
                  u.last_name,u.first_name,p.title,p.type,u.last_name,u.first_name,st.store_name,ag.agent_name,pay.date ".
               " ORDER BY c.id DESC;";

        $query = DB::query($sql);
        $results = $query->execute();
        return $results;
    }

    public function getClients($params) {
        $sql = "SELECT c.id,c.price,c.shipping,c.start_date,c.renew_date,c.client_user_id,u.last_name,u.first_name,u.last_kana,u.first_kana,p.title,c.affiliate,p.type,count(s.shipping_date) AS shipping_count,count(s.id) AS sensor_count ".
               " FROM contracts c ".
               " LEFT JOIN users u ON c.client_user_id = u.id ".
               " LEFT JOIN plans p ON c.plan_id = p.id ".
               " LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               " LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " WHERE p.type != 'initial' AND p.type != 'discount'";
        if(isset($params['user_id'])) {
            $sql .= " AND c.user_id = ".$params['user_id'];
        }
        $sql .= " GROUP BY c.id,c.price,c.shipping,c.start_date,c.renew_date,c.client_user_id,u.last_name,u.first_name,u.last_kana,u.first_kana,p.title,p.type,c.affiliate ".
               " ORDER BY c.id DESC;";

        $query = DB::query($sql);
        $results = $query->execute();
        return $results;
    }

    public function getUsers()
    {
        $sql = "SELECT c.*,u.last_name,u.first_name,p.title ".
               "  FROM contracts c ".
               "  LEFT JOIN users u ON c.user_id = u.id".
               "  LEFT JOIN plans p ON c.plan_id = p.id".
               "  ORDER BY c.id DESC;";
        $query = DB::query($sql);
        $rows = $query->execute();
        $results = array();
        foreach($rows as $row)
        {
            $results[] = $row['user_id'];
        }
        return array_unique($results);
    }

    /**
     * payment_idからuser_idを更新する
     * @param $user_id
     * @param $payment_id
     * @return mixed
     */
    public static function update_user_id_by_payment_id($user_id, $payment_id) {
        $sql = "UPDATE contracts SET user_id = :user_id ".
               "FROM contracts JOIN contract_payments ON (contracts.id = contract_payments.contract_id) ".
               "WHERE contract_payments.payment_id = :payment_id";
        $query = DB::query($sql);
        $query->parameters(array('user_id' => $user_id, 'payment_id' => $payment_id));
        return $query->execute();
    }

    /**
     * user_idからcontractの件数を取得する
     * @param $user_id
     * @return mixed
     */
    public function getCountByUserId($user_id)
    {
      return \Model_Contract::query()
          ->where('user_id', $user_id)
          ->count();
    }
  
  /**
   * user_idからcontractを取得する
   * @param $user_id
   * @return mixed
   */
  public function getByUserId($user_id)
  {
    return \Model_Contract::query()
        ->where('user_id', '=', $user_id)
        ->get();
  }
}