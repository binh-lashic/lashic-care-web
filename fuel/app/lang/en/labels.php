<?php
return [
	'ok'     => 'OK',
	'cancel' => 'Cancel',
	'edit'   => 'Edit',
	'date' => [
		'abbr_month_names' => [
			'jan' => 'Jan.',
			'feb' => 'Feb.',
			'mar' => 'Mar.',
			'apr' => 'Apr.',
			'may' => 'May ',
			'jun' => 'Jun.',
			'jul' => 'Jul.',
			'aug' => 'Aug.',
			'sep' => 'Sep.',
			'oct' => 'Oct.',
			'nov' => 'Nov.',
			'dec' => 'Dec.',
		],
		'abbr_day_names' => [
			'sun' => 'Sun.',
			'mon' => 'Mon.',
			'tue' => 'Tue.',
			'wed' => 'Wed.',
			'thu' => 'Thu.',
			'fri' => 'Fri.',
			'sat' => 'Sat.',
		],
		'day_names' => [
			'sun' => 'Sunday',
			'mon' => 'Monday',
			'tue' => 'Tuesday',
			'wed' => 'Wednesday',
			'thu' => 'Thursday',
			'fri' => 'Friday',
			'sat' => 'Saturday',
		],
		'today' => 'Today',
		'prompts' => [
			'year' => ''
		],
		'format' => [
			'ymd' => 'm/d/Y'
		]
	],
	'sensor_data' => [
		'titles' => [
			'time_of_awakening'         => 'Time of awakening',
			'time_of_sleep'             => 'Time of sleep',
			'time_of_awakening_abbr'    => 'Time of awakening',
			'time_of_sleep_abbr'        => 'Time of sleep',
			'average_time_of_awakening' => 'average',
			'average_time_of_sleep'     => 'average',
			'temperature'               => 'Temperature',
			'humidity'                  => 'Humidity',
			'amount_of_exercise'        => 'Amount of Exercise',
			'illuminance'               => 'Illuminance',
			'risk_of_cold'              => 'Risk of cold',
		]
	],
	'alerts' => [
		'temperature' => [
			'title'       => '室内温度異常',
			'description' => 'LASHICセンサーが設置された環境で設定値を上回った（高温）下回った（低温）場合に異常と判断して通知します。',
		],
		'fire' => [
			'title'       => '火事アラート',
			'description' => 'LASHICセンサーが設置された環境で室温が45度を超えた場合に火事と判断して通知します。',
		],
		'heatstroke' => [
			'title'       => '熱中症アラート',
			'description' => 'LASHICセンサーが設置された環境で熱中症指数（WBGT値）が設定値を超えた場合に熱中症の危険があると判断して通知します。',
		],
		'cold' => [
			'title'       => '風邪アラート',
			'description' => 'LASHICセンサーが設置された環境で風邪ひき指数が設定値を超えた場合に風邪をひく危険があると判断して通知します。',
		],
		'mold_mites' => [
			'title'       => 'カビ・ダニアラート',
			'description' => 'LASHICセンサーが設置された環境でカビやダニが発生しやすい環境として、指数が設定値をこえた場合に異常と判断して通知します。',
		],
		'humidity' => [
			'title'       => '室内湿度異常',
			'description' => 'LASHICセンサーが設置された環境で、室内湿度が設定値を設定値を上回った場合に異常と判断して通知します。',
		],
		'illuminance_daytime' => [
			'title'       => '室内照度異常（日中）',
			'description' => 'LASHICセンサーが設置された環境で、日中（5時～22時）の室内照度が設定値を下回った場合に異常と判断して通知します。',
		],
		'illuminance_night' => [
			'title'       => '室内照度異常（深夜）',
			'description' => 'LASHICセンサーが設置された環境で、深夜（22時～5時）の室内照度が設定値を上回った場合に異常と判断して通知します。',
		],
		'wake_up' => [
			'title'       => '平均起床時間遅延',
			'description' => 'LASHICセンサーが設置された環境で、過去一ヶ月の起床時間と前後3時間以上、起床時間がずれた場合に異常と判断して通知します。',
		],
		'sleep' => [
			'title'       => '平均睡眠時間遅延',
			'description' => 'LASHICセンサーが設置された環境で、過去一ヶ月の睡眠時間と前後3時間以上、睡眠時間がずれた場合に異常と判断して通知します。',
		],
		'abnormal_behavior' => [
			'title'       => '異常行動（夜間行動）',
			'description' => 'LASHICセンサーが設置された環境で、照明がついていない状況で30分以上の行動を感知した場合に異常と判断して通知します。',
		],
		'active_non_detection' => [
			'title'       => '一定時間センサー未感知',
			'description' => 'LASHICセンサーが設置された環境で、設定値を上回って行動センサーに反応がなかった場合に異常と判断して通知します。',
		],
		'disconnection' => [
			'title'       => '接続断アラート',
			'description' => 'LASHICセンサーが設置された環境で、センサーからのデータが一時間以上受信できない場合に異常と判断して通知します。',
		],
		'reconnection' => [
			'title'       => 'センサー接続再開通知',
			'description' => 'LASHICセンサーが設置された環境で、センサーからのデータ受信の再開を確認できた場合に通知します。',
		],
	],
	'header' => [
		'client' => [
			'select_user'                => 'Select User',
			'menu'                       => 'MENU',
			'user_state'                 => 'State',
			'honorific_title'            => '',
			'confirm_report'             => 'Confirmation and report',
			'notice'                     => 'Notice',
			'uncorresponding_items'      => 'Uncorresponding items (:count items)',
			'user_management'            => 'User Edit',
			'my_page'                    => 'My Page',
			'purchase_payment_histories' => 'Purchase and payment histories',
			'alert_notification'         => 'Setting change of alert notification',
			'q_and_a'                    => 'Q &amp; A',
			'logout'                     => 'Logout',
			'cart'                       => 'Shopping Cart',
			'cart_is_empty'              => 'Your Shopping Cart is empty.',
		]
	],
	'template' => [
		'news'    => 'Information',
		'terms'   => 'Terms of Use',
		'company' => 'Operating Company',
		'privacy' => 'Privacy policy',
		'help'    => 'Q &amp; A',
		'contact' => 'Contact Us',
	],
	'sidebar' => [
		'basic_data'        => 'Basic Data',
		'age_format'        => '(Age: :age)',
		'blood_type_format' => ':blood_type',
		'contact_sharing'   => 'Sharing',
		'birthday'          => 'Birthday',
		'blood_type'        => 'Blood type',
		'address'           => 'Address',
		'phone_number_1'    => 'Phone number 1',
		'phone_number_2'    => 'Phone number 2',
		'emergency_contact' => 'Emergency contact number',
	],
	'user' => [
		'index' => [
			'user_state_of'             => 'The State of :user_name',
			'current_graph'             => 'Current Graph',
			'24_hour_graph'             => '24 hour graph',
			'choose_the_date'           => 'Choose the date',
			'choose_the_year_month'     => 'Choose the year and month',
			'item_selection'            => 'Item selection',
		]
	],
];
