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
);
