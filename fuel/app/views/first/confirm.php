		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">初めて利用される方はこちら</h1>
			<!-- flow矢印 -->
			<div class="flowSet flow_no03">
				<ol>
					<li class="flowBoxOn_before">アカウント情報　入力</li>
					<li class="flowBoxOn">アカウント情報　確認</li>
					<li>アカウント登録完了</li>
				</ol>
			</div>
			<!-- /flow矢印 -->
			
			
			
			<div class="contentLarge_h2"><h2>アカウント情報　確認</h2></div>
				<!-- 基本情報 -->
				<h2 class="form_title">基本情報</h2>
				<form action="/first/complete" method="post">
					<input type="hidden" name="email" value="<?php if(!empty($data['email'])) { echo $data['email']; } ?>" />
					<input type="hidden" name="password" value="<?php if(!empty($data['password'])) { echo $data['password']; } ?>" />
				<div class="form_set_container">
						<div class="form_base_data_edit">
							<table>
								<tbody>
									<tr>
										<th>メールアドレス</th>
										<td><?php if(!empty($data['email'])) { echo $data['email']; } ?></td>
									</tr>
									<tr>
										<th>パスワード</th>
										<td>******</td>
									</tr>
								</tbody>
							</table>
					</div>
				</div>
				<!-- /基本情報 -->
				
				<div class="set_container">
					<div class="left_container"><a href="#" class="link_back">戻る</a></div>
					<div class="center_container">
						<input type="submit" value="アカウント登録する" >
					</div>
					<div class="right_container"></div>
				</div>
			</form>
		</section>
		<!-- /content end　編集一覧 -->
