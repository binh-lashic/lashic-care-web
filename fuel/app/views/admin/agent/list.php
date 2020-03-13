<div class="row">
	<div class="col-sm-12">
		<h2>代理店実績管理</h2>
	</div>
</div>
<ul class="col-sm-12 nav nav-pills">
  <li role="presentation"<?php if(empty($status)) { echo "class=\"active\""; }?>><a href="/admin/contract/list">すべて</a></li>
<?php
	foreach($statuses as $key => $val) {
?>
  <li role="presentation"<?php if($status == $key) { echo "class=\"active\""; }?>><a href="/admin/contract/list?status=<?php echo $key; ?>"><?php echo $val; ?></a></li>
<?php
	}
?>
</ul>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">代理店名</th>
					<th class="col-sm-1">エージェント名</th>
					<th class="col-sm-2">契約プラン名</th>
                    <th class="col-sm-2">契約アカウント名</th>
                    <th class="col-sm-2">金額</th>
					<th class="col-sm-1">決済月</th>              
					<th class="col-sm-1">契約開始日</th>
					<th class="col-sm-1">契約終了日</th>
				</tr>
<?php
if(isset($contracts)) {
	foreach($contracts as $contract) {
?>				<tr>
					<td><?php echo $contract['store_name']; ?></td>
					<td><?php echo $contract['agent_name']; ?></td>
					<td><?php echo $contract['title']; ?></td>
					<td><a href="/admin/payment/?id=<?php echo $contract['id']; ?>"><?php echo $contract['last_name']; ?><?php echo $contract['first_name']; ?></a></td>
					<td><?php echo number_format($contract['price']); ?>円</td>>
					<td><?php echo "決済月"; ?></td>
					<td><?php echo $contract['start_date']; ?></td>
					<td><?php echo $contract['end_date']; ?></td>
                </tr>
<?php
	}
}
?>
			</table>
		</div>
		<nav>
		  <ul class="pager">
		    <li class="previous"><a href="/admin/agent/list?page=<?php echo $page - 1; ?>&query=<?php echo $query; ?>"><span aria-hidden="true">&larr;</span> 前へ</a></li>
		    <li class="next"><a href="/admin/agent/list?page=<?php echo $page + 1; ?>&query=<?php echo $query; ?>">次へ <span aria-hidden="true">&rarr;</span></a></li>
		  </ul>
		</nav>
	</div>
</div>