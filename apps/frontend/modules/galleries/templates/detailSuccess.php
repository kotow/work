<ul class="galleries">
<?php if ($gallery):?>
		<h2><?php echo $gallery->getLabel(); ?></h2>
		<p><?php echo $gallery->getDescription(); ?></p>
		<p>&nbsp;</p>
		<?php
			foreach ($images as $img):
			$pic = Document::getDocumentInstance($img);
		?>
			<li>				
				<a href="/media/upload/<?php echo $img; ?>.jpg" title='<?php echo $pic->getDescription(); ?>' class="fancybox" rel="external">
					<span class="imghover_gallery"></span>
					<img src="/media/display/thumb/thumbs/id/<?php echo $img; ?>" alt="" />
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>