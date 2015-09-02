<!--<h1 id="lead" class="lead serif-italic"><?php echo UtilsHelper::Localize("website.frontend.News-title")?></h1>-->
<?php
$count = $pager->getNbResults();
foreach ($pager->getResults() as $n):
$url = UtilsHelper::cleanURL($n);
?>
	<div class="news" style="float: left; width: 190px;">
		<h3><?php echo $n->getLabel();?></h3>
		<?php echo UtilsHelper::Date($n->getStartDate(),"m.d.Y")?>
		<br />
		<?php echo $n->getShortDescription();?>
		<?php if($n->getImage()!=NULL): ?>
		<br />
		<img src="/media/upload/thumbs/<?php echo $n->getImage();?>" />
		<?php endif; ?>
		<br />
		<a href="<?php echo $url?>" class="button radius">още...</a> 
		<div class="clear"></div>
	</div>
<?php endforeach;?>

<div class="clearfix"></div>

<?
/*
<div class="pagination_news">
	<?php if ($count > 3): ?>Page: <?php echo $paging; ?><?php endif; ?>
</div>
*/
?>