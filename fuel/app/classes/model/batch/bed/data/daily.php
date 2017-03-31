<?php
/**
 * bed_data_daily 用モデル
 */
class Model_Batch_Bed_Data_Daily extends Orm\Model {
	protected static $_connection = 'batch';
	protected static $_table_name = 'bed_data_daily';
	protected static $_properties = [
		'id',
		'sensor_name',
		'parent_sensor_name',
		'humans',
		'motion',
		'posture',
		'sleep',
		'rolling',
		'pulse',
		'measurement_time',
		'created_at',
	];

	protected static $_observers = [
		'Orm\Observer_CreatedAt' => [
			'events' => ['before_insert'],
			'mysql_timestamp' => true,
		],
		"Orm\Observer_Validation" => [
			"events" => ['before_save']
		]
	];

	/**
	 * 指定されたセンサー名のうち、指定された時間以降にデータが飛んできているセンサーのセンサー名・親センサー名をまとめた配列を返す
	 * @param array $sensor_names
	 * @param string $datetime Y-m-d H:i:s 形式の日付文字列
	 */
	public static function get_enabled_sensor_names_by_measurement_time_after(array $sensor_names, $datetime) {
		$enabled_sensors = DB::select('sensor_name')
							->select('parent_sensor_name')
							->from(static::$_table_name)
							->where('measurement_time', '>=', $datetime)
							->where('sensor_name', 'IN', $sensor_names)
							->group_by('sensor_name', 'parent_sensor_name')
							->execute('batch')->as_array('sensor_name');
		$result = [];
		foreach ($enabled_sensors as $sensor) {
			$result[] = $sensor['sensor_name'];
			$result[] = $sensor['parent_sensor_name'];
		}
		return \Arr::unique($result);
	}

	/**
	 * 指定された期間内に計測された有効且つ未処理のセンサーデータをセンサー名毎の配列として返す
	 * @param string $date 検索対象日。Y-m-d 形式の JST 日付文字列
	 * @param string $start_date_col_name 開始時間のカラム名
	 * @param string $end_date_col_name 終了時間のカラム名
	 * @param string $flag_col_name 処理済みフラグのカラム名
	 */
	public static function find_sleep_by_measurement_time($date, $start_date_col_name, $end_date_col_name, $flag_col_name) {
		$sensor_data = DB::select_array(['bed_data_daily.sensor_name', 'sleep', 'measurement_time'])
			->from(static::$_table_name)
			->join('daily_enable_sensors')
			->on('daily_enable_sensors.sensor_name', '=', 'bed_data_daily.sensor_name')
			->and_on('date', '=', DB::expr("'" . $date . "'"))
			->and_on('sensor_type', 'IN', DB::expr('(' . Model_Sensor::FACILITY_TYPE_BED_SENSOR_1 . ',' . Model_Sensor::FACILITY_TYPE_BED_SENSOR_2 . ')'))
			->and_on(DB::expr($flag_col_name), '=', 0)
			->where('measurement_time', 'BETWEEN', [DB::expr($start_date_col_name), DB::expr($end_date_col_name)])
			->order_by('bed_data_daily.sensor_name', 'ASC')
			->order_by('measurement_time', 'ASC')
			->execute('batch')
			->as_array();

		# 取得したデータをセンサー名毎にグルーピングする
		$results = [];
		foreach ($sensor_data as $data) {
			$key = $data['sensor_name'];
			if (array_key_exists($key, $results)) {
				$results[$key][] = $data;
			} else {
				$results[$key] = [$data];
			}
		}
		return $results;
	}
}
