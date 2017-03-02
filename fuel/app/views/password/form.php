	<!-- パスワード再設定　STEP1 -->
	<div class="clearfix content"> 
			<!-- flow矢印 -->
			<div class="flowSet flow_no04">
				<ol>
					<li class="flowBoxOn">新パスワード発行　入力</li>
					<li>会員ID確認</li>
					<li>新パスワード設定　入力</li>
					<li>新パスワード設定　完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
			
			
			
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
<?php
if(isset($errors)) {
?><div class="color-container--error">
<?php
	foreach($errors as $error) {
?>
			<p>・<?php echo $error; ?></p>
<?php
	}
?>
</div>
<?php
}
?>


			<h1 class="contentLarge_h1">新パスワード発行　入力</h1>
			<p>会員ID（メールアドレス）、お名前、電話番号を入力し、「新パスワード設定メールを送る」ボタンをクリックしてください。<br>
情報が全て一致していた場合、「新パスワード設定メール」を送信します。<br>
メールのリンクから「新パスワードの設定画面」に移動し、新しいパスワードを設定くださいませ。</p>
<p class="mgt30 small"><span class="text_red">※</span>新パスワード設定画面の有効時間はメール送信後24時間となります。24時間以内に新パスワードの設定を完了させてください。<br>
<span class="text_red">※</span>メールが届かない場合はご入力に間違いがあるか、ドメイン拒否の設定をされている可能性があります。<br>
　ラシク（@lashic.jp）からのメールが受信できるよう設定をし、再度パスワードの再設定をしてください。 <br>
<span class="text_red">※</span>個人情報は、信頼性の高いセキュリティ技術の SSL を使用し暗号化しています。</p>
			
			
			
			
			<!-- 入力 -->
			<h2 class="form_title">お客様情報の入力</h2>
			<form action="/password/form" method="post">
			<div class="form_set_container">
						<table>
								<tbody>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> 会員ID（メールアドレス）</th>
										<td><input type="text" name="email" class="input_text input_medium" placeholder="例）example@lashic.jp" value="<?php if(!empty($data['email'])) { echo $data['email']; } ?>"> <span class="small text_red">※</span><span class="small">半角英数でご入力ください</span></td>
									</tr>
									<tr>
										<th class="largeTh"><span class="icon_Required">必須</span> お名前</th>
										<td>姓&nbsp;<input type="text" name="last_name" class="input_text input_short" placeholder="例）山田" value="<?php if(!empty($data['last_name'])) { echo $data['last_name']; } ?>">&nbsp;&nbsp;名&nbsp;<input type="text" name="first_name" class="input_text input_short" placeholder="例）太郎" value="<?php if(!empty($data['first_name'])) { echo $data['first_name']; } ?>"></td>
									</tr>
								</tbody>
							</table>
				</div>
			<!-- /入力 -->
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="新パスワード設定メールを送る" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end　編集一覧 --> 
	</div>
	<!-- /パスワード再設定　STEP1 -->
