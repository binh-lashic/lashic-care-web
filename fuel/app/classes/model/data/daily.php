<?php 
class Model_Data_Daily extends Orm\Model{
	protected static $_table_name = 'data_daily';

	protected static $_properties = array(
		'id',
        'sensor_id',
        'date',
        'wake_up_time',
        'sleep_time',
    );
}
		