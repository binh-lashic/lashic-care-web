<?php 
class Model_Device extends Orm\Model{

	public static function create(){
		$sql = "CREATE TABLE devices (
  id int NOT NULL IDENTITY (1, 1),
  user_id INT,
  device_id NVARCHAR(255)
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}
}