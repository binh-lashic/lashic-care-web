<?php
return [
	'alerts' => [
		'temperature' => [
			'title'       => '室内温度異常',
			'description' => 'LASHIC-roomが設置された環境で設定値を上回った（高温）下回った（低温）場合に異常と判断して通知します。',
		],
		'fire' => [
			'title'       => '火事アラート',
			'description' => 'LASHIC-roomが設置された環境で室温が45度を超えた場合に火事と判断して通知します。',
		],
		'heatstroke' => [
			'title'       => '熱中症アラート',
			'description' => 'LASHIC-roomが設置された環境で熱中症指数（WBGT値）が設定値を超えた場合に熱中症の危険があると判断して通知します。',
		],
		'cold' => [
			'title'       => '風邪アラート',
			'description' => 'LASHIC-roomが設置された環境で風邪ひき指数が設定値を超えた場合に風邪をひく危険があると判断して通知します。',
		],
		'mold_mites' => [
			'title'       => 'カビ・ダニアラート',
			'description' => 'LASHIC-roomが設置された環境でカビやダニが発生しやすい環境として、指数が設定値をこえた場合に異常と判断して通知します。',
		],
		'humidity' => [
			'title'       => '室内湿度異常',
			'description' => 'LASHIC-roomが設置された環境で、室内湿度が設定値を設定値を上回った場合に異常と判断して通知します。',
		],
		'illuminance_daytime' => [
			'title'       => '室内照度異常（日中）',
			'description' => 'LASHIC-roomが設置された環境で、日中（5時～22時）の室内照度が設定値を下回った場合に異常と判断して通知します。',
		],
		'illuminance_night' => [
			'title'       => '室内照度異常（深夜）',
			'description' => 'LASHIC-roomが設置された環境で、深夜（22時～5時）の室内照度が設定値を上回った場合に異常と判断して通知します。',
		],
		'wake_up' => [
			'title'       => '平均起床時間遅延',
			'description' => 'LASHIC-roomが設置された環境で、過去一ヶ月の起床時間と前後3時間以上、起床時間がずれた場合に異常と判断して通知します。',
		],
		'sleep' => [
			'title'       => '平均睡眠時間遅延',
			'description' => 'LASHIC-roomが設置された環境で、過去一ヶ月の睡眠時間と前後3時間以上、睡眠時間がずれた場合に異常と判断して通知します。',
		],
		'abnormal_behavior' => [
			'title'       => '異常行動（夜間行動）',
			'description' => 'LASHIC-roomが設置された環境で、照明がついていない状況で30分以上の行動を感知した場合に異常と判断して通知します。',
		],
		'active_non_detection' => [
			'title'       => '一定時間センサー未感知',
			'description' => 'LASHIC-roomが設置された環境で、設定値を上回って行動センサーに反応がなかった場合に異常と判断して通知します。',
		],
		'disconnection' => [
			'title'       => '接続断アラート',
			'description' => 'LASHIC-roomが設置された環境で、センサーからのデータが一時間以上受信できない場合に異常と判断して通知します。',
		],
		'reconnection' => [
			'title'       => 'センサー接続再開通知',
			'description' => 'LASHIC-roomが設置された環境で、センサーからのデータ受信の再開を確認できた場合に通知します。',
		],
	],
];
