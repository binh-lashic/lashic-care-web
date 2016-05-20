<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">管理者一覧</div>
			<ul class="list-group">
<?php
foreach($admins as $admin){
?>
				<li class="list-group-item"><a href="/admin/user/?admin_user_id=<?php echo $admin['id']; ?>"><?php echo $admin['name']; ?></a></li>
<?php	
} 
?>
			</ul>
		</div>

	</div>
</div>