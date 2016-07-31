<?php 
class Model_Contract extends Orm\Model{

	protected static $_properties = array(
		'id',
        'user_id',
        'plan_id',
        'client_user_id',
        'sensor_id',
        'start_date',
        'end_date',
        'renew_date',
        'price',
        'shipping',
        'status',
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
        /*
        $sql = "SELECT p.id plan_id, p.title plan_title,o.id option_id, o.title option_title, o.price option_price, o.continuation option_continuation  ".
               "  FROM (plans p INNER JOIN plan_options po ON p.id = po.plan_id) INNER JOIN options o ON po.option_id = o.id".
               " WHERE p.id = :plan_id;";
        */
        $sql = "SELECT c.*,u.last_name,u.first_name,p.title ".
               " FROM contracts c ".
               " LEFT JOIN users u ON c.user_id = u.id".
               " LEFT JOIN plans p ON c.plan_id = p.id".
               " ORDER BY c.id DESC;";
        $query = DB::query($sql);
        //$query->parameters(array('plan_id' => $id));
        $results = $query->execute();
        return $results;
    }

}