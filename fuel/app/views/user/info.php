		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">見守り対象ユーザー情報</h1>
			<p>見守り対象ユーザーの情報を編集できます</p>
			
			<!-- 基本情報 -->
			<h2 class="form_title">基本情報</h2>
			<div class="form_set_container">
				<div class="form_left_container">
					<div class="userDate_photo">
						<div class="aside_photo">
							<div class="aside_photoInner"><img src="<?php echo $client['profile_image']; ?>" width="179" height="179" alt=""/></div>
						</div>
					</div>
					<div class="form_base_data">
						<table>
							<tbody>
								<tr>
									<th>お名前（ふりがな）</th>
									<td><?php echo $client['last_name'].$client['first_name']; ?>（<?php echo $client['last_kana'].$client['first_kana']; ?>）</td>
								</tr>
								<tr>
									<th>性別</th>
									<td><?php echo $client['gender'] == "m" ? "男性" : "女性"; ?></td>
								</tr>
								<tr>
									<th>生年月日</th>
									<td><?php echo date("Y年m月d日", strtotime($client['birthday'])); ?></td>
								</tr>
								<tr>
									<th>血液型</th>
									<td><?php echo $client['blood_type']; ?>型</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="form_right_container"><a href="/user/info_basic_form" class="btn_darkBlue">変更</a></div>
			</div>
			<!-- /基本情報 --> 
			
			
			
			
			<!-- /住所・電話番号 -->
			<h2 class="form_title">住所・電話番号</h2>
			<div class="form_set_container">
				<div class="form_left_container clearfix">
					<table>
						<tbody>
							<tr>
								<th>住所</th>
								<td colspan="3"><?php echo $client['address']; ?></td>
							</tr>
							<tr>
								<th>電話番号1</th>
								<td><?php echo $client['phone']; ?></td>
								<th>電話番号2</th>
								<td><?php echo $client['cellular']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="form_right_container"><a href="/user/info_contact_form" class="btn_darkBlue">変更</a></div>
			</div>
			<!-- /住所・電話番号 -->
		</section>
		<!-- /content end　編集一覧 --> 