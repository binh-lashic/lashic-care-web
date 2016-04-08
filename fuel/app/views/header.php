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
			<button type="button" class="drawer-toggle drawer-hamburger"> <span class="sr-only">toggle navigation</span> <span class="drawer-hamburger-icon"></span> </button>
		</div>
		<nav class="drawer-nav" role="navigation">
			<ul class="drawer-menu drawer-menu--right">
<?php
if(isset($user)) {
?>
				<li class="drawer-dropdown hdr_icon_user"> <a class="drawer-menu-item" data-target="#" href="#" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $user['name']; ?>さん <span class="drawer-caret"></span> </a>
					<ul class="drawer-dropdown-menu">
						<li class="nav_mypage"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">マイページ</a></li>
						<li class="nav_user"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ユーザー登録・削除</a></li>
						<li class="nav_set"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">グラフ設定変更</a></li>
						<li class="nav_help"><a href="#attention_01" rel="shadowbox[cont]" class="drawer-dropdown-menu-item">ヘルプ</a></li>
						<li class="nav_logout"><a href="/user/logout" class="drawer-dropdown-menu-item">ログアウト</a></li>
					</ul>
				</li>
<?php	
}
?>
			</ul>
		</nav>
	</div>
	
	<!-- blue area -->
	<div class="hdr_bg">
		<div class="content clearfix">
			<div class="user_select clearfix">
				<div class="hdr_select_text">ユーザー選択</div>
				<select>
<?php
if(!empty($clients)) {
	foreach($clients as $client) {
?>
					<option value=""><?php echo $client['name']; ?>さん</option>
<?php
	}
}
?>
				</select>
			</div>
			<div id="content_nav">
				<nav>
					<ul>
						<li class="nav_on"><a href="/user/" class="nav_graph"><span></span>ユーザーの様子</a></li>
						<li><a href="/user/report" class="nav_report"><span></span>確認・報告</a></li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	<!-- /blue area end --> 
</header>
<!-- content -->
<main role="main" class="clearBoth">
	<div class="clearfix content"> 
<?php
if(isset($client['name'])) {
?>
		<!-- ユーザー名 -->
		<div class="com_usrName">
			<p><?php echo $client['name']; ?><span class="com_userSmall">さん</span></p>
		</div>
		<!-- /ユーザー名 --> 
<?php
}
?>
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