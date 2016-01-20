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
class Controller_Users extends Controller_Rest
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


		$ret = array('success' => true);

		$row = DB::query("SELECT * FROM users")->execute();
		$data = $row->as_array();
		$ret = array(
			'success' => true,
			'data' => $data,
		);
		/*
		$row = DB::query("SELECT * FROM infic_db.data")->execute();
		$res = $row->as_array();
		print_r($res);
		*/
 		return $this->response($ret);
	}

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function get_login()
	{
		$username = Input::param("username");
		$password = Input::param("password");
		$ret = array('success' => true);
 		return $this->response($ret);
	}

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function get_register()
	{
		$username = Input::param("username");
		$password = Input::param("password");
	    if (Input::param())
	    {
            Auth::create_user(
                $username,
                $password,
                $username
            );
            Session::set_flash('success','success create your account.');
	    }
	    $ret = array('success' => true);
 		return $this->response($ret);
	}	
}

