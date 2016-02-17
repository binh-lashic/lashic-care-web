<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">センサー設定の更新</div>
			<div class="panel-body">
				<form class="form-horizontal" method="post" action="/admin/user/save">
					<input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ""; ?>" />
				  <div class="form-group">
				    <label for="id" class="col-sm-3 control-label">ID</label>
				    <div class="col-sm-9"><?php echo $sensor['id'];?></div>
				  </div>
				  <div class="form-group">
				    <label for="name" class="col-sm-3 control-label">センサーID</label>
				    <div class="col-sm-9"><?php echo $sensor['name'];?></div>
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

	</div>