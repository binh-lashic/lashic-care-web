<div class="row">
	<div class="col-sm-12">
		<h2>親アカウント:<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?></h2>
    <ul class="nav nav-tabs">
      <li role="presentation" class="active"><a href="/admin/user/?id=<?php echo $user['id']; ?>">詳細</a></li>
      <li role="presentation"><a href="/admin/user/sensor?id=<?php echo $user['id']; ?>">センサー機器割当</a></li>
      <li role="presentation"><a href="/admin/user/client_form?id=<?php echo $user['id']; ?>">見守られユーザ登録</a></li>
      <li role="presentation"><a href="/admin/user/client/list?id=<?php echo $user['id']; ?>">見守られユーザ一覧</a></li>
    </ul>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">

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
						<?php echo $user['last_name']; ?><?php echo $user['first_name']; ?>(<?php echo $user['last_kana']; ?><?php echo $user['first_kana']; ?>)
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
				<tr>
					<td class="info text-right">流入元</td>
					<td>
						<?php echo $user['affiliate']; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>

</div>