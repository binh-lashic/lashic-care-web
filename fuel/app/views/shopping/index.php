<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header"> <a class="logo" href="index.html"><img src="/images/common/logo.png" alt=""/></a></div>
		s
		<nav class="drawer-nav drawer-nav-userMenu" role="navigation">
		<button type="button" class="drawer-toggle drawer-hamburger">
          <span class="sr-only">toggle navigation</span>
          <span class="drawer-hamburger-icon"></span>
        </button>
			<ul class="drawer-menu drawer-menu--right">
				<li class="drawer-dropdown nav_logout"><a href="/" class="drawer-dropdown-menu-item">
					  ログイン
					</a>
         		 </li>
				<li id="nav_cart" class="drawer-dropdown nav_cart">
					<a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="nav_cart_text">カート</span><span class="nav_number">1</span></a>
					<div class="drawer-dropdown-menu cartMenu">
					<div id="cartMenu">
						<ul>
							<li id="nav_order01" class="nav_userList">
								<p class="nav_cart_title">CareEye（ケアアイ）<br>12ヶ月パック</p>
								<p class="nav_cart_btnArea right"><a href="javascript:();" class="nav_cart_link" id="nav_cart_delete01">× 削除</a></p>
							</li>
							<li class="nav_userList center"><p class="nav_cart_title">何も入っていません<br><span class="small text_red">＊何も入っていない場合</span></p></li>
							<li>
								<p class="nav_cart_btnArea"><a href="shopping_flow01_01.html" class="nav_cart_btn">購入手続きへ</a></p></li>
						</ul>
						<script type="text/javascript"> 
							/* 1つ目 */
							$('#nav_cart_delete01').click(function(){
								$('#nav_order01').remove();
								$('#nav_cart').addClass("opened");
								$('.opened').delay().queue(function(){
									$('#nav_cart').removeClass("opened");
									$('#nav_cart').addClass("open").dequeue();
								});
								$('.nav_cart_alert').fadeIn(1000).delay().fadeOut(500);
							});
						</script>
					</div>
					</div>
				</li>
			</ul>
						<div class="nav_cart_alert">
							<p>削除されました</p>
						</div>
		</nav>
	</div>
</header>

<!-- content -->
<main role="main" class="clearBoth">
	<div class="clearfix content">
		<!-- デザイン -->
	<div id="moreInfoBg">
	<div class="moreInfoInner2">
		<img src="/images/regist/regist_img_01.jpg" width="100%" alt="高齢者の”自立”をささえ
	”あんしん”を共有する"/> 
		
		<!-- text -->
		<div class="clearfix mgt20">
			<div class="contentHalf floatL">
				<h2 class="regist_h2">高齢者宅の<br>
					”いま”の状態を共有します</h2>
				<p>宅内に設置した「CareEye」センサーでご家族は、設置先である高齢者宅内の”いま”の状態を共有できます。<br>
					温度・湿度・照度など高齢者宅の生活環境や運動量による日常生活の様子がスマートフォンなどでリアルタイムに確認が可能。異常時には、メールやアプリによるプッシュ通知でお知らせします。</p>
			</div>
			<div class="contentHalf floatR">
				<h2 class="regist_h2"> 蓄積データを活用し<br>
					”これから”をお知らせします </h2>
				<p>センサー等で取得した情報を機械学習やAI（人工知能）を活用して解析し、介護事業で蓄積したノウハウや傾向を組み合わせ、高齢者の”これから”を想定し、お知らせします。<br>
					個々の高齢者にあった介護サービスや福祉用具の利用などを紹介し、ご家族の負担を軽減します。</p>
			</div>
		</div>
		<!-- /text --> 
		
		<!-- 枠 -->
		<div class="regist_waku clearfix">
			<div class="floatL"><img src="/images/regist/regist_img_02_01.jpg" width="129" height="169" alt="PC画面"/></div>
			<div class="floatR regist_waku_right">
				<h3 class="regist_h3 mgb20">CareEye モニター画面</h3>
				<ul>
					<li class="clearfix">
						<div class="floatL"><img src="/images/regist/regist_img_02_02.jpg" width="48" height="40" class="mgr10" alt=""/></div>
						パソコンやスマートフォン、タブレット端末で確認できます。 </li>
					<li class="clearfix">
						<div class="floatL"><img src="/images/regist/regist_img_02_03.jpg" width="48" height="40" class="mgr10" alt=""/></div>
						複数の利用者様・お部屋をモニターできます。 </li>
					<li class="clearfix">
						<div class="floatL"><img src="/images/regist/regist_img_02_04.jpg" width="48" height="40" class="mgr10" alt=""/></div>
						利用者様の状況をアイコンでわかりやすく表示します。 </li>
					<li class="clearfix">
						<div class="floatL"><img src="/images/regist/regist_img_02_05.jpg" width="48" height="40" class="mgr10" alt=""/></div>
						異常値を検出した場合は、アプリやメールでお知らせします。 </li>
					<li class="clearfix">
						<div class="floatL"><img src="/images/regist/regist_img_02_06.jpg" width="48" height="40" class="mgr10" alt=""/></div>
						表示項目や期間を設定し、過去データも自由に閲覧できます。 </li>
					<li class="clearfix">
						<div class="floatL"><img src="/images/regist/regist_img_02_07.jpg" width="48" height="40" class="mgr10" alt=""/></div>
						見やすくセンサー数値をグラフィカルに表示します。 </li>
				</ul>
			</div>
		</div>
		<!-- /枠 --> 
		
		<!-- text -->
		
		<h4 class="regist_h4">”いま”を知ることが自立支援の第一歩です</h4>
		<p>老化や人視聴の初期段階はほんの僅かな変化から始まり、ご家族はもちろん、ほんんインでさえそこに気づくのは困難です。<br>
			「CareEye」でその”いま”をキャッチして、ご本人もご家族も納得感がありバランスの取れた”自立”と”支援”の環境構築をサポートします。</p>
		<h4 class="regist_h4 mgt30">”これから”を予測することで事前準備が容易になります</h4>
		<p>認知症の発症などにより、ある日突然対応を迫られると、選択肢は狭まり、費用は増加します。<br>
			「CareEye」からの通知やレポートにより、事前準備をある程度想定しておくことで、ゆとりを持って個々の状態や環境にふさわしい選択が可能とります。</p>
		<!-- /text --> 
		
	</div>
