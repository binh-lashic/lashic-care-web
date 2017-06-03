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
			<form class="form-horizontal" method="post" action="/admin/user/client/add_sensor">
                                <?php echo Form::hidden('user_id', isset($user['id']) ? $user['id'] : ""); ?>
                                <?php echo Form::hidden('parent_id', isset($parent_id) ? $parent_id : ""); ?>

				<div class="form-group">
					<label for="sensor_name" class="col-sm-3 control-label">センサー機器ID</label>                                       
					<div class="col-sm-9">
					<?php if($isDisplay) : ?>
						<?php echo Form::select('sensor', ($sensor) ?: 1, $sensor_list); ?>
					<?php else : ?>
						割当られていないセンサーがありません
					<?php endif; ?>
					</div>
					<?php if(Session::get_flash('error')) : ?>
						<font color="red"><?php echo Session::get_flash('error'); ?></font>
					<?php endif; ?> 
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

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">機器一覧</div>
			<table class="table table-bordered">
				<tr class="info">
					<td class="col-sm-2">システムID</td>
					<td class="col-sm-2">センサーID</td>
					<td class="col-sm-2">機器タイプ</td>
					<td class="col-sm-3">出荷日</td>
					<td class="col-sm-3"></td>
				</tr>
            <?php if(isset($sensors)) : ?>
                    <?php foreach($sensors as $sensor) : ?>
				<tr>
					<td>
						<?php echo $sensor['id']; ?>
					</td>
					<td><?php echo $sensor['name']; ?></td>
					<td><?php echo $sensor['type']; ?></td> 
					<td><?php echo $sensor['shipping_date']; ?></td>
					<td><a href="/admin/user/client/delete_sensor?id=<?php echo $id; ?>&sensor=<?php echo $sensor['id']; ?>&parent_id=<?php echo $parent_id; ?>" class="btn btn-danger">センサー機器の割当解除</a></td>
				</tr>
                    <?php endforeach; ?>
            <?php endif; ?>

			</table>
		</div>
	</div>
</div>