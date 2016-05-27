<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Care Eye ケア　アイ - <?php if(!empty($title)) { echo $title; } ?></title>
<meta name="keywords" content="ケア　アイ,ケア,アイ,見守り">
<meta name="description" content="ケア　アイの管理画面です。">
<meta name="robots" content="all">
<meta property="og:type" content="website" >
<meta property="og:url" content="" >
<meta property="og:locale" content="ja_JP" >
<meta property="og:image" content="/images/common/ogp.jpg" >
<meta property="og:site_name" content="Care Eye（ケア　アイ）　管理ページ" >
<meta property="og:description" content="Care Eye（ケア　アイ）は高齢者の”自立”をささえ、”あんしん”を共有します。" >
<meta name="viewport" content="width=360,initial-scale=0.1">
<meta name="viewport" content="target-densitydpi=device-dpi, width=1000px, minimum-scale=0.1, maximum-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" href="/apple-touch-icon-precomposed.png">
<link href="/css/reset.css" type="text/css" rel="stylesheet">
<link href="/css/common.css" type="text/css" rel="stylesheet">
<link href="/css/drawer.css" type="text/css" rel="stylesheet">
<link href="/css/style.css" type="text/css" rel="stylesheet">
<link href="/css/jquery.mCustomScrollbar.css" type="text/css" rel="stylesheet">
<link href="/css/print.css" type="text/css" rel="stylesheet" media="print" />
<link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet" type="text/css">
<link href="/css/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!-- 円グラフ -->
<link href="/css/jquery.circliful.css" type="text/css" rel="stylesheet">
<!-- /円グラフ -->
<!-- カレンダー表示・非表示 -->
<link href="/css/darktooltip.css" type="text/css" rel="stylesheet">
<!-- /カレンダー表示・非表示 -->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet" type="text/css">
<script src="/js/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/js/amcharts/serial.js" type="text/javascript"></script>

<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
</head>
<body id="home" class="drawer drawer--right">
<?php echo isset($header) ? $header : ""; ?>
<?php echo isset($content) ? $content : ""; ?>
<?php echo isset($sidebar) ? $sidebar : ""; ?>
  </div>
</main>
<footer>
  <ul>
    <li><a href="/page/news">運営者からのお知らせ</a></li>
    <li><a href="/page/terms">利用規約</a></li>
    <li><a href="http://www.infic.net/" target="_blank">運営会社</a></li>
    <li><a href="/page/privacy">プライバシーポリシー</a></li>
    <li><a href="/contact">お問い合わせ</a></li>
  </ul>
  <p><span class="ftr_copyrights">&copy;</span> Care Eye. All Rights Reserved.</p>
</footer>
<p id="page-top"><a href="#home"><img src="/images/common/btn_pagetop.png" width="59" height="59" alt=""/></a></p>


<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script> 
<script src="https://cdn.rawgit.com/ungki/bootstrap.dropdown/3.3.5/dropdown.min.js"></script> 
<script src="/js/jquery.darktooltip.min.js" charset="utf-8"></script> 
<!-- 円グラフ --> 
<script src="/js/jquery.circliful.min.js"></script> 
<script>
$(document).ready(function(){
    $('.myStat').circliful();
});
</script> 
<!-- /円グラフ --> 
<script src="/js/drawer.min.js" charset="utf-8"></script> 
<script src="/js/jquery.tile.js" type="text/javascript"></script> 
<script src="/js/content.js" type="text/javascript"></script>
<script src="/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/js/main.js" type="text/javascript"></script> 
</body>
</html>