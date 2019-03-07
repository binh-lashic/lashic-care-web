<?php 
class Contract_Status {
    const UNKNOWN = 0;          //不明
    const UNALLOCATED = 1;      //未割当
    const UNSHIPPED = 2;        //未出荷
    const SHIPPED = 3;          //出荷済
    const ACTIVE = 4;           //稼働済
    const CANCEL = 5;           //解約申込済
    const CANCELED = 6;         //解約済
    const RETURNED= 7;          //返却済

    public function get() {
        return array(
            Contract_Status::UNSHIPPED => '未出荷',
            Contract_Status::SHIPPED => '出荷済',
            Contract_Status::ACTIVE => '稼働済',
            Contract_Status::CANCEL => '解約申込済',
            Contract_Status::CANCELED => '解約済',
            Contract_Status::RETURNED => '返却済',
        );
    }
}

class Model_Contract extends Orm\Model{

    protected static $_properties = array(
        'id',
        'user_id',
        'plan_id',
        'client_user_id',
        'start_date',
        'end_date',
        'renew_date',
        'price',
        'shipping',
        'status',
        'zip_code',
        'prefecture',
        'address',
        'affiliate',
        'remarks',
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


    public function format($data) {
        $statuses = Contract_Status::get();
        if(isset($statuses[$data['status']])) {
            $data['status_label'] = $statuses[$data['status']];
        } else {
            $data['status_label'] = '不明';
        }
        return $data;
    }

    protected static $_has_one = array(
        'plan' => array(
            'key_from' => 'plan_id',
            'model_to' => 'Model_Plan',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

    public function getSearch($params) {
        $sql = "SELECT c.id,c.price,c.shipping,c.start_date,c.renew_date,c.end_date,c.status,u.last_name,u.first_name,p.title,c.affiliate,p.type,count(s.shipping_date) AS shipping_count,count(s.id) AS sensor_count ".
               " FROM contracts c ".
               " LEFT JOIN users u ON c.user_id = u.id ".
               " LEFT JOIN plans p ON c.plan_id = p.id ".
               " LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               " LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " WHERE p.type != 'initial' AND p.type != 'discount'";
        if(!empty($params['status'])) {
            $sql .= " AND status = '".$params['status']."'";
        }

        if(isset($params['client_user_id'])) {
            $sql .= " AND c.client_user_id = ".$params['client_user_id'];
        }
        $sql .= " GROUP BY c.id,c.price,c.shipping,c.start_date,c.renew_date,c.end_date,c.status,u.last_name,u.first_name,p.title,p.type,c.affiliate,u.last_name,u.first_name ".
               " ORDER BY c.id DESC;";

        $query = DB::query($sql);
        $_results = $query->execute();
        $results = array();
        foreach($_results as $result) {
            $results[] = \Model_Contract::format($result);
        }
        return $results;
    }

    public function getClients($params) {
        $sql = "SELECT c.id,c.price,c.shipping,c.start_date,c.renew_date,c.client_user_id,u.last_name,u.first_name,u.last_kana,u.first_kana,p.title,c.affiliate,p.type,count(s.shipping_date) AS shipping_count,count(s.id) AS sensor_count ".
               " FROM contracts c ".
               " LEFT JOIN users u ON c.client_user_id = u.id ".
               " LEFT JOIN plans p ON c.plan_id = p.id ".
               " LEFT JOIN contract_sensors cs ON c.id = cs.contract_id ".
               " LEFT JOIN sensors s ON cs.sensor_id = s.id ".
               " WHERE p.type != 'initial' AND p.type != 'discount'";
        if(isset($params['user_id'])) {
            $sql .= " AND c.user_id = ".$params['user_id'];
        }
        $sql .= " GROUP BY c.id,c.price,c.shipping,c.start_date,c.renew_date,c.client_user_id,u.last_name,u.first_name,u.last_kana,u.first_kana,p.title,p.type,c.affiliate ".
               " ORDER BY c.id DESC;";

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