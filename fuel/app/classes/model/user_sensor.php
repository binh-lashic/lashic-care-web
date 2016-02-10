<?php 
class Model_User_Sensor extends Orm\Model{
	protected static $_has_one = array('sensor'=> array(
        'model_to' => 'Model_Sensor',
        'key_from' => 'sensor_id',
        'key_to' => 'id',
        'cascade_save' => true,
        'cascade_delete' => false,
    ));
}