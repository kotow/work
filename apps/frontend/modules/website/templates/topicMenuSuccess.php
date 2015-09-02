<?php /* if($pages):?>
<div class="one-third column">
    <div class="indent-top4 indent-left1">
        <h1><?php echo $title?></h1>
    </div>
</div>
<div class="two-thirds column">
    <nav>
        <ul class="menu-page">
<?php foreach ($pages as $p):
	$current = false;
	if(Document::getStatus($p->getId()) != UtilsHelper::STATUS_ACTIVE) continue;
	$page = Document::getDocumentByCulture($p, null, true);
	if(!$page) continue;
	if($sf_params->get('pageref') == $page->getId()) $current = true;
?>
				<li>
					<a <?php if($current):?>class="selected"<?php endif;?> title="<?php echo $page->getLabel();?>" href="<?php echo $page->getHref();?>" style="outline: medium none;">
						<?php echo $page->getLabel();?>
					</a>
				</li>
<?php endforeach;?>
        </ul>
    </nav>
</div>
<br class="clear">
<?php endif; */ ?>

<div class="one-third column">
<div class="indent-top4 indent-left1">
<h1><?php echo $title; ?></h1>
</div>
</div>
<br class="clear">