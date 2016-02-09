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
					<a href="/admin/user/<?php echo $admin['id']; ?>"><?php echo $admin['username']; ?></a>
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
			<p>
			<form class="form-horizontal" id="login" method="post" action="/admin/user/save">
			  <div class="form-group">
			    <label for="name" class="col-sm-3 control-label">氏名※</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="name" placeholder="氏名" value="<?php echo isset($user['name']) ? $user['name'] : ""; ?>">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="kana" class="col-sm-3 control-label">フリガナ※</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="kana" placeholder="フリガナ" value="<?php echo isset($user['kana']) ? $user['kana'] : ""; ?>">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="kana" class="col-sm-3 control-label">性別※</label>
			    <div class="col-sm-9">
				    <div class="btn-group" data-toggle="buttons">
					  <label class="btn btn-primary active">
					    <input type="radio" name="gender" id="gender_f" autocomplete="off" checked>女
					  </label>
					  <label class="btn btn-primary">
					    <input type="radio" name="gender" id="gender_M" autocomplete="off">男
					  </label>
					</div>
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="username" class="col-sm-3 control-label">ID</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="username" placeholder="ID" value="<?php echo isset($user['username']) ? $user['username'] : ""; ?>">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="password" class="col-sm-3 control-label">初期パスワード</label>
			    <div class="col-sm-9">
			      <input type="password" class="form-control" id="password" placeholder="初期パスワード">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="phone" class="col-sm-3 control-label">電話番号</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="phone" placeholder="電話番号" value="<?php echo isset($user['phone']) ? $user['phone'] : ""; ?>">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="cellular" class="col-sm-3 control-label">携帯番号</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="cellular" placeholder="携帯番号" value="<?php echo isset($user['cellular']) ? $user['cellular'] : ""; ?>">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="email" class="col-sm-3 control-label">メールアドレス※</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="email" placeholder="メールアドレス" value="<?php echo isset($user['email']) ? $user['email'] : ""; ?>">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="work_start_date" class="col-sm-3 control-label">勤務開始日</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="work_start_date" placeholder="勤務開始日">
			    </div>
			  </div>

			  <div class="form-group">
			    <label for="memo" class="col-sm-3 control-label">備考</label>
			    <div class="col-sm-9">
			      <textarea class="form-control" id="memo"><?php echo isset($user['memo']) ? $user['memo'] : ""; ?></textarea>
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
			</p>
		</div>
	</div>
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
if(isset($admins)) {
	foreach($admins as $admin) {
?>
				<tr>
					<td><?php echo $admin['username']; ?></td>
					<td><?php echo $admin['username']; ?></td>
					<td><?php echo $admin['username']; ?></td>
					<td>
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</td>
				</tr>
<?php
	}
}
?>
  			</table>
		</div>
	</div>
</div>