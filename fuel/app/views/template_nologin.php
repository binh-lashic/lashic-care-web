<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>高齢者の”自立”をささえ、”あんしん”を共有する、LASHIC ラシク</title>
<meta name="keywords" content="ラシク,見守り">
<meta name="description" content="ラシクの管理画面です。">
<meta name="robots" content="all">
<meta property="og:type" content="website" >
<meta property="og:url" content="" >
<meta property="og:locale" content="ja_JP" >
<meta property="og:image" content="/images/common/ogp.jpg" >
<meta property="og:site_name" content="LASHIC（ラシク）　管理ページ" >
<meta property="og:description" content="LASHIC（ラシク）は高齢者の”自立”をささえ、”あんしん”を共有します。" >
<meta name="viewport" content="target-densitydpi=device-dpi, width=1000px, minimum-scale=0.1, maximum-scale=1.0, user-scalable=yes">
<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" href="/apple-touch-icon-precomposed.png">

<link href="/css/reset.css" type="text/css" rel="stylesheet">
<link href="/css/common.css" type="text/css" rel="stylesheet">
<link href="/css/drawer.css" type="text/css" rel="stylesheet">
<link href="/css/style.css" type="text/css" rel="stylesheet">
<link href="/css/print.css" type="text/css" rel="stylesheet" media="print" />
<link href="/css/jquery.mCustomScrollbar.css" type="text/css" rel="stylesheet">
<link href="/css/animate.min.css" rel="stylesheet">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

<!-- srcoll design -->
<script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
$(function(){
  $('.scroll_area').jScrollPane();
});
</script>
<!-- /srcoll design -->

<!-- ログイン画面デザインjs -->
<script type="text/javascript">
/* ログインページ　高さ */



$(document).ready(function(){
if ($(window).width() > 773) {//ウインドウサイズが736以上ならば
var WindowHeight2 = $(window).height()*0.3; //WindowHeightは変数のため任意の名前をつける
$('#loginTitle').css('top',WindowHeight2+'px');
}
});



$(document).ready(function(){
if ($(window).width() > 773) {//ウインドウサイズが736以上ならば
var WindowHeight3 = $(window).height()*0.17; //WindowHeightは変数のため任意の名前をつける
$('#loginContainer').css('top',WindowHeight3+'px');
}
});



/* 画像サイズ */
$(function() {
  setSize();
  //リサイズしたら実行
  $(window).resize(function(){
     setSize();
  });
});
function setSize() {
  //画像サイズ指定
  var imgW = 1000;
  var imgH = 666;
  //ウィンドウサイズ取得
  var winW = $(window).width();
  var winH = $(window).height();
  
  var scaleW = winW / imgW;
  var scaleH = winH / imgH;
  var fixScale = Math.max(scaleW, scaleH);
  
  var setW = imgW * fixScale;
  var setH = imgH * fixScale;

  var moveX = Math.floor((winW - setW) / 2);
  var moveY = Math.floor((winH - setH) / 2);

  $('#loginBg').css({
    'width': setW,
    'height': setH,
    'left' : moveX,
    'top' : moveY
  });
}




/* リサイズするとリロード */

if(!navigator.userAgent.match(/(iPhone|Android|iPad)/)){
window.onresize = rebuild;
function rebuild(){ location.reload();}
}
</script>
<!-- ログイン画面js -->
<?php Fuel::load(APPPATH.'/views/google_tag_head.php') ?>
</head>
<body id="home" class="drawer drawer--right loginBg">
<?php Fuel::load(APPPATH.'/views/google_tag_body.php') ?>
<?php echo isset($content) ? $content : ""; ?>
<footer>
  <ul>
    <li><a href="https://www.infic-c.net/LASHIC/index.php">運営者からのお知らせ</a></li>
    <li><a href="/page/terms">利用規約</a></li>
    <li><a href="http://www.infic.net/" target="_blank">運営会社</a></li>
    <li><a href="/page/privacy">プライバシーポリシー</a></li>
    <li><a href="/page/help">Q&amp;A</a></li>
    <li><a href="/contact">お問い合わせ</a></li>
  </ul>
  <p><span class="ftr_copyrights">&copy;</span> LASHIC. All Rights Reserved.</p>
</footer>
<p id="page-top"><a href="#home"><img src="/images/common/btn_pagetop.png" width="59" height="59" alt=""/></a></p>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script> 
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
</body>
</html>
