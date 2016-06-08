<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=infic',
			'username'   => 'infic',
			'password'   => 'Vb6HZWqK',
		),
		'identifier'   => '`',
        'profiling' => true,
	),

	'data' => array(
		'connection'  => array(
			'dsn'        => 'mysql:host=localhost;dbname=infic',
			'username'   => 'infic',
			'password'   => 'Vb6HZWqK',
		),
		'identifier'   => '`',
        'profiling' => true,
	),
);