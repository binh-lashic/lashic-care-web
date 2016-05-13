<?php 
class Model_Contract extends Orm\Model{

	protected static $_properties = array(
		'id',
        'user_id',
        'title',
        'sensor_id',
        'description'
	);

    public static function createTable(){
        $sql = "CREATE TABLE contracts (
            id int NOT NULL IDENTITY (1, 1),
            user_id int,
            sensor_id int,
            title NTEXT,
            description NTEXT
        ) ON [PRIMARY];";
        return DB::query($sql)->execute();
    }
}