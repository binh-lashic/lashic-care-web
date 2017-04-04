<?php

use WindowsAzure\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Table\Models\QueryEntitiesOptions;
use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Table\Models\Entity;
use MicrosoftAzure\Storage\Table\Models\Filters\Filter;

/**
 * Class Model_Base_Storage_Table
 */
abstract class Model_Base_Storage_Table extends Model
{
	const PARTITION_KEY_FIELD = 'PartitionKey';
	const ROW_KEY_FIELD       = 'RowKey';
	const TIMESTAMP_FIELD     = 'Timestamp';

	protected static $_storage_table_timezone = null;

	protected static $_azure_storage_account    = null;
	protected static $_azure_storage_access_key = null;

	protected static $_connection_string = null;
	protected static $_rest_proxy = null;

	/**
	 * 指定されたパーティションキーと行キーを持つ Entity を返す
	 * 取得できなかった場合は null を返す
	 */
	public static function find($partition_key, $row_key) {
		try {
			$result = static::get_rest_proxy()->getEntity(static::$_table_name, $partition_key, $row_key);
			return $result->getEntity();
		} catch(\MicrosoftAzure\Storage\Common\ServiceException $e) {
			$code = $e->getCode();
			if ($code == 404) {
				Log::debug("entity not found. table: [" . static::$_table_name . "] partition_key: [{$partition_key}] row_key:[{$row_key}]", __METHOD__);
				return null;
			}
			throw $e;
		}
	}

	/**
	 * 指定された検索条件に一致する Storage Table の全レコードを取得する
	 * NextPartitionKey, NextRowKey が返ってきた場合は再帰的にリクエストを発行するので 1000 件以上のレコードを取得可能
	 */
	public static function find_all($filter, $entities = [], $next_partition_key = null, $next_row_key = null) {
		$result   = static::execute_query($filter, null, $next_partition_key, $next_row_key);
		$entities = array_merge($entities, self::to_array($result));

		$next_partition_key = $result->getNextPartitionKey();
		$next_row_key       = $result->getNextRowKey();
		if ($next_partition_key && $next_row_key) {
			return static::find_all($filter, $entities, $next_partition_key, $next_row_key);
		} else {
			return $entities;
		}
	}

	/**
	 * 指定された datetime プロパティの指定期間のデータを取得する
	 * 期間の範囲指定方法は以下
	 *      $from <= $datetime_property_name && $datetime_property_name < $to
	 * @param string $partition_key パーティションキー
	 * @param string $datetime_property_name 検索対象プロパティ名
	 * @param \DateTimeImmutable $from 期間開始日時
	 * @param \DateTimeImmutable $to 期間終了日時
	 */
	public static function find_by_datetime_range($partition_key, $datetime_property_name, $from, $to) {
		$to   = static::format_datetime_filter($to);
		$from = static::format_datetime_filter($from);

		$filter = static::PARTITION_KEY_FIELD . " eq '{$partition_key}' and {$datetime_property_name} ge {$from} and {$datetime_property_name} lt {$to}";
		Log::debug("table: [". static::$_table_name . "] filter: [{$filter}]", __METHOD__);

		return static::find_all($filter);
	}

	/**
	 * 指定日より過去に指定された日数分だけレコードを取得する
	 *
	 * @param string $partition_key パーティションキー
	 * @param string $datetime_property_name 検索対象プロパティ名
	 * @param \DateTimeImmutable $datetime 指定日
	 * @param int $days 指定日より遡る日数
	 */
	public static function find_last_days($partition_key, $datetime_property_name, $datetime, $days = 30) {
		# Storage Table は UTC だが検索用フィールドは見た目上 JST になるようにしたデータを設定しているのでタイムゾーンは Asia/Tokyo のままで OK
		$to_date   = $datetime->setTime(0, 0, 0);
		$from_date = $to_date->modify("- {$days} days");

		$to   = static::format_datetime_filter($to_date);
		$from = static::format_datetime_filter($from_date);

		# $from <= $datetime_property_name && $datetime_property_name < $to
		$filter = static::PARTITION_KEY_FIELD . " eq '{$partition_key}' and {$datetime_property_name} ge {$from} and {$datetime_property_name} lt {$to}";

		Log::debug("filter: [{$filter}]", __METHOD__);

		$query_results = static::execute_query($filter);
		return static::to_array($query_results);
	}

	/**
	 * 指定されたレコードに指定されたプロパティが設定済みかどうかを返す
	 * @param \MicrosoftAzure\Storage\Table\Models\Entity $entity
	 * @param string $property_name
	 */
	public static function is_already_set($entity, $property_name) {
		if (!$entity) {
			return false;
		}
		$property = $entity->getProperty($property_name);
		return  $property && $property->getValue();
	}

	/**
	 * 指定された検索条件に一致する Storage Table のレコードを最大 1000 件まで取得する
	 * 1000 件は Storage Table API の一回のリクエストでの最大取得件数による制限値
	 */
	public static function execute_query($filter, $top = null, $next_partition_key = null, $next_row_key = null) {
		$options = new QueryEntitiesOptions();
		if ($next_partition_key && $next_row_key) {
			$options->setNextPartitionKey($next_partition_key);
			$options->setNextRowKey($next_row_key);
		}
		if ($top) {
			$options->setTop($top);
		}
		$options->setFilter(Filter::applyQueryString($filter));
		return static::get_rest_proxy()->queryEntities(static::$_table_name, $options);
	}

	/**
	 * 指定されたテーブルにレコードを保存する
	 * 既にレコードが存在する場合、プロパティが存在すれば更新し、存在しなければ追加する
	 */
	public static function upsert($partition_key, $row_key, array $properties) {
		$entity = static::to_entity($partition_key, $row_key, $properties);
		static::get_rest_proxy()->insertOrMergeEntity(static::$_table_name, $entity);
	}

