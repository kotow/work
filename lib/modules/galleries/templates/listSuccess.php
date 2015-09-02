<div class="box_700_inter">
<h2>Gallery</h2>

<?php
$count = $pager->getNbResults();
foreach ($pager->getResults() as $g):
$url = UtilsHelper::cleanURL($g);
?>

<h3><a href="<?php echo $url; ?>"><?php echo $g->getLabel(); ?></a></h3>
<?php
$images = Document::getChildrenOf($g->getId(), 'Media', false);
$cnt = count($images);
?>
<?php if ($images[0]): $img = $images[0]; ?>
<a href="<?php echo $url; ?>"><img class="gal_b" src="/media/display/thumb/325/id/<?php echo $img; ?>"></a>
<?php endif; ?>
<?php if ($images[1]): $img = $images[1]; ?>
<a href="<?php echo $url; ?>"><img class="gal_m1" src="/media/display/thumb/158/id/<?php echo $img; ?>"></a>
<?php endif; ?>
<?php if ($images[2]): $img = $images[2]; ?>
<a href="<?php echo $url; ?>"><img class="gal_m2" src="/media/display/thumb/158/id/<?php echo $img; ?>"></a>
<?php endif; ?>

<div class="gal_t">
Photos: <strong><?php echo $cnt; ?></strong><br>
Seen: <strong><?php echo intval($g->getRds()); ?> times</strong><br>
<span>Created <?php echo UtilsHelper::Date($g->getCreatedAt(), "d.m.Y")?></span><br>
<a href="<?php echo $url; ?>"><strong>View gallery</strong></a>
</div>

<div class="clearfix"></div>
<br/>
<?php endforeach; ?>

<div class="pagination_news">
<?php if ($count > 10): ?>Page: <?php echo $paging; ?><?php endif; ?>
</div>

</div>