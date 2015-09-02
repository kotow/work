<div class="box accentbox">
	<h2 class="box-heading"><span><?php echo UtilsHelper::Localize("website.frontend.News_menu_title")?></span></h2>
	<div class="clear"></div>
	<ul class="attractions-list">
	    <?php foreach ($months as $month):?>
			<li>
				<a href="<?php echo "news_".$monthsArr[$month]."_".$currentYear."_".$month?>.html" title="#" <?php if($currentMonth == $month):?>class="active"<?php endif;?>>
					<?php echo $monthsArr[$month]." ".$currentYear?>
				</a>
			</li>
		<?php endforeach;?>
		<?php if($pastYears):?>
			<li>
				<a href="news_archive.html" title="#" <?php if($currentMonth == 'archive'):?>class="active"<?php endif;?>>
					Archive
				</a>
			</li>
		<?php endif;?>
	</ul>
</div>