</div>
	<!-- /デザイン -->
		<!-- 後でデザイン変更 -->
		<div>
			<div class="shoppingCart_container clearfix">
				<ul class="shoppingCart_containerUl">
					<li class="shoppingCart_containerLi">
						<div class="shoppingCart_box">
							<h3 class="shoppingCart_h3">CareEye（ケアアイ）<br>月々パック</h3>
							<p class="shoppingCart_price">1200円（税込）<span class="small">/月</span></p>
							<p class="right">初期費用 14,800円（税込）</p>
							<div class="shoppingCart_detail">
								<ul class="ul-disc">
									<li>月々1200円（税込）が自動的に引き落とされます。</li>
									<li>1ヶ月からお試しでご利用も可能です。</li>
								</ul>
							</div>
							<div class="mgt10 mgb10"><a class="shoppingFancybox btn_darkBlue" data-plan="1" href="#settingChange">カートに入れる</a></div>
							<input type="checkbox" id="pack1">
							<label for="pack1" class="checkbox shoppingCart_input">wifi貸出　月980円（税込）も一緒に申し込む</label>
						</div>
					</li>
					<li class="shoppingCart_containerLi">
						<div class="shoppingCart_box">
							<h3 class="shoppingCart_h3">CareEye（ケアアイ）<br>6ヶ月パック</h3>
							<p class="shoppingCart_price">6600円（税込）<span class="small">1100円/月</span></p>
							<p class="right">初期費用 14,800円（税込）</p>
							<div class="shoppingCart_detail">
								<ul class="ul-disc">
									<li>6ヶ月分6600円（税込）の一括払い。6ヶ月ごとに自動更新されます。</li>
								</ul>
							</div>
							<div class="mgt10 mgb10"><a class="shoppingFancybox btn_darkBlue" data-plan="2" href="#settingChange">カートに入れる</a></div>
							<input type="checkbox" id="pack2">
							<label for="pack2" class="checkbox shoppingCart_input">wifi貸出　月980円（税込）も一緒に申し込む</label>
						</div>
					</li>
					<li class="shoppingCart_containerLi">
						<div class="shoppingCart_box">
							<h3 class="shoppingCart_h3">CareEye（ケアアイ）<br>12ヶ月パック</h3>
							<p class="shoppingCart_price">11760円（税込） <span class="small">980円/月</span></p>
							<p class="right">初期費用 14,800円（税込）</p>
							<div class="shoppingCart_detail">
								<ul class="ul-disc">
									<li>12ヶ月分11760円（税込）の一括払い。12ヶ月ごとに自動更新されます。</li>
								</ul>
							</div>
							<div class="mgt10 mgb10"><a class="shoppingFancybox btn_darkBlue" data-plan="3" href="#settingChange">カートに入れる</a></div>
							<input type="checkbox" id="pack3">
							<label for="pack3" class="checkbox shoppingCart_input">wifi貸出　月980円（税込）も一緒に申し込む</label>
						</div></li>
				</ul>
			</div>
		</div>
		<!-- /後でデザイン変更 -->
	</div>
</main>

<div id="settingChange" class="settingContainer" style="display: none; width:400px; height:300px; ">
	<div class="settingInner">
		<p class="mgb20">選択した商品を購入しますか？</p>
		<a href="#settingComp" class="startShopping shoppingFancybox btn_darkBlue graphSettingTrue">カートに入れる</a>
		<a href="javascript:$.shoppingFancybox.close();" class="btn_lightGray radius20 graphSettingFalse">キャンセル</a>
	</div>
</div>
<div id="settingComp" class="settingContainer" style="display: none; width:400px; height:300px; ">
	<div class="settingInner">
		<p class="mgb20">商品をカートに入れました。</p>
		<a href="/shopping/cart" class="hoppingFancybox btn_darkBlue graphSettingTrue">購入手続きへ</a>
		<a href="javascript:$.shoppingFancybox.close();" class="btn_lightGray radius20 graphSettingFalse">ページへ戻る</a>
	</div>
</div>
<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
<script>
$(document).ready(function() {
	$(".shoppingFancybox").click(function(event) {
		if(typeof $(this).attr('data-plan') != "undefined") {
			var plan_ids = [];
			var plan = $(this).attr('data-plan');
			if(plan == '1') {
				plan_ids.push(1);
			} else if(plan == '2') {
				plan_ids.push(2);
			} else if(plan == '3') {
				plan_ids.push(3);
			}
			plan_ids.push(4);	//初期費用
			console.log($("#pack" + plan).prop('checked'));
			if($("#pack" + plan).prop('checked')) {
				plan_ids.push(5);	//wifi貸出
			}
	        Cookies.set("plan_id", JSON.stringify(plan_ids), { expires: 90 });

		}
    });
 	$(".shoppingFancybox").fancybox();
	$(".startShopping").click(function(event) {
        Cookies.set("cart_plan_id", Cookies.get("plan_id"));
    });
}); 
</script> 