		
		<!-- content start オプション設定変更確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/info_option_complete" method="post">
				<input type="hidden" name="emergency_last_name_1" value="<?php echo $data['emergency_last_name_1']; ?>">
				<input type="hidden" name="emergency_first_name_1" value="<?php echo $data['emergency_first_name_1']; ?>">
				<input type="hidden" name="emergency_last_kana_1" value="<?php echo $data['emergency_last_kana_1']; ?>">
				<input type="hidden" name="emergency_first_kana_1" value="<?php echo $data['emergency_first_kana_1']; ?>">
				<input type="hidden" name="emergency_phone_1" value="<?php echo $data['emergency_phone_1']; ?>">
				<input type="hidden" name="emergency_cellular_1" value="<?php echo $data['emergency_cellular_1']; ?>">
				<input type="hidden" name="emergency_last_name_2" value="<?php echo $data['emergency_last_name_2']; ?>">
				<input type="hidden" name="emergency_first_name_2" value="<?php echo $data['emergency_first_name_2']; ?>">
				<input type="hidden" name="emergency_last_kana_2" value="<?php echo $data['emergency_last_kana_2']; ?>">
				<input type="hidden" name="emergency_first_kana_2" value="<?php echo $data['emergency_first_kana_2']; ?>">
				<input type="hidden" name="emergency_phone_2" value="<?php echo $data['emergency_phone_2']; ?>">
				<input type="hidden" name="emergency_cellular_2" value="<?php echo $data['emergency_cellular_2']; ?>">
				<input type="hidden" name="client_user_id" value="<?php echo $client['id']; ?>">
				<input type="hidden" name="last_name" value="<?php echo $data['last_name']; ?>">
				<input type="hidden" name="first_name" value="<?php echo $data['first_name']; ?>">
				<input type="hidden" name="last_kana" value="<?php echo $data['last_kana']; ?>">
				<input type="hidden" name="first_kana" value="<?php echo $data['first_kana']; ?>">
				<input type="hidden" name="email" value="<?php echo $data['email']; ?>">
				<h1 class="contentLarge_h1">見守り対象ユーザー　オプション設定変更確認</h1>
				<!-- 緊急連絡先の設定 -->
				<h2 class="form_title">緊急連絡先の設定</h2>
				<div class="form_set_container">
					<h3 class="content_h3 mgt20">緊急連絡先 1</h3>
						<table>
								<tbody>
									<tr>
										<th>お名前</th>
										<td><?php echo $data['emergency_last_name_1']; ?><?php echo $data['emergency_first_name_1']; ?></td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td><?php echo $data['emergency_last_kana_1']; ?><?php echo $data['emergency_first_kana_1']; ?></td>
									</tr>
									<tr>
										<th>電話番号1</th>
										<td><?php echo $data['emergency_phone_1']; ?></td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><?php echo $data['emergency_cellular_1']; ?></td>
									</tr>
								</tbody>
							</table>
					<h3 class="content_h3 mgt30">緊急連絡先 2</h3>
						<table>
								<tbody>
									<tr>
										<th>お名前</th>
										<td><?php echo $data['emergency_last_name_2']; ?><?php echo $data['emergency_first_name_2']; ?></td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td><?php echo $data['emergency_last_kana_2']; ?><?php echo $data['emergency_first_kana_2']; ?></td>
									</tr>
									<tr>
										<th>電話番号1</th>
										<td><?php echo $data['emergency_phone_2']; ?></td>
									</tr>
									<tr>
										<th>電話番号2</th>
										<td><?php echo $data['emergency_cellular_2']; ?></td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /緊急連絡先の設定 --> 
				
				
				<!-- 連絡共有先の設定 -->
				<h2 class="form_title">連絡共有先の設定</h2>
				<div class="form_set_container">
						<table class="table_border">
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
										<th>メールアドレス</th>
										<td><?php echo $data['email']; ?></td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /連絡共有先の設定 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="変更を完了する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end オプション設定変更確認 --> 
		