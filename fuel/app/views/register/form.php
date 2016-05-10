		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">Care Eye 新規登録のお客様</h1>
			<p>インフィックさんからご招待があります。</p>
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
			<div class="contentLarge_h2"><h2>必要な情報を、分かりやすく、シンプルに。ご家族などの介護者にお伝えします。</h2></div>
			<p>コンテンツデザインはあとから挿入</p>
			<!-- /デザインあとではめ込み -->
			
			
			
			<div class="contentLarge_h2"><h2>アカウント情報　入力</h2></div>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> メールアドレス</th>
										<td>hoge@hoge.jp<br>
										<span class="small text_red">※初期設定では変更ができません。ご登録完了後、マイページにてメールアドレスをご変更ください。<br>
※携帯電話メールでご登録の場合はPCメール受信設定をご確認いただき、hoge.comのメールアドレスを受信可能にご設定ください。</span></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td><input type="text" name="name" class="input_text input_medium">
<?php
if(!empty($error['name'])) {
?>
											<p class="error">お名前を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td><input type="text" name="kana" class="input_text input_medium">
<?php
if(!empty($error['kana'])) {
?>
											<p class="error">ふりがなを入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 性別</th>
										<td>
											<input type="radio" id="male" name="gender" value="m" <?php if(!empty($user) && $user['gender'] === "m") { echo "checked=\"checked\""; } ?>>
											<label for="male" class="checkbox">男性</label>
											<input type="radio" id="female" name="gender" value="f" <?php if(!empty($user) && $user['gender'] === "f") { echo "checked=\"checked\""; } ?>>
											<label for="female" class="checkbox">女性</label>
<?php
if(!empty($error['gender'])) {
?>

											<p class="error">エラー：性別を選択してください。</p>
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
														<option value="<?php echo $key; ?>" <?php if(!empty($user) && $user['year'] == $key) { echo "selected=\"selected\""; } ?>><?php echo $era; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if(!empty($user) && $user['month'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if(!empty($user) && $user['day'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　日</div>
											</div>
<?php
if(!empty($error['birthday'])) {
?>
											<p class="error">エラー：生年月日を選択してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th>郵便番号</th>
										<td><input type="text" class="input_text input_short" maxlength="7"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）1234567</span></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select nmae="prefecture">
														<option value="" selected>都道府県</option>
<?php
foreach($prefectures as $prefecture) {
?>
														<option value="<?php echo $prefecture; ?>"<?php if(!empty($user) && $prefecture == $user['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?>
														</option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL">&nbsp;&nbsp;<input class="btn_text btn_text_large" type="submit" value="郵便番号から住所を設定" ></div>
											</div>
<?php
if(!empty($error['prefecture'])) {
?>
											<p class="error">都道府県を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県以下</th>
										<td><input type="text" name="address" class="input_text input_large"><br>
											<span class="small text_red">※市町村、番地、建物名、室番号までご入力ください。</span>
<?php
if(!empty($error['address'])) {
?>
											<p class="error">都道府県以下を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 電話番号1</th>
										<td><input type="text" class="input_text input_short" maxlength="11"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
<?php
if(!empty($error['phone'])) {
?>
											<p class="error">電話番号1を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><input type="text" class="input_text input_short" maxlength="11"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> パスワード</th>
										<td><input type="password" name="password" class="input_text input_short" maxlength="8"> <span class="small text_red">※半角英数 8桁</span>
<?php
if(!empty($error['password'])) {
?>
											<p class="error">エラー：パスワードを入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> パスワード（確認）</th>
										<td><input type="password" name="password_confirm" class="input_text input_short" maxlength="8"> <span class="small text_red">※確認のため誤入力ください。</span>
<?php
if(!empty($errors['password_confirm'])) {
?>
										<p class="error">エラー：パスワードが一致しません。</p>
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
		</section>
		<!-- /content end　編集一覧 --> 