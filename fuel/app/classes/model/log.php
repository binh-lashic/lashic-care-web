<?php 
class Model_Log extends Orm\Model{

	protected static $_properties = array(
		'id',
        'date',
        'user_id',
        'description',
	);

    public static function createTable(){
        $sql = "CREATE TABLE logs (
            id int NOT NULL IDENTITY (1, 1),
            date DATETIME,
            user_id int,
            description NTEXT,
        ) ON [PRIMARY];";
        return DB::query($sql)->execute();
    }

    public static function saveLog($description) {
        $log = \Model_Alert::forge();
        list(, $user_id) = Auth::get_user_id();
        $params = array(
            'date' => date("Y-m-d H:i:s"),
            'user_id' => $user_id,
            'description' => $description,
        );
        $log->set($params);
        return $log->save();
    }
}