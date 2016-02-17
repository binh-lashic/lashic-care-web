<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<p><?php echo isset($user['name']) ? $user['name'] : ""; ?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">アラート設定</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="/admin/user/alert_save">
					<input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />

					<div class="form-group">
						<label for="temperature_alert" class="col-sm-4 control-label">室温異常</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="temperature_alert" />
								<input type="checkbox" name="temperature_alert" id="temperature_alert" value="1" <?php if(isset($user['temperature_alert']) && $user['temperature_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="fire_alert" class="col-sm-4 control-label">火事</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="fire_alert" />
								<input type="checkbox" name="fire_alert" id="fire_alert" value="1" <?php if(isset($user['fire_alert']) && $user['fire_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="heatstroke_alert" class="col-sm-4 control-label">熱中症</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="heatstroke_alert" />
								<input type="checkbox" name="heatstroke_alert" id="heatstroke_alert" value="1" <?php if(isset($user['heatstroke_alert']) && $user['heatstroke_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="hypothermia_alert" class="col-sm-4 control-label">低体温症</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="hypothermia_alert" />
								<input type="checkbox" name="hypothermia_alert" id="hypothermia_alert" value="1" <?php if(isset($user['hypothermia_alert']) && $user['hypothermia_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="humidity_alert" class="col-sm-4 control-label">湿度異常</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="humidity_alert" />
								<input type="checkbox" name="humidity_alert" id="humidity_alert" value="1" <?php if(isset($user['humidity_alert']) && $user['humidity_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="mold_mites_alert" class="col-sm-4 control-label">カビ・ダニ警報</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="mold_mites_alert" />
								<input type="checkbox" name="mold_mites_alert" id="mold_mites_alert" value="1" <?php if(isset($user['mold_mites_alert']) && $user['mold_mites_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="illuminance_daytime_alert" class="col-sm-4 control-label">照度異常（日中）</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="illuminance_daytime_alert" />
								<input type="checkbox" name="illuminance_daytime_alert" id="illuminance_daytime_alert" value="1" <?php if(isset($user['illuminance_daytime_alert']) && $user['illuminance_daytime_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="illuminance_night_alert" class="col-sm-4 control-label">照度異常（深夜）</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="illuminance_night_alert" />
								<input type="checkbox" name="illuminance_night_alert" id="illuminance_night_alert" value="1" <?php if(isset($user['illuminance_night_alert']) && $user['illuminance_night_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="disconnection_alert" class="col-sm-4 control-label">通信断</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="disconnection_alert" />
								<input type="checkbox" name="disconnection_alert" id="disconnection_alert" value="1" <?php if(isset($user['disconnection_alert']) && $user['disconnection_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="reconnection_alert" class="col-sm-4 control-label">通信復帰</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="reconnection_alert" />
								<input type="checkbox" name="reconnection_alert" id="reconnection_alert" value="1" <?php if(isset($user['reconnection_alert']) && $user['reconnection_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="wake_up_alert" class="col-sm-4 control-label">起床遅延</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="wake_up_alert" />
								<input type="checkbox" name="wake_up_alert" id="wake_up_alert" value="1" <?php if(isset($user['wake_up_alert']) && $user['wake_up_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="abnormal_behavior_alert" class="col-sm-4 control-label">異常行動</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="abnormal_behavior_alert" />
								<input type="checkbox" name="abnormal_behavior_alert" id="abnormal_behavior_alert" value="1" <?php if(isset($user['abnormal_behavior_alert']) && $user['abnormal_behavior_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>


					<div class="form-group">
						<label for="active_non_detection_alert" class="col-sm-4 control-label">人間未検知</label>
						<div class="col-sm-8">
							<label class="checkbox-inline">
								<input type="hidden" value="0" name="active_non_detection_alert" />
								<input type="checkbox" name="active_non_detection_alert" id="active_non_detection_alert" value="1" <?php if(isset($user['active_non_detection_alert']) && $user['active_non_detection_alert'] == 1) { echo "checked"; } ?>>オン
							</label>
						</div>
					</div>

				  <div class="form-group">
				    <div class="col-sm-offset-4 col-sm-8">
				      <button type="submit" class="btn btn-primary">
				      	<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 保存する
				      </button>
				    </div>
				  </div>
				</form>
			</div>
		</div>
	</div>