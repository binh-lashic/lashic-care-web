<?php 
class Model_Log extends Orm\Model{

	protected static $_properties = array(
		'id',
        'date',
        'user_id',
        'description',
        'data'
	);

    public static function createTable(){
        $sql = "CREATE TABLE logs (
            id int NOT NULL IDENTITY (1, 1),
            date DATETIME,
            user_id int,
            description NTEXT,
            data NTEXT,
        ) ON [PRIMARY];";
        return DB::query($sql)->execute();
    }

    public static function saveLog($params) {
        $log = \Model_Log::forge();
        list(, $user_id) = Auth::get_user_id();
        $params['date'] = date("Y-m-d H:i:s");
        $params['user_id']  = $user_id;
        $log->set($params);
        return $log->save();
    }
}