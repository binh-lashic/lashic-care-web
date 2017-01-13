	<div class="row">
		<div class="col-sm-12">
			<h2>継続支払い一覧</h2>
		</div>
	</div>
	<nav aria-label="...">
	  <ul class="pager">
	    <li class="previous"><a href="/admin/billing/payment?date=<?php echo $prev_date; ?>"><span aria-hidden="true">&larr;</span> <?php echo date("Y年m月", strtotime($prev_date)); ?></a></li>
	    <li><a><?php echo date("Y年m", strtotime($date)); ?>月</a></li>
	    <li class="next"><a href="/admin/billing/payment?date=<?php echo $next_date; ?>"><?php echo date("Y年m月", strtotime($next_date)); ?> <span aria-hidden="true">&rarr;</span></a></li>
	  </ul>
	</nav>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-default">
				<table class="table table-bordered">
					<tr>
						<th class="info col-sm-3">対象月</th>
						<td class="col-sm-10"><?php echo date("Y年m月", strtotime($date)); ?></td>
					</tr>
					<tr>
						<th class="info col-sm-3">対象契約期間</th>
						<td class="col-sm-10"><?php echo date("Y年m月", strtotime($date)); ?></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row col-sm-12">
		<a class="btn btn-primary" href="/admin/billing/londering_download?date=<?php echo $date; ?>">洗い替えCSV出力</a>
		<a class="btn btn-primary" href="/admin/billing/download?date=<?php echo $date; ?>">継続課金CSV出力</a>
	</div>


<div class="row">
	<div class="col-sm-12" style="padding:20px;">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">ID</th>
					<th class="col-sm-4">内訳</th>
<!--
					<th>ショップID</th>
-->
					<th class="col-sm-1">会員ID</th>
<!--
					<th>カード登録連番</th>
					<th>取引コード</th>
-->
					<th class="col-sm-1">利用年月日</th>
					<th class="col-sm-1">オーダーID</th>
<!--
					<th>商品コード</th>
-->
					<th class="col-sm-1">利用金額</th>
					<th class="col-sm-1">税送料</th>
<!--
					<th>支払方法</th>
					<th>予備</th>
					<th>予備</th>
					<th>予備</th>
-->
					<th class="col-sm-2">端末処理通番</th>
<!--
					<th>加盟店自由項目</th>
					<th>処理番号</th>
					<th>処理結果</th>
					<th>仕向先コード</th>
					<th>オーソリ結果</th>
-->
				</tr>
<?php
if(isset($contracts)) {
	foreach($contracts as $contract) {
		$i++;
?>				<tr>
					<td><?php echo $contract['payment_id']; ?></td>
					<td><?php echo implode(",", $contract['titles']); ?></td>
<!--
					<td><?php echo $_SERVER['PGCARD_SHOP_ID']; ?></td>
-->
					<td><?php echo $contract['user_id']; ?></td>
<!--
					<td>0</td>
					<td>0</td>
-->
					<td><?php echo date('Ymd', mktime(0, 0, 0, date('m', strtotime($date)), 0, date('Y', strtotime($date)))); ?></td>
					<td><?php echo 	$contract['user_id']."-".$contract['id']; ?></td>
<!--
					<td>0000990</td>
-->
					<td class="text-right"><?php echo number_format(array_sum($contract['prices'])); ?>円</td>
					<td class="text-right"><?php echo number_format(array_sum($contract['prices']) * Config::get("tax")); ?>円</td>
<!--
					<td>1</td>
					<td></td>
					<td></td>
					<td></td>
-->
					<td><?php echo sprintf("%05d",$i); ?></td>
<!--
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
-->
				</tr>
<?php
	}
}
?>
			</table>
		</div>
	</div>
</div>
