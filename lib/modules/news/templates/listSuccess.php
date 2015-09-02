	<?php
	$count = $pager->getNbResults();
	foreach ($pager->getResults() as $n):
	$url = UtilsHelper::cleanURL($n);
	?>
		<div class="news">
			<h2><?php echo $n->getLabel();?></h2>
			<?php echo UtilsHelper::Date($n->getStartDate(),"H:i | d.m.Y"); ?> | Прочетена: <strong><?php echo $n->getRds(); ?> пъти</strong>
			<?php 
				$img = $n->getImage();
				if($image = Document::getDocumentInstance($img)):
				?>
				<img width="528" src="/media/upload/<?php echo $img?>" class="news_im" title="<?php echo $image->getDescription();?>"/>
			<?php endif;?>
			<p><?php echo $n->getShortDescription();?></p>
			<a href="<?php echo $url?>">Още...</a>
		</div>
		<div class="hr"></div>
	<?php endforeach;?>
	
	<div class="clearfix"></div>
	
	<div class="pagination_news">
		<?php if ($count > 15): ?>Page: <?php echo $paging; ?><?php endif; ?>
	</div>

