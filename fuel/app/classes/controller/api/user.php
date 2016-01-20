<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2015 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_ApiUser extends Controller_Rest
{
	protected $format = 'json';
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function get_index()
	{
		// ログインしていないのであればログインを
		if (!Auth::check())
		{
		    $ret = array('message' => 'ログインをしてください');
		}
		else
		{
			$ret = array('success' => true);
		}
		
/*
		$row = DB::query("SELECT * FROM users")->execute();
		$data = $row->as_array();
		$ret = array(
			'success' => true,
			'data' => $data,
		);
		$sql = "";
		/*
		$row = DB::query("SELECT * FROM infic_db.data")->execute();
		$res = $row->as_array();
		print_r($res);
		*/
 		return $this->response($ret);
	}

	public function get_login()
	{
		$username = Input::param("username");
		$password = Input::param("password");
		if (Auth::login($username, $password))
		{
			$ret = array('success' => true);
		}
		else
		{
			$ret = array('success' => false);
		}
		
 		return $this->response($ret);
	}

	public function get_logout()
	{
		Auth::logout();
		$ret = array('success' => true);
		return $this->response($ret);
	}

	public function get_register()
	{
		
		DB::query("DROP TABLE users")->execute();
		$sql = "CREATE TABLE users (
  username NVARCHAR(50),
  password NVARCHAR(255),
  email NVARCHAR(512),
  profile_fields NVARCHAR(512),
  last_login NVARCHAR(512),
  login_hash NVARCHAR(512),
  created_at INT
);";
		DB::query($sql)->execute();

		$username = Input::param("username");
		$password = Input::param("password");
	    if (Input::param())
	    {
            echo Auth::create_user(
                $username,
                $password,
                'ikko615@gmail.com'
            );
            exit;
            Session::set_flash('success','success create your account.');
	    }
	    $ret = array('success' => true);
 		return $this->response($ret);
	}	
}
