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
<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header"> <a class="logo" href="./index.html"><img src="/images/common/logo.png" width="222" height="52" alt=""/></a>
			<button type="button" class="drawer-toggle drawer-hamburger"> <span class="sr-only">toggle navigation</span> <span class="drawer-hamburger-icon"></span> </button>
		</div>
		<nav class="drawer-nav" role="navigation">
			<ul class="drawer-menu drawer-menu--right">
				<li class="drawer-dropdown hdr_icon_user"> <a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"> 服部伴之さん <span class="drawer-caret"></span> </a>
					<ul class="drawer-dropdown-menu">
						<li class="nav_mypage"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">マイページ</a></li>
						<li class="nav_user"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ユーザー登録・削除</a></li>
						<li class="nav_set"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">グラフ設定変更</a></li>
						<li class="nav_help"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ヘルプ</a></li>
						<li class="nav_logout"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ログアウト</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
	
	<!-- blue area -->
	<div class="hdr_bg">
		<div class="content clearfix">
			<div class="user_select clearfix">
				<div class="hdr_select_text">ユーザー選択</div>
				<select>
					<option value="">インフィックさん</option>
					<option value="">選択肢01</option>
					<option value="">選択肢02</option>
					<option value="">選択肢03</option>
					<option value="">選択肢04</option>
					<option value="">選択肢05</option>
				</select>
			</div>
			<div id="content_nav">
				<nav>
					<ul>
						<li class="nav_on"><a href="index.html" class="nav_graph"><span></span>ユーザーの様子</a></li>
						<li><a href="report/index.html" class="nav_report"><span></span>確認・報告</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<!-- /blue area end --> 
</header>

<!-- content -->
<?php echo $content; ?>
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
