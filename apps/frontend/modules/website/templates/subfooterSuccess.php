<div class="tree-col-l">
	<h4><?php echo UtilsHelper::Localize("website.frontend.Latest-news-subfooter")?></h4>
	<ul class="latest-news">
    	<?php foreach ($news as $n):
		if(Document::getStatus($n->getId()) != UtilsHelper::STATUS_ACTIVE) continue;
		?>
		<li>
			<h5 class="serif-bold"><a href="<?php echo UtilsHelper::cleanURL($n)?>" title="<?php echo $n->getLabel()?>"><?php echo $n->getLabel()?></a></h5>
            <p class="date">Date: <?php echo UtilsHelper::Date($n->getStartDate(),"M. j, Y")?></p>
		</li>
		<?php endforeach;?>
    </ul>
</div>
<div class="tree-col-c">
	<h4>Useful Information</h4>
    <?php
	echo MenuHelper::get_menu_by_tag("website_menu_subfooter",
	array(
		'depth' => 1,
		'mainMasterClass' => 'subf-menu'
		));
	?>
</div>
<div class="tree-col-r">
	<h4><?php echo UtilsHelper::Localize("website.frontend.Contact-us-subfooter")?></h4>
    <p>Mobile: phone</p>
	<p>E-mail: <a href="#">email</a></p>
	<p><a href="contact-us.html">Write us a message</a></p>
<p><a href="#" style="margin-right:5px;"><img src="/images//facebook.png"/></a></p>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function () {
	$('.subf-menu').easyListSplitter({ 
			colNumber: 3
	});
});
</script>