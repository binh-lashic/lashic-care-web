		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">LASHIC 新規登録のお客様</h1>
			<!-- flow矢印 -->
			<div class="flowSet flow_no03">
				<ol>
					<li class="flowBoxOn_before">アカウント情報　入力</li>
					<li class="flowBoxOn">アカウント情報　確認</li>
					<li>アカウント登録完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
			
			
			
			<div class="contentLarge_h2"><h2>アカウント情報　確認</h2></div>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<form action="/register/complete" method="post">
					<input type="hidden" name="first_name" value="<?php if(!empty($data['first_name'])) { echo $data['first_name']; } ?>" />
					<input type="hidden" name="last_name" value="<?php if(!empty($data['last_name'])) { echo $data['last_name']; } ?>" />
					<input type="hidden" name="first_kana" value="<?php if(!empty($data['first_kana'])) { echo $data['first_kana']; } ?>" />
					<input type="hidden" name="last_kana" value="<?php if(!empty($data['last_kana'])) { echo $data['last_kana']; } ?>" />
					<input type="hidden" name="gender" value="<?php if(!empty($data['gender'])) { echo $data['gender']; } ?>" />
					<input type="hidden" name="birthday" value="<?php if(!empty($data['birthday'])) { echo $data['birthday']; } ?>" />
					<input type="hidden" name="zip_code" value="<?php if(!empty($data['zip_code'])) { echo $data['zip_code']; } ?>" />
					<input type="hidden" name="prefecture" value="<?php if(!empty($data['prefecture'])) { echo $data['prefecture']; } ?>" />
					<input type="hidden" name="address" value="<?php if(!empty($data['address'])) { echo $data['address']; } ?>" />
					<input type="hidden" name="phone" value="<?php if(!empty($data['phone'])) { echo $data['phone']; } ?>" />
					<input type="hidden" name="cellular" value="<?php if(!empty($data['cellular'])) { echo $data['cellular']; } ?>" />
					<input type="hidden" name="email" value="<?php if(!empty($data['email'])) { echo $data['email']; } ?>" />
					<input type="hidden" name="password" value="<?php if(!empty($data['password'])) { echo $data['password']; } ?>" />
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th>メールアドレス</th>
										<td><?php if(!empty($data['email'])) { echo $data['email']; } ?></td>
									</tr>
									<tr>
										<th>お名前</th>
										<td>
											<?php if(!empty($data['last_name'])) { echo $data['last_name']; } ?>
											<?php if(!empty($data['first_name'])) { echo $data['first_name']; } ?>										
										</td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td>
											<?php if(!empty($data['last_kana'])) { echo $data['last_kana']; } ?>
											<?php if(!empty($data['first_kana'])) { echo $data['first_kana']; } ?>
										</td>
									</tr>
									<tr>
										<th>性別</th>
										<td><?php echo $data['gender'] == "m" ? "男性" : "女性"; ?></td>
									</tr>
									<tr>
										<th>生年月日</th>
										<td><?php echo $data['birthday_display']; ?></td>
									</tr>
									<tr>
										<th>住所</th>
										<td>〒<?php if(!empty($data['zip_code'])) { echo $data['zip_code']; } ?><br>
										    <?php if(!empty($data['prefecture'])) { echo $data['prefecture']; } ?>
											<?php if(!empty($data['address'])) { echo $data['address']; } ?>
										</td>
									</tr>
									<tr>
										<th>電話番号1</th>
										<td><?php if(!empty($data['phone'])) { echo $data['phone']; } ?></td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><?php if(!empty($data['cellular'])) { echo $data['cellular']; } ?></td>
									</tr>
									<tr>
										<th>パスワード</th>
										<td>******</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="アカウント登録する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end　編集一覧 --> 
