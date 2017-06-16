		<!-- content start メールアドレス変更完了 -->
		<section id="contentBoxLarge">
			<form class="form" action="/user/account" method="get">
				<h1 class="contentLarge_h1">アカウント　メールアドレス変更完了</h1>
				
				<table class="tableBeige form_result mgt20">
					<tr>
						<th><?php if($isSuccess) : ?>メールアドレスの変更を完了しました。<?php else : ?>有効期限切れ<?php endif; ?></th>
					</tr>
					<tr>
						<td><?php if($isSuccess) : ?>メールアドレスにお手続き完了のご連絡をお送りいたしました。<?php else : ?>確認メールの有効時間を超過しています。再度メールアドレスの変更手続きをお願いします。<?php endif; ?></td>
					</tr>
				</table>
				
				<div class="set_container">
					<div class="left_container"></div>
					<div class="center_container">
						<input type="submit" value="マイページへ" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end メールアドレス変更完了 --> 