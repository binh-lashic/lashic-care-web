	<div class="clearfix content"> 
			<!-- flow矢印 -->
			<div class="flowSet flow_no06">
				<ol>
					<li class="flowBoxOn">カート</li>
					<li>送付先指定</li>
					<li>配送とお支払い</li>
					<li>ご注文確認</li>
					<li>完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
	
		<!-- content start　ご注文内容確認-->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">カート</h1>
				<p class="plan_message" style="display:none">プランがカートに入っています。お申し込み手続きを完了させてください。</p>
				<form action="/shopping/destination" method="post" id="cart_form">
				<div class="contentLarge_h2">
					<h2>ご注文</h2>
				</div>
			<!-- ご注文1 -->
				<div id="order_no" class="orderSet">
				<div class="bgGray borderGrayRadius">
					<div class="order_deleteSet"><button id="order_btn_delete" class="order_btn_delete"><span class="order_btn_delete_icon close"></span><span class="order_wrap_text">削除する</span></button></div>
						<table class="tableGray mgb-1">
						<tbody id="plans">
							<tr>
								<th class="center">プラン名</th>
								<th class="center">単価</th>
								<th class="center">数量</th>
								<th class="center">小計</th>
							</tr>
						</tbody>
					</table>
					<table class="borderGray mgt0 plan_total" style="display:none">
						<tbody>
							<tr>
								<td class="bgBeige lowerTotalPrice right">消費税 <strong id="tax">0</strong> 円</td>
							</tr>
							<tr>
								<td class="bgBeige lowerTotalPrice right">合計 <strong class="large" id="total_price">0</strong> 円</td>
							</tr>
						</tbody>
					</table>
					<div class="set_container mgb30">
						<div class="left_container"></div>
						<div class="center_container">
							<input type="submit" value="次の画面に進む" >
						</div>
						<div class="right_container"></div>
					</div>
					<div class="set_container mgb30">
						<div class="left_container"></div>
						<div class="center_container"><a href="/shopping" class="link_back">プランを再選択する</a></div>
						<div class="right_container"></div>
					</div>
					</form>
				</div>
			</div>
			<!-- /ご注文1 -->
				

			<div class="order_alert"><p>削除されました</p></div>
				
				<div class="set_container">
					<div class="left_container"><a href="/" class="link_back">戻る</a></div>
					<div class="center_container"></div>
					<div class="right_container"></div>
				</div>
		</section>
		<!-- /content end　ご注文内容確認 --> 
<script type="text/javascript" src="/js/cart.js"></script>