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
						<input type="text" class="form-control" id="sensor_name" name="name" placeholder="機器ID">
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
					<td>システムID</td>
					<td>センサーID</td>
					<td>見守られユーザ</td>
					<td>出荷日</td>
					<td></td>
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
					<td></td>
					<td></td>
					<td></td>
				</tr>
<?php
		}
	}
?>

			</table>
		</div>
	</div>
</div>