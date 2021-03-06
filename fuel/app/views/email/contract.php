<?php echo $user['last_name']; ?>　<?php echo $user['first_name']; ?>　様<br />
                                                        <?php echo $date; ?><br />
**********************************************************************<br />
 LASHICサービス購入のご連絡<br />
**********************************************************************<br />
このたびはLASHICサービスにお申込、サービスのご購入をいただき、誠にありがとうござました。<br />
現在、お受付順にLASHIC-roomの出荷準備をしております。<br />
出荷手配ができ次第、ご案内のうえ発送させて頂きますので、今しばらくお待ち下さい。<br />
<br />
<br />
■今後の流れ<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
URLより初回利用登録を行います。<br />
<?php echo $url; ?><br />
　↓<br />
ログイン後見守りユーザ登録を行います。<br />
　↓<br />
LASHIC-roomがお手元に届きます。<br />
　↓<br />
LASHIC-roomを居室内に設置します。<br />
　↓<br />
LASHIC-roomをインターネット回線に接続します。<br />
<br />
以上の5ステップで簡単に見守りが開始されます。<br />
初回利用登録で入力頂いたID（メールアドレス）とパスワードを入力してログインしてください。
<br />
<br />
■アカウント登録情報<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
お名前 ： <?php echo $user['last_name']; ?>　<?php echo $user['first_name']; ?><br />
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
小　計 ：<?php echo $subtotal_priec; ?>（税抜）<br />
送　料 ：<?php echo $destination['shipping']; ?>円<br />
消費税 ：<?php echo $tax; ?>円<br />
合　計 ：<?php echo $total_price; ?>円<br />
　

<br />
<br />
■サポート＆サービス情報<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
↓Ｑ＆Ａ<br />
http://www.infic-c.net/LASHIC/qa.html<br />
↓お問い合わせ<br />
http://www.lashic.jp/contact<br />
↓運営会社<br />
http://www.infic.net<br />
http://www.infic-c.net<br />
<br />
■お問い合わせについて<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
このメールアドレスは送信専用となっております。<br />
ご質問等を返信いただきましても回答することができませんので、<br />
あらかじめご了承願います。<br />
<br />
■個人情報保護方針<br />
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br />
当社の個人情報保護方針につきましては、下記のWebサイトにてご確認いただけ<br />
ます。<br />
http://www.infic-c.net/LASHIC/privacy.htm<br />
<br />
**********************************************************************<br />
本メールは自動的に作成し、配信しております。<br />
本メールへ返信いただきましても、お返事致し兼ねますのでご注意ください。<br />
**********************************************************************<br />
<br />
発行・製作　：株式会社インフィック、インフィック・コミュニケーションズ株式会社<br />
全文、または一部の記事の無断転載および再配布を禁じます。<br />
