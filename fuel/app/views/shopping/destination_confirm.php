	<div class="clearfix content"> 
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li>カート</li>
				<li>見守り対象ユーザー設定</li>
				<li class="flowBoxOn_before">送付先指定</li>
				<li class="flowBoxOn">配送とお支払い</li>
				<li>ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 --> 
		
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">配送の確認</h1>
			<p>配送についてご確認ください。</p>
			<div class="shoppingCart_container clearfix"> 
				
				<!-- 商品確認 -->
				<div class="floatL contentHalf borderGrayRadius">
					<div class="pd20">
						<p class="mgb20 text_gray">送付先： <?php echo $destination['last_name']; ?><?php echo $destination['first_name']; ?>　<?php echo $destination['prefecture']; ?><?php echo $destination['address']; ?></p>
<?php
foreach($plans as $plan) {
?>
						<div id="item01">
							<p><strong><?php echo $plan['title']; ?>　</strong><span class="text_red">&nbsp;&nbsp;<?php echo $plan['price']; ?>円（税込）</span></p>
<!--							<div class="mgt5 mgb10"><a class="fancybox  mgt20" href="#settingChange">商品変更</a>&nbsp;&nbsp;&nbsp;<a href="#deleteItem1" class="fancybox ">× 削除</a></div>-->
						</div>
<?php
}
?>
						<hr>
						<p class="right">小計<?php echo $total_price; ?>円（税込）</p>
						<p class="right">送料　<?php echo $destination['shipping']; ?>円</p>
						<p class="right">合計<strong class="text_red"><?php echo $total_price + $destination['shipping']; ?>円</strong></p>
					</div>
				</div>
				<!-- /商品確認 --> 
				<!-- 配送指定 -->
				<div class="floatR contentHalf">
					<h3 class="content_h3">お届け日について</h3>
					<p>お届けは、ご注文後3営業日内となります。</p>
					<form action="/shopping/payment" method="get">
						<button class="btn_darkBlue w300 floatR pd15 mgt30">次の画面へ</button>
					</form>
				</div>
				<!-- 配送指定 --> 
			</div>
			<div class="set_container">
				<div class="left_container"><a href="index_kounyu_login.html" class="link_back">戻る</a></div>
				<div class="center_container"></div>
				<div class="right_container"></div>
			</div>
		</section>
		<!-- /content end　編集一覧 --> 
	</div>

<!--　商品変更 -->
<div id="settingChange" class="settingContainer" style="display: none; width:400px; height:300px; ">
	<div class="settingInner">
		<p class="mgb20 large text_blue">変更する商品を選択してください</p>
		<div class="left">
			<input type="radio" id="1month" name="pack" checked>
			<label for="1month" class="checkbox shoppingCart_input"><strong>CareEye（ケアアイ） 月々パック</strong> <span class="text_red">1200円（税込）</span><br>
				※初期費用 14,800円（税込）</label>
			<hr>
			<input type="radio" id="6month" name="pack" >
			<label for="6month" class="checkbox shoppingCart_input"><strong>CareEye（ケアアイ） 6ヶ月パック</strong> <span class="text_red">6600円（税込）</span><br>
				1100円/月<br>
				※初期費用 14,800円（税込）</label>
			<hr>
			<input type="radio" id="1year" name="pack" >
			<label for="1year" class="checkbox shoppingCart_input"><strong>CareEye（ケアアイ） 12ヶ月パック</strong> <span class="text_red">11760円（税込）</span><br>
				980円/月<br>
				※初期費用 14,800円（税込）</label>
		</div>
		<br>
		<a href="javascript:$.fancybox.close();" class="fancybox btn_darkBlue graphSettingTrue">変更する</a> <a href="javascript:$.fancybox.close();" class="btn_lightGray radius20 graphSettingFalse">キャンセル</a> </div>
</div>
<!--　/商品変更 --> 

<!--　商品変更2 -->
<div id="settingChange2" class="settingContainer" style="display: none; width:400px; height:300px; ">
	<div class="settingInner">
		<p class="mgb20 large text_blue">変更する商品を選択してください</p>
		<div class="left">
			<input type="checkbox" id="yes" name="wifi" checked>
			<label for="yes" class="checkbox shoppingCart_input"><strong>WiFi貸出料金月額</strong> <span class="text_red">980円（税込）</span></label>
		</div>
		<br>
		<a href="javascript:$.fancybox.close();" class="fancybox btn_darkBlue graphSettingTrue">変更する</a> <a href="javascript:$.fancybox.close();" class="btn_lightGray radius20 graphSettingFalse">キャンセル</a> </div>
</div>
<!--　/商品変更2 --> 

<!--　商品削除 -->
<div id="deleteItem1" class="settingContainer" style="display: none; width:400px; height:300px; ">
	<div class="settingInner">
		<p class="mgb20 large text_blue">商品を削除しますか？</p>
		<br>
		<a href="javascript:$.fancybox.close();" id="delete01" class="fancybox btn_darkBlue graphSettingTrue">削除する</a> 
		<script type="text/javascript"> 
							$('#delete01').click(function(){
							 setTimeout("location.href='index_kounyu_login.html'",1000);
							 $('.order_alert').fadeIn(1000).delay().fadeOut(1000);
							});
						</script> 
		<a href="javascript:$.fancybox.close();" class="btn_lightGray radius20 graphSettingFalse">キャンセル</a> </div>
</div>
<!--　/商品削除 --> 

<!--　商品削除2 -->
<div id="deleteItem2" class="settingContainer" style="display: none; width:400px; height:300px; ">
	<div class="settingInner">
		<p class="mgb20 large text_blue">商品を削除しますか？</p>
		<br>
		<a href="javascript:$.fancybox.close();" id="delete02" class="fancybox btn_darkBlue graphSettingTrue">削除する</a> 
		<script type="text/javascript"> 
							$('#delete02').click(function(){
							$('#item02').remove();
							 $('.order_alert').fadeIn(1000).delay().fadeOut(1000);
							});
						</script> 
		<a href="javascript:$.fancybox.close();" class="btn_lightGray radius20 graphSettingFalse">キャンセル</a> </div>
</div>
<!--　/商品削除2 -->

<div class="order_alert">
	<p>削除されました</p>
</div>