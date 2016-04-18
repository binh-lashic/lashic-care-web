<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header">
<?php
if(isset($user)) {
?>
			<a class="logo" href="/user"><img src="/images/common/logo.png" width="222" height="52" alt=""/></a>
<?php
} else {
?>
			<a class="logo" href="/"><img src="/images/common/logo.png" width="222" height="52" alt=""/></a>
<?php
}
?>
		</div>
		<nav class="drawer-nav drawer-nav-userMenu" role="navigation">
				<button type="button" class="drawer-toggle drawer-hamburger">
		          <span class="sr-only">toggle navigation</span>
		          <span class="drawer-hamburger-icon"></span>
		        </button>
		        <ul class="drawer-menu drawer-menu--right">
<?php
if(isset($user)) {
?>
				<li class="drawer-dropdown nav_user"> <a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $user['name']; ?>さん <span class="drawer-caret"></span> </a>
					<ul class="drawer-dropdown-menu">
<?php
foreach($clients as $_client) {
?>
						<li class="nav_userList"><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="drawer-dropdown-menu-item"><?php echo $_client['name']; ?>さん</a></li>
<?php
}
?>
						<li class="nav_user-admin"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ユーザー管理</a></li>
						<li class="nav_userListRegist"><a href="#attention_01" rel="shadowbox[cont]" class="btn_darkBlue">ユーザーを追加する</a></li>
					</ul>
				</li>
				<li class="drawer-dropdown nav_mainMenu">
					<a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
					  メニュー <span class="drawer-caret"></span>
					</a>
					<ul class="drawer-dropdown-menu">
						<li class="nav_mypage"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">マイページ</a></li>
						<li class="nav_set"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">グラフ設定変更</a></li>
						<li class="nav_help"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ヘルプ</a></li>
						<li class="nav_logout"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ログアウト</a></li>
					</ul>
         		 </li>
<?php	
}
?>
			</ul>
		</nav>
	</div>
</header>
<!-- blue area -->
<div class="hdr_bg">
	<div class="content clearfix">
		<!-- ユーザー名 -->
		<div class="user_select">
		<?php
if(isset($client['name'])) {
?>
			<div class="hdr_select_text"><p><?php echo $client['name']; ?><span class="com_userSmall">さん</span></p></div>
<?php
}
?>

		</div>
		<!-- /ユーザー名 --> 
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
<!-- content -->
<main role="main" class="clearBoth">
	<div class="clearfix content"> 

<?php
if(!empty($this->data['header_alerts'])) {
?>
		<!-- お知らせ -->
		<div class="com_news">
			<dl class="clearfix">
				<dt class="com_news_tile"><img src="/images/common/hdr_news_megaphone.png" alt="icon"/><br>
					お知らせ</dt>
				<dd class="com_news_tile"> <a href="/user/report" class="com_news_link"> <span class="com_news_text"><?php echo $this->data['header_alerts'][0]['description']; ?><br>
					<span class="small">その他未対応事項（<?php echo count($this->data['header_alerts']); ?>件）</span> </span> </a> </dd>
			</dl>
		</div>
		<!-- /お知らせ --> 
<?php
}
?>
	</div>
	<div class="clearfix content"> 
