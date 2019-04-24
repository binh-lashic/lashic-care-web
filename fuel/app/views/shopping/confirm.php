	<div class="clearfix content"> 
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li>カート</li>
				<li>送付先指定</li>
				<li class="flowBoxOn_before">配送とお支払い</li>
				<li class="flowBoxOn">ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 --> 
		
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">ご注文確認</h1>
			<p>ご注文情報をご確認のうえ、「ご注文を確定する」をクリックしてください。</p>
<?php
if(isset($card)) {
?>
			<!-- お支払い方法 -->
			<div class="form_set_container">
				<div class="form_base_data_edit">
					<div class="clearfix">
						<h3 class="content_h3 mgt20 floatL">お支払い方法</h3>
						<!-- お支払い指定へリンク --><a class="floatR btn_lightGray mgt20 small" href="/shopping/payment">カード情報を編集する</a>
					</div>
					<table>
						<tbody>
							<tr>
								<th width="200">カード番号</th>
								<td><?php echo $card['CardNo']; ?></td>
							</tr>
							<tr>
								<th>有効期限</th>
								<td><?php echo substr($card['Expire'], 2, 2); ?>月 20<?php echo substr($card['Expire'], 0, 2); ?>年</td>
							</tr>
							<tr>
								<th>名義人</th>
								<td><?php echo $card['HolderName']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /お支払い方法 --> 
			<br><br>
<?php
}
?>
			<!-- 送付先 -->
			<div class="form_set_container">
				<div class="form_base_data_edit">
					<div class="clearfix">
						<h3 class="content_h3 mgt20 floatL">送付先</h3>
						<!-- お支払い指定へリンク --><a class="floatR btn_lightGray mgt20 small" href="/shopping/destination">送付先を編集する</a>
					</div>
					<table>
						<tbody>
							<tr>
								<th width="200">お名前</th>
								<td><?php echo $destination['last_name']; ?><?php echo $destination['first_name']; ?></td>
							</tr>
							<tr>
								<th>ご住所</th>
								<td><?php echo $destination['prefecture']; ?><?php echo $destination['address']; ?></td>
							</tr>
							<tr>
								<th>電話番号</th>
								<td><?php echo $destination['phone']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /送付先 -->
			<br><br>
			<!-- ご注文内容 -->
			<div class="form_set_container">
				<div class="form_base_data_edit pdb20">
					<h3 class="content_h3 mgt20">ご注文内容</h3>
					<table>
						<tbody>
						<tr>
							<th>備考</th>
							<td class="right"><?php echo nl2br($destination['remarks']); ?></td>
						</tr>
<?php
foreach($plans as $plan) {
?>
							<tr>
								<th><?php echo $plan['title']; ?></th>
								<td class="right"><?php echo number_format($plan['price']) ?>円（税抜）</td>
							</tr>
<?php
}
?>

						</tbody>
					</table>
					
			
				
					<!-- クレジットカード情報登録 -->
						<div class="bgBeige clearfix">
							<table class="sumTalble mgr20">
								<tr>
									<td>小計</td>
									<td class="right"><?php echo number_format($subtotal_price); ?>円（税抜）</td>
								</tr>
								<tr>
									<td>送料</td>
									<td class="right"><?php echo number_format($destination['shipping']); ?>円</td>
								</tr>
								<tr>
									<td>消費税</td>
									<td class="right"><?php echo number_format($tax); ?>円</td>
								</tr>
								<tr>
									<td class="large">合計</td>
									<td class="large right"><strong class="text_red large"><?php echo number_format($total_price); ?>円</strong></td>
								</tr>
							</table>
						</div>
					<!-- /クレジットカード情報登録 -->
						<p class="right"></p>
						<p class="right">　</p>
						<p class="right"></p>
				</div>
			</div>
			<!-- /ご注文内容 -->
			
			
				
			<div class="set_container">
				<div class="left_container"><a href="#" class="link_back">戻る</a></div>
				<div class="center_container">
				<form action="/shopping/complete" method="post">
					<input type="submit"  value="注文を確定する" >
				</form>
				</div>
				<div class="right_container left"></div>
			</div>
		</section>
	</div>