<div class="row">
	<div class="col-sm-12">
		<h2>センサー機器一覧</h2>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<h2>センサー機器新規一括登録</h2>
		<form action="/admin/sensor/register" method="post">
		<div class="panel panel-default">
			<div class="panel-body">
				<textarea name="sensor_names" class="form-control" rows="3"></textarea>			
				<input class="btn btn-default"  type="submit" value="一括登録" />
			</div>
		</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<form action="/admin/sensor/list" method="get">
			<div class="input-group">
		  		<input type="text" class="form-control" placeholder="名前、ふりがな、センサー機器IDで検索" name="query" value="<?php echo $query; ?>">
		  		<span class="input-group-btn">
		    		<button class="btn btn-default" type="submit">検索</button>
		  		</span>
		  	</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">システムID</th>
					<th class="col-sm-1">センサー機器ID</th>
					<th class="col-sm-2">親アカウント</th>
					<th class="col-sm-2">見守られユーザ</th>
					<th class="col-sm-1">ステータス</th>
					<th class="col-sm-2">出荷日</th>
					<th class="col-sm-3">操作</th>
				</tr>
<?php
foreach($sensors as $sensor){
	if(!empty($sensor['shipping_date']) && $sensor['enable'] == 1) {
		$status = "稼働中";
	} else 	if(!empty($sensor['shipping_date']) && $sensor['enable'] != 1) {
		$status = "出荷済";
	} else {
		$status = "未出荷";
	}

?>
				<tr class="<?php if($sensor['enable'] == 0) { echo "active"; } ?>">
					<td class="text-center">
						<?php echo $sensor['id']; ?>
					</td>
					<td class="text-center">
						<?php echo $sensor['name']; ?>
					</td>
					<td>
						<?php echo $sensor['name']; ?>
					</td>
					<td>
						<?php echo $sensor['name']; ?>
					</td>
					<td class="text-center">
						<?php echo $status; ?>
					</td>
					<td class="text-center">
						<?php echo $sensor['shipping_date']; ?>
					</td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/sensor/shipping?id=<?php echo $sensor['id']; ?>">出荷日登録</a>
						<a class="btn btn-primary btn-sm" href="/admin/sensor/data?name=<?php echo $sensor['name']; ?>">データ確認</a>
					</td>
				</tr>
<?php	
} 
?>
			</table>
		</div>

	</div>
</div>