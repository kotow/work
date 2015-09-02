<?php /*
	echo MenuHelper::get_menu_by_tag("website_menu_main",
	array(
		'depth' => 1,
		'mainMasterClass' => 'menu-top',
		'currentAClass' => 'selected',
		'lastItemClass' => 'last'
		));
*/
$pageRef = $sf_params->get('pageref');
$topicId = Document::getParentOf($pageRef, null, false);
?>
<?php if ($sf_user->isAuthenticated()) : ?>
	<ul class="qfMainNavList">
<?php $ind = 0; ?>
<?php foreach ($menuItems as $tId =>$p): ?>
<?php $ind++; ?>
		<li class="qfMNavList0<?php echo $ind; ?> <?php if ($tId == $topicId) echo 'qfMNavListActive'; ?>">
			<a href="<?php echo $p->getHref(); ?>">
				<img src="/images/menu-item0<?php echo $ind; ?>.png" />
				<span><?php echo $p->getNavigationTitle(); ?></span>
			</a>
		</li>
<?php /*
		<li class="qfMNavList02">
			<a href="search-templates.php">
				<img src="/images/menu-item02.png" />
				<span>Search templates</span>
			</a>
		</li>
		<li class="qfMNavList03">
			<a href="import-history.php">
				<img src="/images/menu-item03.png" />
				<span>Browse search reports</span>
			</a>
		</li>
		<li class="qfMNavList04">
			<a href="web-search.php">
				<img src="/images/menu-item04.png" />
				<span>Web search</span>
			</a>
		</li>
		<li class="qfMNavList05">
			<a href="upload-trademark.php">
				<img src="/images/menu-item05.png" />
				<span>Upload</span>
			</a>
		</li>
*/ ?>

<?php endforeach; ?>
	</ul>
<?php else: ?>
	<ul class="qfMainNavList">
		<li class="qfMNavList01 qfMNavListActive">
			<a href="#">
				<img src="/images/menu-item06.png" />
				<span>Login</span>
			</a>
		</li>
	</ul>
<?php endif; ?>
