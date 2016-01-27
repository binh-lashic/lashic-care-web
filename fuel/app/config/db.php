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
      'dsn' => 'sqlsrv:server = tcp:infic-test.database.windows.net,1433; Database = infic_test',
      'username' => 'infic-test',
      'password' => '2scHOVO6',
      'persistent' => false,
    ),
    'identifier' => '',
    'table_prefix' => '',
    'charset' => NULL,
  ),
  'data' => array(
    'type' => 'pdo', // PDO を利用
    'connection' => array(
      'dsn' => 'sqlsrv:server = tcp:j1ot5wy793.database.windows.net,1433; Database = infic_db',
      'username' => 'qyNFJoQegELogin_infic-api',
      'password' => 'Zm87el320546zZ$$',
      'persistent' => false,
    ),
    'identifier' => '',
    'table_prefix' => '',
    'charset' => NULL,
  ),
);
