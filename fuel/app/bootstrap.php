<?php
// Bootstrap the framework DO NOT edit this
require COREPATH.'bootstrap.php';

// Register the autoloader
\Autoloader::register();

/**
 * Your environment.  Can be set to any of the following:
 *
 * Fuel::DEVELOPMENT
 * Fuel::TEST
 * Fuel::STAGING
 * Fuel::PRODUCTION
 */
if(preg_match("/infic.garoo.jp/i", $_SERVER['HTTP_HOST'])) {
	\Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : \Fuel::DEVELOPMENT);
} else {
	\Autoloader::add_classes(array(
	    'Database_Query_Builder' => APPPATH.'classes/database/query/builder.php',
	    'Database_Query_Builder_Select' => APPPATH.'classes/database/query/builder/select.php',
	    'Database_Connection' => APPPATH.'classes/database/connection.php',
	));
	\Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : \Fuel::TEST);
}

// Initialize the framework with the config file.
\Fuel::init('config.php');
