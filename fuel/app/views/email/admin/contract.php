LASHIC新規アカウント登録・購入情報<br />
<br />
下記のユーザーが新規にアカウント登録・ご購入いただきました。<br />
速やかに発送の準備を進めてください。<br />
<br />
日時:<?php echo $date; ?><br />
入力端末:<?php echo $user_agent; ?><br />
<br />
■アカウント登録情報<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
ID:<?php echo $user['id']; ?><br />
お名前 ： <?php echo $user['last_name']; ?>　<?php echo $user['first_name']; ?><br />
性　別 ： <?php echo $user['gender_display']; ?><br />
生年月日： <?php echo $user['birthday_display']; ?><br />
住　所 ： <?php echo $user['prefecture']; ?><?php echo $user['address']; ?><br />
電　話 ： <?php echo $user['phone']; ?><br />
メール ： <?php echo $user['email']; ?><br />
<br />
■お支払い情報<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
カード番号 ： <?php echo $card['CardNo']; ?><br />
有効期限　 ： <?php echo substr($card['Expire'], 2, 2); ?>月 20<?php echo substr($card['Expire'], 0, 2); ?>年<br />
名　義　人 ： <?php echo $card['HolderName']; ?><br />
<br />
■送付先<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
お名前 ： <?php echo $destination['last_name']; ?>　<?php echo $destination['first_name']; ?><br />
住　所 ： <?php echo $destination['prefecture']; ?><?php echo $destination['address']; ?><br />
電　話 ： <?php echo $destination['phone']; ?><br />
<br />
■ご注文内容<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
<?php
foreach($plans as $plan) {
?>
<?php echo $plan['title'] ?>：<?php echo $plan['price'] ?>円<br />
<?php
}
?><br />
小　計 ：<?php echo $subtotal_price; ?>円（税抜）<br />
送　料 ：<?php echo $destination['shipping'] ? $destination['shipping'] : 0; ?>円<br />
消費税 ：<?php echo $tax; ?>円<br />
合　計 ：<?php echo $total_price; ?>円<br />
備　考 ：<?php echo nl2br($destination['remarks']); ?><br />
