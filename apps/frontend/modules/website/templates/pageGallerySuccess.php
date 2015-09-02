<?php if($images):?>
	<ul class="galleries">
		<?php foreach ($images as $image):?>
    	<li>
	    	<a rel="external" class="fancybox" href="<?php echo $image->getRelativeUrl()?>" title="<?php echo $image->getDescription()?>">
	    		<span class="imghover_gallery"></span>
	    		<img src="<?php echo $image->getRelativeThumbUrl()?>" title="<?php echo $image->getDescription()?>">
	    	</a>
    	</li>
    	<?php endforeach;?>
    </ul>
<?php endif;?>