<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント:<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/admin/user/?id=<?php echo $id; ?>">詳細</a></li>
      <li role="presentation"><a href="/admin/user/sensor?id=<?php echo $id; ?>">センサー機器割当</a></li>
      <li role="presentation" class="active"><a href="/admin/user/client_form?id=<?php echo $id; ?>">見守られユーザ登録</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">見守られユーザの新規登録</div>
			<div class="panel-body">
                        <?php echo Form::open(['action' => '/admin/user/client_complete', 'method' => 'post', 'class' => 'form-horizontal']); ?>
                                <?php echo Form::hidden('id', $id); ?>

				<div class="form-group">
					<label for="sensor_name" class="col-sm-3 control-label">名前</label>
					<div class="col-sm-9"> 
						<?php echo Form::input('last_name', $data['last_name']); ?>　<?php echo Form::input('first_name', $data['first_name']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">ふりがな</label>
                        		<div class="col-sm-9"> 
						<?php echo Form::input('last_kana', $data['last_kana']); ?>　<?php echo Form::input('first_kana', $data['first_kana']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">性別</label>
                        		<div class="col-sm-9">
                                            <?php foreach($List['gender'] as $key => $value) : ?>
						<?php echo Form::radio('gender', $key, $data['gender']); ?><?php echo Form::label($value, 'gender'); ?>　
                                            <?php endforeach; ?>
					</div>
				</div> 
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">生年月日</label>
                        		<div class="col-sm-9">
                                            <?php echo Form::select('year', $data['year'], $List['eras']); ?>年　<?php echo Form::select('month', $data['month'], $List['months']); ?>月　<?php echo Form::select('day', $data['day'], $List['days']); ?>日
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">血液型</label>
                        		<div class="col-sm-9">
                                            <?php echo Form::select('blood_type', $data['blood_type'], $List['blood_type']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">郵便番号</label>
                                        <?php if($error['zip_code']) : ?>
                                            <font color="red"><?php echo $error['zip_code']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('zip_code', $data['zip_code']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">都道府県</label>
                        		<div class="col-sm-9">
                                            <?php echo Form::select('prefecture', $data['prefecture'], $List['prefectures']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">都道府県以下</label>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('address', $data['address']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">電話番号1</label>
                                        <?php if($error['phone']) : ?>
                                            <font color="red"><?php echo $error['phone']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('phone', $data['phone']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">電話番号2</label>
                                        <?php if($error['cellular']) : ?>
                                            <font color="red"><?php echo $error['cellular']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('cellular', $data['cellular']); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">メールアドレス</label>
                                        <?php if($error['email']) : ?>
                                            <font color="red"><?php echo $error['email']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('email', $data['email']); ?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="submit" class="btn btn-primary">
					  		<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 登録する
						</button>
					</div>
				</div>
			<?php echo Form::close(); ?>
			</div>
		</div>
	</div>
</div>
