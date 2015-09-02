<?php
	echo MenuHelper::get_menu_by_tag("website_menu_main",
	array(
		'depth' => 1,
		'mainMasterClass' => 'menu-top',
		'currentAClass' => 'selected',
		'lastItemClass' => 'last'
		));
?>