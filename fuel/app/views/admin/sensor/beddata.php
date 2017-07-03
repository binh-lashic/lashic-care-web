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
					<th class="col-sm-2">日時</th>
					<th class="col-sm-1">状態</th>
					<th class="col-sm-1">人感</th>
					<th class="col-sm-1">体動</th>
					<th class="col-sm-1">姿勢</th>
					<th class="col-sm-1">睡眠</th>
					<th class="col-sm-1">寝返り</th>
					<th class="col-sm-1">脈拍</th>
				</tr>
<?php
foreach($data as $_data) {
?>
				<tr>
					<td class="text-center">
						<?php echo $_data['measurement_time']; ?>
					</td>
					<td>
						<?php echo $_data['status']; ?>
					</td>
					<td>
						<?php echo $_data['humans']; ?>
					</td>
					<td>
						<?php echo $_data['motion']; ?>
					</td>
					<td>
						<?php echo $_data['posture']; ?>
					</td>
					<td>
						<?php echo $_data['sleep']; ?>
					</td>
					<td>
						<?php echo $_data['rolling']; ?>
					</td>
					<td>
						<?php echo $_data['pulse']; ?>
					</td>
				</tr>
<?php	
} 
?>
			</table>
		</div>

	</div>
</div>
