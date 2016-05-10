		<!-- content start　お問い合わせ確認 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">お問い合わせ　確認</h1>
			<p>以下の内容で間違いがないか確認してください。<br>
</p>
				<!-- 基本情報 -->
				<h2 class="form_title">ご入力内容</h2>
				<form action="/contact/complete" method="post">
					<input type="hidden" name="name" value="<?php if(!empty($data['name'])) { echo $data['name']; } ?>" />
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th>お名前</th>
										<td><?php if(!empty($data['name'])) { echo $data['name']; } ?></td>
									</tr>
									<tr>
										<th>ふりがな</th>
										<td><?php if(!empty($data['kana'])) { echo $data['kana']; } ?></td>
									</tr>
									<tr>
										<th>会社名</th>
										<td><?php if(!empty($data['company'])) { echo $data['company']; } ?></td>
									</tr>
									<tr>
										<th>メールアドレス</th>
										<td><?php if(!empty($data['email'])) { echo $data['email']; } ?></td>
									</tr>
									<tr>
										<th>電話番号</th>
										<td><?php if(!empty($data['phone'])) { echo $data['phone']; } ?></td>
									</tr>
									<tr>
										<th>お問い合わせ内容</th>
										<td><?php if(!empty($data['detail'])) { echo $data['detail']; } ?></td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 --> 
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
						<input type="submit" value="送信する" >
					</div>
					<div class="right_container"></div>
				</div>
				</form>
		</section>
		<!-- /content end　お問い合わせエラー --> 