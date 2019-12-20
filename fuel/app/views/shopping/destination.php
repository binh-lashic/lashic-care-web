	<div class="clearfix content"> 
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li class="flowBoxOn_before">カート</li>
				<li class="flowBoxOn">送付先指定</li>
				<li>配送とお支払い</li>
				<li>ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 --> 
		
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">送付先指定</h1>
			<p>LASHIC機器の送付先を入力ください。</p>
		<form class="h-adr" action="/shopping/destination" method="post">
			<input type="hidden" class="p-country-name" value="Japan">
			<!-- 新しい住所追加エラー -->
			<h2 class="form_title">新しい住所を追加</h2>
			<div class="form_set_container">
				<?php if(!empty($errors)) { ?>
					<p class="title_errer"><strong>入力内容にエラーがありました</strong></p>
				<?php } ?>
				<p class="mgt20">必要事項を入力し、「この住所を使う」ボタンをクリックしてください。</p>
				<ul class="ul-disc">
					<li>私書箱や空港内の窓口へのお届けは承っておりません。</li>
					<li>コンビニや営業所などの住所を入力すると商品をお受け取りいただけません。</li>
				</ul>
				<div class="form_set_container_form">
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
									<input type="text" class="input_text input_short" placeholder="例）やまだ" name="last_kana" maxlength="45" value="<?php if(isset($data['last_kana'])) { echo $data['last_kana']; } ?>">&nbsp;&nbsp;
									<input type="text" class="input_text input_short" placeholder="例）たろう" name="first_kana" maxlength="45"value="<?php if(isset($data['first_kana'])) { echo $data['first_kana']; } ?>">
									<?php if(!empty($errors['last_kana'])) { ?>
										<p class="error"><?php echo $errors['last_kana']; ?></p>
									<?php } ?>
									<?php if(!empty($errors['first_kana'])) { ?>
										<p class="error"><?php echo $errors['first_kana']; ?></p>
									<?php } ?>							
								</td>
							</tr>
							<tr>
								<th>郵便番号</th>
								<td><input type="text" name="zip_code" class="input_text input_short p-postal-code" maxlength="7" placeholder="例）1234567" value="<?php if(isset($data['zip_code'])) { echo $data['zip_code']; } ?>">
									&nbsp;&nbsp;
									　&nbsp;&nbsp;<a href="http://www.post.japanpost.jp/zipcode/" target="_blank">郵便番号検索</a>&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角 数字、ハイフンなしでご入力ください。</span>
									<?php if (isset($errors['zip_code'])) {?>
										<p class="error"><?php echo $errors['zip_code']; ?></p>
									<?php } ?>	
								</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 都道府県</th>
								<td><div class="clearfix">
										<div class="floatL common_select">
											<select class="p-region" name="prefecture">
												<option value="" selected>都道府県</option>
													<?php foreach($prefectures as $prefecture) { ?>
														<option value="<?php echo $prefecture; ?>"<?php if(isset($data['prefecture']) && $prefecture == $data['prefecture']) { echo "selected=\"selected\""; } ?>><?php echo $prefecture; ?></option>
													<?php } ?>
											</select>
										</div>
									</div>
								<?php if(!empty($errors['prefecture'])) { ?>
									<p class="error"><?php echo $errors['prefecture']; ?></p>
								<?php } ?>							
								</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 都道府県以下</th>
								<td><input type="text" name="address" class="input_text input_large p-locality p-street-address p-extended-address" placeholder="例）静岡市インフィックマンション302号" value="<?php if(isset($data['address'])) { echo $data['address']; } ?>">
									<br>
									<span class="small text_red">※</span><span class="small">市町村、番地、建物名、室番号までご入力ください。</span>
									<?php if(!empty($errors['address'])) { ?>									
										<p class="error"><?php echo $errors['address']; ?></p>
									<?php }?>
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
						</tbody>
					</table>
					<div class="set_container mgb30">
						<div class="left_container"></div>
						<div class="center_container icon_white_arrow">
							<input type="submit" value="この住所を使う" >
						</div>
						<div class="right_container"></div>
					</div>
				</div>
			</div>
			<!--/ 新しい住所追加エラー -->
			</form>
			<div class="order_alert">
				<p>削除されました</p>
			</div>

			<div class="set_container">
				<div class="left_container"><a href="/shopping/cart" class="link_back">戻る</a></div>
				<div class="center_container"></div>
				<div class="right_container"></div>
			</div>
		</section>
		<!-- /content end　編集一覧 --> 
	</div>
