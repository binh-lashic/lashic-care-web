<img src="/images/login/login.jpg" width="1000" height="683" id="loginBg" alt="">
<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header"> <a class="logo" href="./index.html"><img src="/images/common/logo.png" width="222" height="52" alt=""/></a></div>
	</div>
</header>

<!-- content -->
<main role="main" class="clearBoth">
	
	<!-- content start -->
	<div id="loginTop">
	<form class="form-horizontal" id="login" method="post" name="login" action="/user/login">
		<div id="loginTitle"><p>高齢者の"自立"をささえ<br>"あんしん"を共有する</p></div>
		<div id="loginContainer">
			<div id="loginContainerInner">
				<dl>
					<dt>ログインID</dt>
					<dd><input type="text" class="input_text" name="username"></dd>
					<dt>パスワード</dt>
					<dd><input type="password" class="input_text" name="password"></dd>
				</dl>
				<input type="checkbox" id="password_check">
				<label for="password_check" class="checkbox">ログインを保持する</label>
				<a href="javascript:void(0)" onclick="document.login.submit();return false;" class="btn_darkBlue mgt20">ログインする</a>
				<a href="/register" class="btn_redRadius20 mgt10">新規登録する</a>
			</div>
		</div>
	</form>
	</div>
	<!-- /content end --> 
</main>