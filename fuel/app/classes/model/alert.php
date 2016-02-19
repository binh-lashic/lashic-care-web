<?php 
class Model_Alert extends Orm\Model{
	protected static $_properties = array(
		'id',
		'title',
		'sensor_id',
		'date',
		'reason',
		'confirm_status',
		'confirm_user_id',
		'confirm_date',
		'responder_user_id',
		'corresponding_type',
		'expected_description',
		'description',
		'corresponding_status',
		'manager_confirm_status',
		'corresponding_date',
		'corresponding_time',
		'corresponding_description',
		'corresponding_user_id',
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
  reason NTEXT,
  confirm_status INT,
  confirm_user_id INT, 
  confirm_date DATE, 
  responder_user_id INT, 
  corresponding_type INT, 
  expected_description NTEXT, 
  description NTEXT, 
  corresponding_status INT, 
  manager_confirm_status INT, 
  corresponding_date DATE, 
  corresponding_time TIME, 
  corresponding_description NTEXT, 
  corresponding_user_id INT
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

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
		if(isset($params['sensor_id'])) {
			$sensor_id = $params['sensor_id'];
		} else if(isset($params['client_user_id'])) {
			$sensors = \Model_Sensor::getSensorsFromClientUserId($params['client_user_id']);
			$sensor_id = $sensors[0]['id'];
		}

		if(isset($params['date'])) {
			$start_date = $params['date'];
		} else {
			$start_date = date("Y-m-d");
		}

		$end_date = $start_date." 23:59:59";
		$start_date = $start_date." 00:00:00";

		if($sensor_id) {
			$_alerts = \Model_Alert::query()
				->where('sensor_id', $sensor_id)
				->where('date', 'between', array($start_date, $end_date))
	        	->get();
		}

		if($_alerts) {
			foreach($_alerts as $_alert) {
				$alerts[] = $_alert;
			}
		}
		return $alerts;
	}

	public static function saveAlert($params) {
		//sensor_id,date
		if(isset($params['id'])) {
	    	$alert = \Model_Alert::find($params['id']);
		} else {
			$alert = \Model_Alert::forge();
		}

		unset($params['q']);
		unset($params['id']);
		$alert->set($params);
		if($alert->save()) {
			return $alert;
		}
	
    	return null;
    }
}