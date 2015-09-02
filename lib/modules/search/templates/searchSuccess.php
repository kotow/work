
<?php if($error):?><strong class="red"><?php echo $error?></strong><?php endif?>
<?php if($pager && $count > 0):?>
<br>	
<h1>Results (<?php echo $count?>)</h1>
	<ul style="margin-left:30px">
	<?php foreach($pager->getResults() as $doc):?>
	
		<li>
			<a href="detail_<?php echo $doc->did?>.html"><?php echo $doc->Label?></a><br>
		</li>
	<?php endforeach;?>
	</ul>
	<div class="paging">
		<?php echo $paging; ?>
	</div>
<?php elseif($sf_params->get("submitted")):?>
	<div class="no_info">No results found.</div>
<?php endif;?>