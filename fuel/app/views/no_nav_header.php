<?php include 'i18n.php'?>
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
