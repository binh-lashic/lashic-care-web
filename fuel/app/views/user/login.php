<img src="/images/login/login.jpg" width="1000" height="683" id="loginBg" alt=""/>

<header class="drawer-navbar" role="banner">
	<div class="drawer-container">
		<div class="drawer-navbar-header"> <a class="logo" href="./index.html"><img src="/images/common/logo.png" width="222" height="52" alt=""/></a></div>
	</div>
</header>

<!-- content -->
<main role="main" class="clearBoth">
	<form class="form-horizontal" id="login" method="post" name="login" action="/user/login">
	
	<!-- content start -->
	<div id="loginTop">
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
				<a href="regist/index.html" class="btn_redRadius20 mgt10">新規登録する</a>
			</div>
		</div>
	</div>
	</form>
	<!-- /content end --> 
</main>
<footer>
	<p><a href="#">運営者からのお知らせ</a>　　<a href="#">利用規約</a>　　<a href="#">運営会社</a>　　<a href="#">プライバシーポリシー</a>　　<a href="#">お問い合わせ</a></p>
	<p><span class="ftr_copyrights">&copy;</span> Care Eye. All Rights Reserved.</p>
</footer>
<p id="page-top"><a href="#home"><img src="images/common/btn_pagetop.png" width="59" height="59" alt=""/></a></p>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.1.3/iscroll.min.js"></script> 
<script src="https://cdn.rawgit.com/ungki/bootstrap.dropdown/3.3.5/dropdown.min.js"></script> 
<script src="js/drawer.min.js" charset="utf-8"></script> 
<script src="js/jquery.darktooltip.min.js" charset="utf-8"></script> 
<!-- 円グラフ --> 
<script src="js/jquery.circliful.min.js"></script> 
<script>
$(document).ready(function(){
    $('.myStat').circliful();
});
</script> 
<!-- /円グラフ --> 
<script src="js/jquery.tile.js" type="text/javascript"></script> 
<script src="js/content.js" type="text/javascript"></script>
