<?php 
class Model_User_Client extends Orm\Model{
	protected static $_properties = array(
		'id',
		'user_id',
		'client_user_id',
	);

	protected static $_has_one = array(
		'client'=> array(
	        'model_to' => 'Model_User',
	        'key_from' => 'client_user_id',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
	    ),
		'admin'=> array(
	        'model_to' => 'Model_User',
	        'key_from' => 'user_id',
	        'key_to' => 'id',
	        'cascade_save' => false,
	        'cascade_delete' => false,
    	)
	);


	public static function createTable(){
		try {
		    DB::query("DROP TABLE user_clients")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE user_clients (
  id INT NOT NULL IDENTITY (1, 1),
  user_id INT NOT NULL,
  client_user_id INT NOT NULL
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

}