<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
  'default' => array(
    'type' => 'pdo', // PDO を利用
    'connection' => array(
      'dsn'        => $_SERVER['DEFAULT_DSN'],
      'username'   => $_SERVER['DEFAULT_USERNAME'],
      'password'   => $_SERVER['DEFAULT_PASSWORD'],
      'persistent' => false,
    ),
    'identifier' => '',
    'table_prefix' => '',
    'charset' => NULL,
  ),
  'data' => array(
    'type' => 'pdo', // PDO を利用
    'connection' => array(
      'dsn'        => $_SERVER['DATA_DSN'],
      'username'   => $_SERVER['DATA_USERNAME'],
      'password'   => $_SERVER['DATA_PASSWORD'],
      'persistent' => false,
    ),
    'identifier' => '',
    'table_prefix' => '',
    'charset' => NULL,
  ),
  // 施設版のバッチ用データベースに接続するための設定
  'batch' => array(
    'type' => 'pdo',
    'connection' => array(
      'dsn'        => $_SERVER['BATCH_DSN'],
      'username'   => $_SERVER['BATCH_USERNAME'],
      'password'   => $_SERVER['BATCH_PASSWORD'],
      'persistent' => false,
    ),
    'identifier' => '',
    'table_prefix' => '',
    'charset' => NULL,
  ),
  // セッションストアとして使う Redis の設定
  'redis' => array(
    'default' => array(
      'hostname' => $_SERVER['REDIS_HOST'],
      'port'     => $_SERVER['REDIS_PORT'],
      'password' => $_SERVER['REDIS_PASSWORD'],
      'timeout'  => null,
    ),
  ),
  //施設版のDB
  'facility' => array(
    'type' => 'pdo', // PDO を利用
    'connection' => array(
      'dsn'        => 'sqlsrv:server=tcp:lashic-test-infic-facility-db.database.windows.net,1433;Database=lashic-test-infic_facility_db-2019-1-22',
      'username'   => 'facility-admin',
      'password'   => 'xvgdwgf2L1gVAYSF',
      'persistent' => false,
    ),
    'identifier' => '',
    'table_prefix' => '',
    'charset' => NULL,
  ),
);
