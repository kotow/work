<h2 class="box-heading"><span>Our Tours</span></h2>
<div class="clear"></div>
<ul id="services">
	    		<?php $i=0; foreach ($tours as $t):
	    		if(Document::getStatus($t->getId()) != UtilsHelper::STATUS_ACTIVE) continue;
	    		$tour = Document::getDocumentByCulture($t, null, true);
	    		if($i%4==0) echo "<li><ul>";
	    		?>
					<li>
						<a href="<?php echo $tour->getHref();?>" title="<?php echo $tour->getLabel();?>">
						<img src="/media/display/thumb/big/id/<?php echo $tour->getImage();?>"/></a>
						<h3><a href="<?php echo $tour->getHref();?>" title="<?php echo $tour->getLabel();?>"><?php echo $tour->getLabel();?></a></h3>
					    <div class="button"><a class="button bt-big" href="<?php echo $tour->getHref();?>" title="<?php echo $tour->getLabel();?>">Read More and Book</a></div>
					</li>
				<?php 
				$i++; 
				if($i%4==0) echo "</ul></li>";
				endforeach;?>
</ul>        
<div class="clear"></div>
<script type="text/javascript">
$(function(){
  $('#services').bxSlider({
    infiniteLoop: false,
    hideControlOnEnd: false,
	prevImage: '/images/prev.png',
	nextImage: '/images/next.png'
  });
});
</script>