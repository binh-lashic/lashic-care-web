<?php
class Controller_Api_User extends Controller_Api
{
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
 		return $this->response($ret);
	}

	public function post_login()
	{
		$username = Input::param("username");
		$password = Input::param("password");
		if (Auth::login($username, $password))
		{
			$ret = array('success' => true);
		}
		else
		{
			$this->errors[] = array(
				'message' => "ユーザー名かパスワードが間違っています"
			);
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
