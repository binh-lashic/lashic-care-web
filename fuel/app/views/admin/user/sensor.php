<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント:<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/admin/user/?id=<?php echo $user['id']; ?>">詳細</a></li>
      <li role="presentation" class="active"><a href="/admin/user/sensor?id=<?php echo $user['id']; ?>">センサー機器割当</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">センサー機器の新規登録</div>
			<div class="panel-body">
			<form class="form-horizontal" method="post" action="/admin/user/add_sensor">
				<input type="hidden" name="user_id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />

				<div class="form-group">
					<label for="sensor_name" class="col-sm-3 control-label">機器ID</label>
					<div class="col-sm-9">
						<textarea class="form-control" id="sensor_name" name="sensor_names" placeholder="割り当てるセンサー機器を入力してください。
改行で複数入力になります。"></textarea>
					</div>
					</div>
					<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="submit" class="btn btn-primary">
					  		<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 保存する
						</button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">機器一覧</div>
			<table class="table table-bordered">
				<tr class="info">
					<td class="col-sm-2">システムID</td>
					<td class="col-sm-2">センサーID</td>
					<td class="col-sm-2">見守られユーザ</td>
					<td class="col-sm-3">出荷日</td>
					<td class="col-sm-3"></td>
				</tr>
<?php
	if(isset($sensors)) {
		foreach($sensors as $sensor) {
?>
				<tr>
					<td>
						<?php echo $sensor['id']; ?>
					</td>
					<td><?php echo $sensor['name']; ?></td>
					<td>
<?php
if(isset($sensor['clients'])) {
	foreach($sensor['clients'] as $client) {
		if(!empty($client['last_name']) && !empty($client['first_name'])) {
?>
	<?php echo $client['last_name'].$client['first_name']; ?><br />
<?php
		} else {
?>
	未設定
<?php		
		}
?>
<?php
	}
}
?>
					</td>
					<td><?php echo $sensor['shipping_date']; ?></td>
					<td><a href="" class="btn btn-danger">センサー機器の割当解除</a></td>
				</tr>
<?php
		}
	}
?>

			</table>
		</div>
	</div>
</div>