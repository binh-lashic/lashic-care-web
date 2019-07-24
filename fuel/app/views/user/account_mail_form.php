		<!-- content start メールアドレス変更エラー -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account_mail_form" method="post">
				<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
				<h1 class="contentLarge_h1">アカウント　メールアドレス変更申し込み入力</h1>
				<p>新しいメールアドレスを入力してください。<br>
<span class="text_red">※携帯メールアドレスをご登録の際はPCメールの受信設定を確認し、「×××@×××.com」を受信できるように設定してください。</span></p>
				<!-- /メールアドレス -->
				<h2 class="form_title">メールアドレス</h2>
				<div class="form_set_container">
						<table>
								<tbody>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 変更するメールアドレス</th>
										<td><?php echo Form::input('new_email', $data['new_email'], ['class' => 'input_text input_medium', 'id' => null]); ?><span class="small text_red">※半角英数　例）hoge@hoge.jp</span>
											<?php if(!empty($errors['new_email'])) : ?>
												<p class="error"><?php echo $errors['new_email']; ?></p></p>
											<?php  endif; ?>                                                                                   
                                        </td>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 変更するメールアドレス　確認</th>
										<td><?php echo Form::input('new_email_confirm', $data['new_email_confirm'], ['class' => 'input_text input_medium', 'id' => null]); ?><span class="small text_red">※半角英数　例）hoge@hoge.jp</span>
											<?php if(!empty($errors['new_email_confirm'])) : ?>
												<p class="error"><?php echo $errors['new_email_confirm']; ?></p>
											<?php  endif; ?>                                                                                   
                                        </td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 当社からのメール案内</th>
										<td>
											<input type="radio" id="yes" name="subscription" <?php if($user['subscription'] == 1) { echo "checked=\"checked\""; } ?>>
											<label for="yes" class="checkbox">受け取る</label>
											<input type="radio" id="no" name="subscription" <?php if($user['subscription'] == 0) { echo "checked=\"checked\""; } ?>>
											<label for="no" class="checkbox">受け取らない</label></td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /メールアドレス--> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end メールアドレス変更エラー --> 