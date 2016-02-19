<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">センサー設定の更新</div>
			<form class="form-horizontal" method="post" action="/admin/sensor/save">
				<input type="hidden" name="id" value="<?php echo isset($sensor['id']) ? $sensor['id'] : ""; ?>" />
				<div class="panel-body">
					  <div class="form-group">
					    <label for="id" class="col-sm-3 control-label">ID</label>
					    <div class="col-sm-9 form-control-static"><?php echo $sensor['id'];?></div>
					  </div>
					  <div class="form-group">
					    <label for="name" class="col-sm-3 control-label">センサーID</label>
					    <div class="col-sm-9 form-control-static"><?php echo $sensor['name'];?></div>
					  </div>	
				</div>

				<div class="panel-heading">室温異常通知</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="temperature_upper_limit" class="col-sm-3 control-label">温度上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="temperature_upper_limit" id="temperature_upper_limit" value="<?php echo $sensor['temperature_upper_limit']; ?>">
					    	<div class="input-group-addon">℃</div>
						</div>
					</div>

					<div class="form-group">
					    <label for="temperature_lower_limit" class="col-sm-3 control-label">温度下限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="temperature_lower_limit" id="temperature_lower_limit" value="<?php echo $sensor['temperature_lower_limit']; ?>">
					    	<div class="input-group-addon">℃</div>
						</div>
					</div>

					<div class="form-group">
					    <label for="temperature_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="temperature_duration" id="temperature_duration" value="<?php echo $sensor['temperature_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">火事アラート</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="fire_temperature_upper_limit" class="col-sm-3 control-label">温度上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="fire_temperature_upper_limit" id="fire_temperature_upper_limit" value="<?php echo $sensor['fire_temperature_upper_limit']; ?>">
					    	<div class="input-group-addon">℃</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">熱中症アラート</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="heatstroke_wbgt_upper_limit" class="col-sm-3 control-label">WBGT値上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="heatstroke_wbgt_upper_limit" id="heatstroke_wbgt_upper_limit" value="<?php echo $sensor['heatstroke_wbgt_upper_limit']; ?>">
					    	<div class="input-group-addon">℃</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="heatstroke_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="heatstroke_duration" id="heatstroke_duration" value="<?php echo $sensor['heatstroke_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>
<!--
				<div class="panel-heading">低体温症アラート</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="admin" class="col-sm-3 control-label">温度上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="admin" id="admin" value="<?php echo $sensor['admin']; ?>">
					    	<div class="input-group-addon">℃</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="admin" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="admin" id="admin" value="<?php echo $sensor['admin']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>
-->
				<div class="panel-heading">室内湿度異常アラート</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="humidity_upper_limit" class="col-sm-3 control-label">湿度上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="humidity_upper_limit" id="humidity_upper_limit" value="<?php echo $sensor['humidity_upper_limit']; ?>">
					    	<div class="input-group-addon">%</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="humidity_lower_limit" class="col-sm-3 control-label">湿度下限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="humidity_lower_limit" id="humidity_lower_limit" value="<?php echo $sensor['humidity_lower_limit']; ?>">
					    	<div class="input-group-addon">%</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="humidity_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="humidity_duration" id="humidity_duration" value="<?php echo $sensor['humidity_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">カビ・ダニ警報アラート</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="admin" class="col-sm-3 control-label">湿度上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="admin" id="admin" value="<?php echo $sensor['admin']; ?>">
					    	<div class="input-group-addon">%</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="mold_mites_temperature_upper_limit" class="col-sm-3 control-label">温度上限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="mold_mites_temperature_upper_limit" id="mold_mites_temperature_upper_limit" value="<?php echo $sensor['mold_mites_temperature_upper_limit']; ?>">
					    	<div class="input-group-addon">℃</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="mold_mites_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="mold_mites_duration" id="mold_mites_duration" value="<?php echo $sensor['mold_mites_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">室内照度異常（日中）</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="illuminance_daytime_start_time" class="col-sm-3 control-label">時間帯</label>
					    <div class="col-sm-5 input-group">
					    	<input type="text" class="form-control" name="illuminance_daytime_start_time" id="illuminance_daytime_start_time" value="<?php echo $sensor['illuminance_daytime_start_time']; ?>">
					    	<div class="input-group-addon">時</div>
					    	<div class="input-group-text">〜</div>
					    	<input type="text" class="form-control" name="illuminance_daytime_end_time" id="illuminance_daytime_end_time" value="<?php echo $sensor['illuminance_daytime_end_time']; ?>">
					    	<div class="input-group-addon">時</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="illuminance_daytime_lower_limit" class="col-sm-3 control-label">照度下限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="illuminance_daytime_lower_limit" id="illuminance_daytime_lower_limit" value="<?php echo $sensor['illuminance_daytime_lower_limit']; ?>">
					    	<div class="input-group-addon">lux</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="illuminance_daytime_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="illuminance_daytime_duration" id="illuminance_daytime_duration" value="<?php echo $sensor['illuminance_daytime_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">室内照度異常（深夜）</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="illuminance_night_start_time" class="col-sm-3 control-label">時間帯</label>
					    <div class="col-sm-5 input-group">
					    	<input type="text" class="form-control" name="illuminance_night_start_time" id="illuminance_night_start_time" value="<?php echo $sensor['illuminance_night_start_time']; ?>">
					    	<div class="input-group-addon">時</div>
					    	<div class="input-group-text">〜</div>
					    	<input type="text" class="form-control" name="illuminance_night_end_time" id="illuminance_night_end_time" value="<?php echo $sensor['illuminance_night_end_time']; ?>">
					    	<div class="input-group-addon">時</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="illuminance_night_lower_limit" class="col-sm-3 control-label">照度下限</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="illuminance_night_lower_limit" id="illuminance_night_lower_limit" value="<?php echo $sensor['illuminance_night_lower_limit']; ?>">
					    	<div class="input-group-addon">lux</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="illuminance_night_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="illuminance_night_duration" id="illuminance_night_duration" value="<?php echo $sensor['illuminance_night_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">通信断アラート</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="disconnection_duration" class="col-sm-3 control-label">継続時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="disconnection_duration" id="disconnection_duration" value="<?php echo $sensor['disconnection_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-heading">平均起床時間遅延</div>
				<div class="panel-body">
					<div class="form-group">
					    <label for="wake_up_period" class="col-sm-3 control-label">集計期間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="wake_up_period" id="wake_up_period" value="<?php echo $sensor['wake_up_period']; ?>">
					    	<div class="input-group-addon">日</div>
						</div>
					</div>
					<div class="form-group">
					    <label for="wake_up_delay_allowance_duration" class="col-sm-3 control-label">遅延許容時間</label>
					    <div class="col-sm-2 input-group">
					    	<input type="text" class="form-control" name="wake_up_delay_allowance_duration" id="wake_up_delay_allowance_duration" value="<?php echo $sensor['wake_up_delay_allowance_duration']; ?>">
					    	<div class="input-group-addon">分</div>
						</div>
					</div>
				</div>

				<div class="panel-body">
					  <div class="form-group">
					    <div class="col-sm-offset-3 col-sm-9">
					      <button type="submit" class="btn btn-primary">
					      	<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 保存する
					      </button>
					    </div>
					  </div>
				</div>
			</form>
		</div>

	</div>
</div>