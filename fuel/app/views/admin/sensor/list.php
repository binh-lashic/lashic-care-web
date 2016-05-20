<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">センサー設定の更新</div>
			<ul class="list-group">
<?php
foreach($sensors as $sensor){
?>
				<li class="list-group-item"><a href="/admin/sensor?id=<?php echo $sensor['id']; ?>"><?php echo $sensor['name']; ?></a></li>
<?php	
} 
?>
			</ul>
		</div>

	</div>
</div>