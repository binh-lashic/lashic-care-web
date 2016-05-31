		<!-- content start パスワード変更　エラー -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account_password_form" method="post">
				<h1 class="contentLarge_h1">アカウント　パスワード変更入力</h1>
				<p>新しいパスワードを入力してください。</p>
				<!-- パスワード -->
				<h2 class="form_title">パスワード</h2>
				<div class="form_set_container">
						<table>
								<tbody>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 現在のパスワード</th>
										<td><input type="password" name="password" class="input_text input_short" minlength="8" maxlength="16"> <span class="small text_red">※半角英数 8桁</span>
<?php
if(!empty($errors['password'])) {
?>
										<p class="error">現在のパスワードが間違っています。</p>
<?php
}
?>	
									</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 新しいパスワード</th>
										<td><input type="password" name="new_password" class="input_text input_short" minlength="8" maxlength="16"> <span class="small text_red">※半角英数 8桁で、できるだけ複雑な文字の組み合わせでご入力ください。　例）W4eHvmCE</span>
<?php
if(!empty($errors['new_password'])) {
?>
										<p class="error">新しいパスワードを入力してください。</p>
<?php
}
?>										</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 新しいパスワード　確認</th>
										<td><input type="password" name="new_password_confirm" class="input_text input_short" minlength="8" maxlength="16"> <span class="small text_red">※半角英数 8桁</span>
<?php
if(!empty($errors['new_password_confirm'])) {
?>
										<p class="error">新しいパスワードが一致しません。</p>
<?php
}
?>
									</td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /パスワード --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="次の画面に進む" >
					</div>
					<div class="right_container"></div>
				</div>
				<p class="center"><a href="#">パスワードを忘れた方はこちら</a></p>
			</form>
		</section>
		<!-- /content end パスワード変更　エラー --> 
		
		