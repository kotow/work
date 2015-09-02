<div class="right-box no-border">
	<h3 class="right-heading"><span class="cats"><?php echo UtilsHelper::Localize("website.frontend.Products_menu_title"); ?></span></h3>
    <ul class="cat-nav">
    	<?php foreach ($categories as $cat): $id = $cat->getId(); ?>
    	<li>
	    	<a href="<?php echo UtilsHelper::cleanRssURL($cat); ?>" title="" <?php if ($id == $currentId): ?>class="active"<?php endif; ?>>
	    		<?php echo $cat->getLabel(); ?>
	    		<span>(<?php echo $prodNum[$id]; ?>)</span>
	    	</a>
    	</li>
    	<?php endforeach; ?>
    </ul>
    <div class="clear"></div>
</div>