<ul id="top_products">
<?php foreach ($topProducts as $product):?>
	<li>
		<h3><?php echo $product->getLabelI18n()?></h3>
		<span>
			<?php echo Media::displayThumb($product->getImageI18n(), 100, 100);?>
		</span>
		<?php echo $product->getShortDescriptionI18n();?>
	</li>
<?php endforeach;?>
</div>
