<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント一覧</h2>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<form action="/admin/user/list" method="get">
			<div class="input-group">
		  		<input type="text" class="form-control" placeholder="名前、ふりがな、センサー機器IDで検索" name="query" value="<?php echo $query; ?>">
		  		<span class="input-group-btn">
		    		<button class="btn btn-default" type="submit">検索</button>
		  		</span>
		  	</div>
		</form>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">システムID</th>
					<th class="col-sm-3">名前</th>
					<th class="col-sm-6">センサー機器</th>
					<th class="col-sm-2">センサー機器の割当</th>
				</tr>
<?php
if(isset($admins)) {
	foreach($admins as $admin) {
?>
				<tr>
					<td><?php echo $admin['id']; ?></td>
					<td>
						<a href="/admin/user/?admin_user_id=<?php echo $admin['id']; ?>"><?php echo $admin['name']; ?>
						(<?php echo $admin['kana']; ?>)
						</a></td>
					<td>
<?php
	foreach($admin['sensors'] as $sensor) {
		if(empty($sensor['name'])) continue;
?>
					<a href="/admin/sesnor/"><?php echo $sensor['name']; ?></a>&nbsp; 
<?php
	}
?>
					</td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/user/sensor?id=<?php echo $sensor['id']; ?>">センサー機器の割当</a>						
					</td>
				</tr>
<?php
	}
}
?>
			</table>
		</div>
		<nav>
		  <ul class="pager">
		    <li class="previous"><a href="#"><span aria-hidden="true">&larr;</span> 前へ</a></li>
		    <li class="next"><a href="#">次へ <span aria-hidden="true">&rarr;</span></a></li>
		  </ul>
		</nav>
	</div>
</div>