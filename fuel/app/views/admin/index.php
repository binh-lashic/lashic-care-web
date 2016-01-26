<div class="row">
	<div class="panel panel-default col-sm-4">
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