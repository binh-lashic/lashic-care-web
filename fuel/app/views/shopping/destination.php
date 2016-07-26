	<div class="clearfix content"> 
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li>カート</li>
				<li class="flowBoxOn_before">見守り対象ユーザー設定</li>
				<li class="flowBoxOn">送付先指定</li>
				<li>配送とお支払い</li>
				<li>ご注文確認</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 --> 
		
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">送付先指定</h1>
			<p>CareEye機器の送付先をご指定ください。</p>
			<div class="shoppingCart_container clearfix">
				<ul class="shoppingCart_containerUl">
<?php
foreach($users as $key => $_user)
{
?>
					<li id="order_address<?php echo $key; ?>" class="shoppingCart_containerLi shopping_tile">
<?php
/*
						<div class="order_deleteSet">
							<button id="order_btn_delete01" class="order_btn_delete" onClick="removeElement()"><span class="order_btn_delete_icon close"></span><span class="order_wrap_text">削除する</span></button>
						</div>
						<script type="text/javascript"> 
							$('#order_btn_delete<?php echo $key; ?>').click(function(){
							$('#order_address<?php echo $key; ?>').remove();
							 $('.order_alert').fadeIn(1000).delay().fadeOut(1000);
							});
						</script>
*/
						?>
						<div class="borderGrayRadius pd20">
							<div class="shoppingCart_address">
								<h3 class="shoppingCart_h3"><?php echo $_user['last_name']; ?><?php echo $_user['first_name']; ?></h3>
								<p><?php echo $_user['prefecture']; ?><?php echo $_user['address']; ?><br>
									<?php echo $_user['phone']; ?></p>
							</div>
							<div class="mgt10 mgb10"><a class="fancybox btn_darkBlue" href="/shopping/destination_confirm?user_id=<?php echo $_user['id']; ?>">この住所を使う</a></div>
							<p class="right"><a href="#">編集する</a></p>
						</div>
					</li>
<?php
}
?>


				</ul>
			</div>
			<p class="mgt20 mgb30 center text_red">送付先がありません<br>
				下記フォームより送付先を追加してください<br>
			</p>
			
			<!-- 新しい住所追加エラー -->
			<h2 class="form_title">新しい住所を追加</h2>
			<div class="form_set_container">
				<p class="title_errer"><strong>入力内容にエラーがありました</strong></p>
				<p class="mgt20">必要事項を入力し、「この住所を使う」ボタンをクリックしてください。</p>
				<ul class="ul-disc">
					<li>私書箱や空港内の窓口へのお届けは承っておりません。</li>
					<li>コンビニや営業所などの住所を入力すると商品をお受け取りいただけません。</li>
				</ul>
				<div class="form_set_container_form">
					<table>
						<tbody>
							<tr>
								<th><span class="icon_Required">必須</span> お名前</th>
								<td><input type="text" class="input_text input_short" placeholder="例）山田">
									&nbsp;&nbsp;
									<input type="text" class="input_text input_short" placeholder="例）太郎">
									<p class="error">エラー：お名前を入力してください。</p></td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> ふりがな</th>
								<td><input type="text" class="input_text input_short" placeholder="例）やまだ">
									&nbsp;&nbsp;
									<input type="text" class="input_text input_short" placeholder="例）たろう">
									<p class="error">エラー：ふりがなを入力してください。</p></td>
							</tr>
							<tr>
								<th>郵便番号</th>
								<td><input type="text" class="input_text input_short" maxlength="7" placeholder="例）1234567">
									&nbsp;&nbsp;
									<input class="btn_text btn_text_large" type="submit" value="郵便番号から住所を設定" >
									　&nbsp;&nbsp;<a href="http://www.post.japanpost.jp/zipcode/" target="_blank">郵便番号検索</a>&nbsp;&nbsp;<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span></td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 都道府県</th>
								<td><div class="clearfix">
										<div class="floatL common_select">
											<select>
												<option value="" selected>都道府県</option>
												<option value="北海道">北海道</option>
												<option value="青森県">青森県</option>
												<option value="岩手県">岩手県</option>
												<option value="宮城県">宮城県</option>
												<option value="秋田県">秋田県</option>
												<option value="山形県">山形県</option>
												<option value="福島県">福島県</option>
												<option value="茨城県">茨城県</option>
												<option value="栃木県">栃木県</option>
												<option value="群馬県">群馬県</option>
												<option value="埼玉県">埼玉県</option>
												<option value="千葉県">千葉県</option>
												<option value="東京都">東京都</option>
												<option value="神奈川県">神奈川県</option>
												<option value="新潟県">新潟県</option>
												<option value="富山県">富山県</option>
												<option value="石川県">石川県</option>
												<option value="福井県">福井県</option>
												<option value="山梨県">山梨県</option>
												<option value="長野県">長野県</option>
												<option value="岐阜県">岐阜県</option>
												<option value="静岡県">静岡県</option>
												<option value="愛知県">愛知県</option>
												<option value="三重県">三重県</option>
												<option value="滋賀県">滋賀県</option>
												<option value="京都府">京都府</option>
												<option value="大阪府">大阪府</option>
												<option value="兵庫県">兵庫県</option>
												<option value="奈良県">奈良県</option>
												<option value="和歌山県">和歌山県</option>
												<option value="鳥取県">鳥取県</option>
												<option value="島根県">島根県</option>
												<option value="岡山県">岡山県</option>
												<option value="広島県">広島県</option>
												<option value="山口県">山口県</option>
												<option value="徳島県">徳島県</option>
												<option value="香川県">香川県</option>
												<option value="愛媛県">愛媛県</option>
												<option value="高知県">高知県</option>
												<option value="福岡県">福岡県</option>
												<option value="佐賀県">佐賀県</option>
												<option value="長崎県">長崎県</option>
												<option value="熊本県">熊本県</option>
												<option value="大分県">大分県</option>
												<option value="宮崎県">宮崎県</option>
												<option value="鹿児島県">鹿児島県</option>
												<option value="沖縄県">沖縄県</option>
											</select>
										</div>
									</div>
									<p class="error">エラー：都道府県を選択してください。</p></td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 都道府県以下</th>
								<td><input type="text" class="input_text input_large" placeholder="例）静岡市インフィックマンション302号">
									<br>
									<span class="small text_red">※</span><span class="small">市町村、番地、建物名、室番号までご入力ください。</span>
									<p class="error">エラー：都道府県以下を入力してください。</p></td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 電話番号</th>
								<td><input type="text" class="input_text input_short" maxlength="11" placeholder="例）0542666201">
									<span class="small text_red">※</span><span class="small">半角英数、ハイフンなしでご入力ください。</span>
									<p class="error">エラー：電話番号を入力してください。</p></td>
							</tr>
						</tbody>
					</table>
					<div class="set_container mgb30">
						<div class="left_container"></div>
						<div class="center_container icon_white_arrow">
							<input type="submit" onClick="location.href='shopping_flow02_04.html'" value="この住所を使う" >
						</div>
						<div class="right_container"></div>
					</div>
				</div>
			</div>
			<!--/ 新しい住所追加エラー -->
			<div class="order_alert">
				<p>削除されました</p>
			</div>
			<div class="set_container">
				<div class="left_container"><a href="index_kounyu_login.html" class="link_back">戻る</a></div>
				<div class="center_container"></div>
				<div class="right_container"></div>
			</div>
		</section>
		<!-- /content end　編集一覧 --> 
	</div>