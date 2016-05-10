		<!-- content start　お問い合わせエラー -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">お問い合わせ</h1>
			<p>以下のフォームにお問い合わせ内容をご入力のうえ、「確認ページへ進む」ボタンをクリックしてください。<br>
※弊社からの回答は【3営業日以内】に行います。(土日祝日・年末年始除く)<br>
</p>
				<!-- 基本情報 -->
				<h2 class="form_title">以下にご入力ください</h2>
				<form action="/contact" method="post">
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th><span class="icon_Required">必須</span> お名前</th>
										<td><input type="text" name="name" class="input_text input_medium" value="<?php if(!empty($data['name'])) { echo $data['name']; } ?>">
<?php
if(!empty($error['name'])) {
?>
											<p class="error">お名前を入力してください。</p>
<?php
}
?>
										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> ふりがな</th>
										<td><input type="text" name="kana" class="input_text input_medium" value="<?php if(!empty($data['kana'])) { echo $data['kana']; } ?>">
<?php
if(!empty($error['kana'])) {
?>										<p class="error">ふりがなを入力してください。</p>
<?php
}
?>										</td>
									</tr>
									<tr>
										<th>会社名</th>
										<td><input type="text" name="company" class="input_text input_medium" value="<?php if(!empty($data['company'])) { echo $data['company']; } ?>"></td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> メールアドレス</th>
										<td><input type="text" name="email" class="input_text input_medium" value="<?php if(!empty($data['email'])) { echo $data['email']; } ?>">
										 <span class="small text_red">※半角英数</span>
<?php
if(!empty($error['email'])) {
?>										<p class="error">メールアドレスを入力してください。</p>
<?php
}
?>										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> メールアドレス（確認）</th>
										<td><input type="text" name="email_confirm" class="input_text input_medium" value="<?php if(!empty($data['email_confirm'])) { echo $data['email_confirm']; } ?>">
										 <span class="small text_red">※半角英数</span>
<?php
if(!empty($error['email_confirm'])) {
?>										<p class="error">メールアドレスが一致しません</p>
<?php
}
?>										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> 電話番号</th>
										<td><input type="text" name="phone" class="input_text input_short" maxlength="11" value="<?php if(!empty($data['phone'])) { echo $data['phone']; } ?>"> 
										<span class="small text_red">※半角英数、ハイフンなしでご入力ください。例）00012345678</span>
<?php
if(!empty($error['phone'])) {
?>										<p class="error">電話番号を入力してください。</p>
<?php
}
?>										</td>
									</tr>
									<tr>
										<th><span class="icon_Required">必須</span> お問い合わせ内容</th>
										<td><textarea rows="20" name="detail" class="input_text input_textarea"><?php if(!empty($data['detail'])) { echo $data['detail']; } ?></textarea>
<?php
if(!empty($error['detail'])) {
?>										<p class="error">お問い合わせ内容を入力してください。</p>
<?php
}
?>										</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 --> 
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
				</form>
		</section>
		<!-- /content end　お問い合わせエラー --> 