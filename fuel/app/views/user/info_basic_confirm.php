		
		<!-- content start 基本情報変更確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/info_basic_complete" method="post">
				<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
				<input type="hidden" name="first_name" value="<?php if(!empty($data['first_name'])) { echo $data['first_name']; } ?>" />
				<input type="hidden" name="last_name" value="<?php if(!empty($data['last_name'])) { echo $data['last_name']; } ?>" />
				<input type="hidden" name="first_kana" value="<?php if(!empty($data['first_kana'])) { echo $data['first_kana']; } ?>" />
				<input type="hidden" name="last_kana" value="<?php if(!empty($data['last_kana'])) { echo $data['last_kana']; } ?>" />
				<input type="hidden" name="gender" value="<?php if(!empty($data['gender'])) { echo $data['gender']; } ?>" />
				<input type="hidden" name="birthday" value="<?php if(!empty($data['birthday'])) { echo $data['birthday']; } ?>" />
				<input type="hidden" name="blood_type" value="<?php if(!empty($data['blood_type'])) { echo $data['blood_type']; } ?>" />
				<h1 class="contentLarge_h1">見守り対象ユーザー　基本情報変更確認</h1>
				<p>以下の入力内容でお間違いないかご確認ください。</p>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<div class="form_set_container">
						<div class="userDate_photo">
							<div class="aside_photo">
								<div class="aside_photoInner"><img src="../images/user/sample.jpg" width="179" height="179" alt=""/></div>
							</div>
						</div>
						<div class="form_base_data_edit">
							<table>
							<tbody>
								<tr>
									<th>お名前（ふりがな）</th>
									<td><?php echo $data['last_name']; ?><?php echo $data['first_name']; ?>（<?php echo $data['last_kana']; ?><?php echo $data['first_kana']; ?>）</td>
								</tr>
								<tr>
									<th>性別</th>
									<td><?php echo $data['gender'] == "m" ? "男性" : "女性"; ?></td>
								</tr>
								<tr>
									<th>生年月日</th>
									<td><?php echo date("Y年m月d日", strtotime($data['birthday'])); ?></td>
								</tr>
								<tr>
									<th>血液型</th>
									<td><?php echo $data['blood_type']; ?>型</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /基本情報 --> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="変更を完了する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end 基本情報変更確認 --> 
		
		