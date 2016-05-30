		<!-- content start 基本情報変更確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account_basic_complete" method="post">
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
				<h1 class="contentLarge_h1">アカウント　基本情報変更確認</h1>
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
										<td><?php echo $data['birthday']; ?></td>
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
		<!-- /content end 基本情報変更確認 --> 