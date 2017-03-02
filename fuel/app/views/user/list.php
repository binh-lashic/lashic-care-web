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

	foreach($clients as $client) {
?>
					<tr>
						<th colspan="2" class="center large"><?php echo $client['last_name'].$client['first_name']; ?>（<?php echo $client['last_kana'].$client['first_kana']; ?>）さん
							<div class="usrMn_btn_edit"><a href="/user/info?set_client_id=<?php echo $client['id']; ?>" class="btn_text">ユーザー情報を編集する</a></div>
						</th>
					</tr>
<?php
		if(!empty($client['contracts'])) {
			foreach($client['contracts'] as $contract) {
?>
					<tr>
						<td><p><?php echo $contract['title']; ?></p></td>
						<td width="198"><a href="/user/contract?id=<?php echo $contract['id']; ?>" class="btn_darkBlue">契約詳細確認</a></td>
					</tr>

<?php
			}
		}
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
					<li><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="link_next"><?php echo $_client['last_name'].$_client['first_name']; ?>（<?php echo $_client['last_kana'].$_client['first_kana']; ?>）さん</a></li>
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
			
			
			
			<!-- LASHICから退会希望のお客様 -->
			<h2 class="form_title">登録したユーザーを解約したいお客様へ</h2>
			<div class="form_set_container center">
				<p class="mgt20 mgb10">お電話で解約のお申し込みをしてください。</p>
				<p class="mgb20"><span class="phone_number">054-266-6201</span><br>
午前9時〜午後18時まで、土日祝日休み</p>
			</div>
			<!-- /LASHICから退会希望のお客様 -->
		</section>
		<!-- /content end　ユーザー管理 --> 
		
