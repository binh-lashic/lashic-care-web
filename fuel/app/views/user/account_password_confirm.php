		<!-- content start パスワード変更確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account_password_complete" method="post">
				<input type="hidden" name="password" value="<?php echo $data['password']; ?>" />
				<input type="hidden" name="new_password" value="<?php echo $data['new_password']; ?>" />  
				<h1 class="contentLarge_h1">アカウント　パスワード変更確認</h1>
				<p class="mgb80 mgt80 center">パスワードを変更します。よろしいですか？</p>
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="変更を完了する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end パスワード変更確認 --> 