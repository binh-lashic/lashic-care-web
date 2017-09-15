<?php
/*
 * 過去のセンサーデータ取得API Model
 */
use Fascent\Careeye\Api\Client\Sensor as Sensor;
use Fascent\Careeye\Api\Client\BedSensor as BedSensor;

class Model_Api_Sensors_Dailies extends Model_Api_Base
{
    private $dailies = null;
    private $sensor_name = null;
        
    /*
     * factory
     * 
     * @access public
     * @param string $sensor_name
     * @param string $bedsensor_name
     * @return objiect $this;
     */
    public function factory($sensor_name, $bedsensor_name)
    {
        if ($sensor_name) {
            $this->sensor_name = $sensor_name;
            $this->dailies = new Sensor\Dailies();
        } else if ($bedsensor_name) {
            $this->sensor_name = $bedsensor_name;
            $this->dailies = new Sensor\Dailies();
        }
        return $this;
    }
    
    /**
     * センサーのデータを取得する
     * 
     * @access public
     * @param int $year
     * @param int $month
     * @return array
     */
    public function get($year, $month)
    {
        try {
            $result = null;
            \Log::debug("get dailies data start. sensor_name:[{$this->sensor_name}]", __METHOD__);
                
            if(!$result = $this->dailies->get($this->sensor_name, $year, $month)) {
                throw new Exception("get dailies api failed.");
            }
                
            \Log::debug("get dailies data end. sensor_name:[{$this->sensor_name}] data:" . print_r($result, true), __METHOD__);
            return self::get_contents($result);
                
        } catch (Exception $e) {
            \Log::debug("getting dailies data failed. [". $e->getMessage() . "]", __METHOD__);
            throw new Exception($e->getMessage());
        }
    }
}
