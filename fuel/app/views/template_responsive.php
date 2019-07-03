<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>LASHIC ラシク - <?php if(!empty($title)) { echo $title; } ?></title>
<meta name="keywords" content="ラシク,見守り">
<meta name="description" content="ラシクの管理画面です。">
<meta name="robots" content="all">
<meta property="og:type" content="website" >
<meta property="og:url" content="" >
<meta property="og:locale" content="ja_JP" >
<meta property="og:image" content="/images/common/ogp.jpg" >
<meta property="og:site_name" content="LASHIC（ラシク）　管理ページ" >
<meta property="og:description" content="LASHIC（ラシク）は高齢者の”自立”をささえ、”あんしん”を共有します。" >
<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" href="/apple-touch-icon-precomposed.png">

<link href="/css/reset.css" type="text/css" rel="stylesheet">
<link href="/css/common.css" type="text/css" rel="stylesheet">
<link href="/css/drawer.css" type="text/css" rel="stylesheet">
<link href="/css/style.css" type="text/css" rel="stylesheet">
<link href="/css/jquery.mCustomScrollbar.css" type="text/css" rel="stylesheet">
<link href="/css/print.css" type="text/css" rel="stylesheet" media="print" />
<link href="/css/animate.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet" type="text/css">
<link href="/css/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet" type="text/css">
<script src="/js/js.cookie.js"></script>
<?php if(\Util::is_production()) {?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-128509273-2"></script>
  <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-128509273-2');
  </script>
<?php } ?>
</head>
<body id="home" class="drawer drawer--right">
<?php echo isset($header) ? $header : ""; ?>
<?php echo isset($content) ? $content : ""; ?>
<?php echo isset($sidebar) ? $sidebar : ""; ?>
  </div>
</main>
<footer>
  <ul>
    <li><a href="https://www.infic-c.net/LASHIC/index.php"><?php echo __('template.news'); ?></a></li>
    <li><a href="/page/terms"><?php echo __('template.terms'); ?></a></li>
    <li><a href="http://www.infic.net/" target="_blank"><?php echo __('template.company'); ?></a></li>
    <li><a href="/page/privacy"><?php echo __('template.privacy'); ?></a></li>
    <li><a href="/page/help"><?php echo __('template.help'); ?></a></li>
    <li><a href="/contact"><?php echo __('template.contact'); ?></a></li>
  </ul>
  <p><span class="ftr_copyrights">&copy;</span> LASHIC. All Rights Reserved.</p>
</footer>
<p id="page-top"><a href="#home"><img src="/images/common/btn_pagetop.png" width="59" height="59" alt=""/></a></p>


<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script>
<script src="/js/jquery.darktooltip.min.js" charset="utf-8"></script>
<!-- 円グラフ -->
<script src="/js/jquery.circliful.js"></script>
<script type="text/javascript" src="/js/jquery.fancybox.pack.js"></script>
<script>
$(document).ready(function() {
    $(".fancybox").fancybox();
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