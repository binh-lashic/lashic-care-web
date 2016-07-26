<?php 
class Model_Option extends Orm\Model{
	protected static $_properties = array(
		'id',
		'title',
		'price',
		'continuation' => array('default' => 1),
		'free_period',
	);

	public static function getOption($id){
		try {
			$plan = \Model_Option::find($id);
		} catch(Exception $e) {
			return null;
		}
		if($plan) {
			return \Model_Option::format($plan);
		} else {
			return null;
		}	
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
		$options = \Model_Option::find('all', $query);
		return $options;
	}
}