	/**
	 * 指定されたレコードを指定されたプロパティで更新する
	 * レコードが存在しなかった場合はエラーになる
	 */
	public static function merge_property($partition_key, $row_key, array $properties) {
		$entity = static::to_entity($partition_key, $row_key, $properties);
		$entity->addProperty('updated_at', EdmType::DATETIME, static::pseudo_jst_datetime());
		static::get_rest_proxy()->mergeEntity(static::$_table_name, $entity);
	}

	/**
	 * 指定されたレコードを更新する
	 */
	public static function update_entity($entity, array $properties) {
		$entity = static::set_properties($entity, $properties);
		$entity->addProperty('updated_at', EdmType::DATETIME, static::pseudo_jst_datetime());
		static::get_rest_proxy()->updateEntity(static::$_table_name, $entity);
	}

	/**
	 * 指定された文字列から見た目上 JST 時刻となっている UTC の DateTime 型を返す
	 * (タイムゾーンが UTC で時刻に +9 した DateTime )
	 *
	 * Storage Table 上では日付型プロパティは必ず UTC になる
	 * 通常の JST の DateTime を保存すると自動的に -9 されてしまう
	 * 検索などでの便宜上、見た目だけ JST の形で日付型プロパティを保存したい場合に使う
	 *
	 * @param string|DateTime|DateTimeImmutable $datetime
	 */
	public static function pseudo_jst_datetime($datetime = null) {
		if (!$datetime) {
			# 引数が無い場合は現在日時
			return new DateTime('+9 hours', static::storage_table_timezone());
		}

		# 文字列
		if (is_string($datetime)) {
			return new DateTime($datestring, static::storage_table_timezone());
		}

		# DateTime
		if (is_object($datetime) && $datetime instanceof \DateTime) {
			return $datetime->setTimezone(static::storage_table_timezone())->modify('+9 hours');
		}

		# DateTimeImmutable
		if (is_object($datetime) && $datetime instanceof \DateTimeImmutable) {
			return (new DateTime(null, static::storage_table_timezone()))->setTimestamp($datetime->getTimestamp())->modify('+9 hours');
		}
	}

	/**
	 * 接続用の RestProxy を生成する
	 * 以下の環境変数の設定が必要
	 *
	 * - AZURE_STORAGE_ACCOUNT
	 * - AZURE_STORAGE_ACCESS_KEY
	 */
	protected static function get_rest_proxy() {
		if (is_null(static::$_azure_storage_account)) {
			static::$_azure_storage_account = getenv('AZURE_STORAGE_ACCOUNT');
		}
		if (is_null(static::$_azure_storage_access_key)) {
			static::$_azure_storage_access_key = getenv('AZURE_STORAGE_ACCESS_KEY');
		}
		if (is_null(static::$_connection_string)) {
			static::$_connection_string = "DefaultEndpointsProtocol=https;AccountName=" . static::$_azure_storage_account . ";AccountKey=" . self::$_azure_storage_access_key;
		}
		if (is_null(static::$_rest_proxy)) {
			static::$_rest_proxy = ServicesBuilder::getInstance()->createTableService(static::$_connection_string);
		}
		return static::$_rest_proxy;
	}

	/**
	 * Storage Table 用の DateTimeZone オブジェクト(UTC)を返す
	 */
	protected static function storage_table_timezone() {
		if (is_null(static::$_storage_table_timezone)) {
			static::$_storage_table_timezone = new DateTimeZone('UTC');
		}
		return static::$_storage_table_timezone;
	}

	/**
	 * PHP の DateTime オブジェクトを Storage Table のDateTime 型のプロパティ検索用の文字列にフォーマットして返す
	 */
	protected static function format_datetime_filter($datetime, $trunc_time = false) {
		if ($trunc_time) {
			$datetime_str = $datetime->format('Y-m-d\T00:00:00');
		} else {
			$datetime_str = $datetime->format('Y-m-d\TH:i:s');
		}
		return "datetime'{$datetime_str}'";
	}


	/**
	 * Storage Table へのクエリ実行結果を連想配列に変換して返す
	 */
	protected static function to_array($query_results) {
		$entities = $query_results->getEntities();

		$results = [];
		foreach ($entities as $entity) {
			$result = [];
			foreach ($entity->getProperties() as $name => $value) {
				$result[$name] = $value->getValue();
			}
			$results[] = $result;
		}
		return $results;
	}

	/**
	 * キーと連想配列から Entity オブジェクトを作成する
	 */
	protected static function to_entity($partition_key, $row_key, array $properties) {
		$entity = new Entity();
		$entity->setPartitionKey($partition_key);
		$entity->setRowKey($row_key);

		return static::set_properties($entity, $properties);
	}

	/**
	 * 指定されたエンティティに連想配列で与えられたプロパティを設定する
	 */
	protected static function set_properties(&$entity, array $properties) {
		foreach ($properties as $name => $value) {
			$type = static::get_edm_type($value);
			$entity->addProperty($name, $type, $value);
		}
		return $entity;
	}

	/**
	 * EdmType に変換する
	 */
	protected static function get_edm_type($val) {
		if (is_int($val)) {
			return EdmType::INT32;
		} else if (is_long($val)) {
			return EdmType::INT64;
		} else if (is_float($val)) {
			return EdmType::DOUBLE;
		} else if (is_bool($val)) {
			return EdmType::BOOLEAN;
		} else if (is_string($val)) {
			return EdmType::STRING;
		} else if (is_object($val) && $val instanceof DateTime) {
			return EdmType::DATETIME;
		} else {
			return null;
		}
	}

}
