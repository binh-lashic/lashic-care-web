<?php
return array(
	'_root_'  => 'page/lp',  // The default route
	'_404_'   => 'page/404',    // The main 404 route
	'admin' => 'admin/sessions/index',
	'admin/login' => 'admin/sessions/login',
	'admin/logout' => 'admin/sessions/logout',
	'admin/register' => 'admin/account/create',
	'admin/account' => 'admin/account/register',
	'admin/edit' => 'admin/account/edit',
	'admin/update' => 'admin/account/update',
	'admin/delete' => 'admin/account/delete',
	'contents/lashic' => 'page/lashic',
	'contents/infic' => 'page/infic',
	'contents/info' => 'page/news',
	'contents/kiyaku' => 'page/terms',
	'contents/privacy' => 'page/privacy',
	's/:affiliate' => 'shopping',
	'lp1'  => 'page/lp1',
	'lp2'  => 'page/lp2',
	'lp3'  => 'page/lp3',
);
