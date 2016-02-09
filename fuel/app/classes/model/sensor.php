<?php 
class Model_Sensor extends Orm\Model{

	public static function createTable(){
		$sql = "CREATE TABLE sensors (
  id NVARCHAR(255) NOT NULL IDENTITY (1, 1),
) ON [PRIMARY];";
		return DB::query($sql)->execute();
	}

	public static function getSensor($id){
		$sql = "SELECT * FROM sensors WHERE id = :id;";
		$query = DB::query($sql);
		$query->parameters(array('id' => $id));
		$res = $query->execute();
		if($res[0]) {
			return $res[0];
		} else {
			return null;
		}	
	}
}