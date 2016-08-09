<?php 
class Model_Contract_Payment extends Orm\Model{
	protected static $_properties = array(
		'id',
		'contract_id',
		'payment_id',
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

	protected static $_belongs_to = array('payment'=> array(
        'model_to' => 'Model_Payment',
        'key_from' => 'payment_id',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ));
    
	public static function saveContractPayment($params) {
		if(isset($params['id'])) {
	    	$contract_payment = \Model_Contract_Payment::find($params['id']);
		} else {
			if(isset($params['contract_id'])){
				$contract_id = $params['contract_id'];				
			}
			$contract_payment = \Model_Contract_Payment::find("first", array(
				"where" => array(
					"contract_id" => $contract_id,
					"payment_id" => $params['payment_id'],
				)
			));
			if(empty($contract_payment)) {
				$contract_payment = \Model_Contract_Payment::forge();
			}
		}
    	if($contract_payment) {
    		unset($params['q']);
    		unset($params['id']);
    		$contract_payment->set($params);
    		if($contract_payment->save(false)) {
    			return $contract_payment;
    		}
    	}
    	return null;
    }

    public static function getContractPayment($params) {
		if(!empty($params['id'])) {
	    	$contract_payment = \Model_Contract_Payment::find($params['id']);
		} else {
			if(isset($params['contract_id'])){
				$contract_id = $params['contract_id'];				
			} else {
				list(, $contract_id) = Auth::get_contract_id();
			}

			$contract_payment = \Model_Contract_Payment::find("first", array(
				"where" => array(
					"contract_id" => $contract_id,
					"payment_id" => $params['payment_id'],
				),
				'related' => array('payment'),
			));
		}
		if(isset($contract_payment)) {
			$contract_payment = $contract_payment->to_array();
		} else {
			$payment = \Model_Payment::find($params['payment_id']);
			if(!empty($payment)) {
				$contract_payment['payment'] = $payment->to_array();
			}
		}
    	return \Model_Contract_Payment::format($contract_payment);
    }

    public static function deleteContractPayment($params) {
		if(isset($params['id'])) {
	    	$contract_payment = \Model_Contract_Payment::find($params['id']);
		} else {
			$contract_payment = \Model_Contract_Payment::find("first", array(
				"where" => array(
					"contract_id" => $params['contract_id'],
					"payment_id" => $params['payment_id'],
				)
			));
		}
    	if($contract_payment) {
    		if($contract_payment->delete(false)) {
    			return $contract_payment;
    		}
    	}
    	return null;
    }

    public static function format($params) {
		$ret = array();
		$keys = array(
			'contract_id',
			'payment_id',
		);

		foreach($keys as $key) {
			if(isset($params[$key])) {
				$ret[$key] = $params[$key];
			}
		}
		if(isset($params['payment'])) {
			$ret = array_merge($ret, $params['payment']);
		}
		return $ret;
	}
}