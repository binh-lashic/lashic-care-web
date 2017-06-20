<?php
return [
	'ok'     => 'OK',
	'cancel' => 'キャンセル',
	'edit'   => '編集',
	'date' => [
		'abbr_month_names' => [
			'jan' => '1月',
			'feb' => '2月',
			'mar' => '3月',
			'apr' => '4月',
			'may' => '5月',
			'jun' => '6月',
			'jul' => '7月',
			'aug' => '8月',
			'sep' => '9月',
			'oct' => '10月',
			'nov' => '11月',
			'dec' => '12月',
		],
		'abbr_day_names' => [
			'sun' => '日',
			'mon' => '月',
			'tue' => '火',
			'wed' => '水',
			'thu' => '木',
			'fri' => '金',
			'sat' => '土',
		],
		'day_names' => [
			'sun' => '日曜日',
			'mon' => '月曜日',
			'tue' => '火曜日',
			'wed' => '水曜日',
			'thu' => '木曜日',
			'fri' => '金曜日',
			'sat' => '土曜日',
		],
		'today' => '今日',
		'prompts' => [
			'year' => '年'
		],
		'format' => [
			'ymd' => 'Y年m月d日'
		]
	],
	'sensor_data' => [
		'titles' => [
			'time_of_awakening'         => '起床時間',
			'time_of_sleep'             => '就寝時間',
			'time_of_awakening_abbr'    => '起床',
			'time_of_sleep_abbr'        => '就寝',
			'average_time_of_awakening' => '平均起床時間',
			'average_time_of_sleep'     => '平均就寝時間',
			'temperature'               => '室温',
			'humidity'                  => '湿度',
			'amount_of_exercise'        => '運動量',
			'illuminance'               => '照度',
			'risk_of_cold'              => '風邪ひき指数',
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
			'select_user'                => 'ユーザー選択',
			'menu'                       => 'メニュー',
			'user_state'                 => 'ユーザーの様子',
			'honorific_title'            => 'さん',
			'confirm_report'             => '確認・報告',
			'notice'                     => 'お知らせ',
			'uncorresponding_items'      => 'その他未対応事項（:count件）',
			'user_management'            => 'ユーザー管理',
			'my_page'                    => 'マイページ',
			'purchase_payment_histories' => '購入・支払い履歴',
			'alert_notification'         => 'アラート通知設定変更',
			'q_and_a'                    => 'Q &amp; A',
			'logout'                     => 'ログアウト',
			'cart'                       => 'カート',
			'cart_is_empty'              => '何も入っていません',
		]
	],
	'template' => [
		'news'    => '運営者からのお知らせ',
		'terms'   => '利用規約',
		'company' => '運営会社',
		'privacy' => 'プライバシーポリシー',
		'help'    => 'Q&amp;A',
		'contact' => 'お問い合わせ',
	],
	'sidebar' => [
		'basic_data'        => '基本データ',
		'age_format'        => '（:age歳）',
		'blood_type_format' => ':blood_type型',
		'contact_sharing'   => '連絡共有',
		'birthday'          => '生年月日',
		'blood_type'        => '血液型',
		'address'           => '住所',
		'phone_number_1'    => '電話番号1',
		'phone_number_2'    => '電話番号2',
		'emergency_contact' => '緊急連絡先',
	],
	'user' => [
		'index' => [
			'user_state_of'             => ':user_nameさんの様子',
			'current_graph'             => '現在のグラフ',
			'24_hour_graph'             => '24時間グラフ',
			'choose_the_date'           => '表示日設定',
			'choose_the_year_month'     => '年月を選択してください',
			'item_selection'            => 'グラフ表示項目選択',
		]
	],
];

