		<!-- content start パスワード変更　エラー -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account_password_form" method="post">
				<h1 class="contentLarge_h1">アカウント　パスワード変更入力</h1>
                                <?php if(!empty($errors['update_password_error'])) : ?>
                                    <p class="error">パスワード変更に失敗しました。</p>
                                <?php endif; ?>
				<p>新しいパスワードを入力してください。</p>
				<!-- パスワード -->
				<h2 class="form_title">パスワード</h2>
				<div class="form_set_container">
						<table>
								<tbody>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 現在のパスワード</th>
										<td><?php echo Form::password('password', $data['password'], ['class' => 'input_text input_short']); ?> <span class="small text_red">※半角英数 8桁以上</span>
									<?php if($errors['password']) : ?>
                                                                                   <p class="error"><?php echo $errors['password']; ?></p>
									<?php endif; ?>                                                   
									</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 新しいパスワード</th>
										<td><?php echo Form::password('new_password', $data['new_password'], ['class' => 'input_text input_short']); ?> <span class="small text_red">※半角英数 8桁以上で、できるだけ複雑な文字の組み合わせでご入力ください。　例）W4eHvmCE</span>
									<?php if($errors['new_password']) : ?>
										<p class="error"><?php echo $errors['new_password']; ?></p>
									<?php endif; ?>
                                                                                </td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 新しいパスワード　確認</th>
										<td><?php echo Form::password('new_password_confirm', $data['new_password_confirm'], ['class' => 'input_text input_short', 'minlength' => '8', 'maxlength' => '16']); ?> <span class="small text_red">※半角英数 8桁以上</span>
									<?php if($errors['new_password_confirm']) : ?>
										<p class="error"><?php echo $errors['new_password_confirm']; ?></p>
									<?php endif; ?>
									</td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /パスワード --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
				<p class="center"><a href="/password/">パスワードを忘れた方はこちら</a></p>
			</form>
		</section>
		<!-- /content end パスワード変更　エラー --> 
		
		