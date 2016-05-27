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
				<li class="drawer-dropdown nav_user"> <a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false">ユーザー選択<span class="drawer-caret"></span> </a>
					<div class="drawer-dropdown-menu mainMenu">
						<div id="mainMenu">
							<ul>
<?php
if(!empty($clients)) {
	foreach($clients as $_client) {
?>
								<li class="nav_userList"><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="drawer-dropdown-menu-item <?php if($client['id'] == $_client['id']) { echo "nowStay"; } ?>"><?php echo $_client['name']; ?>さん</a></li>
<?php
	}
}
?>
								<li class="nav_user-admin"><a href="/user/list" class="drawer-dropdown-menu-item">ユーザー管理</a></li>
							</ul>
						</div>
					</div>
				</li>
				<li class="drawer-dropdown nav_mainMenu">
					<a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
					  メニュー <span class="drawer-caret"></span>
					</a>
					<ul class="drawer-dropdown-menu">
						<li class="nav_mypage"><a href="/user/account" class="drawer-dropdown-menu-item">マイページ</a></li>
						<li class="nav_set"><a href="/user/setting" class="drawer-dropdown-menu-item">グラフ設定変更</a></li>
						<li class="nav_help"><a href="/page/help" class="drawer-dropdown-menu-item">Q &amp; A</a></li>
						<li class="nav_logout"><a href="/user/logout" class="drawer-dropdown-menu-item">ログアウト</a></li>
					</ul>
         		 </li>
<?php	
}
?>
			</ul>
		</nav>
	</div>
</header>
<?php
if(isset($client['name'])) {
?>
<!-- blue area -->
<div class="hdr_bg">
	<div class="content clearfix">
		<!-- ユーザー名 -->
		<div class="user_select">

			<div class="hdr_select_text"><p><?php echo $client['name']; ?><span class="com_userSmall">さん</span></p></div>


		</div>
		<!-- /ユーザー名 --> 
		<div id="content_nav">
			<nav>
				<ul>
					<li <?php if(Request::active()->action == "index") { echo "class=\"nav_on\""; } ?>><a href="/user/" class="nav_graph"><span></span>ユーザーの様子</a></li>
					<li <?php if(Request::active()->action == "report") { echo "class=\"nav_on\""; } ?>><a href="/user/report" class="nav_report"><span></span>確認・報告</a></li>
				</ul>
			</nav>
		</div>
	</div>
</div>
<!-- /blue area end --> 
<?php
}
?>
<!-- content -->
<main role="main" class="clearBoth">
	<div class="clearfix content"> 

		<!-- お知らせ -->
		<div class="com_news">
		<?php
if(!empty($this->data['header_alerts'])) {
?>
			<dl class="clearfix">
				<dt class="com_news_tile"><img src="/images/common/hdr_news_megaphone.png" alt="icon"/><br>
					お知らせ</dt>
				<dd class="com_news_tile"> <a href="/user/report" class="com_news_link"> <span class="com_news_text"><?php echo $this->data['header_alerts'][0]['description']; ?><br>
					<span class="small">その他未対応事項（<?php echo $this->data['header_alert_count']; ?>件）</span> </span> </a> </dd>
			</dl>
<?php
}
?>
		</div>
		<!-- /お知らせ --> 

	</div>
<?php
if(!empty($breadcrumbs)) {
?>
	<div id="pankuzu">
		<div class="content">
		<a href="/user/">ホーム</a>
<?php
	foreach($breadcrumbs as $breadcrumb) {
?>
		&nbsp;&gt;&nbsp; <?php echo $breadcrumb; ?>
<?php
	}
?>
		</div>
	</div>
<?php
}
?>
	<div class="clearfix content"> 
