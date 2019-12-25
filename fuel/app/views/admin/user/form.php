<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント一覧</h2>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
            <ul class="nav nav-tabs">
              <li role="presentation"><a href="/admin/user/list">親アカウント一覧</a></li>
              <li role="presentation" class="active"><a href="/admin/user/form">親アカウント作成</a></li>
            </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">親アカウント作成</div>
			<div class="panel-body">
                        <?php echo Form::open(['action' => '/admin/user/complete', 'method' => 'post', 'class' => 'form-horizontal']); ?>

				<div class="form-group">
					<label for="sensor_name" class="col-sm-3 control-label">名前</label>
					<div class="col-sm-9"> 
						<?php echo Form::input('last_name', $data['last_name'], array('maxlength' => '45')); ?>　<?php echo Form::input('first_name', $data['first_name'], array('maxlength' => '45')); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">ふりがな</label>
                        		<div class="col-sm-9"> 
						<?php echo Form::input('last_kana', $data['last_kana'], array('maxlength' => '45')); ?>　<?php echo Form::input('first_kana', $data['first_kana'], array('maxlength' => '45')); ?>
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
                                            <?php echo Form::input('zip_code', $data['zip_code'], array('maxlength' => '7')); ?>
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
                                            <?php echo Form::input('phone', $data['phone'], array('maxlength' => '11')); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">電話番号2</label>
                                        <?php if($error['cellular']) : ?>
                                            <font color="red"><?php echo $error['cellular']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('cellular', $data['cellular'], array('maxlength' => '11')); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">メールアドレス</label>
                                        <?php if($error['email']) : ?>
                                            <font color="red"><?php echo $error['email']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::input('email', $data['email'], array('maxlength' => '512')); ?>
					</div>
				</div>
				<div class="form-group">
                           		<label for="sensor_name" class="col-sm-3 control-label">パスワード</label>
                                        <?php if($error['password']) : ?>
                                            <font color="red"><?php echo $error['password']; ?></font>
                                        <?php endif; ?>
                        		<div class="col-sm-9">
                                            <?php echo Form::password('password', $data['password'], array('minlength' => '8', 'maxlength' => '16')); ?>
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
