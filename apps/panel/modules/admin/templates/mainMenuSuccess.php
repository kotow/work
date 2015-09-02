<?php $module = $sf_params->get("m"); ?>
<div id="header-con"> 
	<!-- HEADER -->
	<div id="header">
		<div id="logo">
			<h1><a href="/panel/" title="DONE.CMS">Done.Cms</a></h1>
		</div>
		<ul id="header-nav">
	  		<li>
<?php
	$cultureArr = Lists::getListitemsForSelect('culture');
	if (count($cultureArr) > 1)
		echo panel_select('sf_culture', $sf_user->getCulture(), $cultureArr, array('labelname' => 'Select language'));
?>
			</li>
			<li>Welcome <a href="#" title="#" class="green"><?php echo $subscriber->getFirstName()." ".$subscriber->getLastName(); ?></a></li>
			<li><a href="/" title="#" target="_blank">Preview site</a></li>
			<li><a href="/panel/user/logout" title="#">Log out</a></li>
		</ul>
		<div class="clear"></div>
		<!-- END HEADER --> 
	</div>
</div>

<div id="nav-con"> 
	<!-- NAV -->
	<div id="nav">
		<ul id="main-nav" class="clearfix">
			<li>
				<a <?php if (empty($module)): ?>class="active"<?php endif; ?> title="Dashboard" href="/panel/">Dashboard</a>
			</li>
			<?php foreach ($userRights as $name => $rights): ?>
			<li>
				<a <?php if ($module==$name): ?>class="active"<?php endif; ?> title="<?php echo $name?>" href="/panel/?m=<?php echo $name?>">
					<?php echo ucfirst($name)?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clear"></div>
	</div>
	<!-- END NAV -->
</div>
