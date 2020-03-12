<?php 
class Model_Payment extends Orm\Model{

    protected static $_properties = array(
        'id',
        'user_id',
        'title',
        'date',
        'price',
        'tax',
        'shipping',
        'updated_at',
        'created_at',
        'first_name',
        'last_name',
        'first_kana',
        'last_kana',
        'phone',
        'email',
        'token',
        'member_id'
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

    public static function validate()
    {
        $val = Validation::forge();
        $val->add_callable('Validation_Japanese');
        $val->add_callable('usersrules');
        $val->add_field('email', 'メールアドレス', 'required|valid_email|max_length[512]');
        $val->add_field('last_name', 'お名前 姓', 'required|max_length[45]');
        $val->add_field('first_name', 'お名前 名', 'required|max_length[45]');
        $val->add_field('phone', '電話番号', 'required|valid_string[numeric]|max_length[45]');
        return $val;
    }

    public function getSearch() {
      /*
        $sql = "SELECT pay.id,pay.title,pay.price,pay.shipping,u.last_name,u.first_name, c.affiliate, count(shipping_date) AS shipping_count,count(s.id) AS sensor_count ".
               " FROM payments pay ".
               " LEFT JOIN contract_payments cp ON pay.id = cp.payment_id ".
               " LEFT JOIN contracts c ON cp.contract_id = c.id ".
               " LEFT JOIN users u ON c.user_id = u.id ".
               " LEFT JOIN plans p ON c.plan_id = p.id ".
               " LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               " LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " GROUP BY pay.id,pay.title,pay.price,pay.shipping,u.last_name,u.first_name,c.affiliate".
               " ORDER BY pay.id DESC;";
               */
        $sql = "SELECT pay.id,pay.price,u.last_name,u.first_name,c.affiliate,st.store_name,ag.agent_name, (
        SELECT title + ',' FROM plans p 
        LEFT JOIN contracts c ON c.plan_id = p.id
        LEFT JOIN contract_payments cp ON c.id = cp.contract_id
        WHERE cp.payment_id = pay.id
        FOR XML PATH ('')
        ) AS title,
        count(shipping_date) AS shipping_count,
        count(s.id) AS sensor_count 
        FROM payments pay
        LEFT JOIN contract_payments cp ON cp.payment_id = pay.id
        LEFT JOIN contract_sensors cs ON cs.contract_id = cp.contract_id 
        LEFT JOIN sensors s ON cs.sensor_id = s.id 
        LEFT JOIN contracts c ON c.id = cp.contract_id
        LEFT JOIN agents ag ON c.affiliate = ag.agent_code
        LEFT JOIN stores st ON ag.store_id = st.id
        LEFT JOIN users u ON c.user_id = u.id
        WHERE pay.price > 0
        GROUP BY pay.id,pay.price,c.affiliate,u.last_name,
                 u.first_name,st.store_name,ag.agent_name;";
        $query = DB::query($sql);
        $results = $query->execute();
        return $results;
    }

    public function getPayments($id) {
        $sql = "SELECT * FROM payments ".
               "  LEFT JOIN users ON users.id = payments.user_id ".
               " INNER JOIN contract_payments cp ON payments.id = cp.payment_id ".
               " INNER JOIN contracts ON cp.contract_id = contracts.id ".
               "  LEFT JOIN plans ON contracts.plan_id = plans.id ".
               " WHERE payments.id= :id";
        $query = DB::query($sql);
        $query->parameters(array('id' => &$id));
        $results = $query->execute();
        return $results;
    }

    public function getSensors($id) {
        $sql = "SELECT *,c.id AS contract_id,s.id AS sensor_id FROM payments p ".
               "  LEFT JOIN users ON users.id = p.user_id ".
               " INNER JOIN contract_payments cp ON p.id = cp.payment_id ".
               " INNER JOIN contracts c ON cp.contract_id = c.id ".
               "  LEFT JOIN plans ON c.plan_id = plans.id ".
               "  LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               "  LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " WHERE plans.type != 'initial' AND plans.type != 'discount'".
               "   AND p.id= :id";
        $query = DB::query($sql);
        $query->parameters(array('id' => &$id));
        $results = $query->execute();
        return $results;
    }
    
    public static function exist_token($token) {
        $count = \Model_Payment::query()->where('token', $token)->count();
        return ($count > 0);
    }
    
    public static function exist_member_id($member_id) {
        $count = \Model_Payment::query()->where('member_id', $member_id)->count();
        return ($count > 0);
    }
    
    public static function find_by_token($token) {
        return Model_Payment::query()
                            ->select('id', 'first_name', 'last_name', 'first_kana', 'last_kana', 'phone', 'email', 'token')
                            ->where('token', '=', $token)
                            ->get();
    }
}