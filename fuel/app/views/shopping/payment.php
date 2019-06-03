	<div class="clearfix content">
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li>カート</li>
				<li class="flowBoxOn_before">送付先指定</li>
				<li class="flowBoxOn">配送とお支払い</li>
				<li>ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">お支払い指定</h1>
			<p>クレジットカード情報を入力し、「次の画面へ進む」をクリックしてください。</p>
			<p><strong>ご利用いただけるカード：</strong>VISA、Master、JCB、アメリカン・エキスプレス、ダイナース<br>
				<img src="/images/common/card_m_all.png" width="136"></p>
<?php
if(!empty($errors['card'])) {
?>
				<p class="title_errer"><strong>クレジットカードに不備がありました</strong></p>
<?php
} else if(!empty($errors)) {
?>
				<p class="title_errer"><strong>入力内容にエラーがありました</strong></p>
<?php
}
?>
			<form action="/shopping/payment" method="post">
			<!-- ご登録のクレジットカード -->
			<div class="form_set_container">
					<table>
						<tbody>
<?php
if(!empty($cards))
{
?>
							<th colspan="2" class="large"> <input type="radio" id="card01" name="process" value="registered" checked>
								<label for="card01" class="checkbox largeInput">ご登録のクレジットカード</label>
							</th>
<?php
	foreach($cards as $_card) {
?>
							<tr>
								<th>カード番号</th>
								<td><?php echo $_card['CardNo']; ?></td>
							</tr>
							<tr>
								<th>有効期限</th>
								<td><?php echo substr($_card['Expire'], 2, 2); ?>月 20<?php echo substr($_card['Expire'], 0, 2); ?>年</td>
							</tr>
							<tr>
								<th>名義人</th>
								<td><?php echo $_card['HolderName']; ?></td>
							</tr>
<?php
	}
} else {
?>
							<tr>
								<td colspan="2">ご登録のクレジットカードがありません</td>
							</tr>
<?php
}
?>

						</tbody>
					</table>
			</div>
			<!-- /ご登録のクレジットカード --> 
			<br><br>
			<!-- 別のクレジットカード -->
			<div class="form_set_container">
					<table>
						<tbody>
							<tr>
								<th colspan="2" class="large">
								<input type="radio" id="card02" name="process" value="new" <?php if($card['process'] == "new") { echo "checked=\"checked\""; } ?>>
								<label for="card02" class="checkbox largeInput">別のクレジットカード</label> <span class="small">：こちらのクレジットカードが登録されます</span>
								</th>
							</tr>
							<tr>
								<th>カード番号</th>
								<td><input type="text" id="number" name="number" class="input_text input_medium" value="<?php if($card['number']) echo $card['number']; ?>">
									&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
<?php
if(!empty($errors['number'])) {
?>
									<p class="error">エラー：カード番号を入力してください。</p>
<?php
}
?>
								</td>
							</tr>
							<tr>
								<th>有効期限</th>
								<td><div class="clearfix">
										<div class="floatL common_select">
											<select id="expire_month" name="expire_month">
												<option value=""> -- </option>
<?php
for($i = 1; $i <= 12; $i++) {
	 $value = sprintf("%02d", $i);
?>
												<option value="<?php echo $value; ?>" <?php if($value == $card['expire_month']) echo "selected=\"selected\""; ?>> <?php echo $value; ?> </option>
<?php
}
?>
											</select>
										</div>
										<div class="floatL pdt5">　月　</div>
										<div class="floatL common_select">
											<select id="expire_year" name="expire_year">
												<option value=""> -- </option>
<?php
for($i = date("Y"); $i <= date("Y") + 21; $i++) {
?>
												<option value="<?php echo $i; ?>" <?php if($i == $card['expire_year']) echo "selected=\"selected\""; ?>> <?php echo $i; ?> </option>
<?php
}
?>
											</select>
										</div>
										<div class="floatL pdt5">　年　</div>
									</div>
<?php
if(!empty($errors['expire'])) {
?>
									<p class="error">エラー：有効期限を入力してください。</p>
<?php
}
?>
								</td>
							</tr>
							<tr>
								<th>名義人</th>
								<td><input type="text" id="holder_name" name="holder_name" class="input_text input_medium" value="<?php if($card['holder_name']) echo $card['holder_name']; ?>">&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角英数大文字、カードの表記通りにご入力ください。</span>
<?php
if(!empty($errors['holder_name'])) {
?>
									<p class="error">エラー：名義人を入力してください。</p>
<?php
}
?>
								</td>
							</tr>
							<tr>
								<th>セキュリティコード</th>
								<td><input type="text" id="security_code" name="security_code" class="input_text input_short" maxlength="11">&nbsp;&nbsp;<a href="https://www.gmo-pg.com/service/mulpay/security/securitycode/" target="_blank">セキュリティコードとは</a>&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角英数</span>
<?php
if(!empty($errors['security_code'])) {
?>
									<p class="error">エラー：セキュリティコードを入力してください。</p>
<?php
}
?>								</td>
							</tr>
						</tbody>
					</table>
			</div>
			<!-- /別のクレジットカード -->
			
			<div class="set_container">
				<div class="left_container"><a href="/shopping/destination" class="link_back">戻る</a></div>
				<div class="center_container">
					<input type="hidden" value="1" name="tokennumber" id= "tokennumber" />
					<input type="button" value="次の画面に進む" onclick="doPurchase('<?php echo $_SERVER['PGCARD_SHOP_ID']; ?>')" />
				</div>
				<div class="right_container left"></div>
			</div>
			</form>
			<form id="purchaseForm" action="/shopping/payment" method="post">
				<input type="hidden" value="" id="token" name="token" />
				<input type="hidden" value="registered" id="token" name="process" />
			</form>
		</section>
	</div>
	<script type="text/javascript" src="<?php echo $_SERVER['GMO_TOKEN_JS_URL']; ?>" ></script>
	<script type="text/javascript" src="/js/token_payment.js" ></script>
