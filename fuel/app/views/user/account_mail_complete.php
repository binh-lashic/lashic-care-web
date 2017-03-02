		<!-- content start メールアドレス完了 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account" method="post">
				<h1 class="contentLarge_h1">アカウント　メールアドレス変更申し込み完了</h1>
				
				<table class="tableBeige form_result mgt20">
					<tr>
						<th>メールアドレスの確認メールを送信しました。</th>
					</tr>
					<tr>
						<td class="left">以下のメールアドレスに「メールアドレス変更手続きメール」を送信いたしました。<br>
メールボックスをご確認ください。<br>
確認メールの有効時間は、送信後約24時間となります。24時間以内にご登録を完了させてください。<br>
確認メールが届かない場合、ご入力に間違いがあるか、ドメイン拒否の設定をされている可能性があります。<br>
LASHICからのメール（<?php echo Config::get('email.noreply'); ?>）が受信できるように設定のうえ、再度メールアドレスの変更手続きをお願いします。<br><br>
							<table class="tableGray">
								<tr>
									<th>メールアドレス</th>
									<td><strong class="text_blue large"><?php echo $data['new_email']; ?></strong></td>
								</tr>
							</table>
</td>
					</tr>
				</table>
				
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
						<input type="submit" value="マイページへ" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end メールアドレス完了 --> 
