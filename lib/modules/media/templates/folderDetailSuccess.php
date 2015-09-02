<?php $lang = $sf_user->getCulture() ?>
<?php foreach ($images as $pic): ?>
<?php if($pic->isImage()): ?>
<?php $id = $pic->getId() ?>
	<?php list($w, $h) = getimagesize($pic->getServerAbsoluteThumbUrl());
	$m = ((100-$h)/2);
	?>
	<div class="thumb_inner">
		<div class="thumb">
			<a href="<?php echo $pic->getRelativeUrl(); ?>" rel="floatbox[x]">
			<img src="<?php echo $pic->getRelativeThumbUrl(); ?>" style="margin-top:<?php echo $m?>px"/>
			</a>
		</div>
	</div>
<?php endif; ?>
<?php endforeach; ?>