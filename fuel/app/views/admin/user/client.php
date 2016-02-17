<div class="row">
	<div class="col-sm-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<p><?php echo isset($user['name']) ? $user['name'] : ""; ?></p>
			</div>
			<div class="panel-heading">管理者一覧</div>
			<ul class="list-group">
<?php
if(isset($admins)) {
	foreach($admins as $admin) {
?>
				<li class="list-group-item">
					<a href="/admin/user/?id=<?php echo $admin['id']; ?>"><?php echo $admin['name']; ?></a>
				</li>
<?php
	}
}
?>
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">お客様情報の新規登録</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="/admin/user/save">
					<input type="hidden" name="admin_user_id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />
					<input type="hidden" name="id" value="<?php echo isset($client['id']) ? $client['id'] : ""; ?>" />
				  <div class="form-group">
				    <label for="name" class="col-sm-3 control-label">氏名※</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="name" name="name" placeholder="氏名" value="<?php echo isset($client['name']) ? $client['name'] : ""; ?>">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="kana" class="col-sm-3 control-label">フリガナ※</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="kana" name="kana" placeholder="フリガナ" value="<?php echo isset($client['kana']) ? $client['kana'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="kana" class="col-sm-3 control-label">性別※</label>
				    <div class="col-sm-9">
				    	<label class="radio-inline">
							<input type="radio" name="gender" id="gender_f" value="f" <?php if(isset($client['gender']) && $client['gender'] == "f") { echo "checked"; } ?>>女
						</label>
				    	<label class="radio-inline">
							<input type="radio" name="gender" id="gender_m" value="m" <?php if(isset($client['gender']) && $client['gender'] == "m") { echo "checked"; } ?>>男
						</label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="birthday" class="col-sm-3 control-label">生年月日</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="birthday" name="birthday" placeholder="生年月日" value="<?php echo isset($client['birthday']) ? $client['birthday'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="admin" class="col-sm-3 control-label">血液型※</label>
				    <div class="col-sm-9">
				    	<select name="blood_type" class="form-control">
<?php
	foreach($blood_types as $blood_type) {
?>
							<option value="<?php echo $blood_type; ?>"><?php echo $blood_type; ?></option>
<?php
	}
?>
						</select>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="address" class="col-sm-3 control-label">住所</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="address" name="address" placeholder="住所" value="<?php echo isset($client['address']) ? $client['address'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="area" class="col-sm-3 control-label">区画</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="area" name="area" placeholder="区画" value="<?php echo isset($client['area']) ? $client['area'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="phone" class="col-sm-3 control-label">電話番号</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="phone" name="phone" placeholder="電話番号" value="<?php echo isset($client['phone']) ? $client['phone'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="cellular" class="col-sm-3 control-label">携帯番号</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="cellular" name="cellular" placeholder="携帯番号" value="<?php echo isset($client['cellular']) ? $client['cellular'] : ""; ?>">
				    </div>
				  </div>


				  <div class="form-group">
				    <label for="memo" class="col-sm-3 control-label">備考</label>
				    <div class="col-sm-9">
				      <textarea class="form-control" id="memo" name="memo"><?php echo isset($client['memo']) ? $user['memo'] : ""; ?></textarea>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="admin" class="col-sm-3 control-label">センサー機器※</label>
				    <div class="col-sm-9">
				    	<select name="sensor_id" class="form-control">
				    		<option value="">指定なし</option>
<?php
	if(isset($sensors)) {
		foreach($sensors as $sensor) {
?>
							<option value="<?php echo $sensor['id']; ?>"<?php if($client_sensor_id == $sensor->id) echo " selected=\"selected\""; ?>><?php echo $sensor['name']; ?></option>
<?php
		}
	}
?>
						</select>
				    </div>
				  </div>

				  <div class="form-group">
				    <div class="col-sm-offset-3 col-sm-9">
				      <button type="submit" class="btn btn-primary">
				      	<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 保存する
				      </button>
				    </div>
				  </div>
				</form>
			</div>
		</div>

	</div>
</div>