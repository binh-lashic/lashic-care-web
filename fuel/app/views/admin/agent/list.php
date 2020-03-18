<div class="row">
	<div class="col-sm-12">
		<h2>代理店実績管理</h2>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<h3>代理店実績検索</h3>
		<div class="panel panel-default">
			<form action="/admin/agent/list" method="get" class="form-horizontal">
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">代理店名</label>
					<div class="col-sm-10">
						<?php echo Form::select('store', $default_store, $storeList, array('class' => 'select')); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">エージェント名</label>
					<div class="col-sm-10">
						<?php echo Form::select('agent', $default_agent, $agentList, array('class' => 'select')); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">検索期間</label>
					<div class="raw col-sm-10">
						<?php echo Form::select('from_year', $default_from_year, $years, array('class' => 'select')); ?> 年
						<?php echo Form::select('from_month', $default_from_month, $months, array('class' => 'select')); ?> 月
						〜 
						<?php echo Form::select('to_year', $default_to_year, $years, array('class' => 'select')); ?> 年
						<?php echo Form::select('to_month', $default_to_month, $months, array('class' => 'select')); ?> 月
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input class="btn btn-default"  type="submit" value="検索" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
if(Input::param('from_year')) {
?>
<div class="row">
	<div class="col-sm-12">
		<h3>検索結果：</h3>
        <h3>
            <?php echo Input::param('store'); ?> <?php echo Input::param('agent'); ?> 
            <?php echo Input::param('from_year')."年".Input::param('from_month')."月" ?> 〜 
            <?php echo Input::param('to_year')."年".Input::param('to_month')."月"; ?>の実績
        </h3>
        <h3>
            初回利用料合計：<?php echo $filter['initial_count']."件 ".number_format($filter['initial_price'])."円、"; ?>
            月額利用料合計：<?php echo $filter['continuation_count']."件 ".number_format($filter['continuation_price'])."円、"; ?>
            合計：<?php echo $filter['sum_count']."件 ".number_format($filter['sum_price'])."円"; ?>
        </h3>
	</div>
</div>
<?php
}
?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">代理店名</th>
					<th class="col-sm-1">エージェント名</th>
					<th class="col-sm-2">契約プラン名</th>
					<th class="col-sm-1">契約アカウント名</th>
					<th class="col-sm-2">金額</th>
					<th class="col-sm-1">決済月</th> 
					<th class="col-sm-1">契約開始日</th>
					<th class="col-sm-1">契約終了日</th>
				</tr>
<?php
if(isset($agents)) {
	foreach($agents as $agent) {
?>				<tr>
					<td><?php echo $agent['store_name']; ?></td>
					<td><?php echo $agent['agent_name']; ?></td>
					<td><?php echo $agent['title']; ?></td>
					<td><a href="/admin/payment/?id=<?php echo $agent['id']; ?>"><?php echo $agent['last_name']; ?><?php echo $agent['first_name']; ?></a></td>
					<td><?php echo number_format($agent['price']); ?>円</td>
					<td><?php echo $agent['date']; ?></td>
					<td><?php echo $agent['start_date']; ?></td>
					<td><?php echo $agent['end_date']; ?></td>
				</tr>
<?php
	}
}
?>
			</table>
		</div>
		<nav>
		  <ul class="pager">
		    <li class="previous"><a href="<?php echo Uri::update_query_string(array('page' => $page-1)); ?>"><span aria-hidden="true">&larr;</span> 前へ</a></li>
		    <li class="next"><a href="<?php echo Uri::update_query_string(array('page' => $page+1)); ?>">次へ <span aria-hidden="true">&rarr;</span></a></li>
		  </ul>
		</nav>
	</div>
</div>