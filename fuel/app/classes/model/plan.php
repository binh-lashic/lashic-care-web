<?php 
class Model_Plan extends Orm\Model{
	protected static $_properties = array(
		'id',
		'title',
        'type',
        'span',
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

    protected static $_many_many = array(
        'options' => array(
            'key_from' => 'id',
            'key_through_from' => 'plan_id', // テーブル間のカラム1は、posts.idと一致する必要があります
            'table_through' => 'plan_options', // アルファベット順にプレフィックスなしの複数のmodel双方に
            'key_through_to' => 'option_id', // テーブル間のカラム2は、users.idと一致する必要があります
            'model_to' => 'Model_Option',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

	public static function getPlan($id){
		$sql = "SELECT p.id plan_id, p.title plan_title,p.type plan_type, p.span plan_span, o.id option_id, o.title option_title, o.price option_price, o.continuation option_continuation,".
               "o.unit_price option_unit_price  ".
               "  FROM (plans p INNER JOIN plan_options po ON p.id = po.plan_id) INNER JOIN options o ON po.option_id = o.id".
               " WHERE p.id = :plan_id;";
        $query = DB::query($sql);
        $query->parameters(array('plan_id' => $id));
        $results = $query->execute();
        $price = 0;
        foreach($results as $result) {
        	$plan['id'] = $result['plan_id'];
        	$plan['title'] = $result['plan_title'];
            $plan['type'] = $result['plan_type'];
            $plan['span'] = $result['plan_span'];
        	$plan['options'][] = array(
        		'id' => $result['option_id'],
        		'title' => $result['option_title'],
        		'price' => $result['option_price'],
                'unit_price' => $result['option_unit_price'],
                'tilte' => $result['unit_price'],
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