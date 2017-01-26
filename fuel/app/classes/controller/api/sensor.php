<?php
class Controller_Api_Sensor extends Controller_Api
{

	public function before() {
		$this->nologin_methods = array(
			'getTime'
		);
	    parent::before();
	}

	public function post_get() {
		return $this->_get();
	}

	public function get_get() {
		return $this->_get();
	}

	public function _get() {
        list(, $user_id) = Auth::get_user_id();
        $params = array(
            'user_id' => $user_id,
            'sensor_id' => Input::param('id'),
        );
		$sensor = \Model_User_Sensor::getUserSensor($params);
        unset($sensor['active_non_detection_alert']);
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}

	public function post_save() {
		return $this->_save();
	}

	public function get_save() {
		return $this->_save();
	}

	public function _save() {
		$sensor = \Model_Sensor::saveSensor(Input::param());
		$this->result = array(
			'data' => $sensor
		);
 		return $this->result();
	}

	public function get_getTime() {
		$this->_getTime();
	}

	public function post_getTime() {
		$this->_getTime();
	}

	public function _getTime() {
		echo date("YmdHis");
		exit;		
	}

	public function get_sensorData() {
    	$this->_sensorData();
    }

	public function post_sensorData() {
    	$this->_sensorData();
    }
    
	public function _sensorData() {
    	$error = 0;
    	$data = Input::param("data");
    	$params['corporate_id'] = substr($data, 0, 24);
    	$params['sensor_id'] = substr($data, 24, 5);
    	$data_count = substr($data, 29, 1);
    	//print_r($params);
    	$offset = 30;
        for($i = 0; $i < $data_count; $i++) {
        	$offset += 30 * $i;
        }
    	/*
    	\Model_Data::

    var table_data = request.service.tables.getTable('data');


        
        var year   = data.substr(offset,4);
        var month  = data.substr(offset + 4,2);
        var day    = data.substr(offset + 6,2);
        var hour   = data.substr(offset + 8,2);
        var minute = data.substr(offset + 10,2);
        var second = data.substr(offset + 12,2);
        var date = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
 
        var temperature  = data.substr(offset + 14, 4);
        var humidity    = data.substr(offset + 18, 4);
        var illuminance = data.substr(offset + 22, 4);
        var active      = data.substr(offset + 26, 4);

        temperature = (parseInt(temperature, 10)) / 10;
        humidity   = (parseInt(humidity, 10)) / 10;
        illuminance = parseInt(illuminance);
        active = (parseInt(active, 10)) / 10;

        var param = {
            corporate_id: corporate_id,
            sensor_id:    sensor_id,
            date:         date,
            temperature:   temperature,
            humidity:     humidity,
            illuminance:  illuminance,
            active:       active,
        };
        table_data.insert(param, {
            success: function() {},
            error: function(e) {
                error = true;
            }
        });
    }

    */
    	echo $error;
    	exit;
	}

    public function get_sensor_token() {
        $this->_sensor_token();
    }

    public function post_sensor_token() {
        $this->_sensor_token();
    }

    private function _sensor_token() {
        list(, $user_id) = Auth::get_user_id();
        $client_user_id = Input::param('user_id');               
        $user_client = \Model_User_Client::getUserClient($user_id, $client_user_id);
        if (empty($user_client)) {
            $this->errors[] = array('message' => 'センサーへのアクセスの許可がありません');
        } else {
            $sensors = \Model_Sensor::getSensorsFromClientUserId($client_user_id);
            foreach($sensors as $sensor) {
                if ($sensor->type == 'sensor') {
                    $sensor->functions_token = \Util::functions_token($sensor->name);
                } else if ($sensor->type == 'bedsensor') {
                    $sensor->functions_token = \Util::functions_token($sensor->name);
                    $sensor->websocket_token = \Util::websocket_token($sensor->name);
                }
            }
            $this->result = array('sensors' => $sensors);
        } 
        return $this->result();
    }
}

