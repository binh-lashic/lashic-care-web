<!DOCTYPE html>
<html lang="ja_JP">
<head>
	<meta charset="utf-8">
	<title>ラシク管理画面 - <?php echo isset($title) ? $title : ""; ?></title>
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="/js/main.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>
	<div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <a class="navbar-brand" href="#"><img alt="Brand" src="/images/common/logo.png" style="height:26px;"></a>
        </div>
      </div><!-- /.container-fluid -->
    </nav>

    <ul class="col-sm-12 nav nav-pills">
      <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Contract") { echo "class=\"active\""; }?>><a href="/admin/contract/list">契約</a></li>
      <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Payment") { echo "class=\"active\""; }?>><a href="/admin/payment/list">支払い</a></li>
      <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Billing") { echo "class=\"active\""; }?>><a href="/admin/billing/payment">継続課金</a></li>
      <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_User") { echo "class=\"active\""; }?>><a href="/admin/user/list">親アカウント</a></li>
      <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Sensor") { echo "class=\"active\""; }?>><a href="/admin/sensor/list">センサー機器</a></li>
    </ul>
		<?php echo $content; ?>
	</div>
</body>
</html>
