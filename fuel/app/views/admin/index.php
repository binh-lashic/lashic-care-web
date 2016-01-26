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
		<form class="form-horizontal" id="login">
		  <div class="form-group">
		    <label for="username" class="col-sm-2 control-label">ID</label>
		    <div class="col-sm-10">
		      <input type="text" class="form-control" id="username" placeholder="User Name">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="password" class="col-sm-2 control-label">パスワード</label>
		    <div class="col-sm-10">
		      <input type="password" class="form-control" id="password" placeholder="Password">
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      <button type="submit" class="btn btn-default">ログインする</button>
		    </div>
		  </div>
		</form>
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