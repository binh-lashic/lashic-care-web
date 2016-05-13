<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

return array(

	/**
	 * base_url - The base URL of the application.
	 * MUST contain a trailing slash (/)
	 *
	 * You can set this to a full or relative URL:
	 *
	 *     'base_url' => '/foo/',
	 *     'base_url' => 'http://foo.com/'
	 *
	 * Set this to null to have it automatically detected.
	 */
	// 'base_url'  => null,

	/**
	 * url_suffix - Any suffix that needs to be added to
	 * URL's generated by Fuel. If the suffix is an extension,
	 * make sure to include the dot
	 *
	 *     'url_suffix' => '.html',
	 *
	 * Set this to an empty string if no suffix is used
	 */
	// 'url_suffix'  => '',

	/**
	 * index_file - The name of the main bootstrap file.
	 *
	 * Set this to 'index.php if you don't use URL rewriting
	 */
	// 'index_file' => false,

	// 'profiling'  => false,

	/**
	 * Default location for the file cache
	 */
	// 'cache_dir'       => APPPATH.'cache/',

	/**
	 * Settings for the file finder cache (the Cache class has it's own config!)
	 */
	// 'caching'         => false,
	// 'cache_lifetime'  => 3600, // In Seconds

	/**
	 * Callback to use with ob_start(), set this to 'ob_gzhandler' for gzip encoding of output
	 */
	// 'ob_callback'  => null,

	// 'errors'  => array(
		// Which errors should we show, but continue execution? You can add the following:
		// E_NOTICE, E_WARNING, E_DEPRECATED, E_STRICT to mimic PHP's default behaviour
		// (which is to continue on non-fatal errors). We consider this bad practice.
		// 'continue_on'  => array(),
		// How many errors should we show before we stop showing them? (prevents out-of-memory errors)
		// 'throttle'     => 10,
		// Should notices from Error::notice() be shown?
		// 'notices'      => true,
		// Render previous contents or show it as HTML?
		// 'render_prior' => false,
	// ),

	/**
	 * Localization & internationalization settings
	 */
	// 'language'           => 'en', // Default language
	// 'language_fallback'  => 'en', // Fallback language when file isn't available for default language
	// 'locale'             => 'en_US', // PHP set_locale() setting, null to not set

	/**
	 * Internal string encoding charset
	 */
	// 'encoding'  => 'UTF-8',

	/**
	 * DateTime settings
	 *
	 * server_gmt_offset	in seconds the server offset from gmt timestamp when time() is used
	 * default_timezone		optional, if you want to change the server's default timezone
	 */
	// 'server_gmt_offset'  => 0,
	// 'default_timezone'   => null,

	/**
	 * Logging Threshold.  Can be set to any of the following:
	 *
	 * Fuel::L_NONE
	 * Fuel::L_ERROR
	 * Fuel::L_WARNING
	 * Fuel::L_DEBUG
	 * Fuel::L_INFO
	 * Fuel::L_ALL
	 */
	// 'log_threshold'    => Fuel::L_WARNING,
	// 'log_path'         => APPPATH.'logs/',
	// 'log_date_format'  => 'Y-m-d H:i:s',
	'log_threshold'    => Fuel::L_ALL,

	/**
	 * Security settings
	 */
	'security' => array(
		// 'csrf_autoload'    => false,
		// 'csrf_token_key'   => 'fuel_csrf_token',
		// 'csrf_expiration'  => 0,

		/**
		 * A salt to make sure the generated security tokens are not predictable
		 */
		// 'token_salt'            => 'put your salt value here to make the token more secure',

		/**
		 * Allow the Input class to use X headers when present
		 *
		 * Examples of these are HTTP_X_FORWARDED_FOR and HTTP_X_FORWARDED_PROTO, which
		 * can be faked which could have security implications
		 */
		// 'allow_x_headers'       => false,

		/**
		 * This input filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 */
		'uri_filter'       => array('htmlentities'),

		/**
		 * This input filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 */
		// 'input_filter'  => array(),

		/**
		 * This output filter can be any normal PHP function as well as 'xss_clean'
		 *
		 * WARNING: Using xss_clean will cause a performance hit.
		 * How much is dependant on how much input data there is.
		 */
		'output_filter'  => array('Security::htmlentities'),

		/**
		 * Encoding mechanism to use on htmlentities()
		 */
		// 'htmlentities_flags' => ENT_QUOTES,

		/**
		 * Wether to encode HTML entities as well
		 */
		// 'htmlentities_double_encode' => false,

		/**
		 * Whether to automatically filter view data
		 */
		// 'auto_filter_output'  => true,

		/**
		 * With output encoding switched on all objects passed will be converted to strings or
		 * throw exceptions unless they are instances of the classes in this array.
		 */
		'whitelisted_classes' => array(
			'Fuel\\Core\\Presenter',
			'Fuel\\Core\\Response',
			'Fuel\\Core\\View',
			'Fuel\\Core\\ViewModel',
			'Closure',
		),
	),

	/**
	 * Cookie settings
	 */
	// 'cookie' => array(
		// Number of seconds before the cookie expires
		// 'expiration'  => 0,
		// Restrict the path that the cookie is available to
		// 'path'        => '/',
		// Restrict the domain that the cookie is available to
		// 'domain'      => null,
		// Only transmit cookies over secure connections
		// 'secure'      => false,
		// Only transmit cookies over HTTP, disabling Javascript access
		// 'http_only'   => false,
	// ),

	/**
	 * Validation settings
	 */
	// 'validation' => array(
		/**
		 * Wether to fallback to global when a value is not found in the input array.
		 */
		// 'global_input_fallback' => true,
	// ),

	/**
	 * Controller class prefix
	 */
	 // 'controller_prefix' => 'Controller_',

	/**
	 * Routing settings
	 */
	// 'routing' => array(
		/**
		 * Whether URI routing is case sensitive or not
		 */
		// 'case_sensitive' => true,

		/**
		 *  Wether to strip the extension
		 */
		// 'strip_extension' => true,
	// ),

	/**
	 * To enable you to split up your application into modules which can be
	 * routed by the first uri segment you have to define their basepaths
	 * here. By default empty, but to use them you can add something
	 * like this:
	 *      array(APPPATH.'modules'.DS)
	 *
	 * Paths MUST end with a directory separator (the DS constant)!
	 */
	// 'module_paths' => array(
	// 	//APPPATH.'modules'.DS
	// ),

	/**
	 * To enable you to split up your additions to the framework, packages are
	 * used. You can define the basepaths for your packages here. By default
	 * empty, but to use them you can add something like this:
	 *      array(APPPATH.'modules'.DS)
	 *
	 * Paths MUST end with a directory separator (the DS constant)!
	 */
	'package_paths' => array(
		PKGPATH,
	),

	/**************************************************************************/
	/* Always Load                                                            */
	/**************************************************************************/
	 'always_load'  => array(

		/**
		 * These packages are loaded on Fuel's startup.
		 * You can specify them in the following manner:
		 *
		 * array('auth'); // This will assume the packages are in PKGPATH
		 *
		 * // Use this format to specify the path to the package explicitly
		 * array(
		 *     array('auth'	=> PKGPATH.'auth/')
		 * );
		 */
		 'packages'  => array(
		 	'orm',
			'auth',
		 ),

		/**
		 * These modules are always loaded on Fuel's startup. You can specify them
		 * in the following manner:
		 *
		 * array('module_name');
		 *
		 * A path must be set in module_paths for this to work.
		 */
		// 'modules'  => array(),

		/**
		 * Classes to autoload & initialize even when not used
		 */
		// 'classes'  => array(),

		/**
		 * Configs to autoload
		 *
		 * Examples: if you want to load 'session' config into a group 'session' you only have to
		 * add 'session'. If you want to add it to another group (example: 'auth') you have to
		 * add it like 'session' => 'auth'.
		 * If you don't want the config in a group use null as groupname.
		 */
		// 'config'  => array(),

		/**
		 * Language files to autoload
		 *
		 * Examples: if you want to load 'validation' lang into a group 'validation' you only have to
		 * add 'validation'. If you want to add it to another group (example: 'forms') you have to
		 * add it like 'validation' => 'forms'.
		 * If you don't want the lang in a group use null as groupname.
		 */
		// 'language'  => array(),

	),
	'blood_types' => array(
		'A',
		'B',
		'AB',
		'O',
		'A (Rh-)',
		'B (Rh-)',
		'AB (Rh-)',
		'O (Rh-)',
	),
	'sensor_default_setting' => array(
		'temperature_upper_limit' => 30,
		'temperature_lower_limit' => 5,
		'temperature_duration' => 60,
		'fire_temperature_upper_limit' => 45,
		'heatstroke_wbgt_upper_limit' => 28,
		'heatstroke_duration' => 60,
		'humidity_upper_limit' => 70,
		'humidity_lower_limit' => 40,
		'humidity_duration' => 60,
		'mold_mites_humidity_upper_limit' => 70,
		'mold_mites_temperature_upper_limit' => 20,
		'mold_mites_duration' => 60,
		'illuminance_daytime_lower_limit' => 50,
		'illuminance_daytime_duration' => 60,
		'illuminance_daytime_start_time' => 7,
		'illuminance_daytime_end_time' => 17,
		'illuminance_night_lower_limit' => 30,
		'illuminance_night_duration' => 30,
		'illuminance_night_start_time' => 0,
		'illuminance_night_end_time' => 4,
		'disconnection_duration' => 60,
		'wake_up_period' => 30,
		'wake_up_delay_allowance_duration' => 120,
	),
	'report_list_count' => 10,
	'sendgrid' => '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',
	'email' => array(
		'from' => 'info@careeye.jp',
		'templates' => array(
			'user_update' => array(
				'subject' => "ユーザ情報更新",
				'text'	  => "ユーザ情報が更新されました",
			),
		),
	),
	'eras' => array(
		"1900" => "1900/明治33",
		"1901" => "1901/明治34",
		"1902" => "1902/明治35",
		"1903" => "1903/明治36",
		"1904" => "1904/明治37",
		"1905" => "1905/明治38",
		"1906" => "1906/明治39",
		"1907" => "1907/明治40",
		"1908" => "1908/明治41",
		"1909" => "1909/明治42",
		"1910" => "1910/明治43",
		"1911" => "1911/明治44",
		"1912" => "1912/大正元",
		"1913" => "1913/大正2",
		"1914" => "1914/大正3",
		"1915" => "1915/大正4",
		"1916" => "1916/大正5",
		"1917" => "1917/大正6",
		"1918" => "1918/大正7",
		"1919" => "1919/大正8",
		"1920" => "1920/大正9",
		"1921" => "1921/大正10",
		"1922" => "1922/大正11",
		"1923" => "1923/大正12",
		"1924" => "1924/大正13",
		"1925" => "1925/大正14",
		"1926" => "1926/大正15",
		"1927" => "1927/昭和2",
		"1928" => "1928/昭和3",
		"1929" => "1929/昭和4",
		"1930" => "1930/昭和5",
		"1931" => "1931/昭和6",
		"1932" => "1932/昭和7",
		"1933" => "1933/昭和8",
		"1934" => "1934/昭和9",
		"1935" => "1935/昭和10",
		"1936" => "1936/昭和11",
		"1937" => "1937/昭和12",
		"1938" => "1938/昭和13",
		"1939" => "1939/昭和14",
		"1940" => "1940/昭和15",
		"1941" => "1941/昭和16",
		"1942" => "1942/昭和17",
		"1943" => "1943/昭和18",
		"1944" => "1944/昭和19",
		"1945" => "1945/昭和20",
		"1946" => "1946/昭和21",
		"1947" => "1947/昭和22",
		"1948" => "1948/昭和23",
		"1949" => "1949/昭和24",
		"1950" => "1950/昭和25",
		"1951" => "1951/昭和26",
		"1952" => "1952/昭和27",
		"1953" => "1953/昭和28",
		"1954" => "1954/昭和29",
		"1955" => "1955/昭和30",
		"1956" => "1956/昭和31",
		"1957" => "1957/昭和32",
		"1958" => "1958/昭和33",
		"1959" => "1959/昭和34",
		"1960" => "1960/昭和35",
		"1961" => "1961/昭和36",
		"1962" => "1962/昭和37",
		"1963" => "1963/昭和38",
		"1964" => "1964/昭和39",
		"1965" => "1965/昭和40",
		"1966" => "1966/昭和41",
		"1967" => "1967/昭和42",
		"1968" => "1968/昭和43",
		"1969" => "1969/昭和44",
		"1970" => "1970/昭和45",
		"1971" => "1971/昭和46",
		"1972" => "1972/昭和47",
		"1973" => "1973/昭和48",
		"1974" => "1974/昭和49",
		"1975" => "1975/昭和50",
		"1976" => "1976/昭和51",
		"1977" => "1977/昭和52",
		"1978" => "1978/昭和53",
		"1979" => "1979/昭和54",
		"1980" => "1980/昭和55",
		"1981" => "1981/昭和56",
		"1982" => "1982/昭和57",
		"1983" => "1983/昭和58",
		"1984" => "1984/昭和59",
		"1985" => "1985/昭和60",
		"1986" => "1986/昭和61",
		"1987" => "1987/昭和62",
		"1988" => "1988/昭和63",
		"1989" => "1989/平成元",
		"1990" => "1990/平成2",
		"1991" => "1991/平成3",
		"1992" => "1992/平成4",
		"1993" => "1993/平成5",
		"1994" => "1994/平成6",
		"1995" => "1995/平成7",
		"1996" => "1996/平成8",
		"1997" => "1997/平成9",
		"1998" => "1998/平成10",
		"1999" => "1999/平成11",
		"2000" => "2000/平成12",
		"2001" => "2001/平成13",
		"2002" => "2002/平成14",
		"2003" => "2003/平成15",
		"2004" => "2004/平成16",
		"2005" => "2005/平成17",
		"2006" => "2006/平成18",
		"2007" => "2007/平成19",
		"2008" => "2008/平成20",
		"2009" => "2009/平成21",
		"2010" => "2010/平成22",
		"2011" => "2011/平成23",
		"2012" => "2012/平成24",
		"2013" => "2013/平成25",
		"2014" => "2014/平成26",
		"2015" => "2015/平成27",
		"2016" => "2016/平成28",
	),
	'prefectures' => array(
		"北海道",
		"青森県",
		"岩手県",
		"宮城県",
		"秋田県",
		"山形県",
		"福島県",
		"茨城県",
		"栃木県",
		"群馬県",
		"埼玉県",
		"千葉県",
		"東京都",
		"神奈川県",
		"新潟県",
		"富山県",
		"石川県",
		"福井県",
		"山梨県",
		"長野県",
		"岐阜県",
		"静岡県",
		"愛知県",
		"三重県",
		"滋賀県",
		"京都府",
		"大阪府",
		"兵庫県",
		"奈良県",
		"和歌山県",
		"鳥取県",
		"島根県",
		"岡山県",
		"広島県",
		"山口県",
		"徳島県",
		"香川県",
		"愛媛県",
		"高知県",
		"福岡県",
		"佐賀県",
		"長崎県",
		"熊本県",
		"大分県",
		"宮崎県",
		"鹿児島県",
		"沖縄県",
	),
);
