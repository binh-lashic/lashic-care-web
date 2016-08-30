<img src="/images/login/login.jpg" width="1000" height="683" id="loginBg" alt="">
<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header"> <a class="logo" href="/"><img src="/images/common/logo.png" width="222" height="52" alt=""/></a></div>
	</div>
</header>

<!-- content -->
<main role="main" class="clearBoth">
	
	<!-- content start -->
	<div id="loginTop">
	<form class="form-horizontal" id="login" method="post" name="login" action="/user/login">
		<div id="loginTitle"><p>高齢者の"自立"をささえ<span class="sp_noWrap">"あんしん"を共有する</span></p></div>
		<div id="loginContainer">
			<div id="loginContainerInner">
<?php
if(isset($error)) {
?>
				<p class="error small mgb10">メールアドレスまたはパスワードが正しくありません</p>
<?php
}
?>
				<dl>
					<dt>メールアドレス</dt>
					<dd><input type="text" class="input_text" name="username"></dd>
					<dt>パスワード</dt>
					<dd><input type="password" class="input_text" name="password"></dd>
				</dl>
				<input type="checkbox" id="password_check">
				<label for="password_check" class="checkbox">ログインを保持する</label>
				<p class="pdt10 center"><a href="/password/" class="link_normal">パスワードをお忘れの方はこちら</a></p>
				<p><a href="javascript:void(0)" onclick="document.login.submit();return false;" class="btn_darkBlue mgt20">ログインする</a></p>
				<p><a href="/register" class="btn_redRadius20 mgt10">新規登録する</a></p>
				<a href="#moreInfoBg" class="moreINfoLink">
					<div class="moreInfoTitle mgt10">CareEyeを知る</div>
					<div  class="center mgt5"><img src="/images/login/moreinfo_arrow.png" width="17" height="17" alt=""/></div>
				</a>
			</div>
		</div>
	</form>
	</div>
	<!-- /content end --> 

	
	<!-- moreInfo -->
	<div id="moreInfo" class="moreInfoContainer loginMoreInfo" >
		<?php echo View::forge('more_info') ?>
	</div>
	<!-- /moreInfo -->
</main>