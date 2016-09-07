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

    public function getSearch() {
        $sql = "SELECT pay.id,pay.title,pay.price,pay.shipping,u.last_name,u.first_name,p.title AS plan_title,c.affiliate, count(shipping_date) AS shipping_count,count(s.id) AS sensor_count ".
               " FROM payments pay INNER JOIN contract_payments cp ON pay.id = cp.payment_id ".
               "INNER JOIN contracts c ON cp.contract_id = c.id ".
               " LEFT JOIN users u ON c.user_id = u.id ".
               " LEFT JOIN plans p ON c.plan_id = p.id ".
               " LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               " LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " GROUP BY pay.id,pay.title,pay.price,pay.shipping,u.last_name,u.first_name".
               " ORDER BY pay.id DESC;";
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
}