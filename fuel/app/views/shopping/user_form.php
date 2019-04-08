	<div class="clearfix content"> 
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li class="flowBoxOn_before">カート</li>
				<li class="flowBoxOn">見守り対象ユーザー設定</li>
				<li>送付先指定</li>
				<li>配送とお支払い</li>
				<li>ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">見守り対象ユーザー　基本情報入力</h1>
<?php
if(!empty($errors)) {
?>
			<p class="title_errer"><strong>入力内容にエラーがありました</strong></p>
<?php
}
?>
			<p>見守り対象ユーザーの情報を入力してください。</p>
			<!-- 基本情報 -->
			<h2 class="form_title">基本情報</h2>
			<form class="h-adr" action="/shopping/user_form" method="post">
			<input type="hidden" class="p-country-name" value="Japan">
			<div class="form_set_container">
				<div class="form_base_data_edit">
					<table>
						<tbody>
							<tr>
								<th><span class="icon_Required">必須</span> お名前</th>
								<td>
									<input type="text" name="last_name" class="input_text input_short" placeholder="例）山田" value="<?php if(isset($data['last_name'])) { echo $data['last_name']; } ?>">&nbsp;&nbsp;
									<input type="text" name="first_name" class="input_text input_short" placeholder="例）太郎" value="<?php if(isset($data['first_name'])) { echo $data['first_name']; } ?>">
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
											<input type="text" class="input_text input_short" placeholder="例）やまだ" name="last_kana" value="<?php if(isset($data['last_kana'])) { echo $data['last_kana']; } ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）たろう" name="first_kana" value="<?php if(isset($data['first_kana'])) { echo $data['first_kana']; } ?>">
								  
								  
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
									<input type="radio" id="male" name="gender" value="m" <?php if(isset($data['gender']) && $data['gender'] == "m") { echo " checked=\"checked\""; } ?>>
									<label for="male" class="checkbox">男性</label>
									<input type="radio" id="female" name="gender" value="f" <?php if(isset($data['gender']) && $data['gender'] == "f") { echo " checked=\"checked\""; } ?>>
									<label for="female" class="checkbox">女性</label>
<?php
if(!empty($errors['gender'])) {
?>
									<p class="error"><?php echo $errors['gender']; ?></p>
<?php
}
?>
								</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 生年月日</th>
								<td><div class="clearfix">
										<div class="floatL common_select">
											<select name="year">
<?php
foreach($eras as $key => $era) {
?>
														<option value="<?php echo $key; ?>" <?php if(isset($data['year']) && $data['year'] == $key) { echo "selected=\"selected\""; } ?>><?php echo $era; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if(isset($data['month']) && $data['month'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if(isset($data['day']) && $data['day'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
									<p class="error">生年月日を選択してください。</p></td>
<?php
}
?>							</tr>
							<tr>
								<th>郵便番号</th>
								<td><input type="text" name="zip_code" class="input_text input_short p-postal-code" maxlength="7" placeholder="例）1234567" value="<?php if(isset($data['zip_code'])) { echo $data['zip_code']; } ?>"> 
									　&nbsp;&nbsp;<a href="http://www.post.japanpost.jp/zipcode/" target="_blank">郵便番号検索</a>&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角数字、ハイフンなしでご入力ください。</span></td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 都道府県</th>
								<td><div class="clearfix">
										<div class="floatL common_select">
												<select class="p-region" name="prefecture">
												<option value="" selected>都道府県</option>
<?php
foreach($prefectures as $prefecture) {
?>
														<option value="<?php echo $prefecture; ?>"<?php if(isset($data['prefecture']) && $prefecture == $data['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?>
														</option>
<?php
}
?>
											</select>
										</div>
									</div>
<?php
if(!empty($errors['prefecture'])) {
?>
									<p class="error"><?php echo $errors['prefecture']; ?></p>
<?php
}
?>								</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 都道府県以下</th>
								<td><input type="text" name="address" class="input_text input_large p-locality p-street-address p-extended-address" placeholder="例）静岡市インフィックマンション302号" value="<?php if(isset($data['address'])) { echo $data['address']; } ?>">
									<br>
									<span class="small text_red">※</span><span class="small">市町村、番地、建物名、室番号までご入力ください。</span>
<?php
if(!empty($errors['address'])) {
?>
									<p class="error"><?php echo $errors['address']; ?></p>
<?php
}
?>
							</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 電話番号1</th>
								<td><input type="text" name="phone" class="input_text input_short" maxlength="11" placeholder="例）0542666201" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>">
									<span class="small text_red">※</span><span class="small">半角数字、ハイフンなしでご入力ください。</span>
<?php
if(!empty($errors['phone'])) {
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
									<span class="small text_red">※</span><span class="small">半角数字、ハイフンなしでご入力ください。</span></td>
							</tr>
							<tr>
								<th>血液型</th>
								<td><div class="clearfix">
										<div class="floatL common_select">
											<select name="blood_type">
												<option value="">選択してください</option>
<?php
foreach($blood_types as $blood_type) {
?>
														<option value="<?php echo $blood_type; ?>" <?php if(isset($data['blood_type']) && $data['blood_type'] == $blood_type) { echo "selected=\"selected\""; } ?>><?php echo $blood_type; ?></option>
<?php
}
?>
											</select>
										</div>
										<div class="floatL pdt5">　型　<span class="small text_red">※</span><span class="small">緊急時に役立てます。できるだけご記入ください。</span></div>
									</div></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /基本情報 -->
			
			<div class="set_container">
				<div class="left_container"><a href="/shipping/user" class="link_back">戻る</a></div>
				<div class="center_container">
					<input type="submit" value="次の画面に進む" >
				</div>
				<div class="right_container"></div>
			</div>
			</form>
		</section>
	</div>