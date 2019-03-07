<div class="row">
	<div class="col-sm-12">
		<h2>支払い詳細：<?php echo $payments[0]['last_name']; ?><?php echo $payments[0]['first_name']; ?>様</h2>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-4">契約プラン名</th>
					<th class="col-sm-1">金額</th>
					<th class="col-sm-1">送料</th>
					<th class="col-sm-4">備考</th>
				</tr>
<?php
if(isset($payments)) {
	foreach($payments as $payment) {
?>				<tr>
					<td><?php echo $payment['title']; ?></td>
					<td class="text-right"><?php echo $payment['price']; ?>円</td>
					<td class="text-right"><?php echo $payment['shipping']; ?>円</td>
					<td class="text-right"><?php echo nl2br($payment['remarks']); ?></td>
				</tr>
<?php
	}
}
?>
			</table>

		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<h2>機器一覧</h2>
	</div>
</div>

<form action="/admin/payment/save_sensor" method="post">
<input type="hidden" name="payment_id" value="<?php echo $id; ?>" />
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th></th>
					<th class="col-sm-8">契約プラン名</th>
					<th class="col-sm-1">機器名</th>
					<th class="col-sm-1">出荷日</th>
					<th class="col-sm-1">操作</th>
				</tr>
<?php
if(isset($sensors)) {
	foreach($sensors as $sensor) {
?>
				<tr>
					<td><input type="checkbox" name="sensor_ids[]" value="<?php echo $sensor['sensor_id']; ?>" checked="checked"/></td>
					<td><?php echo $sensor['title']; ?></td>
					<td><?php echo $sensor['name']; ?></td>
					<td><?php echo $sensor['shipping_date']; ?></td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/contract/sensor?id=<?php echo $sensor['contract_id']; ?>">機器割当</a>
					</td>
				</tr>
<?php
	}
}
?>
			</table>

		</div>
		<div class="panel panel-default">
		<div class="panel-body">出荷日を設定し、発送メールを送信します</div>
		<div class="panel-body form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">運送会社</label>
					<div class="col-sm-10 radio">
						<label>
							<input type="radio" name="vendor" value="ヤマト運輸" checked="checked">ヤマト運輸
						</label>
						<label>
							<input type="radio" name="vendor" value="ゆうパック">ゆうパック
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="slip_number" class="col-sm-2 control-label">お問い合わせ伝票番号</label>
					<div class="col-sm-10">
						<input type="text" name="slip_number" value="" class="form-control">
					</div>
				</div>
				<div class="form-group form-inline">
						<label for="date" class="col-sm-2 control-label">出荷日</label>
						<div class="col-sm-10">
							<select name="shipping_year" class="form-control">
								<option value="2016">2016</option>
								<option value="2017">2017</option>
							</select>
							年
							<select name="shipping_month" class="form-control">
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
							<select name="shipping_day" class="form-control">
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
						
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-default btn-sm" type="submit" value="発送メールを送信">
					</div>
				</div>
							
			</div>
		</div>
	</div>
</div>
</form>
