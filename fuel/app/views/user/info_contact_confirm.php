		
		<!-- content start 住所・電話番号確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/info_contact_complete" method="post">
				<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
				<input type="hidden" name="zip_code" value="<?php if(!empty($data['zip_code'])) { echo $data['zip_code']; } ?>" />
				<input type="hidden" name="prefecture" value="<?php if(!empty($data['prefecture'])) { echo $data['prefecture']; } ?>" />
				<input type="hidden" name="address" value="<?php if(!empty($data['address'])) { echo $data['address']; } ?>" />
				<input type="hidden" name="phone" value="<?php if(!empty($data['phone'])) { echo $data['phone']; } ?>" />
				<input type="hidden" name="cellular" value="<?php if(!empty($data['cellular'])) { echo $data['cellular']; } ?>" />
				<h1 class="contentLarge_h1">見守り対象ユーザー　住所・電話番号変更確認</h1>
				<p>以下の入力内容でお間違いないかご確認ください。</p>
				<!-- 住所・電話番号 -->
				<h2 class="form_title">住所・電話番号</h2>
				<div class="form_set_container">
						<table>
								<tbody>
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
				<!-- /住所・電話番号 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="変更を完了する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end 住所・電話番号確認 --> 