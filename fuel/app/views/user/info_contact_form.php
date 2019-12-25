		<!-- content start 住所・電話番号変更　エラー -->
		<section id="contentBoxLarge">
			<form class="form h-adr" action="/user/info_contact_form" method="post">
				<input type="hidden" name="id" value="<?php echo $client['id']; ?>">
				<input type="hidden" class="p-country-name" value="Japan">
				<h1 class="contentLarge_h1">見守り対象ユーザー　住所・電話番号変更入力</h1>
				<p>変更したい内容を入力してください。</p>
				<!-- 住所・電話番号 -->
				<h2 class="form_title">住所・電話番号</h2>
				<div class="form_set_container">
						<table>
								<tbody>
									<tr>
										<th>郵便番号</th>
										<td><input type="text" class="input_text input_short p-postal-code" maxlength="7" name="zip_code" value="<?php echo $client['zip_code']; ?>"> 
											<span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）1234567</span>
											<?php if (isset($errors['zip_code'])) {?>
												<p class="error"><?php echo $errors['zip_code']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県</th>
										<td>
											<div class="clearfix">
												<div class="floatL common_select">
													<select class="p-region" name="prefecture">
														<option value="" selected>都道府県</option>
														<?php foreach($prefectures as $prefecture) { ?>
															<option value="<?php echo $prefecture; ?>"<?php if($prefecture == $client['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="floatL">&nbsp;&nbsp;
												<a href="http://www.post.japanpost.jp/zipcode/" target="_blank">郵便番号検索</a></div>
											</div>
											<?php if(isset($errors['prefecture'])) { ?>
												<p class="error"><?php echo $errors['prefecture']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 都道府県以下</th>
										<td><input type="text" class="input_text input_large p-locality p-street-address p-extended-address" name="address" value="<?php echo $client['address']; ?>"><br>
											<span class="small text_red">※市町村、番地、建物名、室番号までご入力ください。</span>
											<?php if(isset($errors['address'])) { ?>
												<p class="error"><?php echo $errors['address']; ?></p>
											<?php } ?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 電話番号1</th>
										<td><input type="text" class="input_text input_short" maxlength="11" name="phone" value="<?php echo $client['phone']; ?>"> <span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
											<?php if(isset($errors['phone'])) { ?>
												<p class="error"><?php echo $errors['phone']; ?></p>
											<?php }?>
										</td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td>
											<input type="text" class="input_text input_short" maxlength="11" name="cellular" value="<?php echo $client['cellular']; ?>"> 
											<span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
											<?php if(isset($errors['cellular'])) { ?>
												<p class="error"><?php echo $errors['cellular']; ?></p>
											<?php }?>
										</td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /住所・電話番号 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end 住所・電話番号変更　エラー --> 
		