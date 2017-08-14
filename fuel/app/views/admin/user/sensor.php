<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント:<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/admin/user/?id=<?php echo $user['id']; ?>">詳細</a></li>
      <li role="presentation" class="active"><a href="/admin/user/sensor?id=<?php echo $user['id']; ?>">センサー機器割当</a></li>
      <li role="presentation"><a href="/admin/user/client_form?id=<?php echo $user['id']; ?>">見守られユーザ登録</a></li>
      <li role="presentation"><a href="/admin/user/client/list?id=<?php echo $user['id']; ?>">見守られユーザ一覧</a></li>
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
                                        <?php if(Session::get_flash('error')) : ?>
                                            <font color="red"><?php echo Session::get_flash('error'); ?></font>
                                        <?php endif; ?> 
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
<?php if(isset($sensors)) : ?>
    <?php foreach($sensors as $sensor) : ?>
				<tr>
					<td>
						<?php echo $sensor['id']; ?>
					</td>
					<td><?php echo $sensor['name']; ?></td>
					<td>
        <?php if(!empty($sensor['last_name']) && !empty($sensor['first_name'])) : ?>
						<?php echo $sensor['last_name'].$sensor['first_name']; ?><br />
        <?php else : ?>
						未設定
        <?php endif; ?>
					</td>
					<td><?php echo $sensor['shipping_date']; ?></td>
					<td><a href="/admin/user/sensor/delete?user_id=<?php echo $user['id']; ?>&sensor_id=<?php echo $sensor['id']; ?>" class="btn btn-danger">センサー機器の割当解除</a></td>
				</tr>
    <?php endforeach; ?>
<?php endif; ?>

			</table>
		</div>
	</div>
</div>