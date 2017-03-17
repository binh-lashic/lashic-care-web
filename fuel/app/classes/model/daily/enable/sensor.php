<?php
/**
 * daily_enable_sensors 用モデル
 */
class Model_Daily_Enable_Sensor extends Orm\Model {
	protected static $_connection = 'batch';
	protected static $_table_name = 'daily_enable_sensors';
	protected static $_properties = [
		'sensor_name',
		'date',
		'sensor_type',
		'wake_up_started_at',
		'wake_up_ended_at',
		'sleep_started_at',
		'sleep_ended_at',
		'last_sleep_time_processed',
		'wake_up_time_processed',
	];

    const MERGE_SQL = <<<SQL
MERGE INTO [daily_enable_sensors] AS t1
USING (
  SELECT
    :sensor_name AS sensor_name,
    :date AS date,
    :sensor_type AS sensor_type,
    :wake_up_started_at AS wake_up_started_at,
    :wake_up_ended_at AS wake_up_ended_at,
    :sleep_started_at AS sleep_started_at,
    :sleep_ended_at AS sleep_ended_at
) AS t2
ON (t1.sensor_name = t2.sensor_name AND t1.date = t2.date)
WHEN NOT MATCHED THEN
  INSERT(sensor_name, date, sensor_type, wake_up_started_at, wake_up_ended_at, sleep_started_at, sleep_ended_at)
  VALUES (t2.sensor_name, t2.date, t2.sensor_type, t2.wake_up_started_at, t2.wake_up_ended_at, t2.sleep_started_at, t2.sleep_ended_at);
SQL;

	/**
	 * レコードを追加する
	 * レコードが既に存在する場合は何もしない
	 * @param array $properties
	 */
	public static function insert(array $properties) {
        $query = DB::query(self::MERGE_SQL);
        $query->parameters($properties);
        return $query->execute('batch');
	}
}
