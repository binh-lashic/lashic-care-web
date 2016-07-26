	<div class="clearfix content"> 
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li class="flowBoxOn_before">カート</li>
				<li class="flowBoxOn">見守り対象ユーザー設定</li>
				<li>送付先指定</li>
				<li>配送とお支払い</li>
				<li>ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">見守り対象ユーザー　基本情報確認</h1>
			<p>以下の入力内容でお間違いないかご確認ください。</p>
			<form action="/shopping/user_complete" method="post">
				<input type="hidden" name="first_name" value="<?php if(!empty($data['first_name'])) { echo $data['first_name']; } ?>" />
				<input type="hidden" name="last_name" value="<?php if(!empty($data['last_name'])) { echo $data['last_name']; } ?>" />
				<input type="hidden" name="first_kana" value="<?php if(!empty($data['first_kana'])) { echo $data['first_kana']; } ?>" />
				<input type="hidden" name="last_kana" value="<?php if(!empty($data['last_kana'])) { echo $data['last_kana']; } ?>" />
				<input type="hidden" name="gender" value="<?php if(!empty($data['gender'])) { echo $data['gender']; } ?>" />
				<input type="hidden" name="birthday" value="<?php if(!empty($data['birthday'])) { echo $data['birthday']; } ?>" />
				<input type="hidden" name="blood_type" value="<?php if(!empty($data['blood_type'])) { echo $data['blood_type']; } ?>" />
				<input type="hidden" name="phone" value="<?php if(!empty($data['phone'])) { echo $data['phone']; } ?>" />
				<input type="hidden" name="cellular" value="<?php if(!empty($data['cellular'])) { echo $data['cellular']; } ?>" />
				<input type="hidden" name="zip_code" value="<?php if(!empty($data['zip_code'])) { echo $data['zip_code']; } ?>" />
				<input type="hidden" name="address" value="<?php if(!empty($data['address'])) { echo $data['address']; } ?>" />
				<input type="hidden" name="prefecture" value="<?php if(!empty($data['prefecture'])) { echo $data['prefecture']; } ?>" />

			<!-- 基本情報 -->
			<h2 class="form_title">基本情報</h2>
			<div class="form_set_container">
				<div class="form_base_data_edit">
					<table>
						<tbody>
							<tr>
								<th>お名前（ふりがな）</th>
								<td><?php echo $data['last_name']; ?><?php echo $data['first_name']; ?>（<?php echo $data['last_kana']; ?><?php echo $data['first_kana']; ?>）</td>
							</tr>
							<tr>
								<th>性別</th>
								<td><?php echo $genders[$data['gender']]; ?></td>
							</tr>
							<tr>
								<th>生年月日</th>
								<td><?php echo $data['birthday']; ?></td>
							</tr>
							<tr>
								<th>郵便番号</th>
								<td><?php echo $data['zip_code']; ?></td>
							</tr>
							<tr>
								<th>都道府県</th>
								<td><?php echo $data['prefecture']; ?></td>
							</tr>
							<tr>
								<th>都道府県以下</th>
								<td><?php echo $data['address']; ?></td>
							</tr>
							<tr>
								<th>電話番号1</th>
								<td><?php echo $data['phone']; ?></td>
							</tr>
							<tr>
								<th>電話番号2</th>
								<td><?php echo $data['cellular']; ?></td>
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
					<input type="submit" value="ユーザーを新規登録する" >
				</div>
				<div class="right_container"></div>
			</div>
			</form>
		</section>
		<!-- /content end 基本情報変更確認 --> 
	</div>