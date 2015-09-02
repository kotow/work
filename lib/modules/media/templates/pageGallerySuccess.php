<?php if ($images):?>
<div class="image_thumbs">
    <h3><?php echo $galleryLabel; ?></h3>
	<ul>
		<?php foreach ($images as $image): ?>
    	<li>
	    	<a rel="example_group" href="<?php echo $image->getRelativeUrl(); ?>">
	    		<?php echo Media::displayThumb($image->getId(), 126, 92, false); ?>
	    	</a>
    	</li>
    	<?php endforeach; ?>
    </ul>
	<div class="clear"></div>
</div>
<?php endif; ?>