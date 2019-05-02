		<!-- content start アカウント本登録 -->
		<section id="contentBoxLarge">
			<form class="form h-adr" action="/user/temp_account_form" method="post">
				<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
				<input type="hidden" class="p-country-name" value="Japan">
				<h1 class="contentLarge_h1">アカウント本登録　入力</h1>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td>
										<input type="text" class="input_text input_short" name="last_name" value="<?php echo $data['last_name']; ?>">
										<input type="text" class="input_text input_short" name="first_name" value="<?php echo $data['first_name']; ?>">
<?php
if(isset($errors['last_name'])) {
  ?>
											<p class="error"><?php echo $errors['last_name']; ?></p>
  <?php
}
?>
<?php
if(isset($errors['first_name'])) {
  ?>
											<p class="error"><?php echo $errors['first_name']; ?></p>
  <?php
}
?>
										
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td>
											<input type="text" class="input_text input_short" name="last_kana" value="<?php echo $data['last_kana']; ?>">
											<input type="text" class="input_text input_short" name="first_kana" value="<?php echo $data['first_kana']; ?>">
<?php
if(isset($errors['last_kana'])) {
  ?>
											<p class="error"><?php echo $errors['last_kana']; ?></p>
  <?php
}
?>
<?php
if(isset($errors['first_kana'])) {
  ?>
											<p class="error"><?php echo $errors['first_kana']; ?></p>
  <?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 性別</th>
										<td>
											<input type="radio" id="male" name="gender" value="m" <?php if($data['gender'] === "m") { echo "checked=\"checked\""; } ?>>
											<label for="male" class="checkbox">男性</label>
											<input type="radio" id="female" name="gender" value="f" <?php if($data['gender'] === "f") { echo "checked=\"checked\""; } ?>>
											<label for="female" class="checkbox">女性</label>
<?php
if(isset($errors['gender'])) {
  ?>
											<p class="error"><?php echo $errors['gender']; ?></p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 生年月日</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select name="year">
<?php
foreach($eras as $key => $era) {
?>
														<option value="<?php echo $key; ?>" <?php if($data['year'] == $key) { echo "selected=\"selected\""; } ?>><?php echo $era; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　年　</div>
												<div class="floatL common_select">
													<select name="month">
														<option value="">選択してください</option>
<?php
for($i = 1; $i <= 12; $i++) {
?>
														<option value="<?php echo $i; ?>" <?php if($data['month'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　月　</div>
												<div class="floatL common_select">
													<select name="day">
														<option value="">選択してください</option>
<?php
for($i = 1; $i <= 31; $i++) {
?>
														<option value="<?php echo $i; ?>" <?php if($data['day'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　日</div>
											</div>
<?php
if(!empty($errors['birthday'])) {
?>
											<p class="error">生年月日を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th>郵便番号</th>
										<td><input type="text" class="input_text input_short p-postal-code" maxlength="7" name="zip_code" value="<?php echo $data['zip_code']; ?>">
										<span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）1234567</span></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select class="p-region" name="prefecture">
														<option value="">都道府県</option>
<?php
foreach($prefectures as $prefecture) {
?>
														<option value="<?php echo $prefecture; ?>"<?php if($prefecture == $data['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?></option>
<?php
}
?>
													</select>
												</div>
											</div>
<?php
if(isset($errors['prefecture'])) {
  ?>
											<p class="error"><?php echo $errors['prefecture']; ?></p>
  <?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県以下</th>
										<td><input type="text" class="input_text input_large p-locality p-street-address p-extended-address" name="address" value="<?php echo $data['address']; ?>"><br>
<span class="small text_red">※市町村、番地、建物名、室番号までご入力ください。</span>
<?php
if(isset($errors['address'])) {
  ?>
											<p class="error"><?php echo $errors['address']; ?></p>
  <?php
}
?>

										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 電話番号1</th>
										<td><input type="text" class="input_text input_short" maxlength="11" name="phone" value="<?php echo $data['phone']; ?>"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
<?php
if(isset($errors['phone'])) {
  ?>
											<p class="error"><?php echo $errors['phone']; ?></p>
  <?php
}
?>
										</td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td>
											<input type="text" class="input_text input_short" maxlength="11" name="cellular" value="<?php echo $data['cellular']; ?>"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
<?php
if(isset($errors['cellular'])) {
  ?>
											<p class="error"><?php echo $errors['cellular']; ?></p>
  <?php
}
?>
										</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 変更するメールアドレス</th>
										<td><?php echo Form::input('new_email', $data['new_email'], ['class' => 'input_text input_medium', 'id' => null]); ?><span class="small text_red">※半角英数　例）hoge@hoge.jp</span>
										  <?php if(!empty($errors['new_email'])) : ?>
											  <p class="error">変更するメールアドレスを入力してください。</p>
										  <?php endif; ?>
										  <?php if(!empty($errors['email_duplicate'])) : ?>
											  <p class="error">変更するメールアドレスは既に登録されています。</p>
										  <?php endif; ?>
										</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 変更するメールアドレス　確認</th>
										<td><?php echo Form::input('new_email_confirm', $data['new_email_confirm'], ['class' => 'input_text input_medium', 'id' => null]); ?><span class="small text_red">※半角英数　例）hoge@hoge.jp</span>
										  <?php if(!empty($errors['new_email_confirm'])) : ?>
											  <p class="error">変更するメールアドレスが一致しません。</p>
										  <?php endif; ?>										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 当社からのメール案内</th>
										<td>
											<input type="radio" id="yes" name="subscription" value="1" <?php if($data['subscription'] == 1) { echo "checked=\"checked\""; } ?>>
											<label for="yes" class="checkbox">受け取る</label>
											<input type="radio" id="no" name="subscription" value="0" <?php if($data['subscription'] == 0) { echo "checked=\"checked\""; } ?>>
											<label for="no" class="checkbox">受け取らない</label></td>
									</tr>
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
										<td><?php echo Form::password('new_password_confirm', $data['new_password_confirm'], ['class' => 'input_text input_short']); ?> <span class="small text_red">※半角英数 8桁以上</span>
										  <?php if($errors['new_password_confirm']) : ?>
											  <p class="error"><?php echo $errors['new_password_confirm']; ?></p>
										  <?php endif; ?>
										</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 -->
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end アカウント本登録 -->