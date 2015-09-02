<?php if($topics): ?>
<div class="two-thirds column">
    <div class="indent-top4 indent-left1">
        <h1><?php echo $title; ?></h1>
    </div>
</div>
<div class="one-third column">
    <nav>
        <ul class="menu-page">
<?php //var_dump($pages);
	foreach ($topics as $t):
		$topicId = $t->getId();
		$current = false;
		if (Document::getStatus($topicId) != UtilsHelper::STATUS_ACTIVE) continue;
//		if (Document::hasTag($p, 'website_page_index')) continue;
		$page = $t->getIndexPage();
//		$page = Document::getDocumentByCulture($p, null, true);
		if (!$page) continue;
		if ($sf_params->get('pageref') == $page->getId()) $current = true;
		if (in_array($sf_params->get('pageref'), $pages[$topicId])) $current = true;
?>
			<li>
				<a <?php if($current): ?>class="selected"<?php endif; ?> title="<?php echo $page->getLabel(); ?>" href="<?php echo $page->getHref(); ?>" style="outline: medium none;">
					<?php echo $page->getLabel();?>
				</a>
			</li>
<?php endforeach;?>
        </ul>
    </nav>
</div>
<br class="clear">
<?php endif;?>
