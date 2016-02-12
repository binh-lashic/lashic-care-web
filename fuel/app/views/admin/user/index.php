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
			<div class="panel-heading">ユーザの新規登録</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="/admin/user/save">
					<input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />
				  <div class="form-group">
				    <label for="name" class="col-sm-3 control-label">氏名※</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="name" name="name" placeholder="氏名" value="<?php echo isset($user['name']) ? $user['name'] : ""; ?>">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="kana" class="col-sm-3 control-label">フリガナ※</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="kana" name="kana" placeholder="フリガナ" value="<?php echo isset($user['kana']) ? $user['kana'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="kana" class="col-sm-3 control-label">性別※</label>
				    <div class="col-sm-9">
				    	<label class="radio-inline">
							<input type="radio" name="gender" id="gender_f" value="f" <?php if(isset($user['gender']) && $user['gender'] == "f") { echo "checked"; } ?>>女
						</label>
				    	<label class="radio-inline">
							<input type="radio" name="gender" id="gender_m" value="m" <?php if(isset($user['gender']) && $user['gender'] == "m") { echo "checked"; } ?>>男
						</label>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="username" class="col-sm-3 control-label">ID</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="username" name="username" placeholder="ID" value="<?php echo isset($user['username']) ? $user['username'] : ""; ?>">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="password" class="col-sm-3 control-label">初期パスワード</label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" id="password" name="password" placeholder="初期パスワード">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="phone" class="col-sm-3 control-label">電話番号</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="phone" name="phone" placeholder="電話番号" value="<?php echo isset($user['phone']) ? $user['phone'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="cellular" class="col-sm-3 control-label">携帯番号</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="cellular" name="cellular" placeholder="携帯番号" value="<?php echo isset($user['cellular']) ? $user['cellular'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="email" class="col-sm-3 control-label">メールアドレス※</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="email" name="email" placeholder="メールアドレス" value="<?php echo isset($user['email']) ? $user['email'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="work_start_date" class="col-sm-3 control-label">勤務開始日</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="work_start_date" name="work_start_date" placeholder="勤務開始日" value="<?php echo isset($user['work_start_date']) ? $user['work_start_date'] : ""; ?>">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="memo" class="col-sm-3 control-label">備考</label>
				    <div class="col-sm-9">
				      <textarea class="form-control" id="memo" name="memo"><?php echo isset($user['memo']) ? $user['memo'] : ""; ?></textarea>
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="admin" class="col-sm-3 control-label">管理者※</label>
				    <div class="col-sm-9">
				    	<label class="checkbox-inline">
							<input type="checkbox" name="admin" id="admin" value="1" <?php if(isset($user['admin']) && $user['admin'] == 1) { echo "checked"; } ?>>オン
						</label>
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
<?php
if(isset($user)) {
?>
			<div class="panel panel-default">
				<div class="panel-heading">機器一覧</div>
				<ul class="list-group">
<?php
	if(isset($sensors)) {
		foreach($sensors as $sensor) {
?>
					<li class="list-group-item"><?php echo $sensor['name']; ?></li>
<?php
		}
	}
?>

				</ul>
				<div class="panel-heading">センサー機器の新規登録</div>
				<div class="panel-body">
				<form class="form-horizontal" method="post" action="/admin/user/add_sensor">
					<input type="hidden" name="user_id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />

					<div class="form-group">
						<label for="sensor_name" class="col-sm-3 control-label">機器ID</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="sensor_name" name="name" placeholder="機器ID">
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
<?php
}
?>
	</div>

<?php
if(isset($user)) {
?>
	<div class="col-sm-3">
			<div class="panel panel-default">
				<div class="panel-heading">担当一覧</div>
				<table class="table table-bordered">
					<tr>
						<th>お客様名</th>
						<th>性別</th>
						<th>生年月日</th>
						<th></th>
					</tr>
<?php
if(isset($clients)) {
	foreach($clients as $client) {
?>
				<tr>
					<td><?php echo $client['name']; ?></td>
					<td><?php echo $client['gender'] == "f" ? "女" : "男"; ?></td>
					<td><?php echo $client['username']; ?></td>
					<td>
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</td>
				</tr>
<?php
	}
}
?>
	  			</table>
				<div class="panel-body">
					<a class="btn btn-primary" href="/admin/user/add_client?user_id=<?php echo $user['id']; ?>" role="button">担当を追加</a>
				</div>
			</div>
	</div>
<?php
}
?>

</div>