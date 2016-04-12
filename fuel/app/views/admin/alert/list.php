<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">アラート一覧</div>
			<table class="table">
			    <tr>
			    	<th>ID</th>
			    	<th>Sensor ID</th>
			    	<th>日付</th>
			    	<th>内容</th>
			    	<th>タイプ</th>
			    	<th>カテゴリー</th>
			    </tr>
<?php
foreach($alerts as $alert) {
//[id] => 42 [sensor_id] => 1 [title] => 通信断 [description] => 通信断 [date] => 2016-02-24 13:57:11 [category] => [type] => [reason] => [confirm_status] => [confirm_user_id] => [confirm_date] => [responder_user_id] => [corresponding_type] => [expected_description] => [corresponding_status] => [report_description] => [manager_confirm_status] => [corresponding_date] => [corresponding_time] => [corresponding_description] => [corresponding_user_id
?>
			    <tr>
			    	<td><?php echo $alert['id']; ?></td>
			    	<td><?php echo $alert['sensor_id']; ?></td>
			    	<td><?php echo $alert['date']; ?></td>
			    	<td><?php echo $alert['title']; ?></td>
			    	<td><?php echo $alert['type']; ?></td>
			    	<td><?php echo $alert['category']; ?></td>
			    </tr>
<?php
}
?>
			</table>
		</div>
	</div>
</div>