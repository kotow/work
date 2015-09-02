<?php if ($gallery):
$url = UtilsHelper::cleanURL($gallery, true);
$label = $gallery->getLabel();
$cnt = count($images);
?>
<div class="box_700_inter">
<h2><?php echo $label; ?></h2>
Photos: <strong><?php echo $cnt; ?></strong> | Seen: <strong><?php echo $gallery->getRds(); ?> times</strong>
<br><br>
<ul class="gallerito">
<?php
$i = 0;
foreach ($images as $img):
$i++;
$class = ($i == 4) ? ' class="last"' : '';
$pic = Document::getDocumentInstance($img);
?>
	<li <?php echo $class; ?>>
		<a href="<?php echo $pic->getRelativeUrl(); ?>" title='<?php echo $pic->getDescription(); ?>' class="galleria">
		<img src="/media/display/thumb/158/id/<?php echo $img; ?>" title='<?php echo $pic->getDescription(); ?>'></a>
	</li>
<?php endforeach; ?>
</ul>

<div class="clearfix"></div>
</div>
<?php endif; ?>