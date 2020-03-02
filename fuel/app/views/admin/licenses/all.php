<div class="row">
	<div class="col-sm-12">
		<h2>ライセンスコード一覧</h2>
	</div>
</div>

<div class="pull-right">
	<a class="btn-sm btn-primary" href="/admin/licenses/new">ライセンスコードを登録する</a>
</div>
<!--
<div class="row">
	<div class="col-sm-6">
		<form action="/admin/contract/list" method="get">
			<div class="input-group">
		  		<input type="text" class="form-control" placeholder="名前、ふりがなで検索" name="query" value="">
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
        <?php echo Form::open(['action' => '/admin/licenses/submit_select', 'method' => 'post']);?>
			<table class="table table-bordered">
				<tr class="info">
                    <th class="col-sm-1">チェック</th>
                    <th class="col-sm-1">システムID</th>
					<th class="col-sm-2">ライセンスコード</th>
					<th class="col-sm-2">アカウント</th>
					<th class="col-sm-2">種別</th>
					<th class="col-sm-1">ステータス</th>
					<th class="col-sm-1">出荷日</th>
				</tr>
                <?php if(isset($license_codes)) {
                    foreach($license_codes as $license_code) { ?>				
                        <tr>
                            <td><?php echo Form::checkbox('license_id[]', $license_code['id'], false); ?></td>
                            <td><?php echo $license_code['id']; ?></td>
                            <td><?php echo $license_code['code']; ?></td>
                            <td><?php echo $license_code['email']; ?></td>
                            <td><?php echo $license_code['name']."(".$license_code['sensor_type_name'].")"; ?></td>
                            <td><?php echo $license_code_status[$license_code['status']]; ?></td>
                            <td><?php echo $license_code['shipping_date']; ?></td>
                        </tr>
                <?php }} ?>
            </table>
        <input class="btn btn-sm btn-primary" name="submit_type" value="CSV出力" type="submit" id="form_get_csv">
        <?php echo Form::select('status', 'none', ['none'=>'----', '0'=>'未出荷', '1'=>'出荷済み', '2'=>'利用済み', '3'=>'削除']);?>
        <input class="btn btn-sm btn-primary" name="submit_type" value="ステータス変更" type="submit" id="change_status">
        <?php echo Form::csrf(); ?>
        <?php echo Form::close();?>
		<nav>
		  <ul class="pager">
            <li class="previous"><?php echo Pagination::instance('licenses_all_pagination')->previous();?></li>
            <li class="next"><?php echo Pagination::instance('licenses_all_pagination')->next();?></li>
		  </ul>
		</nav>
	</div>
</div>