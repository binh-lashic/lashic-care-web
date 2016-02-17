<?php 
class Model_Data extends Orm\Model{
	protected static $_table_name = 'data';

	protected static $_properties = array(
		'id',
        'corporate_id',
        'sensor_id',
        'date',
        'temperature',
        'humidity',
        'illuminance',
        'active',
	);
}
		