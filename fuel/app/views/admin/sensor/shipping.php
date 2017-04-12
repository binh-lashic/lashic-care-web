<div class="row">
	<div class="col-sm-12">
		<h2>センサー機器ID：<?php echo $sensor['name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a href="/admin/sensor/shipping?id=<?php echo $sensor['id']; ?>">出荷日の設定</a></li>
      <li role="presentation"><a href="/admin/sensor/data?name=<?php echo $sensor['name']; ?>">データの確認</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">出荷日を設定します</div>
		<div class="panel-body">
						<form action="/admin/sensor/save" method="post">
							<input type="hidden" name="id" value="<?php echo $sensor['id']; ?>" />
							<?php echo Form::select('shipping_year', $year, $shipping_years); ?>
							年
							<?php echo Form::select('shipping_month', $month, $shipping_months); ?>
							月
							<?php echo Form::select('shipping_day', $day, $shipping_days); ?>
							日<br />
							<input class="btn btn-default btn-sm" type="submit" value="出荷日を登録">
						</form>
			</div>
		</div>
	</div>
</div>
