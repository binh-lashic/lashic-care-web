<div class="row">
	<div class="col-sm-12">
		<h2>見守られユーザ:<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/admin/user/client/detail?id=<?php echo $user['id']; ?>&parent_id=<?php echo $parent_id; ?>">詳細</a></li>
      <li role="presentation" class="active"><a href="/admin/user/client/sensor?id=<?php echo $user['id']; ?>&parent_id=<?php echo $parent_id; ?>">センサー機器割当</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">センサー機器の新規登録</div>
			<div class="panel-body">
                        <?php if(Session::get_flash('error')) : ?>
                            <font color="red"><?php echo Session::get_flash('error'); ?></font>
                        <?php endif; ?>
			<form class="form-horizontal" method="post" action="/admin/user/client/add_sensor">
                                <?php echo Form::hidden('user_id', isset($user['id']) ? $user['id'] : ""); ?>
                                <?php echo Form::hidden('parent_id', isset($parent_id) ? $parent_id : ""); ?>

				<div class="form-group">
					<label for="sensor_name" class="col-sm-3 control-label">センサー機器ID</label>
					<div class="col-sm-9">
						<?php echo Form::select('sensor', ($sensor) ?: 1, $sensor_list); ?>
					</div>
					</div>
					<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="submit" class="btn btn-primary">
					  		<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 登録する
						</button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>