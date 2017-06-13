<?php
return array(
	'tax_rate' => 0.08,
	'shipping' => array(
		array(
			'key' => '沖縄',
			'price' => 800,
		)
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
		'cold_upper_limit' => 60,
		'cold_duration' => 60,
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
		'wake_up_start_time' => 5,
		'wake_up_end_time' => 9,
		'wake_up_threshold' => 5,
		'wake_up_duration' => 30,
		'wake_up_ignore_duration' => 5,
		'sleep_start_time' => 19,
		'sleep_end_time' => 23,
		'sleep_threshold' => 5,
		'sleep_duration' => 30,
		'sleep_ignore_duration' => 5,
	),
	'sensor_levels' => array(
		'temperature' => array(
			array(
				'upper_limit' => 30,
				'lower_limit' => 5,
				'duration' => 60,
			),
			array(
				'upper_limit' => 30,
				'lower_limit' => 5,
				'duration' => 60,
			),
			array(
				'upper_limit' => 30,
				'lower_limit' => 5,
				'duration' => 60,
			),
		),
		'fire' => array(
			array(
				'temperature_upper_limit' => 45,
			),
			array(
				'temperature_upper_limit' => 45,
			),
			array(
				'temperature_upper_limit' => 45,
			),
		),
		'heatstroke' => array(
			array(
				'wbgt_upper_limit' => 31,
				'duration' => 60,
			),
			array(
				'wbgt_upper_limit' => 28,
				'duration' => 60,
			),
			array(
				'wbgt_upper_limit' => 25,
				'duration' => 60,
			),
		),
		'cold' => array(
			array(
				'cold_upper_limit' => 75,
				'duration' => 60,
			),
			array(
				'cold_upper_limit' => 75,
				'duration' => 60,
			),
			array(
				'cold_upper_limit' => 75,
				'duration' => 60,
			),
		),
		'mold_mites' => array(
			array(
				'humidity_upper_limit' => 70,
				'temperature_upper_limit' => 20,
				'duration' => 60,
			),
			array(
				'humidity_upper_limit' => 70,
				'temperature_upper_limit' => 20,
				'duration' => 60,
			),
			array(
				'mold_mites_humidity_upper_limit' => 70,
				'mold_mites_temperature_upper_limit' => 20,
				'mold_mites_duration' => 60,
			),
		),
		'humidity' => array(
			array(
				'upper_limit' => 70,
				'lower_limit' => 40,
				'duration' => 60,
			),
			array(
				'upper_limit' => 70,
				'lower_limit' => 40,
				'duration' => 60,
			),
			array(
				'upper_limit' => 70,
				'lower_limit' => 40,
				'duration' => 60,
			),
		),
		'illuminance_daytime' => array(
			array(
				'lower_limit' => 50,
				'duration' => 60,
				'start_time' => 7,
				'end_time' => 17,
			),
			array(
				'lower_limit' => 50,
				'duration' => 60,
				'start_time' => 7,
				'end_time' => 17,
			),
			array(
				'lower_limit' => 50,
				'duration' => 60,
				'start_time' => 7,
				'end_time' => 17,
			),
		),
		'illuminance_night' => array(
			array(
				'lower_limit' => 30,
				'duration' => 30,
				'start_time' => 0,
				'end_time' => 4,
			),
			array(
				'lower_limit' => 30,
				'duration' => 30,
				'start_time' => 0,
				'end_time' => 4,
			),
			array(
				'lower_limit' => 30,
				'duration' => 30,
				'start_time' => 0,
				'end_time' => 4,
			),
		),
		'wake_up' => array(
			array(
				'start_time' => 5,
				'end_time' => 9,
				'threshold' => 5,
				'duration' => 30,
				'ignore_duration' => 5,
				'delay_duration' => 120,
			),
			array(
				'start_time' => 5,
				'end_time' => 9,
				'threshold' => 5,
				'duration' => 30,
				'ignore_duration' => 5,
				'delay_duration' => 120,
			),
			array(
				'start_time' => 5,
				'end_time' => 9,
				'threshold' => 5,
				'duration' => 30,
				'ignore_duration' => 5,
				'delay_duration' => 120,
			),
		),
		'sleep' => array(
			array(
				'start_time' => 19,
				'end_time' => 23,
				'threshold' => 5,
				'duration' => 30,
				'ignore_duration' => 5,
				'delay_duration' => 120,
			),
			array(
				'start_time' => 19,
				'end_time' => 23,
				'threshold' => 5,
				'duration' => 30,
				'ignore_duration' => 5,
				'delay_duration' => 120,
			),
			array(
				'start_time' => 19,
				'end_time' => 23,
				'threshold' => 5,
				'duration' => 30,
				'ignore_duration' => 5,
				'delay_duration' => 120,
			),
		),
		'abnormal_behavior' => array(
			array(
				'illuminance_threshold' => 50,
				'active_threshold' => 5,
				'duration' => 30,
			),
			array(
				'illuminance_threshold' => 50,
				'active_threshold' => 5,
				'duration' => 30,
			),
			array(
				'illuminance_threshold' => 50,
				'active_threshold' => 5,
				'duration' => 30,
			),
		),
		'active_non_detection' => array(
			array(
				'threshold' => 5,
				'duration' => 60 * 12,
			),
			array(
				'threshold' => 5,
				'duration' => 60 * 12,
			),
			array(
				'threshold' => 5,
				'duration' => 60 * 12,
			),
		),

	),
	'template' => array(
		'alert' =>
			array(
				'temperature' => array(
					'title' => '室内温度異常',
					'description' => 'LASHICセンサーが設置された環境で設定値を上回った（高温）下回った（低温）場合に異常と判断して通知します。',
				),
				'fire' => array(
					'title' => '火事アラート',
					'description' => 'LASHICセンサーが設置された環境で室温が45度を超えた場合に火事と判断して通知します。',
				),
				'heatstroke' => array(
					'title' => '熱中症アラート',
					'description' => 'LASHICセンサーが設置された環境で熱中症指数（WBGT値）が設定値を超えた場合に熱中症の危険があると判断して通知します。',
				),
				'cold' => array(
					'title' => '風邪アラート',
					'description' => 'LASHICセンサーが設置された環境で風邪ひき指数が設定値を超えた場合に風邪をひく危険があると判断して通知します。',
				),
				'mold_mites' => array(
					'title' => 'カビ・ダニアラート',
					'description' => 'LASHICセンサーが設置された環境でカビやダニが発生しやすい環境として、指数が設定値をこえた場合に異常と判断して通知します。',
				),
				'humidity' => array(
					'title' => '室内湿度異常',
					'description' => 'LASHICセンサーが設置された環境で、室内湿度が設定値を設定値を上回った場合に異常と判断して通知します。',
				),
				'illuminance_daytime' => array(
					'title' => '室内照度異常（日中）',
					'description' => 'LASHICセンサーが設置された環境で、日中（5時～22時）の室内照度が設定値を下回った場合に異常と判断して通知します。',
				),
				'illuminance_night' => array(
					'title' => '室内照度異常（深夜）',
					'description' => 'LASHICセンサーが設置された環境で、深夜（22時～5時）の室内照度が設定値を上回った場合に異常と判断して通知します。',
				),
				'wake_up' => array(
					'title' => '平均起床時間遅延',
					'description' => 'LASHICセンサーが設置された環境で、過去一ヶ月の起床時間と前後3時間以上、起床時間がずれた場合に異常と判断して通知します。',
				),
				'sleep' => array(
					'title' => '平均睡眠時間遅延',
					'description' => 'LASHICセンサーが設置された環境で、過去一ヶ月の睡眠時間と前後3時間以上、睡眠時間がずれた場合に異常と判断して通知します。',
				),	
				'abnormal_behavior' => array(
					'title' => '異常行動（夜間行動）',
					'description' => 'LASHICセンサーが設置された環境で、照明がついていない状況で30分以上の行動を感知した場合に異常と判断して通知します。',
				),	
				'active_non_detection' => array(
					'title' => '一定時間センサー未感知',
					'description' => 'LASHICセンサーが設置された環境で、設定値を上回って行動センサーに反応がなかった場合に異常と判断して通知します。',
				),
				'disconnection' => array(
					'title' => '接続断アラート',
					'description' => 'LASHICセンサーが設置された環境で、センサーからのデータが一時間以上受信できない場合に異常と判断して通知します。',
				),
				'reconnection' => array(
					'title' => 'センサー接続再開通知',
					'description' => 'LASHICセンサーが設置された環境で、センサーからのデータ受信の再開を確認できた場合に通知します。',
				),
		),
	),
	'report_list_count' => 10,
	'sendgrid' => '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',
	'email' => array(
		'domain' => 'lashic.jp',
		'info' => 'info@lashic.jp',
		'master' => 'master@lashic.jp',
		'from' => 'info@lashic.jp',
		'noreply' => 'noreply@lashic.jp',
		'templates' => array(
			'user_update' => array(
				'subject' => "ユーザ情報更新",
				'text'	  => "ユーザ情報が更新されました",
			),
		),
	),
	'eras' => array(
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
	'gender' => array(
		"m" => "男性",
		"f" => "女性",
	),

	'months' => array_combine(range(1, 12), range(1, 12)),

	'days' => array_combine(range(1, 31), range(1, 31)),
    
	'sensor_type' => [
		'parent' => '親機',
		'sensor' => 'センサー',
		'wifi' => 'WiFi',
		'bedsensor' => 'ベッドセンサー',
	],
    
	'blood_type' => [
                'A' => 'A型' ,
                'B' => 'B型',
                'O' => 'O型',
                'AB' => 'AB型',
         ],
);
