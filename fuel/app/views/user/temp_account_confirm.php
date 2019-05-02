		<!-- content start アカウント本登録確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/temp_account_complete" method="post">
				<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
				<input type="hidden" name="last_name" value="<?php echo $data['last_name']; ?>">
				<input type="hidden" name="first_name" value="<?php echo $data['first_name']; ?>">
				<input type="hidden" name="last_kana" value="<?php echo $data['last_kana']; ?>">
				<input type="hidden" name="first_kana" value="<?php echo $data['first_kana']; ?>">
				<input type="hidden" name="birthday" value="<?php echo $data['birthday']; ?>">
				<input type="hidden" name="prefecture" value="<?php echo $data['prefecture']; ?>">
				<input type="hidden" name="zip_code" value="<?php echo $data['zip_code']; ?>">
				<input type="hidden" name="address" value="<?php echo $data['address']; ?>">
				<input type="hidden" name="phone" value="<?php echo $data['phone']; ?>">
				<input type="hidden" name="cellular" value="<?php echo $data['cellular']; ?>">
				<input type="hidden" name="cellular" value="<?php echo $data['cellular']; ?>">
				<input type="hidden" name="email" value="<?php echo $data['new_email']; ?>">
				<input type="hidden" name="subscription" value="<?php echo $data['subscription']; ?>">
				<input type="hidden" name="password" value="<?php echo $data['new_password']; ?>">
				<h1 class="contentLarge_h1">アカウント本登録　確認</h1>
				<p>以下の入力内容でお間違いないかご確認ください。</p>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th>お名前</th>
										<td><?php echo $data['last_name']; ?><?php echo $data['first_name']; ?></td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td><?php echo $data['last_kana']; ?><?php echo $data['first_kana']; ?></td>
									</tr>
									<tr>
										<th>生年月日</th>
										<td><?php echo $data['birthday_display']; ?></td>
									</tr>
									<tr>
										<th>郵便番号</th>
										<td><?php echo $data['zip_code']; ?></td>
									</tr>
									<tr>
										<th>都道府県</th>
										<td><?php echo $data['prefecture']; ?></td>
									</tr>
									<tr>
										<th>都道府県以下</th>
										<td><?php echo $data['address']; ?></td>
									</tr>
									<tr>
										<th>電話番号1</th>
										<td><?php echo $data['phone']; ?></td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><?php echo $data['cellular']; ?></td>
									</tr>
									<tr>
										<th>メールアドレス</th>
										<td><?php echo $data['new_email']; ?></td>
									</tr>
									<tr>
										<th>当社からのメール案内</th>
										<td><?php if($data['subscription']) { echo "受け取る"; } else { echo "受け取らない"; } ?></td>
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
						<input type="submit" value="変更を完了する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end アカウント本登録確認 -->