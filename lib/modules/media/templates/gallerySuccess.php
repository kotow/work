<?php $lang = $sf_user->getCulture() ?>
<?php use_helper('Pager') ?>

<?php if($pager): ?>
<div class="pictures_galery">
	<h1 ><?php echo UtilsHelper::Localize('media.frontend.Gallery-Label', $lang); ?></h1>

	<?php 
	$i = 0; 
	$y = 0; 
	foreach ($pager->getResults() as $relation): 
	$pic = Document::getDocumentInstance($relation->getId2());
	?>

	<?php if($y == 0):?>
		<div class="listPict">
	<?php 
	$d = false;
	endif;
	?>

	<div class="<?php if($y == 0){echo 'Pict1';}else{ echo 'Pict2';}?> ">
		<div class="borderPict" style="float:left; margin:2px;">
			<a href="<?php echo $pic->getRelativeUrl()?>" rel="lightbox" title="<?php echo $pic->getDescription()?>">   
			<img border="0" src="<?php echo $pic->getRelativeDirUrl()."thumbs/".$pic->getFilename()?>"/>
			</a>
		</div>
		<div class="namePict">
			<?php echo strtoupper($pic->getDescription())?>
		</div>
	</div>
	
	<?php if($y == 3):?>
		</div>
		
	<?php 
	$d = true;
	endif;
	?>
	
	<?php
	$i++;
	if($i%4 == 0)
	{
		$y = 0;
	}
	else
	{
		$y++;
	}; 
	endforeach; 
	?>
	
	<?php if(!$d):?>
		</div>
	<?php
	$d = true;
	endif;
	?>
	<div style="clear:both";>
	<div class="galerry_roll">
		<div style="float:left;">
			<?php if ($pager->getFirstPage() != $pager->getPage()):?>
				&laquo; <a href="?page=<?php echo $pager->getPreviousPage()?>" class="prev"><?php echo UtilsHelper::Localize('media.frontend.gallery-previous', $lang); ?></a>
			<?php endif;?>
		</div>
		
		<div class="numberBox">
		<?php
		$pages = ceil($pager->getNbResults()/$pager->getMaxPerPage());
		for($p=1; $p <= $pages ; $p++)
		{
			if($p == $pager->getPage()) 
				echo "<b style='color:#970000'> ".$p." </b>";
			else
				echo "<a href='?page=".$p."'>".$p."</a>";
			if($p != $pager->getLastPage())
				echo "|";
		}
		?>
		</div>
		<div style="float:right;">
			<?php if ($pager->getLastPage() != $pager->getPage()):?>
				<a href="?page=<?php echo $pager->getNextPage()?>" class="next"><?php echo UtilsHelper::Localize('media.frontend.gallery-next', $lang); ?></a> &raquo;
			<?php endif;?>
		</div>
	</div>
</div>

<?php else:?>
	<?php echo UtilsHelper::Localize('media.frontend.Gallery-no-tag-warn', $lang); ?>
	"<?php echo $tag; ?>" !
<?php endif;?>