		<!-- content start　ユーザー管理 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">ユーザー管理</h1>
			<p>登録した見守り対象ユーザーの情報を管理できます</p>
			<div class="contentLarge_h2"><h2>管理中のユーザー一覧</h2></div>
<?php
if(!empty($clients)) {
?>		
			<!-- ユーザーSet -->
			<table class="tableBlue">
				<tbody>
<?php

	foreach($clients as $_client) {
?>
					<tr>
						<th colspan="2" class="center large"><?php echo $_client['name']; ?>（<?php echo $_client['kana']; ?>）さん
							<div class="usrMn_btn_edit"><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="btn_text">ユーザー情報を編集する</a></div>
						</th>
					</tr>
					<tr>
						<td><p><strong>見守り契約</strong> 12ヶ月パック　無料期間</p></td>
						<td width="198"><a href="detail.html" class="btn_darkBlue">契約詳細確認</a></td>
					</tr>
<?php
	} //foreach
?>
				</tbody>
			</table>
			<!-- /ユーザーSet --> 
<?php
} else {
?>
			<p class="center">現在管理中のユーザーはいません</p>
<?php
}
?>

			
<?php
if($user['admin'] == 0) {
?>
			
			<div class="contentLarge_h2 mgt60"><h2>閲覧中のユーザー一覧</h2></div>

<?php
if(!empty($clients)) {
?>		
			<!-- ユーザーSet -->
			<div class="form_set_container">
				<ul class="usrMn_list">
<?php

	foreach($clients as $_client) {
?>
					<li><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="link_next"><?php echo $_client['name']; ?>（<?php echo $_client['kana']; ?>）さん</a></li>
<?php
	} //foreach
?>
				</ul>
			</div>
<?php
} else {
?>
			<p class="center">現在管理中のユーザーはいません</p>
<?php
}
?>
<?php
}
?>			
			<!-- /ユーザーSet --> 
			
			
			
			<!-- Care Eyeから退会希望のお客様 -->
			<h2 class="form_title">登録したユーザーを解約したいお客様へ</h2>
			<div class="form_set_container center">
				<p class="mgt20 mgb10">お電話で解約のお申し込みをしてください。</p>
				<p class="mgb20"><span class="phone_number">054-266-6201</span><br>
午前9時〜午後18時まで、土日祝日休み</p>
			</div>
			<!-- /Care Eyeから退会希望のお客様 -->
		</section>
		<!-- /content end　ユーザー管理 --> 
		