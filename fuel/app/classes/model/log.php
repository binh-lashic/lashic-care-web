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
}