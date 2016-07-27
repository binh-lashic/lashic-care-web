	<div class="clearfix content"> 
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
				<h1 class="contentLarge_h1">会員登録申し込み完了</h1>
				
				<table class="tableBeige form_result mgt20">
					<tr>
						<th>メールアドレスの確認メールを送信しました。</th>
					</tr>
					<tr>
						<td>以下のメールアドレスに「会員登録手続きメール」を送信いたしました。<br>
ご自身のメールボックスをご確認ください。<br>
メールに記載された内容をご確認のうえ、引き続き登録手続きを行ってください。<br>
確認メールの有効時間は、送信後約24時間となります。24時間以内にご登録を完了させてください。<br>
確認メールが届かない場合、ご入力に間違いがあるか、ドメイン拒否の設定をされている可能性があります。<br>ケアアイからのメール（@careeye.jp）が受信できるように設定のうえ、再度メールアドレスのご登録をお願いします。</td>
					</tr>
				</table>
				
				
				<div class="bgGray mgt20 borderGrayRadius no-boxShadow">
					<div class="regist_kiyaku_doui">
						<p><?php echo $data['email']; ?></p>
					</div>
				</div>
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
					<form action="/">
						<input type="submit" value="トップへ" >
					</form>
					</div>
					<div class="right_container"></div>
				</div>
		</section>
	</div>