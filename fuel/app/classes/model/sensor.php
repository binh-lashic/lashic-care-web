<?php 
class Model_Sensor extends Orm\Model{
	protected static $_properties = array(
		'id',
		'name',
	);

	public static function createTable(){
		try {
		    DB::query("DROP TABLE sensors")->execute();
		} catch(Exception $e) {

		}
		$sql = "CREATE TABLE sensors (
  id INT NOT NULL IDENTITY (1, 1),
  name NVARCHAR(50)
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