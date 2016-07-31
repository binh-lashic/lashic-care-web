<?php 
class Model_Plan extends Orm\Model{
	protected static $_properties = array(
		'id',
		'title',
		'end_time',
		'start_time',
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

	public static function getPlan($id){
		$sql = "SELECT p.id plan_id, p.title plan_title,o.id option_id, o.title option_title, o.price option_price, o.continuation option_continuation  ".
               "  FROM (plans p INNER JOIN plan_options po ON p.id = po.plan_id) INNER JOIN options o ON po.option_id = o.id".
               " WHERE p.id = :plan_id;";
        $query = DB::query($sql);
        $query->parameters(array('plan_id' => $id));
        $results = $query->execute();
        $price = 0;
        foreach($results as $result) {
        	$plan['id'] = $result['plan_id'];
        	$plan['title'] = $result['plan_title'];
        	$plan['options'][] = array(
        		'id' => $result['option_id'],
        		'title' => $result['option_title'],
        		'price' => $result['option_price'],
        		'continuation' => $result['option_continuation'],
        	);
        	$price += $result['option_price'];
        }
        $plan['price'] = $price;
        return $plan;
	}

	public static function getSearch($params) {
		$query = array(
			'where' => array(
				array('title', 'LIKE', '%'.$params['query'].'%'),
			),
			'order_by' => array('title' => 'desc')
		);
		if(!empty($params['limit'])) {
			$query['limit'] = $params['limit'];
			if(!empty($params['page']) && $params['page'] > 1) {
				$query['offset'] = $params['limit'] * ($params['page'] - 1);
			}
		}
		$plans = \Model_Plan::find('all', $query);
		return $plans;
	}
}