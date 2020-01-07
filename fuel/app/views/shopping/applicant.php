	<div class="clearfix content">
		<!-- flow矢印 -->
		<div class="flowSet flow_no06">
			<ol>
				<li class="flowBoxOn_before">カート</li>
				<li class="flowBoxOn">申込情報 入力</li>
				<li>支払情報 入力</li>
				<li>お届け先情報 入力</li>
				<li>完了</li>
			</ol>
		</div>
		<!-- /flow矢印 -->
		
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">申込情報 入力</h1>
		<form class="h-adr" action="/shopping/applicant" method="post">
			<input type="hidden" class="p-country-name" value="Japan">
			<h2 class="form_title">申込情報</h2>
			<div class="form_set_container">
				<?php if(!empty($errors)) { ?>
					<p class="title_errer"><strong>入力内容にエラーがありました</strong></p>
				<?php } ?>
				<div class="form_set_container_form">
					<table>
						<tbody>
							<tr>
								<th><span class="icon_Required">必須</span> メールアドレス</th>
								<td>
									<input type="text" name="email" class="input_text input_medium" maxlength="512" value="<?php if(isset($data['email'])) { echo $data['email']; } ?>"><br>
									<?php if(isset($errors['email'])) {?>
										<p class="error"><?php echo $errors['email']; ?></p>
									<?php }?>
								</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> お名前</th>
								<td>
									<input type="text" name="last_name" class="input_text input_short" placeholder="例）山田" maxlength="45" value="<?php if(isset($data['last_name'])) { echo $data['last_name']; } ?>">&nbsp;&nbsp;
									<input type="text" name="first_name" class="input_text input_short" placeholder="例）太郎" maxlength="45" value="<?php if(isset($data['first_name'])) { echo $data['first_name']; } ?>">
									<?php if(!empty($errors['last_name'])) { ?>
										<p class="error"><?php echo $errors['last_name']; ?></p>
									<?php } ?>
									<?php if(!empty($errors['first_name'])) { ?>
										<p class="error"><?php echo $errors['first_name']; ?></p>
									<?php } ?>
								</td>
							</tr>
							<tr>
								<th><span class="icon_Required">必須</span> 電話番号</th>
								<td><input type="text" name="phone" class="input_text input_short" maxlength="11" placeholder="例）0542666201" value="<?php if(isset($data['phone'])) { echo $data['phone']; } ?>">
									<span class="small text_red">※</span><span class="small">半角数字、ハイフンなしでご入力ください。</span>
									<?php if(!empty($errors['phone'])) { ?>
										<p class="error"><?php echo $errors['phone']; ?></p>
									<?php } ?>
							</td>
							</tr>
						</tbody>
					</table>
					<div class="set_container mgb30">
						<div class="left_container"></div>
						<div class="center_container icon_white_arrow">
							<input type="submit" value="次の画面に進む" >
						</div>
						<div class="right_container"></div>
					</div>
				</div>
			</div>
			</form>

			<div class="set_container">
				<div class="left_container"><a href="/shopping/cart" class="link_back">戻る</a></div>
				<div class="center_container"></div>
				<div class="right_container"></div>
			</div>
		</section>
		<!-- /content end　編集一覧 -->
	</div>
