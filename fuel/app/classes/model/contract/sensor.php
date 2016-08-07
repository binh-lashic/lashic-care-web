<?php 
class Model_Contract_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'contract_id',
		'sensor_id',
        'created_at',
        'updated_at',
	);

    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('before_save'),
            'mysql_timestamp' => true,
        ),
    );

	protected static $_belongs_to = array('sensor'=> array(
        'model_to' => 'Model_Sensor',
        'key_from' => 'sensor_id',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ));
    
	public static function saveContractSensor($params) {
		if(isset($params['id'])) {
	    	$contract_sensor = \Model_Contract_Sensor::find($params['id']);
		} else {
			if(isset($params['contract_id'])){
				$contract_id = $params['contract_id'];				
			} else {
				list(, $contract_id) = Auth::get_contract_id();
			}
			$contract_sensor = \Model_Contract_Sensor::find("first", array(
				"where" => array(
					"contract_id" => $contract_id,
					"sensor_id" => $params['sensor_id'],
				)
			));
			if(empty($contract_sensor)) {
				$contract_sensor = \Model_Contract_Sensor::forge();
			}
		}
    	if($contract_sensor) {
    		unset($params['q']);
    		unset($params['id']);
    		$contract_sensor->set($params);
    		if($contract_sensor->save(false)) {
    			return $contract_sensor;
    		}
    	}
    	return null;
    }

    public static function getContractSensor($params) {
		if(!empty($params['id'])) {
	    	$contract_sensor = \Model_Contract_Sensor::find($params['id']);
		} else {
			if(isset($params['contract_id'])){
				$contract_id = $params['contract_id'];				
			} else {
				list(, $contract_id) = Auth::get_contract_id();
			}

			$contract_sensor = \Model_Contract_Sensor::find("first", array(
				"where" => array(
					"contract_id" => $contract_id,
					"sensor_id" => $params['sensor_id'],
				),
				'related' => array('sensor'),
			));
		}
		if(isset($contract_sensor)) {
			$contract_sensor = $contract_sensor->to_array();
		} else {
			$sensor = \Model_Sensor::find($params['sensor_id']);
			if(!empty($sensor)) {
				$contract_sensor['sensor'] = $sensor->to_array();
			}
		}
    	return \Model_Contract_Sensor::format($contract_sensor);
    }

    public static function deleteContractSensor($params) {
		if(isset($params['id'])) {
	    	$contract_sensor = \Model_Contract_Sensor::find($params['id']);
		} else {
			$contract_sensor = \Model_Contract_Sensor::find("first", array(
				"where" => array(
					"contract_id" => $params['contract_id'],
					"sensor_id" => $params['sensor_id'],
				)
			));
		}
    	if($contract_sensor) {
    		if($contract_sensor->delete(false)) {
    			return $contract_sensor;
    		}
    	}
    	return null;
    }

    public static function format($params) {
		$ret = array();
		$keys = array(
			'contract_id',
			'sensor_id',
		);

		foreach($keys as $key) {
			if(isset($params[$key])) {
				$ret[$key] = $params[$key];
			} else {
				$ret[$key] = "1";
			}
		}
		if(isset($params['sensor'])) {
			$ret = array_merge($ret, $params['sensor']);
		}
		return $ret;
	}
}