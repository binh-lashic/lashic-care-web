		<!-- content start 基本情報変更エラー -->
		<section id="contentBoxLarge">
			<form class="form h-adr" action="/user/account_basic_form" method="post">
				<input type="hidden" name="id" value="<?php echo $user['id']; ?>">
				<input type="hidden" class="p-country-name" value="Japan">
				<h1 class="contentLarge_h1">アカウント　基本情報変更入力</h1>
				<p>変更したい内容を入力してください。</p>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td>
										<input type="text" class="input_text input_short" name="last_name" value="<?php echo $user['last_name']; ?>">
										<input type="text" class="input_text input_short" name="first_name" value="<?php echo $user['first_name']; ?>">
<?php
if(!empty($error['last_name']) || !empty($error['first_name']) ) {
?>
											<p class="error">お名前を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td>
											<input type="text" class="input_text input_short" name="last_kana" value="<?php echo $user['last_kana']; ?>">
											<input type="text" class="input_text input_short" name="first_kana" value="<?php echo $user['first_kana']; ?>">
<?php
if(!empty($error['last_kana']) || !empty($error['first_kana'])) {
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
											<input type="radio" id="male" name="gender" value="m" <?php if($user['gender'] === "m") { echo "checked=\"checked\""; } ?>>
											<label for="male" class="checkbox">男性</label>
											<input type="radio" id="female" name="gender" value="f" <?php if($user['gender'] === "f") { echo "checked=\"checked\""; } ?>>
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
														<option value="<?php echo $key; ?>" <?php if($user['year'] == $key) { echo "selected=\"selected\""; } ?>><?php echo $era; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if($user['month'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if($user['day'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
											<p class="error">生年月日を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th>郵便番号</th>
										<td><input type="text" class="input_text input_short p-postal-code" maxlength="7" name="zip_code" value="<?php echo $user['zip_code']; ?>">
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
														<option value="<?php echo $prefecture; ?>"<?php if($prefecture == $user['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?></option>
<?php
}
?>
													</select>
												</div>
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
										<td><input type="text" class="input_text input_large p-locality p-street-address p-extended-address" name="address" value="<?php echo $user['address']; ?>"><br>
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
										<td><input type="text" class="input_text input_short" maxlength="11" name="phone" value="<?php echo $user['phone']; ?>"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
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
										<td><input type="text" class="input_text input_short" maxlength="11" name="cellular" value="<?php echo $user['cellular']; ?>"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span></td>
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
		<!-- /content end 基本情報変更エラー -->  