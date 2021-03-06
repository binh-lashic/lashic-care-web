		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">マイページ</h1>
			<p>登録したアカウントの情報を編集できます</p>
			
			<!-- 基本情報 -->
			<h2 class="form_title">基本情報</h2>
			<div class="form_set_container">
				<div class="form_left_container">
					<div class="form_base_data">
						<table>
							<tbody>
								<tr>
									<th>お名前（ふりがな）</th>
									<td colspan="3"><?php echo $user['last_name']; ?><?php echo $user['first_name']; ?>（<?php echo $user['last_kana']; ?><?php echo $user['first_kana']; ?>）</td>
								</tr>
								<tr>
									<th>性別</th>
									<td colspan="3"><?php if($user['gender'] == "m") { echo "男性"; } else if($user['gender'] == "w") { echo "女性"; } ?></td>
								</tr>
								<tr>
									<th>生年月日</th>
									<td colspan="3"><?php if(isset($user['birthday'])) { echo date("Y年m月d日", strtotime($user['birthday'])); } ?></td>
								</tr>
								<tr>
								<th>住所</th>
								<td colspan="3"><?php echo $user['address']; ?>
							</tr>
							<tr>
								<th>電話番号1</th>
								<td><?php echo $user['phone']; ?></td>
								<th>電話番号2</th>
								<td><?php echo $user['cellular']; ?></td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form_right_container"><a href="/user/account_basic_form" class="btn_darkBlue">変更</a></div>
			</div>
			<!-- /基本情報 --> 
			
			
			<!-- メールアドレス -->
			<h2 class="form_title">メールアドレス</h2>
			<div class="form_set_container">
				<div class="form_left_container">
					<table>
						<tbody>
							<tr>
								<th>メールアドレス</th>
								<td colspan="3"><?php echo $user['email']; ?></td>
							</tr>
							<tr>
								<th>当社からの<br>
メール案内</th>
								<td colspan="3"><?php if($user['subscription']) { echo "受け取る"; } else { echo "受け取らない"; } ?></td>
							</tr>
							</tbody>
						</table>
				</div>
				<div class="form_right_container"><a href="/user/account_mail_form" class="btn_darkBlue">変更</a></div>
			</div>
			<!-- /メールアドレス --> 
			
			
			<!-- パスワード -->
			<h2 class="form_title">パスワード</h2>
			<div class="form_set_container">
				<div class="form_left_container">
					<p>******</p>
				</div>
				<div class="form_right_container"><a href="/user/account_password_form" class="btn_darkBlue">変更</a></div>
			</div>
			<!-- /パスワード --> 
			
			
			
			<!-- LASHICから退会希望のお客様 -->
			<h2 class="form_title">LASHICから退会希望のお客様</h2>
			<div class="form_set_container center">
				<p class="mgt20 mgb10">お電話で退会のお申し込みをしてください。</p>
				<p class="mgb20"><span class="phone_number">054-266-6201</span><br>
午前9時〜午後18時まで、土日祝日休み</p>
			</div>
			<!-- /LASHICから退会希望のお客様 -->
		</section>
		<!-- /content end　編集一覧 --> 
