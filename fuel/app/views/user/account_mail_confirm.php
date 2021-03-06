		<!-- content start メールアドレス確認 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account_mail_complete" method="post">
				<?php echo Form::hidden('id', $data['id']); ?>
				<?php echo Form::hidden('new_email', $data['new_email']); ?>
                                
				<h1 class="contentLarge_h1">アカウント　メールアドレス変更申し込み確認</h1>
				<p>以下の入力内容でお間違いないかご確認ください。</p>
				<!-- /メールアドレス -->
				<h2 class="form_title">メールアドレス</h2>
				<div class="form_set_container">
						<p class="center mgt20 mgb20"><?php echo $data['new_email']; ?></p>
				</div>
				<!-- /メールアドレス--> 
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="変更を申し込む" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end メールアドレス確認 --> 