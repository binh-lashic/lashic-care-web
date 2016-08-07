<?php 
class Model_Contract extends Orm\Model{

	protected static $_properties = array(
		'id',
        'user_id',
        'plan_id',
        'client_user_id',
        'sensor_id',
        'start_date',
        'end_date',
        'renew_date',
        'price',
        'shipping',
        'status',
        'updated_at',
        'created_at',
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

    public function getSearch() {
        $sql = "SELECT c.*,u.last_name,u.first_name,p.title ".
               "  FROM contracts c ".
               "  LEFT JOIN users u ON c.user_id = u.id".
               "  LEFT JOIN plans p ON c.plan_id = p.id".
               "  ORDER BY c.id DESC;";
        $query = DB::query($sql);
        $results = $query->execute();
        return $results;
    }

    public function getUsers()
    {
        $sql = "SELECT c.*,u.last_name,u.first_name,p.title ".
               "  FROM contracts c ".
               "  LEFT JOIN users u ON c.user_id = u.id".
               "  LEFT JOIN plans p ON c.plan_id = p.id".
               "  ORDER BY c.id DESC;";
        $query = DB::query($sql);
        $rows = $query->execute();
        $results = array();
        foreach($rows as $row)
        {
            $results[] = $row['user_id'];
        }
        return array_unique($results);
    }

    public static function getSensors($contract_id) {
        $sensors = array();
        if($contract_id) {
            $rows = \Model_Contract_Sensor::find("all", array(
                'where' => array(
                    'contract_id' => $contract_id,
                ),
                'related' => array(
                    'sensor' => array(
                        'order_by' => array('name' => 'asc'),
                    )
                ),
            ));
            foreach($rows as $row) {
                $contract_sensor = $row->to_array();
                $contract_sensor['id'] = $contract_sensor['sensor_id'];
                unset($contract_sensor['contract_id']);
                unset($contract_sensor['sensor_id']);
                if(isset($contract_sensor['sensor'])) {
                    $sensor = $contract_sensor['sensor'];
                    unset($contract_sensor['sensor']);
                    $sensors[] = array_merge($sensor, $contract_sensor);
                } else {
                    $sensors[] = $contract_sensor;
                }               
            }
        }
        return $sensors;
    }
}