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
