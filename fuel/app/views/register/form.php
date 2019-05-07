		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">LASHIC 新規登録のお客様</h1>

			<!-- flow矢印 -->
			<div class="flowSet flow_no03">
				<ol>
					<li class="flowBoxOn">アカウント情報　入力</li>
					<li>アカウント情報　確認</li>
					<li>アカウント登録完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
			
        <!-- デザインあとではめ込み -->
        <div class="mgt30"><a href="#moreInfo" class="fancybox"><img src="/images/regist/regist_img_01.jpg" class="regist_img_01" alt="高齢者の”自立”をささえ
”あんしん”を共有する"/></a></div>
        <div class="floatR"><a href="#moreInfo" class="fancybox link_next">LASHICを知る</a></div>
            <div id="moreInfo" class="moreInfoContainer" style="display: none; width:980px; height:1200px; ">
				<?php echo View::forge('more_info') ?>
            </div>
        <!-- /デザインあとではめ込み -->
			
			
			
			<div class="contentLarge_h2"><h2>アカウント情報　入力</h2></div>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<form class="form h-adr" action="/register" method="post">
				<input type="hidden" class="p-country-name" value="Japan">
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> メールアドレス</th>
										<td><input type="text" name="email" class="input_text input_medium" value="<?php if(isset($data['email'])) { echo $data['email']; } ?>"><br>
										
										<span class="text_red">※</span><span class="small ">初期設定では変更ができません。ご登録完了後、マイページにてメールアドレスをご変更ください。<br>
										<span class="text_red">※</span>携帯電話メールでご登録の場合はPCメール受信設定をご確認いただき、<?php echo Config::get('email.domain'); ?>のメールアドレスを受信可能にご設定ください。</span>
<?php
if(isset($errors['email'])) {
?>
											<p class="error"><?php echo $errors['email']; ?></p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td><input type="text" name="last_name" class="input_text input_short" placeholder="例）山田" value="<?php if(isset($data['last_name'])) { echo $data['last_name']; } ?>">&nbsp;&nbsp;<input type="text" name="first_name" class="input_text input_short" placeholder="例）太郎" value="<?php if(isset($data['first_name'])) { echo $data['first_name']; } ?>">
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
										<td><input type="text" name="last_kana" class="input_text input_short" placeholder="例）やまだ" value="<?php if(isset($data['last_kana'])) { echo $data['last_kana']; } ?>">&nbsp;&nbsp;<input type="text" name="first_kana" class="input_text input_short" placeholder="例）たろう" value="<?php if(isset($data['last_kana'])) { echo $data['last_kana']; } ?>">
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
											<input type="radio" id="male" name="gender" value="m" <?php if(isset($data['gender']) && $data['gender'] === "m") { echo "checked=\"checked\""; } ?>>
											<label for="male" class="checkbox">男性</label>
											<input type="radio" id="female" name="gender" value="f" <?php if(isset($data['gender']) && $data['gender'] === "f") { echo "checked=\"checked\""; } ?>>
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
														<option value="<?php echo $key; ?>" <?php if(isset($data) && $data['year'] == $key) { echo "selected=\"selected\""; } ?>><?php echo $era; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if(isset($data) && $data['month'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if(isset($data) && $data['day'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　日</div>
											</div>
<?php
if(isset($errors['birthday'])) {
?>
											<p class="error">エラー：生年月日を選択してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th>郵便番号</th>
										<td>
											<input type="text" name="zip_code" class="input_text input_short p-postal-code" maxlength="7" placeholder="例）1234567" value="<?php if(isset($data['zip_code'])) { echo $data['zip_code']; } ?>"> &nbsp;&nbsp;<a href="http://www.post.japanpost.jp/zipcode/" target="_blank">郵便番号検索</a>&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select class="p-region" name="prefecture">
														<option value="" selected>都道府県</option>
<?php
foreach($prefectures as $prefecture) {
?>
														<option value="<?php echo $prefecture; ?>"<?php if(isset($data) && $prefecture == $data['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?>
														</option>
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
										<td><input type="text" name="address" class="input_text input_large p-locality p-street-address p-extended-address" placeholder="例）静岡市インフィックマンション302号" value="<?php if(isset($data['address'])) { echo $data['address']; } ?>"><br>
<span class="small text_red">※</span><span class="small">市町村、番地、建物名、室番号までご入力ください。</span>
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
										<td><input type="text" name="phone" class="input_text input_short" maxlength="11" placeholder="例）0542666201" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>"> <span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span></span>
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
										<td><input type="text" name="cellular" class="input_text input_short" maxlength="11" placeholder="例）0542666201" value="<?php if(isset($data['cellular'])) { echo $data['cellular']; } ?>">
										<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> パスワード</th>
										<td><input type="password" name="password" class="input_text input_short" minlength="8" maxlength="16" placeholder="パスワード入力">
										<br>
<span class="small "><span class="text_red">※</span>半角英数 8桁以上<br>
										<span class="text_red">※</span>必ず英字と数字の両方を使って入力してください。大文字小文字は区別されます。<br>
									<span class="text_red">※</span>ユーザーID、郵便番号、電話番号、誕生日など推測できる文字は避けてください。</span>
<?php
if(isset($errors['password'])) {
?>
											<p class="error"><?php echo $errors['password']; ?></p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> パスワード（確認）</th>
										<td><input type="password" name="password_confirm" class="input_text input_short" minlength="8" maxlength="16" placeholder="パスワード入力">
										 <span class="small "><span class="text_red">※</span>確認のため再度ご入力ください。</span></span>
<?php
if(isset($errors['password_confirm'])) {
?>
										<p class="error"><?php echo $errors['password_confirm']; ?></p>
<?php
}
?>
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
