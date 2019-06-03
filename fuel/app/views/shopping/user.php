		
		<!-- content start　編集一覧 -->
		<section id="contentBoxLarge">
			<h1 class="contentLarge_h1">見守り対象ユーザー設定</h1>
			<p>LASHIC機器を使用する見守り対象ユーザーの情報をご登録ください。</p>
			
			<!-- 基本情報 -->
			<div class="set_container mgb30">
				<div class="left_container"></div>
				<div class="center_container icon_white_arrow">
					<form action="/shopping/user_form" method="get">
						<input type="submit"  value="見守り対象ユーザーを新規登録する" >
					</form>
				</div>
				<div class="right_container"></div>
			</div>
			<h2 class="form_title">ユーザー選択</h2>
			<div class="form_set_container">
<?php
if(!empty($clients)) {
?>
				<table>
					<tbody>
						<tr>
							<th class="center" style="width:120px;"></th>
							<th class="left" style="width:120px;">お名前</th>
							<th class="left">送付先</th>
							<th class="center" style="width:200px;"></th>
						</tr>
<?php
	foreach($clients as $_client)
	{
?>
						<tr>
							<td class="center"><a href="/user/set_client?id=<?php echo $_client['id']; ?>">情報を修正する</a></td>
							<td class="left"><?php echo $_client['last_name']; ?><?php echo $_client['first_name']; ?></td>
							<td class="left"><?php echo $_client['prefecture']; ?><?php echo $_client['address']; ?></td>
							<td class="center"><a href="/shopping/destination?client_user_id=<?php echo $_client['id']; ?>" class="btn_text">このユーザーを選択する</a></td>
						</tr>
<?php
	}
?>					</tbody>
				</table>
<?php
} else {
?>
				<p class="pdt30 pdb30 center">見守り対象ユーザーが存在しません</p>
<?php
}
?>
			</div>
			
			<!-- /基本情報 --> 
		</section>
		<!-- /content end　編集一覧 --> 
	</div>
