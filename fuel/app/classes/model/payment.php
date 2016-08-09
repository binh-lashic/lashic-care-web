<?php 
class Model_Payment extends Orm\Model{

	protected static $_properties = array(
		'id',
        'user_id',
        'title',
        'date',
        'price',
        'shipping',
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
        $sql = "SELECT p.*,u.last_name,u.first_name ".
               "  FROM payments p ".
               "  LEFT JOIN users u ON p.user_id = u.id".
               "  ORDER BY p.id DESC;";
        $query = DB::query($sql);
        $results = $query->execute();
        return $results;
    }

}