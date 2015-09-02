<div id="otherProjects" class="sixteen columns">
    <div class="indent-left1 indent-right1 indent-top2">
        <h3>Други Проекти</h3>
    </div>
	<div style="height: 272px;" id="projectsList" class="indent-top1">

<?php
	$ind = 0; $classArry = array(0=>'alpha', 1=>'',2=>'','3'=>'omega');
	foreach ($pages as $p):
	$href = $p->getHref();
?>
    	<div class="four columns <?php echo $classArry[$ind];?>">
    		<div class="portfolio-item">
    			<div class="thumb">
    				<a href="<?php echo $href; ?>">
    					<img alt="" src="/media/display/id/<?php echo $p->getImage(); ?>">
    					<img alt="" src="/media/display/id/<?php echo $p->getImage2(); ?>">
					</a>
				</div>
				<p class="text">
					<a href="<?php echo $href; ?>"><?php echo $p->getLabel(); ?></a>
				</p>
				<p class="more"><a href="<?php echo $href; ?>">виж повече</a></p>
			</div>
		</div>

<?php $ind++; if ($ind > 3) $ind = 0; ?>
<?php endforeach; ?>
	</div>

    <br class="clear">
    <div class="page-bar">
        <a id="pageBarLeft" class="arrow left" href="#"></a>
        <a id="pageBarRight" class="arrow right" href="#"></a>
    </div>
</div>
<br class="clear">
