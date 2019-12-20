		<!-- content start オプション設定変更 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/info_option_form" method="post">
				<h1 class="contentLarge_h1">見守り対象ユーザー　オプション設定変更入力</h1>
				<p>いつでも連絡できる緊急連絡先を設定してください。２件まで登録可能です。</p>
				<!-- 緊急連絡先の設定 -->
				<h2 class="form_title">緊急連絡先の設定</h2>
				<div class="form_set_container">
					<h3 class="content_h3 mgt20">緊急連絡先 1</h3>
						<table>
								<tbody>
									<tr>
										<th>お名前</th>
										<td><input type="text" class="input_text input_short" placeholder="例）山田" name="emergency_last_name_1" maxlength="45" value="<?php echo $client['emergency_last_name_1']; ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）太郎" name="emergency_first_name_1" maxlength="45" value="<?php echo $client['emergency_first_name_1']; ?>">
											<?php if(isset($errors['emergency_last_name_1'])) { ?>
												<p class="error"><?php echo $errors['emergency_last_name_1']; ?></p>
											<?php } ?>
											<?php if(isset($errors['emergency_first_name_1'])) { ?>
												<p class="error"><?php echo $errors['emergency_first_name_1']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td><input type="text" class="input_text input_short" placeholder="例）やまだ" name="emergency_last_kana_1" maxlength="45" value="<?php echo $client['emergency_last_kana_1']; ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）たろう" name="emergency_first_kana_1" maxlength="45" value="<?php echo $client['emergency_first_kana_1']; ?>">
											<?php if(isset($errors['emergency_last_kana_1'])) { ?>
												<p class="error"><?php echo $errors['emergency_last_kana_1']; ?></p>
											<?php } ?>
											<?php if(isset($errors['emergency_first_kana_1'])) { ?>
												<p class="error"><?php echo $errors['emergency_first_kana_1']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>電話番号1</th>
										<td><input type="text" class="input_text input_short" placeholder="例）0542666201" maxlength="11" name="emergency_phone_1" value="<?php echo $client['emergency_phone_1']; ?>">
											<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
											<?php if(isset($errors['emergency_phone_1'])) { ?>
												<p class="error"><?php echo $errors['emergency_phone_1']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><input type="text" class="input_text input_short" placeholder="例）0542666201" maxlength="11" name="emergency_cellular_1" value="<?php echo $client['emergency_cellular_1']; ?>">
											<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
											<?php if(isset($errors['emergency_cellular_1'])) { ?>
												<p class="error"><?php echo $errors['emergency_cellular_1']; ?></p>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
					<h3 class="content_h3 mgt30">緊急連絡先 2</h3>
						<table>
								<tbody>
									<tr>
										<th>お名前</th>
										<td><input type="text" class="input_text input_short" placeholder="例）山田" name="emergency_last_name_2" maxlength="45" value="<?php echo $client['emergency_last_name_2']; ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）太郎" name="emergency_first_name_2" maxlength="45" value="<?php echo $client['emergency_first_name_2']; ?>">
											<?php if(isset($errors['emergency_last_name_2'])) { ?>
												<p class="error"><?php echo $errors['emergency_last_name_2']; ?></p>
											<?php } ?>
											<?php if(isset($errors['emergency_first_name_2'])) { ?>
												<p class="error"><?php echo $errors['emergency_first_name_2']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td><input type="text" class="input_text input_short" placeholder="例）やまだ" name="emergency_last_kana_2" maxlength="45" value="<?php echo $client['emergency_last_kana_2']; ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）たろう" name="emergency_first_kana_2" maxlength="45" value="<?php echo $client['emergency_first_kana_2']; ?>">
											<?php if(isset($errors['emergency_last_kana_2'])) { ?>
												<p class="error"><?php echo $errors['emergency_last_kana_2']; ?></p>
											<?php } ?>
											<?php if(isset($errors['emergency_first_kana_2'])) { ?>
												<p class="error"><?php echo $errors['emergency_first_kana_2']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>電話番号1</th>
										<td><input type="text" class="input_text input_short" placeholder="例）0542666201" maxlength="11" name="emergency_phone_2" value="<?php echo $client['emergency_phone_2']; ?>">
											<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
											<?php if(isset($errors['emergency_phone_2'])) { ?>
												<p class="error"><?php echo $errors['emergency_phone_2']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><input type="text" class="input_text input_short" placeholder="例）0542666201" maxlength="11" name="emergency_cellular_2" value="<?php echo $client['emergency_cellular_2']; ?>">
											<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
											<?php if(isset($errors['emergency_cellular_2'])) { ?>
												<p class="error"><?php echo $errors['emergency_cellular_2']; ?></p>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /緊急連絡先の設定 --> 

				<!-- 連絡共有先の設定 -->
				<a name="share"></a>
				<h2 class="form_title">連絡共有先の設定</h2>
				<div class="form_set_container">
					<div class="clearfix">
						<div class="floatL mgt20"><p>設定した連絡共有者に、お知らせメールが届きます。最大3名まで登録可能です。</p></div>
					</div>
					<?php
if(isset($errors['users_count'])) {
?>
				<p class="error">エラー：<?php echo $errors['users_count']; ?></p>
<?php
}
?>
						<table class="table_border">
								<tbody>
									<tr>
										<th>お名前</th>
										<td>
											<input type="text" class="input_text input_short" name="last_name" maxlength="145">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" name="first_name" maxlength="145">
											<?php if(isset($errors['last_name'])) { ?>
												<p class="error"><?php echo $errors['last_name']; ?></p>
											<?php } ?>
											<?php if(isset($errors['first_name'])) { ?>
												<p class="error"><?php echo $errors['first_name']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td>
											<input type="text" class="input_text input_short" name="last_kana" maxlength="145">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" name="first_kana" maxlength="145">
											<?php if(isset($errors['last_kana'])) { ?>
												<p class="error"><?php echo $errors['last_kana']; ?></p>
											<?php } ?>
											<?php if(isset($errors['first_kana'])) { ?>
												<p class="error"><?php echo $errors['first_kana']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th>メールアドレス</th>
										<td>
											<input type="text" class="input_text input_short" name="email" maxlength="512"> 
											<span class="small text_red">※半角英数でご入力ください。例）example@lashic.jp</span>
											<?php if(isset($errors['email'])) { ?>
												<p class="error"><?php echo $errors['email']; ?></p>
											<?php } ?>
										</td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /連絡共有先の設定 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end オプション設定変更 --> 
		
		
