<div class="row">
	<div class="col-sm-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<p><?php echo isset($user['name']) ? $user['name'] : ""; ?></p>
			</div>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">契約の一覧</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="/admin/user/add_client">
				  <div class="col-sm-12">
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
									<input type="checkbox" name="client_user_ids[<?php echo $user['id']; ?>]" value="true" <?php if(isset($user['flag'])) { echo "checked=\"checked\""; } ?> /><?php echo $user['name']; ?>
								</label>
							</div>
						</li>
<?php
		}
	}
?>
				    </ul>
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