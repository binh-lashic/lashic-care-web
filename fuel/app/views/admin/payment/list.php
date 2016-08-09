<div class="row">
	<div class="col-sm-12">
		<h2>支払い一覧</h2>
	</div>
</div>
<ul class="col-sm-12 nav nav-pills">
  <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Cotract") { echo "class=\"active\""; }?>><a href="/admin/contract/list">初期契約時</a></li>
  <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_User") { echo "class=\"active\""; }?>><a href="/admin/user/list">親アカウント一覧</a></li>
  <li role="presentation"<?php if(Request::main()->controller == "Controller_Admin_Sensor") { echo "class=\"active\""; }?>><a href="/admin/sensor/list">センサー機器一覧</a></li>
</ul>
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
					<th class="col-sm-2">操作</th>
				</tr>
<?php
if(isset($payments)) {
	foreach($payments as $payment) {
?>				<tr>
					<td><?php echo $payment['id']; ?></td>
					<td><a href="/admin/payment/?id=<?php echo $payment['id']; ?>"><?php echo $payment['last_name']; ?><?php echo $payment['first_name']; ?></a></td>
					<td><?php echo $payment['title']; ?></td>
					<td class="text-right"><?php echo $payment['price']; ?>円</td>
					<td class="text-right"><?php echo $payment['shipping']; ?>円</td>
					<td>
						<a class="btn btn-primary btn-sm" href="/admin/payment/sensor?id=<?php echo $payment['id']; ?>">センサー機器の割当</a>						
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