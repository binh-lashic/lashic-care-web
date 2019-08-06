		<!-- content start 基本情報変更 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/info_basic_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $client['id']; ?>">
				<h1 class="contentLarge_h1">見守り対象ユーザー　基本情報変更入力</h1>
				<p>変更したい内容を入力してください。</p>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<?php if (isset($errors['profile_image'])) { ?>
							<p class="error"><?php echo $errors['profile_image']; ?></p>
						<?php } ?>
						<div class="userDate_photo">
							<div class="aside_photo">
								<div class="aside_photoInner"><img src="<?php echo $client['profile_image']; ?>" width="179" height="179" alt=""/></div>
							</div>
							<div class="uploadButton btn_text">ファイルを選択<br>（最大<?php echo Config::get('img_config.properties.size') ?>MB）
								<input type="file" name="profile_image" onChange="uv.style.display='inline-block'; uv.value = this.value;" />
								<input type="text" id="uv" class="uploadValue" disabled />
							</div>
						</div>
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td>
											<input type="text" class="input_text input_short" placeholder="例）山田" name="last_name" value="<?php echo $client['last_name']; ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）太郎" name="first_name" value="<?php echo $client['first_name']; ?>">
											<?php if(isset($errors['last_name'])) { ?>
												<p class="error"><?php echo $errors['last_name']; ?></p>
											<?php } ?>
											<?php if(isset($errors['first_name'])) { ?>
												<p class="error"><?php echo $errors['first_name']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td>
											<input type="text" class="input_text input_short" placeholder="例）やまだ" name="last_kana" value="<?php echo $client['last_kana']; ?>">&nbsp;&nbsp;
											<input type="text" class="input_text input_short" placeholder="例）たろう" name="first_kana" value="<?php echo $client['first_kana']; ?>">
											<?php if(isset($errors['last_kana'])) { ?>
												<p class="error"><?php echo $errors['last_kana']; ?></p>
											<?php } ?>
											<?php if(isset($errors['first_kana'])) { ?>
												<p class="error"><?php echo $errors['first_kana']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 性別</th>
										<td>
											<input type="radio" id="male" name="gender" value="m" <?php if($client['gender'] == "m") { echo " checked=\"checked\""; } ?>>
											<label for="male" class="checkbox">男性</label>
											<input type="radio" id="female" name="gender" value="f" <?php if($client['gender'] == "f") { echo " checked=\"checked\""; } ?>>
											<label for="female" class="checkbox">女性</label>
											<?php if(isset($errors['gender'])) { ?>
												<p class="error"><?php echo $errors['gender']; ?></p>
											<?php } ?>
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
														<option value="<?php echo $key; ?>" <?php if($client['year'] == $key) { echo "selected=\"selected\""; } ?>><?php echo $era; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if($client['month'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
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
														<option value="<?php echo $i; ?>" <?php if($client['day'] == $i) { echo "selected=\"selected\""; } ?>><?php echo $i; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　日</div>
											</div>
										  <?php if(isset($errors['birthday'])) { ?>
											  <p class="error">生年月日を選択してください。</p>
										  <?php } ?>
										</td>
									</tr>
									<tr>
										<th>血液型</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select name="blood_type">
														<option value="">選択してください</option>
<?php
foreach($blood_types as $blood_type) {
?>
														<option value="<?php echo $blood_type; ?>" <?php if($client['blood_type'] == $blood_type) { echo "selected=\"selected\""; } ?>><?php echo $blood_type; ?></option>
<?php
}
?>
													</select>
												</div>
												<div class="floatL pdt5">　型　<span class="small text_red">※緊急時に役立てます。できるだけご記入ください。</span></div>
											</div>
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
		<!-- /content end 基本情報変更 --> 