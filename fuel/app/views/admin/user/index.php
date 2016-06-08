<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント詳細確認</h2>
		<div class="panel panel-default">
			<table class="table table-bordered">
				<tr>
					<td class="info col-sm-3 text-right">システムID</td>
					<td class="col-sm-9">
						<?php echo $user['id']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">名前</td>
					<td>
						<a href="/admin/user/?admin_user_id=<?php echo $user['id']; ?>"><?php echo $user['name']; ?>
						(<?php echo $user['kana']; ?>)
						</a>
					</td>
				</tr>
				<tr>
					<td class="info text-right">Eメール</td>
					<td>
						<?php echo $user['email']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">郵便番号</td>
					<td>
						<?php echo $user['zip_code']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">都道府県</td>
					<td>
						<?php echo $user['prefecture']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">住所</td>
					<td>
						<?php echo $user['address']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">電話番号1</td>
					<td>
						<?php echo $user['phone']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">電話番号2</td>
					<td>
						<?php echo $user['cellular']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">生年月日</td>
					<td>
						<?php echo $user['birthday']; ?>
					</td>
				</tr>
				<tr>
					<td class="info text-right">性別</td>
					<td>
						<?php echo $user['gender']; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>

</div>