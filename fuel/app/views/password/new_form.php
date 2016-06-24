		<!-- パスワード再設定　STEP2 -->
	<div class="clearfix content"> 
		 
			<!-- flow矢印 -->
			<div class="flowSet flow_no04">
				<ol>
					<li>新パスワード発行　入力</li>
					<li class="flowBoxOn_before">会員ID確認</li>
					<li class="flowBoxOn">新パスワード設定　入力</li>
					<li>新パスワード設定　完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
			<!-- content start パスワード変更　エラー -->
		<section id="contentBoxLarge">
			<form class="form" action="/password/new_form" method="post">
				<input type="hidden" name="token" value="<?php echo $data['token']; ?>" />
				<h1 class="contentLarge_h1">新パスワード設定　入力</h1>
				<p>新しいパスワードをご入力のうえ、「変更する」をクリックしてください。</p>
				<p class="mgt30 small"><span class="text_red">※</span>新パスワード設定画面の有効時間はメール送信後24時間となります。24時間以内に新パスワードの設定を完了させてください。</p>
				<!-- パスワード -->
				<h2 class="form_title">新パスワード</h2>
				<div class="form_set_container">
						<table>
								<tbody>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 新しいパスワード</th>
										<td><input type="password" class="input_text input_short" maxlength="8" placeholder="パスワード入力" name="password" value="<?php if(isset($data['password'])) { echo $data['password']; } ?>" ><br>
<span class="small "><span class="text_red">※</span>半角英数 8桁<br>
										<span class="text_red">※</span>必ず英字と数字の両方を使って入力してください。大文字小文字は区別されます。<br>
									<span class="text_red">※</span>ユーザーID、郵便番号、電話番号、誕生日など推測できる文字は避けてください。</span></p>
<?php
if(isset($errors['password'])) {
?>
										<p class="error"><?php echo $errors['password']; ?></p>
<?php	
}
?>
									</td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 新しいパスワード　確認</th>
										<td><input type="password" class="input_text input_short" maxlength="8" placeholder="パスワード入力" name="password_confirm" value="<?php if(isset($data['password_confirm'])) { echo $data['password_confirm']; } ?>" > <span class="small text_red">※</span><span class="small">半角英数 8桁</span>
<?php
if(isset($errors['password_confirm'])) {
?>
										<p class="error"><?php echo $errors['password_confirm']; ?></p>
<?php	
}
?>									</td>
									</tr>
								</tbody>
							</table>
				</div>
				<!-- /パスワード --> 
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
						<input type="submit" value="変更する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end パスワード変更　エラー --> 
		</div>
		<!-- /パスワード再設定　STEP2 -->
		