		
		<!-- aide start -->
		<aside id="aside_userDate">
			<div class="aside_container">
				<div class="clearfix">
					<p class="aside_title">基本データ</p>
					<div class="aside_btn_edit"><a href="#attention_01" rel="shadowbox[cont]" class="btn_text">編集</a></div>
				</div>
				<div class="aside_photo"><div class="aside_photoInner"><img src="/images/user/sample.jpg" width="179" height="179" alt=""/></div></div>
				
				<dl class="aside_userDetail clearfix">
					<dt><img src="/images/common/user_icon_birth.png" width="17" alt="生年月日"/></dt>
					<dd><?php echo date("Y年m月d日", strtotime($client['birthday'])); ?>（<?php echo $client['age']; ?>歳）</dd>
					<dt><img src="/images/common/user_icon_blood.png" width="19" alt="血液型"/></dt>
					<dd><?php echo $client['blood_type']; ?>型</dd>
					<dt><img src="/images/common/user_icon_address.png" width="19" alt="住所"/></dt>
					<dd><?php echo $client['address']; ?></dd>
					<dt><img src="/images/common/user_icon_phone.png" width="19" alt="生年月日"/></dt>
					<dd><?php echo $client['phone']; ?></dd>
					<dt><img src="/images/common/user_icon_mobile.png" width="9" alt="生年月日"/></dt>
					<dd><?php echo $client['cellular']; ?></dd>
				</dl>
				
				
				<!-- 緊急連絡先 -->
				<div class="aside_emergency">
					<h3><img src="/images/common/user_icon_emergency.png" width="17" alt=""/> 緊急連絡先</h3>
					<ul>
						<li>
							<dl>
								<dt>斉藤雅和</dt>
								<dd>018-882-2016<br>080-1813-4139</dd>
							</dl>
						</li>
						<li>
							<dl>
								<dt>斉藤雅和</dt>
								<dd>018-882-2016<br>080-1813-4139</dd>
							</dl>
						</li>
					</ul>
				</div>
				<!-- /緊急連絡先 -->
				
				
				<!-- 連絡共有 -->
				<div class="aside_share">
					<h3><img src="/images/common/user_icon_share.png" width="32" alt=""/> 連絡共有</h3>
					<div class="aside_shareInner">
						<ul class="scroll_area">
<?php
if(!empty($admins)) {
	foreach($admins as $admin) {
?>
							<li><?php echo $admin['name']; ?></li>
<?php
	}
}
?>
						</ul>
					</div>
				</div>
				<!-- /連絡共有 -->
				
			</div>
		</aside>
		<!-- /aide end --> 
	</div>
</main>