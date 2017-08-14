<div class="row">
	<div class="col-sm-12">
		<h2>見守られユーザ一覧</h2>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/admin/user/?id=<?php echo $id; ?>">詳細</a></li>
      <li role="presentation"><a href="/admin/user/sensor?id=<?php echo $id; ?>">センサー機器割当</a></li>
      <li role="presentation"><a href="/admin/user/client_form?id=<?php echo $id; ?>">見守られユーザ登録</a></li>
      <li role="presentation" class="active"><a href="/admin/user/client/list?id=<?php echo $user['id']; ?>">見守られユーザ一覧</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">システムID</th>
					<th class="col-sm-3">名前</th>
					<th class="col-sm-2">センサー機器</th>
					<th class="col-sm-1">出荷日</th>
					<th class="col-sm-2"></th>
				</tr>
<?php if(isset($clients)) : ?>
    <?php foreach($clients as $client) : ?>
				<tr>
					<td><?php echo $client['id']; ?></td>
					<td>
						<?php echo $client['last_name']; ?><?php echo $client['first_name']; ?>
					</td>
					<td>
                                            <?php foreach($client['sensor_name'] as $name) : ?>
						<?php echo $name; ?><br>
                                            <?php endforeach; ?>
					</td>
					<td>
                                            <?php foreach($client['shipping_date'] as $shipping_date) : ?>
						<?php echo $shipping_date; ?><br>
                                            <?php endforeach; ?>
					</td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/user/client/sensor?id=<?php echo $client['id']; ?>&parent_id=<?php echo $id; ?>">センサー機器の割当</a>
					</td>
				</tr>
    <?php endforeach; ?>
<?php endif; ?>
			</table>
		</div>
	</div>
</div>