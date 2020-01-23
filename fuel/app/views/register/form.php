		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">初めて利用される方はこちら</h1>

			<!-- flow矢印 -->
			<div class="flowSet flow_no03">
				<ol>
					<li class="flowBoxOn">アカウント情報　入力</li>
					<li>アカウント情報　確認</li>
					<li>アカウント登録完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
			
			<div class="contentLarge_h2"><h2>アカウント情報　入力</h2></div>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<form class="form h-adr" action="/register?token=<?php echo $data['token']; ?>" method="post">
				<input type="hidden" class="p-country-name" value="Japan">
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td>
											<input type="text" name="last_name" class="input_text input_short" placeholder="例）山田" maxlength="45" value="<?php if(isset($data['last_name'])) { echo $data['last_name']; } ?>">&nbsp;&nbsp;
											<input type="text" name="first_name" class="input_text input_short" placeholder="例）太郎" maxlength="45" value="<?php if(isset($data['first_name'])) { echo $data['first_name']; } ?>">
										  <?php if(!empty($errors['last_name'])) { ?>
											  <p class="error"><?php echo $errors['last_name']; ?></p>
										  <?php } ?>
										  <?php if(!empty($errors['first_name'])) { ?>
											  <p class="error"><?php echo $errors['first_name']; ?></p>
										  <?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td>
											<input type="text" class="input_text input_short" name="last_kana" maxlength="45" value="<?php echo $data['last_kana']; ?>">
											<input type="text" class="input_text input_short" name="first_kana" maxlength="45" value="<?php echo $data['first_kana']; ?>">
										  <?php if (isset($errors['last_kana'])) { ?>
											  <p class="error"><?php echo $errors['last_kana']; ?></p>
										  <?php } ?>
										  <?php if (isset($errors['first_kana'])) { ?>
											  <p class="error"><?php echo $errors['first_kana']; ?></p>
										  <?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 電話番号</th>
										<td><input type="text" name="phone" class="input_text input_short" maxlength="11" placeholder="例）0542666201" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>">
											<span class="small text_red">※</span><span class="small">半角数字、ハイフンなしでご入力ください。</span>
										  <?php if(!empty($errors['phone'])) { ?>
											  <p class="error"><?php echo $errors['phone']; ?></p>
										  <?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> メールアドレス</th>
										<td>
											<input type="text" name="email" class="input_text input_medium" maxlength="512" value="<?php if(isset($data['email'])) { echo $data['email']; } ?>"><br>
											<?php if(isset($errors['email'])) {?>
												<p class="error"><?php echo $errors['email']; ?></p>
											<?php }?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> パスワード</th>
										<td><input type="password" name="password" class="input_text input_short" minlength="8" maxlength="16" placeholder="パスワード入力"><br>
											<span class="small "><span class="text_red">※</span>半角英数 8桁以上<br>
											<span class="text_red">※</span>必ず英字と数字の両方を使って入力してください。大文字小文字は区別されます。<br>
											<span class="text_red">※</span>ユーザーID、郵便番号、電話番号、誕生日など推測できる文字は避けてください。</span>
											<?php if(isset($errors['password'])) { ?>
												<p class="error"><?php echo $errors['password']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> パスワード（確認）</th>
										<td><input type="password" name="password_confirm" class="input_text input_short" minlength="8" maxlength="16" placeholder="パスワード入力">
											<span class="small "><span class="text_red">※</span>確認のため再度ご入力ください。</span></span>
											<?php if(isset($errors['password_confirm'])) { ?>
												<p class="error"><?php echo $errors['password_confirm']; ?></p>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 -->
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end　編集一覧 -->
