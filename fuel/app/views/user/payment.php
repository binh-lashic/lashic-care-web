
		<!-- content start　ユーザー管理 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">購入・支払い履歴</h1>
			<p>ご購入・お支払いいただいた履歴を確認できます</p>
			
			<!-- 履歴 -->
			<div class="mgt30">
				<!-- お知らせ -->
					<table class="tableGray">
						<tbody>
<?php
if(!empty($payments)) {
?>
							<tr>
								<th class="center">パック名</th>
								<th class="center">ご請求額</th>
								<th class="center">入金状況</th>
							</tr>
<?php
} else {
?>
							<tr>
								<td>
									<p class="center">履歴はありません</p>
								</td>
							<tr>
<?php
}
foreach($payments as $payment) {
?>
							<tr>
								<td class="center"><?php echo $payment['title']; ?></td>
								<td class="center"><?php echo number_format($payment['price'] + $payment['tax'] + $payment['shipping']); ?>円（税別）</td>
								<td class="center">入金済</td>
							</tr>
<?php	
} 
?>
						</tbody>
					</table>
				<!-- /お知らせ --> 
			</div>
			<!-- /履歴 --> 
			
			
			
			<!-- CareEyeから退会希望のお客様 -->
			<h2 class="form_title">ご契約の解約やお問い合わせはこちらへご連絡ください。</h2>
			<div class="form_set_container center">
				<p class="mgt20 mgb10">お電話で解約のお申し込みをしてください。</p>
				<p class="mgb20"><span class="phone_number">054-266-6201</span><br>
午前9時〜午後18時まで、土日祝日休み</p>
			</div>
			<!-- /CareEyeから退会希望のお客様 -->
		</section>
		<!-- /content end　ユーザー管理 --> 