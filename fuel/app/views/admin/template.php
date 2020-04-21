<!DOCTYPE html>
<html lang="ja_JP">
<head>
	<meta charset="utf-8">
	<title>ラシク管理画面 - <?php echo isset($title) ? $title : ""; ?></title>
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" integrity="sha384-KZO2FRYNmIHerhfYMjCIUaJeGBRXP7CN24SiNSG+wdDzgwvxWbl16wMVtWiJTcMt" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js" integrity="sha384-JnbsSLBmv2/R0fUmF2XYIcAEMPHEAO51Gitn9IjL4l89uFTIgtLF1+jqIqqd9FSk" crossorigin="anonymous"></script>
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
      <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Agent") { echo "class=\"active\""; }?>><a href="/admin/agent/list">代理店実績管理</a></li>
    </ul>
		<?php echo $content; ?>
	</div>
	<script>
		$(function(){
			$('.select').select2();
		});
	</script>
</body>
</html>
