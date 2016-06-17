<div class="row">
	<div class="col-sm-12">
		<h2>センサー機器ID：<?php echo $sensor['name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/admin/sensor/shipping?id=<?php echo $sensor['id']; ?>">出荷日の設定</a></li>
      <li role="presentation" class="active"><a href="/admin/sensor/data?name=<?php echo $sensor['name']; ?>">データの確認</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">システムID</th>
					<th class="col-sm-2">日時</th>
					<th class="col-sm-1">室温</th>
					<th class="col-sm-1">湿度</th>
					<th class="col-sm-1">運動量</th>
					<th class="col-sm-1">照度</th>
				</tr>
<?php
foreach($data as $_data){
?>
				<tr>
					<td class="text-center">
						<?php echo $_data['id']; ?>
					</td>
					<td class="text-center">
						<?php echo $_data['date']; ?>
					</td>
					<td class="text-center">
						<?php echo $_data['temperature']; ?>
					</td>
					<td>
						<?php echo $_data['humidity']; ?>
					</td>
					<td>
						<?php echo $_data['active']; ?>
					</td>
					<td>
						<?php echo $_data['illuminance']; ?>
					</td>
				</tr>
<?php	
} 
?>
			</table>
		</div>

	</div>
</div>