		<!-- content start　契約内容確認-->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1"><?php echo $contract_user['last_name']; ?><?php echo $contract_user['first_name']; ?>さん　契約詳細確認</h1>
			<p>契約日：<?php echo date("Y/m/d", strtotime($contract['start_date'])); ?><br>
				次回契約更新日：<?php echo date("Y/m/d", strtotime($contract['renew_date'])); ?></p>
				
				
			<!-- 契約内容 -->
			<div class="contentLarge_h2">
				<h2>契約内容</h2>
			</div>
			<div class="bgGray borderGrayRadius">
				<table class="tableGray">
					<tbody>
						<tr>
							<th class="center"><strong>商品情報</strong></th>
							<th class="center">単価</th>
							<th class="center">数量</th>
							<th class="center">小計</th>
						</tr>
						<tr>
							<td><?php echo $contract['plan']['title']; ?></td>
							<td class="right">税込　<?php echo current($contract['plan']['options'])['unit_price'] * (1 + $tax_rate); ?>円</td>
							<td class="center">1</td>
							<td class="right">税込　<?php echo current($contract['plan']['options'])['unit_price'] * (1 + $tax_rate); ?>円</td>
						</tr>
					</tbody>
				</table>
				<table class="borderGray">
					<tbody>
						<tr>
							<td class="bgBeige lowerTotalPrice right">合計 <strong class="large"><?php echo current($contract['plan']['options'])['unit_price'] * (1 + $tax_rate); ?></strong> 円</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /契約内容 -->
				
<?php
/*
			<!-- お支払い方法 -->
			<div class="contentLarge_h2">
				<h2>お支払い方法</h2>
			</div>
			<div class="bgGray borderGrayRadius">
				<table class="tableGray">
					<tbody>
						<tr>
							<th width="50%">カード決済</th>
							<td width="50%" class="right">Visa Master ***********1234</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /お支払い方法 -->
*/
?>
				
			<!-- お届け先 -->
			<div class="contentLarge_h2">
				<h2>お届け先</h2>
			</div>
			<div class="bgGray borderGrayRadius">
				<table class="tableGray">
					<tbody>
						<tr>
							<th>お名前</th>
							<td><?php echo $contract_user['last_name']; ?><?php echo $contract_user['first_name']; ?></td>
						</tr>
						<tr>
							<th>ふりがな</th>
							<td><?php echo $contract_user['last_kana']; ?><?php echo $contract_user['first_kana']; ?></td>
						</tr>
						<tr>
							<th>郵便番号</th>
							<td><?php echo $contract['zip_code']; ?></td>
						</tr>
						<tr>
							<th>都道府県</th>
							<td><?php echo $contract['prefecture']; ?></td>
						</tr>
						<tr>
							<th>都道府県以下</th>
							<td><?php echo $contract['address']; ?></td>
						</tr>
						<tr>
							<th>電話番号１</th>
							<td><?php echo $contract_user['phone']; ?></td>
						</tr>
						<tr>
							<th>電話番号2</th>
							<td><?php echo $contract_user['cellular']; ?></td>
						</tr>
						<tr>
							<th>性別</th>
							<td><?php echo $genders[$contract_user['gender']]; ?></td>
						</tr>
						<tr>
							<th>生年月日</th>
							<td><?php echo date("Y/m/d", strtotime($contract_user['birthday'])); ?></td>
						</tr>
						<tr>
							<th>血液型</th>
							<td><?php echo $contract_user['blood_type']; ?>型</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /お届け先 -->
				
				<div class="set_container">
					<div class="left_container"><a href="/user/list" class="link_back">戻る</a></div>
					<div class="center_container"></div>
					<div class="right_container"></div>
				</div>
		</section>
		<!-- /content end　契約内容確認 --> 