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
								<li class="nav_userList"><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="drawer-dropdown-menu-item <?php if(isset($client) && $client['id'] == $_client['id']) { echo "nowStay"; } ?>"><?php echo $_client['last_name'].$_client['first_name']; ?>さん</a></li>
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
						<li class="nav_shopping_history"><a href="/user/payment" class="drawer-dropdown-menu-item">購入・支払い履歴</a></li>
						<li class="nav_set"><a href="/user/setting" class="drawer-dropdown-menu-item">アラート通知設定変更</a></li>
						<li class="nav_help"><a href="/page/help" class="drawer-dropdown-menu-item">Q &amp; A</a></li>
						<li class="nav_logout"><a href="/user/logout" class="drawer-dropdown-menu-item">ログアウト</a></li>
					</ul>
         		 </li>
<?php	
}
?>
				<li id="nav_cart" class="drawer-dropdown nav_cart">
					<a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="nav_cart_text">カート</span><span class="nav_number" style="display:none;">1</span></a>
					<div class="drawer-dropdown-menu cartMenu">
					<div id="cartMenu">
						<ul id="cart"></ul>
					</div>
					</div>
				</li>
			</ul>
			<div class="nav_cart_alert">
				<p>削除されました</p>
			</div>
		</nav>

	</div>
</header>

<!-- content -->
<main role="main" class="clearBoth">
<?php
if(!empty($breadcrumbs)) {
?>
	<div id="pankuzu">
		<div class="content">
<?php
if(isset($user)) {
?>
		<a href="/user/">ホーム</a>
<?php
} else {
?>
		<a href="/">ホーム</a>
<?php
}
?>
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
