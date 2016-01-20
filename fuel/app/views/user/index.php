<!DOCTYPE html>
<html lang="ja_JP">
<head>
	<meta charset="utf-8">
	<title>Infic</title>
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="/js/main.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>
	<header class="navbar navbar-static-top" id="top" role="banner">
		<div class=container>
  			<div class=navbar-header>
  				<a href=../ class=navbar-brand>Bootstrap</a>
  			</div>
		</div>
	</header>  

	<div class="container">
		<div class="panel panel-default" style="padding:45px;">
			<form class="form-horizontal" id="login">
			  <div class="form-group">
			    <label for="username" class="col-sm-2 control-label">User Name</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="username" placeholder="User Name">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="password" class="col-sm-2 control-label">Password</label>
			    <div class="col-sm-10">
			      <input type="password" class="form-control" id="password" placeholder="Password">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-default">Sign in</button>
			    </div>
			  </div>
			</form>
		</div>
	</div>
</body>
</html>
