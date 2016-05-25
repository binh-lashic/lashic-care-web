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
					<a href="/admin/user/?id=<?php echo $admin['id']; ?>"><?php echo $admin['last_name']; ?><?php echo $admin['first_name']; ?></a>
				</li>
<?php
	}
}
?>
			</ul>
		</div>
	</div>
	<div class="col-sm-6">
					<form class="form-horizontal" method="post" action="/admin/user/add_client">

		<div class="panel panel-default">
			<div class="panel-heading">担当者の選択</div>


				  <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />
				  	<ul class="list-group">
<?php
	if(isset($users)) {
		foreach($users as $user) {
?>
						<li class="list-group-item">
							<div class="checkbox">
								<label>
									<input type="hidden" name="client_user_ids[<?php echo $user['id']; ?>]" value="false">
									<input type="checkbox" name="client_user_ids[<?php echo $user['id']; ?>]" value="true" <?php if(isset($user['flag'])) { echo "checked=\"checked\""; } ?> />
									<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?>
								</label>
							</div>
						</li>
<?php
		}
	}
?>
				    </ul>

				  <div class="pannel-body">
				      <button type="submit" class="btn btn-primary">
				      	<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 保存する
				      </button>
				  </div>
		</form>
		</div>


	</div>
</div>