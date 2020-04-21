<?php 
class Model_Agent extends Orm\Model{

    protected static $_properties = array(
        'store_name',
        'agent_name',
        'start_date',
        'end_date',
        'price',
        'date',
        'agent_code',
        'updated_at',
        'created_at'
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
        $sql = "SELECT c.id,c.price,u.last_name,u.first_name,p.title,
                p.type,st.store_name,ag.agent_name,pay.date".
               " FROM contracts c".
               " LEFT JOIN users u ON c.user_id = u.id".
               " LEFT JOIN plans p ON c.plan_id = p.id".
               " LEFT JOIN agents ag ON c.agent_code = ag.agent_code".
               " LEFT JOIN stores st ON ag.store_id = st.id".
               " LEFT JOIN payments pay ON c.user_id = pay.user_id".
               " WHERE p.type != 'discount'";

        if($params['from']) {
            $sql .= " AND pay.date BETWEEN '". $params['from'] ."' AND '". $params['to'] ."'";
        }

        if($params['store']) {
            $sql .= " AND st.store_name = N'". $params['store']."'";
        }

        if($params['agent']) {
            $sql .= " AND ag.agent_name = N'". $params['agent'] ."'";
        }

        $sql .= " GROUP BY c.id,c.price,u.last_name,u.first_name,p.title,
                  p.type,st.store_name,ag.agent_name,pay.date ".
                " ORDER BY pay.date DESC";
        
        $sql .= " OFFSET ". $params['limit']*($params['page']-1) ." ROWS FETCH NEXT ". $params['limit'] ." ROWS ONLY;";
        
        $query = DB::query($sql);
        $results = $query->execute();
        return $results;
    }

    public function getFilter($params) {
        $sql = "SELECT sum(c.price) as price,p.type,count(p.type) as plan_count".
               " FROM contracts c".
               " LEFT JOIN plans p ON c.plan_id = p.id".
               " LEFT JOIN agents ag ON c.agent_code = ag.agent_code".
               " LEFT JOIN stores st ON ag.store_id = st.id".
               " LEFT JOIN payments pay ON c.user_id = pay.user_id".
               " WHERE p.type != 'discount'";

        if($params['from']) {
            $sql .= " AND pay.date BETWEEN '". $params['from'] ."' AND '". $params['to'] ."'";
        }

        if($params['store']) {
            $sql .= " AND st.store_name = N'". $params['store']."'";
        }

        if($params['agent']) {
            $sql .= " AND ag.agent_name = N'". $params['agent'] ."'";
        }

        $sql .= " GROUP BY p.type;";
        
        $query = DB::query($sql);
        $results = $query->execute();
        return \Model_Agent::formatFilterData($results);
    }

    public function getCsvData($params) {
        $query = DB::select('c.id,c.price,u.last_name,u.first_name,p.title,p.type,st.store_name,ag.agent_name,pay.date')
                    ->from(['contracts', 'c'])
                    ->join(['users', 'u'], 'LEFT')->on('c.user_id', '=', 'u.id')
                    ->join(['plans', 'p'], 'LEFT')->on('c.plan_id', '=', 'p.id')
                    ->join(['agents', 'ag'], 'LEFT')->on('c.agent_code', '=', 'ag.agent_code')
                    ->join(['stores', 'st'], 'LEFT')->on('ag.store_id', '=', 'st.id')
                    ->join(['payments', 'pay'])->on('c.user_id', '=', 'pay.user_id')
                    ->where('p.type', '!=', 'discount');
                    if($params['from']){
                        $query = $query->where('pay.date', 'between', array($params['from'], $params['to']));
                    }
                    if($params['store']){
                        $query = $query->where('st.store_name', '=', $params['store']);
                    }
                    if($params['agent']){
                        $query = $query->where('ag.agent_name', '=', $params['agent']);
                    }
                    $query = $query->order_by('pay.date','DESC')
                    ->execute()->as_array();
        return $query;
    }

    public function getStores() {
        $sql = "SELECT store_name AS name FROM stores";
        $query = DB::query($sql);
        $results = $query->execute();
        return \Model_Agent::formatOptionsData($results);
    }

    public function getAgents() {
        $sql = "SELECT agent_name as name FROM agents";
        $query = DB::query($sql);
        $results = $query->execute();
        return \Model_Agent::formatOptionsData($results);
    }

    public function formatOptionsData($arr) {
        $result = array();
        $result[""] = '---';
        foreach($arr as $val) {
            $result[$val['name']] = $val['name'];
        }
        return $result;
    }

    public function formatFilterData($arr) {
        $result = array();
        foreach($arr as $val) {
            $result[$val['type'].'_price'] = $val['price'];
            $result[$val['type'].'_count'] = $val['plan_count'];
        }
        $result['sum_price'] = $result['continuation_price'] + $result['initial_price'];
        $result['sum_count'] = $result['continuation_count'] + $result['initial_count'];
        return $result;
    }
}