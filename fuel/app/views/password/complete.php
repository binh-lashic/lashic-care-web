	<!-- パスワード再設定　STEP1　完了 -->
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
			<h1 class="contentLarge_h1">新パスワード設定メール　送信</h1>
			<table class="tableBeige form_result mgt20">
					<tr>
						<th>「新パスワード設定メール」を送信しました。</th>
					</tr>
					<tr>
						<td>
							<p>メールが到着していることを確認してください。<br>
確認メールの本文に記載されているURLを開き、パスワード変更の手続きを行ってください。</p>
<div class="tableBeige_leftText"><p class="mgt30 small"><span class="text_red">※</span>新パスワード設定画面の有効時間はメール送信後24時間となります。24時間以内に新パスワードの設定を完了させてください。<br>
<span class="text_red">※</span>メールが届かない場合はご入力に間違いがあるか、ドメイン拒否の設定をされている可能性があります。<br>
　ラシク（@lashic.jp）からのメールが受信できるよう設定をし、再度パスワードの再設定をしてください。 <br>
<span class="text_red">※</span>個人情報は、信頼性の高いセキュリティ技術の SSL を使用し暗号化しています。</p></div></td>
					</tr>
				</table>
				
				
			
			<!-- /メールアドレス -->
				<h2 class="form_title mgt30">会員ID（メールアドレス）</h2>
				<div class="form_set_container">
						<p class="center mgt20 mgb20"><?php echo $data['email']; ?></p>
				</div>
				<!-- /メールアドレス--> 
		</section>
		<!-- /content end　編集一覧 --> 
	</div>
	<!-- パスワード再設定　STEP1 完了 -->
