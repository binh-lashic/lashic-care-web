<?php
return [
	'alerts' => [
		'temperature' => [
			'title'       => 'temperature alarm',
			'description' => 'When the room temperature exceeds the set value, the system judges it as abnormal and notifies it.',
		],
		'fire' => [
			'title'       => 'fire alert',
			'description' => 'When the room temperature exceeds 45 degrees, the system judges it as a fire and notifies it.',
		],
		'heatstroke' => [
			'title'       => 'heat stroke alert',
			'description' => 'When the heat stroke indices (WBGT value) exceeds the set value, the system judges that there is a danger of heat stroke and notifies it.',
		],
		'cold' => [
			'title'       => 'sick alert',
			'description' => 'When the risk of sick value exceeds the set value, the system judges that there is a danger of catching a cold and notifies it.',
		],
		'mold_mites' => [
			'title'       => 'mold and tick alert',
			'description' => 'When the mold and tick index exceeds the set value, the system judges that there is a danger of growing them and notifies it.',
		],
		'humidity' => [
			'title'       => 'humidity alert',
			'description' => 'When the indoor humidity exceeds the set value, the system judges it as abnormal and notifies it.',
		],
		'illuminance_daytime' => [
			'title'       => 'illumination alert (daytime)',
			'description' => "When indoor illuminance of daytime (5 o'clock - 22 o'clock) falls below the set value, the system judges it as abnormal and notifies.",
		],
		'illuminance_night' => [
			'title'       => 'illumination alert (night)',
			'description' => "When indoor illuminance late at night (22 o'clock to 5 o'clock) exceeds the set value, the system judges it as abnormal and notifies.",
		],
		'wake_up' => [
			'title'       => 'Average wake up time',
			'description' => 'When the wake-up time deviates more than 3 hours before and after from the wake-up time of the past one month, the system judges it as abnormal and notifies it.',
		],
		'sleep' => [
			'title'       => 'Average sleeping time',
			'description' => 'When the sleeping time deviates more than 3 hours before and after from the sleeping time of the past one month, the system judges it as abnormal and notifies it.',
		],
		'abnormal_behavior' => [
			'title'       => 'abnormal behavior',
			'description' => 'When the system detects an action of 30 minutes or more in a room without lighting, it judges it as abnormal and notifies you.',
		],
		'active_non_detection' => [
			'title'       => 'Undetected',
			'description' => 'When there is no response to the behavior sensor for a fixed time, it judges it as abnormal and notifies it.',
		],
		'disconnection' => [
			'title'       => 'disconnect alert',
			'description' => "When the device can't catch the data from the sensor for more than one hour, it judges as abnormal and notifies.",
		],
		'reconnection' => [
			'title'       => 'resume connection',
			'description' => 'The system notifies you when it can confirm the resumption of data reception from the sensor.',
		],
	],
];

