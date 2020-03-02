<?php
/**
 * ライセンスモデル
 * Class Model_License_Code
 *
 */
class Model_License_Code extends Orm\Model {
	
	// config/db.phpの連想配列のキーを設定する
	protected static $_connection = 'facility';
	
	const STATUS_UNSHIPPED = 0;
	const STATUS_SHIPPED   = 1;
    const STATUS_USED      = 2;
    const STATUS_DELETE    = 3;
	const RETRY_COUNT      = 10;
	
	const STATUS = [
		self::STATUS_UNSHIPPED => '未出荷',
		self::STATUS_SHIPPED   => '出荷済',
        self::STATUS_USED      => '利用済',
        self::STATUS_DELETE    => '削除',
	];
	
	protected static $_belongs_to = [
		'license',
		'sensor'
    ];
    
	protected static $_properties = [
		'id',
		'license_id',
		'code',
        'status',
		'shipping_date',
		'sensor_id',
		'created_at',
		'updated_at'
	];

	protected static $_observers = [
		'Orm\Observer_CreatedAt' => [
			'events'          => ['before_insert'],
			'mysql_timestamp' => true,
		],
		'Orm\Observer_UpdatedAt' => [
			'events'          => ['before_save'],
			'mysql_timestamp' => true,
		],
		"Orm\Observer_Validation" => [
			"events" => ['before_save']
		]
	];
	
	/**
	 * 一括登録
	 * @param $params
	 */
	public static function bulk_register($params)
	{
		$db = Database_Connection::instance('facility');
		try {
			$db->start_transaction();
			$quantity = $params['quantity'];
			$insert_ids = [];
			for($i = 0; $i < $quantity; $i++){
				$sensor = Model_License_Code::forge([
					'license_id'    => $params['license_id'],
					'code'          => self::generate_code(),
					'status'        => self::STATUS_UNSHIPPED,
					'shipping_date' => $params['shipping_date'],
				]);
				$sensor->save();
                $insert_ids[] = $sensor->id;
			}
			$db->commit_transaction();
			
			return $insert_ids;
		} catch(Exception $e) {
			$db->rollback_transaction();
			throw $e;
        }
    }
	
	/**
	 * IDの配列からライセンスコードの一覧の情報を取得する
	 * @param $params
	 */
	public static function get_license_code_by_ids($ids)
	{
		return DB::select('license_codes.*, licenses.*, sensor_types.name as sensor_type_name')
                    ->from('license_codes')
                    ->join('licenses')
                    ->on('license_codes.license_id', '=', 'licenses.id')
                    ->join('sensor_types')
                    ->on('licenses.sensor_type_id', '=', 'sensor_types.id')
                    ->where('license_codes.id', 'in', $ids)
                    ->execute('facility')
                    ->as_array();
	}
	
	/**
	 * ライセンスコードの一覧を取得する
	 * @param null $pagination
	 * @return \Orm\Model|\Orm\Model[]
	 */
	public static function find_all_pagination($pagination = null)
	{
		$condition['order_by'] = [
			'id' => 'desc'
		];
		if (isset($pagination)) {
			$condition['rows_limit']  = $pagination->per_page;
			// どうも最後の一件が削除されて飛んできた場合にオフセットがおかしくなる模様
			$condition['rows_offset'] = $pagination->offset < 0 ? 0 : $pagination->offset;
        }

        return DB::select('licenses.id','licenses.sensor_type_id','licenses.name','licenses.price','licenses.addition_day','licenses.created_at','licenses.updated_at',
        'license_codes.id','license_codes.license_id','license_codes.code','license_codes.status','license_codes.shipping_date','license_codes.sensor_id','license_codes.created_at','license_codes.updated_at',
        'sensor_types.name as sensor_type_name', 'accounts.email')
                    ->limit($condition['rows_limit'])
                    ->offset($condition['rows_offset'])
                    ->from('license_codes')
                    ->join('licenses')
                    ->on('license_codes.license_id', '=', 'licenses.id')
                    ->join('accounts')
                    ->on('license_codes.id', '=', 'accounts.id')
                    ->join('sensor_types')
                    ->on('licenses.sensor_type_id', '=', 'sensor_types.id')
                    ->order_by('license_codes.id','desc')
                    ->execute('facility')
                    ->as_array();
    }
    
    /**
	 * 仮アカウント取得
	 * @param $usersIds
	 */
	public static function get_temporary_account($usersIds)
	{
		return DB::select('email')
                    ->from('license_codes')
                    ->join('users')
                    ->on('license_codes.users_id', '=', 'users.id')
                    ->where('license_codes.id', 'in', $usersIds)
                    ->execute('facility')
                    ->as_array();
	}

	/**
	 * 19桁(ハイフン含む)のライセンスコードを返す
	 * 重複チェックを行い、リトライ回数におさまらない場合エラー
	 * @return string
	 * @throws HttpServerErrorException
	 */
	private static function generate_code()
	{
		$code = \Util_Random::random().'-'.\Util_Random::random().'-'.\Util_Random::random().'-'.\Util_Random::random();
		$retry_count = 0;
		
		while ($retry_count < self::RETRY_COUNT){
			$license_code = Model_License_Code::find_by_code($code);
			if(empty($license_code)){
				return $code;
			}
			$retry_count++;
		}
		
		throw new HttpServerErrorException('generate_code error.');
	}
}