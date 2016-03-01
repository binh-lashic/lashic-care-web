<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Care Eye ケア　アイ - ユーザーの様子</title>
<meta name="keywords" content="ケア　アイ,ケア,アイ,見守り">
<meta name="description" content="ケア　アイの管理画面です。">
<meta name="robots" content="all">
<meta property="og:type" content="website" >
<meta property="og:url" content="" >
<meta property="og:locale" content="ja_JP" >
<meta property="og:image" content="/images/ogp.jpg" >
<meta property="og:site_name" content="" >
<meta property="og:description" content="ケア　アイの管理画面です。" >
<link href="/css/reset.css" type="text/css" rel="stylesheet">
<link href="/css/common.css" type="text/css" rel="stylesheet">
<link href="/css/drawer.css" type="text/css" rel="stylesheet">
<link href="/css/style.css" type="text/css" rel="stylesheet">
<link href="/css/print.css" type="text/css" rel="stylesheet" media="print" />
<!-- 円グラフ -->
<link href="/css/jquery.circliful.css" type="text/css" rel="stylesheet">
<!-- /円グラフ -->
<!-- カレンダー表示・非表示 -->
<link href="/css/darktooltip.css" type="text/css" rel="stylesheet">
<!-- /カレンダー表示・非表示 -->
<link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet" type="text/css">

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<!-- srcoll design -->
<script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
$(function(){
	$('.scroll_area').jScrollPane();
});
</script>
<!-- /srcoll design -->


<!-- light box -->
<link type="text/css" href="/css/shadowbox.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="/js/shadowbox.js"></script>
<script type="text/javascript">  
Shadowbox.init({
  //modal:true
  //slideshowDelay:1
  //showOverlay:false
  //overlayColor:'#f60'
  //animate:false,
  //animateFade:false
  //continuous:true
  //displayNav: false
});
</script> 
<!-- /light box -->
</head>
<body id="home" class="drawer drawer--right">
<?php echo isset($header) ? $header : ""; ?>
<?php echo isset($content) ? $content : ""; ?>
<?php echo isset($footer) ? $footer : ""; ?>
<footer>
	<p><a href="#">運営者からのお知らせ</a>　　<a href="#">利用規約</a>　　<a href="#">運営会社</a>　　<a href="#">プライバシーポリシー</a>　　<a href="#">お問い合わせ</a></p>
	<p><span class="ftr_copyrights">&copy;</span> Care Eye. All Rights Reserved.</p>
</footer>
<p id="page-top"><a href="#home"><img src="/images/common/btn_pagetop.png" width="59" height="59" alt=""/></a></p>
<div id="attention_01">
  <div class="attention_01"><p>ただ今制作<br>5月中旬公開予定</p></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script> 
<script src="https://cdn.rawgit.com/ungki/bootstrap.dropdown/3.3.5/dropdown.min.js"></script> 
<script src="/js/drawer.min.js" charset="utf-8"></script> 
<script src="/js/jquery.darktooltip.min.js" charset="utf-8"></script> 
<!-- 円グラフ --> 
<script src="/js/jquery.circliful.min.js"></script> 
<script>
$(document).ready(function(){
    $('.myStat').circliful();
});
</script> 
<!-- /円グラフ --> 
<script src="/js/jquery.tile.js" type="text/javascript"></script> 
<script src="/js/content.js" type="text/javascript"></script>
<script src="/js/main.js" type="text/javascript"></script> 
</body>
</html>
