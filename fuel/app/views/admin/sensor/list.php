<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">センサー設定の更新</div>
			<table class="table">
<?php
foreach($sensors as $sensor){
?>
				<tr <?php if($sensor['enable'] == 0) { echo "disabled"; } ?>">
					<td class="col-sm-4">
						<a href="/admin/sensor?id=<?php echo $sensor['id']; ?>"><?php echo $sensor['name']; ?></a>
					</td>
					<td class="col-sm-8">
						<form action="/admin/sensor/save" method="post">
							<input type="hidden" name="id" value="<?php echo $sensor['id']; ?>" />
							<select name="shipping_year">
								<option value="2016">2016</option>
							</select>
							年
							<select name="shipping_month">
<?php
if(!empty($sensor['shipping_date'])) {
	$time = strtotime($sensor['shipping_date']);
} else {
	$time = time();
}
$month = date('n', $time);
for($i = 1; $i <= 12; $i++) {
?>
								<option value="<?php echo $i; ?>"<?php if($i == $month) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
							</select>
							月
							<select name="shipping_day">
<?php
$day = date('j', $time);
for($i = 1; $i <= 31; $i++) {
?>
								<option value="<?php echo $i; ?>"<?php if($i == $day) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
							</select>
							日
							<input class="btn btn-default btn-sm" type="submit" value="出荷日を設定">
						</form>
					</td>
				</tr>
<?php	
} 
?>
			</table>
		</div>

	</div>
	<div class="col-sm-6">
		<form action="/admin/sensor/register" method="post">
		<div class="panel panel-default">
			<div class="panel-heading">センサー一括新規登録</div>
			<div class="panel-body">
				<textarea name="sensor_names" class="form-control" rows="3"></textarea>			
				<input class="btn btn-default"  type="submit" value="一括登録" />
			</div>
		</div>
		</form>
	</div>
</div>