<div class="row">
	<div class="col-sm-12">
		<h2>システム管理者一覧</h2>
	</div>
</div>
<?php $users = $this->data['users']; ?>
<div class="row">
	<div class="col-sm-6">
            <ul class="nav nav-tabs">
              <li role="presentation" class="active"><a href="">システム管理者一覧</a></li>
              <li role="presentation"><a href="/admin/register">システム管理者作成</a></li>
            </ul>
	</div>
</div>
			<?php if(Session::get_flash('success')){ $err = Session::get_flash('success') ;
				?>
				<div class="alert alert-danger col-sm-12" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="false">×</span></button>
								<?php echo $err[0];  ?>
				</div>
				 <?php } ?>
				 			<?php if(Session::get_flash('errors')){ $err = Session::get_flash('errors') ;
				?>
				<div class="alert alert-danger col-sm-12" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="false">×</span></button>
								<?php echo $err[0];  ?>
							</div>
				 <?php } ?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tbody>
				<tr class="info">
					<th class="col-sm-4">メールアドレス</th>
					<th class="col-sm-2">登録日時</th>
					<th class="col-sm-1">処理</th>
				</tr>
				<tr>
					<?php foreach ( $users as $user){ ?>
					<td>
						<a href="/admin/edit?id=<?php echo $user['id'];  ?>"><?php echo $user['email'];  ?></a>
					</td>										
					<td>
						<?php echo $user['created_at'];  ?>
					</td>
					<td>
						<form action="/admin/delete" class="form-inline" onsubmit="demo1@lashic.jp" accept-charset="utf-8" method="post">
						<input name="id_account"  value="<?php echo $user['id'];  ?>" type="hidden" id="form_fuel_csrf_token">
						<input class="btn btn-sm btn-danger" name="destroy_sysadmin" value="削除" type="submit" id="form_destroy_sysadmin">
						</form>
					</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</div>
	</div>
</div>