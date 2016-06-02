<?php 
class Model_Alert extends Orm\Model{
	protected static $_properties = array(
		'id',
		'sensor_id',
		'title',
		'description',
		'date',
		'category',
		'type',
		'reason',
		'confirm_status',
		'confirm_user_id',
		'confirm_date',
		'responder_user_id',
		'corresponding_type',
		'expected_description',
		'corresponding_status',
		'report_description',
		'manager_confirm_status',
		'corresponding_date',
		'corresponding_time',
		'corresponding_description',
		'corresponding_user_id',
		'expiration_time',
		'snooze_count'
	);

	public static function createTable(){
		try {
		    DB::query("DROP TABLE alerts")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE alerts (
  id INT NOT NULL IDENTITY (1, 1),
  title NVARCHAR(255),
  sensor_id INT,
  date DATETIME,
  category NVARCHAR(50),
  type NVARCHAR(50),
  reason NTEXT,
  confirm_status INT DEFAULT 0,
  confirm_user_id INT, 
  confirm_date DATE, 
  responder_user_id INT, 
  corresponding_type INT, 
  expected_description NTEXT, 
  description NTEXT, 
  corresponding_status INT, 
  report_description NTEXT, 
  manager_confirm_status INT,
  corresponding_date DATE, 
  corresponding_time TIME, 
  corresponding_description NTEXT, 
  corresponding_user_id INT,
  expiration_time DATETIME
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	protected static $_has_one = array('confirm_user'=> array(
        'model_to' => 'Model_User',
        'key_from' => 'confirm_user_id',
        'key_to' => 'id',
        'cascade_save' => false,
        'cascade_delete' => false,
    ));

	public static function getAlert($id){
		$sensor = \Model_Alert::find($id);
		if($sensor) {
			return $sensor;
		} else {
			return null;
		}	
	}

	public static function getAlerts($params){
		$alerts = array();
		
		$query = \Model_Alert::buildQuery($params);
		if(!empty($query)) {
			
			if(!empty($params['limit'])) {
				$query = $query->limit($params['limit']);
				if(!empty($params['page']) && $params['page'] > 2) {
					$query = $query->offset($params['limit'] * ($params['page'] - 1));
				}
			}

	 		$_alerts = $query->related("confirm_user")->order_by('id', 'desc')->get();

			if($_alerts) {
				foreach($_alerts as $_alert) {
					$alert = $_alert->to_array();
					if(!empty($alert['confirm_user'])) {
						$alert['confirm_user'] = Model_User::format($alert['confirm_user']);
					}

					$alerts[] = $alert;
				}
			}

		}
		return $alerts;
	}

	public static function getAlertCount($params){
		$alert_count = 0;
		$query = \Model_Alert::buildQuery($params);
		unset($query->confirm_user);
		if(!empty($query)) {
			$alert_count = $query->count();
		}
		return $alert_count;
	}

	public static function buildQuery($params) {
		if(isset($params['sensor_id'])) {
			$sensor_id = $params['sensor_id'];
		} else if(isset($params['client_user_id'])) {
			$sensors = \Model_Sensor::getSensorsFromClientUserId($params['client_user_id']);
			$sensor_id = $sensors[0]['id'];
		}

		if(isset($params['date'])) {
			$start_date = $params['date'];
			$end_date = $start_date." 23:59:59";
		} else {
			$start_date = date("Y-m-d", strtotime("-3months"));
			$end_date = date("Y-m-d H:i:s");
		}

		$start_date = $start_date." 00:00:00";

		if(!empty($sensor_id)) {
			$query = \Model_Alert::query()
				->where('sensor_id', $sensor_id)
				->where('date', 'between', array($start_date, $end_date));

			if(isset($params['confirm_status']) && $params['confirm_status'] !== "") {
				$query->where('confirm_status', $params['confirm_status']);
			}
			if(isset($params['corresponding_status']) && $params['corresponding_status'] !== "") {
				$query->where('corresponding_status', $params['corresponding_status']);
			}
	       	return $query;
		}
		return null;
	}

	public static function saveAlert($params) {
		//sensor_id,date
		if(isset($params['id'])) {
	    	$alert = \Model_Alert::find($params['id']);
		} else {
			$alert = \Model_Alert::forge();
		}

		if(isset($params['confirm_status'])) {
			list(, $user_id) = Auth::get_user_id();
			$params['confirm_user_id'] = $user_id;
		}
		if(isset($params['expiration_hour'])) {
			$params['expiration_time'] = date("Y-m-d H:i:s", time() + $params['expiration_hour'] * 60 * 60);
		}

		$data = json_encode($params);
		unset($params['q']);
		unset($params['id']);
		$alert->set($params);
		if($alert->save()) {
			$params = array(
				'data' => $data,
				'description' => "alertを更新しました",
			);
			\Model_Log::saveLog($params);
			return $alert;
		}
	
    	return null;
    }
	//スヌーズ範囲にデータがある場合はアラートしない
    public static function getLatestAlert($params) {
    	if(!empty($params['sensor_id'])) {
    		$query['sensor_id'] = $params['sensor_id'];
    	}
    	if(!empty($params['type'])) {
    		$query['type'] = $params['type'];
    	}
    	$alert = \Model_Alert::find('first', array(
    		'where' => array(
    			array('date', ">=", date("Y-m-d H:i:s", time() - 60 * 60 * 24))
    		),
    		'order_by' => array('date' => 'desc'),
    	));

		if(!empty($alert['expiration_time'])) {
			if(strtotime($alert['expiration_time']) < time()) {
				return null;
			}
			
		}
    	return $alert;
    }

	//スヌーズ範囲にデータがある場合はアラートしない
    public static function existsAlert($params) {
    	$query = array(array('date', ">=", date("Y-m-d H:i:s", time() - 60 * 60 * 24)));
    	if(!empty($params['sensor_id'])) {
    		$query['sensor_id'] = $params['sensor_id'];
    	}
    	if(!empty($params['type'])) {
    		$query['type'] = $params['type'];
    	}
    	$alert = \Model_Alert::find('first', array(
    		'where' => $query,
    		'order_by' => array('date' => 'desc'),
    	));
    	return $alert;
    }

	public static function pushAlert($params) {
		try {
			require_once APPPATH.'vendor/ApnsPHP/Autoload.php';

			$push = new ApnsPHP_Push(ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION, APPPATH.'vendor/ApnsPHP/certificates/careeye_push.pem');
	        $push->setRootCertificationAuthority(APPPATH.'vendor/ApnsPHP/certificates/entrust_root_certification_authority.pem');
	        $push->connect();

	        $message = new ApnsPHP_Message($params['push_id']);
	        $message->setText($params['text']);
	        $message->setSound();
	        $message->setExpiry(30);
	        $push->add($message);
	        $push->send();
	        $push->disconnect();
		} catch(Exception $e) {

		}
	}
}