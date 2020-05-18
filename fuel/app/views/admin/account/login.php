<!DOCTYPE html>
<html lang="ja_JP">
<head>
	<meta charset="utf-8">
	<title>ラシク管理画面</title>
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="/js/main.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>
	<div class="container">
		<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
	<div class="panel panel-info" >
		<div class="panel-heading">
			<div class="panel-title">ラシク管理画面 ログイン</div>
			<div style="float:right; font-size: 80%; position: relative; top:-10px">
			</div>
		</div>
		<div style="padding-top:30px" class="panel-body">
			<?php if(Session::get_flash('errors')){ $err = Session::get_flash('errors') ;
				?>
				<div class="alert alert-danger col-sm-12" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="false">×</span></button>
								<?php echo $err[0];  ?>
							</div>
				 <?php } ?>				
						<form action="/admin/login" class="form-horizontal" accept-charset="utf-8" method="post">
				<div style="margin-bottom: 25px" class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-envelope"></i>
					</span>
					<input class="form-control" placeholder="メールアドレス" name="username" value="" type="text" id="form_username" />
				</div>
				<div style="margin-bottom: 25px" class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-lock"></i>
					</span>
					<input class="form-control" placeholder="パスワード" name="password" value="" type="password" id="form_password" />
				</div>
				<div class="input-group">
					<div class="checkbox">
						<label>
							<input name="remember_me" value="1" type="checkbox" id="form_remember_me" /> ログインを保持する
						</label>
					</div>
				</div>
				<div style="margin-top:10px" class="form-group">
					<div class="col-sm-12 controls">
					<input class="btn btn-primary" name="login" value="ログイン" type="submit" id="form_login" />
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
