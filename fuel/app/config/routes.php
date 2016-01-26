<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'admin(/:id)?' => array('admin/page', 'name' => 'index'),
);
