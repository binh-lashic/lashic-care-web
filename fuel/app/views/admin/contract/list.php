<div class="row">
	<div class="col-sm-12">
		<h2>契約一覧</h2>
	</div>
</div>
<!--
<div class="row">
	<div class="col-sm-6">
		<form action="/admin/contract/list" method="get">
			<div class="input-group">
		  		<input type="text" class="form-control" placeholder="名前、ふりがなで検索" name="query" value="<?php echo $query; ?>">
		  		<span class="input-group-btn">
		    		<button class="btn btn-default" type="submit">検索</button>
		  		</span>
		  	</div>
		</form>
	</div>
</div>
-->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">システムID</th>
					<th class="col-sm-1">契約アカウント</th>
					<th class="col-sm-3">契約プラン名</th>
					<th class="col-sm-1">金額</th>
					<th class="col-sm-1">送料</th>
					<th class="col-sm-1">契約開始日</th>
					<th class="col-sm-1">契約更新日</th>
					<th class="col-sm-2">操作</th>
				</tr>
<?php
if(isset($contracts)) {
	foreach($contracts as $contract) {
?>				<tr>
					<td><?php echo $contract['id']; ?></td>
					<td><a href="/admin/contract/?id=<?php echo $contract['id']; ?>"><?php echo $contract['last_name']; ?><?php echo $contract['first_name']; ?></a></td>
					<td><?php echo $contract['title']; ?></td>
					<td class="text-right"><?php echo $contract['price']; ?>円</td>
					<td class="text-right"><?php echo $contract['shipping']; ?>円</td>
					<td><?php echo $contract['start_date']; ?></td>
					<td><?php echo $contract['renew_date']; ?></td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/contract/sensor?id=<?php echo $contract['id']; ?>">センサー機器の割当</a>						
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
		    <li class="previous"><a href="/admin/contract/list?page=<?php echo $page - 1; ?>&query=<?php echo $query; ?>"><span aria-hidden="true">&larr;</span> 前へ</a></li>
		    <li class="next"><a href="/admin/contract/list?page=<?php echo $page + 1; ?>&query=<?php echo $query; ?>">次へ <span aria-hidden="true">&rarr;</span></a></li>
		  </ul>
		</nav>
	</div>
</div>