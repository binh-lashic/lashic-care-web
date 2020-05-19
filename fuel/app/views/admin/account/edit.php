<div class="row">
	<div class="col-sm-12">
		<h2>システム管理者編集</h2>
	</div>
</div>
<?php $users = $this->data; 
	foreach ( $users as $user ) {
		$email = $user['email'];
		$id = $user['id'];
	}
?>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<?php if(Session::get_flash('success')){ $err = Session::get_flash('success') ;
				?>
				<div class="alert alert-danger col-sm-12" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="false">×</span></button>
				<?php echo $err[0];  ?>
				</div>
				<?php } ?>
				<?php if(Session::get_flash('errors')){ $err = Session::get_flash('errors') ; ?>
				<div class="alert alert-danger col-sm-12" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="閉じる"><span aria-hidden="false">×</span></button>
								<?php echo $err[0];  ?>
							</div>
				<?php } ?>
				<p>
				</p>
		<form action="/admin/update" class="form-horizontal" method="post">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_email">メールアドレス</label>
					<div class="col-sm-4">
						<input type="hidden" class="form-control" value = "<?php   echo $id; ?>" name="id" id="form_email" />
						<input type="email" class="form-control"  readonly="1" value = "<?php   echo $email; ?>" name="email" id="form_email" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_email_confirmation">メールアドレス(確認)</label>
					<div class="col-sm-4">
						<input type="email" class="form-control"  readonly="1" value = "<?php echo $email; ?>" name="email_confirmation" id="form_email_confirmation" />
					</div>
					</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_password">パスワード</label>
					<div class="col-sm-4">
						<input class="form-control" name="password" type="password" id="form_password" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="form_password_confirmation">パスワード(確認)</label>
					<div class="col-sm-4">
						<input class="form-control" name="password_confirmation" value="" type="password" id="form_password_confirmation" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
					<a class="btn btn-default" href="/admin/account/index">戻る</a>
					<input class="btn btn-primary" name="update_account" value="更新" type="submit" id="form_update_account" />
					</div>
				</div>
		</form>
		</div>
	</div>
</div>
<div class="row">
</div>