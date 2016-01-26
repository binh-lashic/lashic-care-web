<div class="row">
	<div class="col-sm-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<p></p>
			</div>
			<div class="panel-heading">管理者一覧</div>
			<ul class="list-group">
			<?php
			foreach($admins as $admin) {
			?>
				<li class="list-group-item"><?php echo $admin['username']; ?>
			<?php
			}
			?>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<form class="form-horizontal" id="login">
			  <div class="form-group">
			    <label for="name" class="col-sm-3 control-label">氏名※</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="name" placeholder="氏名">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="kana" class="col-sm-3 control-label">フリガナ※</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="kana" placeholder="フリガナ">
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
			      <input type="text" class="form-control" id="username" placeholder="User Name">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="password" class="col-sm-3 control-label">パスワード</label>
			    <div class="col-sm-9">
			      <input type="password" class="form-control" id="password" placeholder="Password">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-sm-offset-3 col-sm-9">
			      <button type="submit" class="btn btn-default">ログインする</button>
			    </div>
			  </div>
			</form>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="panel panel-default">
			<div class="panel-heading">担当一覧</div>
			<ul class="list-group">
			<?php
			foreach($admins as $admin) {
			?>
				<li class="list-group-item"><?php echo $admin['username']; ?>
			<?php
			}
			?>
				</li>
			</ul>
		</div>
	</div>
</div>