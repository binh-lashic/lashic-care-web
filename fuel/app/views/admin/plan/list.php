<div class="row">
	<div class="col-sm-12">
		<h2>プラン一覧</h2>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr class="info">
					<th class="col-sm-1">システムID</th>
					<th class="col-sm-7">タイトル</th>
					<th class="col-sm-2">開始日</th>
					<th class="col-sm-2">終了日</th>
				</tr>
<?php
if(isset($plans)) {
	foreach($plans as $plan){
?>
				<tr>
					<td class="text-center">
						<?php echo $plan['id']; ?>
					</td>
					<td>
						<?php echo $plan['title']; ?>
					</td>
					<td class="text-center">
						<?php echo $plan['start_time']; ?>
					</td>
					<td class="text-center">
						<?php echo $plan['end_time']; ?>
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
    <li class="previous"><a href="/admin/plan/list?page=<?php echo $page - 1; ?>&query=<?php echo $query; ?>"><span aria-hidden="true">&larr;</span> 前へ</a></li>
    <li class="next"><a href="/admin/plan/list?page=<?php echo $page + 1; ?>&query=<?php echo $query; ?>">次へ <span aria-hidden="true">&rarr;</span></a></li>
  </ul>
</nav>

	</div>


</div>