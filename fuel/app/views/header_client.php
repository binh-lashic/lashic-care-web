<?php include 'i18n.php'?>
<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header">
<?php
if(isset($user)) {
?>
			<a class="logo" href="/user"><img src="/images/common/logo.png" alt=""/></a>
<?php
} else {
?>
			<a class="logo" href="/"><img src="/images/common/logo.png" alt=""/></a>
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
				<li id="nav_user" class="drawer-dropdown nav_user"> <a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo __('header.client.select_user'); ?><span class="drawer-caret"></span> </a>
					<div class="drawer-dropdown-menu mainMenu">
						<div id="mainMenu">
							<ul>
<?php
if(!empty($clients)) {
	foreach($clients as $_client) {
?>
	<li class="nav_userList"><a href="/user/set_client?id=<?php echo $_client['id']; ?>" class="drawer-dropdown-menu-item <?php if(isset($client) && $client['id'] == $_client['id']) { echo "nowStay"; } ?>"><?php echo $_client['last_name'].$_client['first_name']; ?><?php echo __('header.client.honorific_title'); ?></a></li>
<?php
	}
}
?>
								<li class="nav_user-admin"><a href="/user/list" class="drawer-dropdown-menu-item"><?php echo __('header.client.user_management'); ?></a></li>
							</ul>
						</div>
					</div>
				</li>
				<li id="nav_mainMenu" class="drawer-dropdown nav_mainMenu">
					<a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false">
					  <?php echo __('header.client.menu'); ?> <span class="drawer-caret"></span>
					</a>
					<ul class="drawer-dropdown-menu">
						<li class="nav_mypage"><a href="/user/account" class="drawer-dropdown-menu-item"><?php echo __('header.client.my_page'); ?></a></li>
						<li class="nav_shopping_history"><a href="/user/payment" class="drawer-dropdown-menu-item"><?php echo __('header.client.purchase_payment_histories'); ?></a></li>
						<?php if(isset($sensor)) { ?>
							<li class="nav_set"><a href="/user/setting" class="drawer-dropdown-menu-item"><?php echo __('header.client.alert_notification'); ?></a></li>
						<?php } ?>
						<li class="nav_help"><a href="/page/help" class="drawer-dropdown-menu-item"><?php echo __('header.client.q_and_a'); ?></a></li>
						<li class="nav_logout"><a href="/user/logout" class="drawer-dropdown-menu-item"><?php echo __('header.client.logout'); ?></a></li>
					</ul>
         		 </li>
<?php	
}
?>
				<li id="nav_cart" class="drawer-dropdown nav_cart">
					<a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"><span class="nav_cart_text"><?php echo __('header.client.cart'); ?></span><span class="nav_number" style="display:none;">1</span></a>
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
<?php
if(isset($client['id'])) {
?>
<!-- blue area -->
<div class="hdr_bg">
	<div class="content clearfix">
		<!-- ユーザー名 -->
		<div class="user_select">
			<div class="hdr_select_text"><p><?php echo $client['last_name'].$client['first_name']; ?><span class="com_userSmall"><?php echo __('header.client.honorific_title'); ?></span></p></div>
		</div>
		<!-- /ユーザー名 --> 
		<div id="content_nav">
			<nav>
				<ul>
					<li <?php if(Request::active()->action == "index") { echo "class=\"nav_on\""; } ?>><a href="/user/" class="nav_graph"><span></span><?php echo __('header.client.user_state'); ?></a></li>
					<li <?php if(Request::active()->action == "report") { echo "class=\"nav_on\""; } ?>><a href="/user/report" class="nav_report"><span></span><?php echo __('header.client.confirm_report'); ?></a></li>
                                        <li <?php if(Request::active()->action == "monthly") { echo "class=\"nav_on\""; } ?>><a href="/user/monthly" class="nav_monthly"><span></span><?php echo __('header.client.monthly_report'); ?></a></li>
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
					<?php echo __('header.client.notice'); ?></dt>
				<dd class="com_news_tile<?php echo $current_language !== 'ja' ? ' com_news_dd_en' : '' ?>">
					<a href="/user/report" class="com_news_link">
						<span class="com_news_text">
							<?php echo __("alerts.{$header_alerts[0]['type']}.description"); ?><br>
							<span class="small"><?php echo __('header.client.uncorresponding_items', ['count' => $header_alert_count]); ?></span>
						</span>
					</a>
				</dd>
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
