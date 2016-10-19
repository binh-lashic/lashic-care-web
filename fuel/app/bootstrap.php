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

\Fuel::$env = (isset($_SERVER['FUEL_ENV']) ? $_SERVER['FUEL_ENV'] : \Fuel::PRODUCTION);
//if (\Fuel::$env === \Fuel::PRODUCTION || \Fuel::$env === \Fuel::STAGING) {
	\Autoloader::add_classes(array(
	    'Database_Query_Builder' => APPPATH.'classes/database/query/builder.php',
	    'Database_Query_Builder_Select' => APPPATH.'classes/database/query/builder/select.php',
	    'Database_Query_Builder_Delete' => APPPATH.'classes/database/query/builder/delete.php',
	    'Database_Connection' => APPPATH.'classes/database/connection.php',
	    'Auth_Login_Simpleauth' => APPPATH.'classes/auth/classes/auth/login/simpleauth.php',
	));
//}

// Initialize the framework with the config file.
\Fuel::init('config.php');
