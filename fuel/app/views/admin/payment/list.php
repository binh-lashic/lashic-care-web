<div class="row">
	<div class="col-sm-12">
		<h2>支払い一覧</h2>
	</div>
</div>
<ul class="col-sm-12 nav nav-pills">
  <li role="presentation"<?php if($type=='initial') { echo "class=\"active\""; }?>><a href="/admin/payment/list?type=initial">初期契約時</a></li>
  <li <?php if($type=='continuation') { echo "class=\"active\""; }?>><a href="/admin/contract/payment">継続課金</a></li>
</ul>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">ID</th>
					<th class="col-sm-1">契約アカウント</th>
					<th class="col-sm-3">契約プラン名</th>
					<th class="col-sm-1">金額</th>
					<th class="col-sm-1">送料</th>
					<th class="col-sm-1">出荷済</th>
					<th class="col-sm-1">機器数</th>
					<th class="col-sm-2">操作</th>
				</tr>
<?php
if(isset($payments)) {
	foreach($payments as $payment) {
?>				<tr>
					<td><?php echo $payment['id']; ?></td>
					<td><a href="/admin/payment/?id=<?php echo $payment['id']; ?>"><?php echo $payment['last_name']; ?><?php echo $payment['first_name']; ?></a></td>
					<td><?php echo $payment['title']; ?></td>
					<td class="text-right"><?php echo number_format($payment['price']); ?>円</td>
					<td class="text-right"><?php echo number_format($payment['shipping']); ?>円</td>
					<td><?php echo $payment['shipping_count']; ?></td>
					<td><?php echo $payment['sensor_count']; ?></td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/payment?id=<?php echo $payment['id']; ?>">契約を確認</a>						
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
		    <li class="previous"><a href="/admin/payment/list?page=<?php echo $page - 1; ?>&query=<?php echo $query; ?>"><span aria-hidden="true">&larr;</span> 前へ</a></li>
		    <li class="next"><a href="/admin/payment/list?page=<?php echo $page + 1; ?>&query=<?php echo $query; ?>">次へ <span aria-hidden="true">&rarr;</span></a></li>
		  </ul>
		</nav>
	</div>
</div>