<p class="breadcrumb">
  You are here: 
   <?php
    	$cnt = count($breadcrumb);
    	$index = 0;
    	foreach ($breadcrumb as $item): ?>
	<?php
		if ($item['href'])
			echo '<a href="'.$item['href'].'">'.$item['label'].'</a>';
		else
			echo $item['label'];
		$index++;
		if ($index != $cnt)
			echo ' <img src="'.UtilsHelper::MAIN_SITE_DOMAIN .'images/sm_arrow.gif" alt="" width="10">  ';
	?>
    <?php endforeach;?>
</p>
