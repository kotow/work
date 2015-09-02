<?php foreach ($pages as $p):
$page = Document::getDocumentByCulture($p, null, true);
if(!$page) continue;
$img = $page->getImage();
$url = $page->getHref();
$pic = Document::getDocumentInstance($img);
if($pic) $desc = $pic->getDescription();
?>    
	<div class="grid_5">
		<h3 class="serif"><?php echo $page->getLabel()?></h3>
	    <p><a href="<?php echo $url?>"><img src="/media/display/thumb/230/id/<?php echo $img?>" width="190" alt="<?php echo $desc?>"/></a></p>
	    <p><?php echo nl2br($desc)?></p>
	    <p><a href="<?php echo $url?>" class="button radius">Read More</a></p>         
	</div>
<?php endforeach;?>
<div class="clear"></div>