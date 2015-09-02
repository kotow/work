<?php foreach ($pages as $p):
$page = Document::getDocumentByCulture($p, null, true);
if(!$page) continue;
$img = $page->getImage();
$pic = Document::getDocumentInstance($img);
if($pic) $desc = $pic->getDescription();
?>  
	<div class="grid_6">
		<a href="<?php echo $page->getHref()?>" title="<?php echo $desc?>">
			<img src="/media/display/thumb/230/id/<?php echo $img?>" alt="<?php echo $desc?>"/>
		</a>
	</div>
<?php endforeach;?>
<div class="clear"></div>
<div class="close"><a href="javascript:void(0)" title="Close"></a></div>