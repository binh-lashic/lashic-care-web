<?php
/**
 * ライセンスモデル
 * Class Model_License
 *
 */
class Model_License extends Orm\Model {
	protected static $_belongs_to = [
		'sensor_type'
	];
	protected static $_properties = [
		'id',
		'sensor_type_id',
		'name',
		'price',
		'addition_day',
		'created_at',
		'updated_at'
	];

	protected static $_observers = [
		'Orm\Observer_CreatedAt' => [
			'events' => ['before_insert'],
			'mysql_timestamp' => true,
		],
		'Orm\Observer_UpdatedAt' => [
			'events' => ['before_save'],
			'mysql_timestamp' => true,
		],
		"Orm\Observer_Validation" => [
			"events" => ['before_save']
		]
	];
	
	/**
	 * ライセンス種別の一覧を返す
	 */
	public static function get_license_type_name() {
		$licenses = self::query()
			->from_cache(false)
			->related(['sensor_type'])
			->select('id', 'name')
			->order_by('id', 'asc')
			->get();
		
		$license_type_names = array();
		foreach($licenses as $license){
			$license_type_names[$license->id] = $license->name.'('.$license->sensor_type->name.')';
		}
		
		return $license_type_names;
	}
}
