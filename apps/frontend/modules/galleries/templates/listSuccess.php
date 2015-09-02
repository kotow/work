<ul class="galleries">
<?php
//	$count = $pager->getNbResults();
	foreach ($pager->getResults() as $g):
	$url = UtilsHelper::cleanURL($g);
/*	if ($img = Document::getDocumentInstance($g->getImage()))
	{
		$alt = $img->getDescription();
	}
	else
	{
		$alt = '#';
	}*/
?>
	<li>				
		<a href="<?=$url;?>">
			<span class="imghover_gallery"></span>
			<img src="/media/display/thumb/big/id/<?php echo $g->getImage(); ?>" alt="" />
		</a>
		<p align="center"><?php echo $g->getLabel(); ?></p>
	</li>
<?php endforeach; ?>
</ul>