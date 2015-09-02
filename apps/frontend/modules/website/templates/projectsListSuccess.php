<div class="sixteen columns indent-top2">
<?php
	$i=0; foreach ($projects as $p):
	if (Document::hasTag($p, "website_page_index")) continue;
	$page = Document::getDocumentByCulture($p, null, true);
	$url = $page->getHref();
?>
		<div class="four columns <?php if($i%4==0) echo 'alpha'; if($i%4==3) echo 'omega'; ?>">
		    <div class="portfolio-item">
		        <div class="thumb">
		            <a href="<?php echo $url?>">
						<img src="/media/display/thumb/thumbs/id/<?php echo $page->getImage();?>" alt="" style="margin-top: 0px;">
						<img src="/media/display/thumb/thumbs/id/<?php echo $page->getImage2();?>" alt="">
		            </a>
		        </div>
		        <p class="text"><a href="<?php echo $url?>"><?php echo $page->getLabel()?></a></p>
		        <p class="more"><a href="<?php echo $url?>">read more</a></p>
		    </div>
		</div>
	<?php $i++; endforeach;?>
</div>
<br class="clear">