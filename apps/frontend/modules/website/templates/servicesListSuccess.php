<div class="indent-top2">
	<div class="content">
		<div style="text-align:center;" class="indent-top1 indent-bottom1">
<?php
	$i=0; foreach ($services as $p):
	if (Document::hasTag($p, "website_page_index")) continue;
	$page = Document::getDocumentByCulture($p, null, true);
	$url = $page->getHref();
?>
		<div class="one-third column omega <?php if($i%3 != 2) echo 'indent-right5'; ?>"  style="height: 350px;">
			<div class="indent-left1 indent-top2 indent-right1">
				<h2><?php echo strip_tags($page->getDescription(), '<br>,<br/>'); ?></h2>
				<a href="<?php echo $url; ?>">
					<img src="/media/display/thumb/thumbs/id/<?php echo $page->getImage(); ?>" alt="">
				</a>
				<?php echo $page->getDescription2(); ?>
				<a style="display: block; text-align: cente;r" class="button" href="<?php echo $url; ?>">See How</a>
			</div>
		</div>
<?php $i++; if ($i%3==0): ?>
		<br class="clear">
<?php endif;?>
<?php endforeach;?>
		</div>
	</div>
	<br class="clear">
</div>
