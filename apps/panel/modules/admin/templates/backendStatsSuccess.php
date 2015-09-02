<div class="stats_content">
	<div class="main">
	<?php switch ($section){
		case "job":
			?>
			<strong>Jobs</strong> | 
	<a href="/admin/index.php/?custom_module=stats&section=house">Housing</a>
			<?php
			break;
		case "house":
			?>
			<a href="/admin/index.php/?custom_module=stats&section=job">Jobs</a> | 
	<strong>Housing</strong>
			<?php
			break;
	}
	?>
	
	<h1><?php echo $section_title ?> Stats</h1>
		<div class="padding">
				<h3>Offers added by feeds & rss</h3>
				<form method="GET" action="" name="statFilter">
				<input type="hidden" value="stats" name="custom_module"/>
				<select name="month" onchange="statFilter.submit();">
				<option value="0">All</option>
					<?php 
					foreach ($months as $k=>$month):
					if ($k==$selected_month) $selected = "selected"; else $selected = "";
					echo '<option value="'.$k.'" '.$selected.'>'.$month.'</option>';
					endforeach;
					?>
				</select>
				
				<select name="year" onchange="statFilter.submit();">
					<?php foreach ($years as $year): 
					if ($year==$selected_year) $selected = "selected"; else $selected = "";
					echo '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
					endforeach;
					?>
				</select>
				
				<input type="submit" value="Show"/>
				&nbsp;&nbsp;
				<a href="/admin/admin/printChart/chart/1/year/<?php echo (int)$selected_year?>/month/<?php echo (int)$selected_month?>/offer_id/<?php echo (int)$offer_id ?>/company_id/<?php echo (int)$company_id ?>/section/<?php echo $section?>" target="_blank">
					<img src="/images/icons/print.png" >
				</a>
				</form>
				<?php echo $offersChart;?>
				
				
				<!--<h3>Offer Views</h3>
				<form method="GET" action="" name="statFilter">
				<input type="hidden" value="stats" name="custom_module"/>
				Offer Id: <input type="text" value="<?php echo $offer_id ?>" name="offer_id"/>
				Company Id: <input type="text" value="<?php echo $company_id ?>" name="company_id"/>
				<select name="month" onchange="statFilter.submit();">
				<option value="0">All</option>
					<?php 
					/*foreach ($months as $k=>$month):
					if ($k==$selected_month) $selected = "selected"; else $selected = "";
					echo '<option value="'.$k.'" '.$selected.'>'.$month.'</option>';
					endforeach;*/
					?>
				</select>
				
				<select name="year">
					<?php /*foreach ($years as $year): 
					if ($year==$selected_year) $selected = "selected"; else $selected = "";
					echo '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
					endforeach;*/
					?>
				</select>
				<input type="submit" value="Show"/>
				&nbsp;&nbsp;
				<a href="/admin/admin/printChart/chart/2/year/<?php echo (int)$selected_year?>/month/<?php echo (int)$selected_month?>/offer_id/<?php echo (int)$offer_id ?>/company_id/<?php echo (int)$company_id ?>/section/<?php echo $section?>" target="_blank">
					<img src="/images/icons/print.png" >
				</a>
				</form>-->
				<?php //echo $offerViewsChart;?>

				
				<h3>Offer Applicants</h3>
				<form method="GET" action="" name="statFilter">
				<input type="hidden" value="stats" name="custom_module"/>
				Offer Id: <input type="text" value="<?php echo $offer_id ?>" name="offer_id"/>
				Company Id: <input type="text" value="<?php echo $company_id ?>" name="company_id"/>
				<select name="month" onchange="statFilter.submit();">
				<option value="0">All</option>
					<?php 
					foreach ($months as $k=>$month):
					if ($k==$selected_month) $selected = "selected"; else $selected = "";
					echo '<option value="'.$k.'" '.$selected.'>'.$month.'</option>';
					endforeach;
					?>
				</select>
				
				<select name="year">
					<?php foreach ($years as $year): 
					if ($year==$selected_year) $selected = "selected"; else $selected = "";
					echo '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
					endforeach;
					?>
				</select>
				<input type="submit" value="Show"/>
				&nbsp;&nbsp;
				<a href="/admin/admin/printChart/chart/3/year/<?php echo (int)$selected_year?>/month/<?php echo (int)$selected_month?>/offer_id/<?php echo (int)$offer_id ?>/company_id/<?php echo (int)$company_id ?>/section/<?php echo $section?>" target="_blank">
					<img src="/images/icons/print.png" >
				</a>
				</form>
				<?php echo $offerApplicantsChart;?>

				<h3>Users</h3>
				Total Users: <?php echo $totalUsers;?>
				<br/>
				<br/>
				<form method="GET" action="" name="usersFilter">
				<input type="hidden" value="stats" name="custom_module"/>
				<select name="month" onchange="usersFilter.submit();">
				<option value="0">All</option>
					<?php 
					foreach ($months as $k=>$month):
					if ($k==$selected_month) $selected = "selected"; else $selected = "";
					echo '<option value="'.$k.'" '.$selected.'>'.$month.'</option>';
					endforeach;
					?>
				</select>
				
				<select name="year" onchange="usersFilter.submit();">
					<?php foreach ($years as $year): 
					if ($year==$selected_year) $selected = "selected"; else $selected = "";
					echo '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
					endforeach;
					?>
				</select>
				<input type="submit" value="Show"/>
				&nbsp;&nbsp;
				<a href="/admin/admin/printChart/chart/4/year/<?php echo (int)$selected_year?>/month/<?php echo (int)$selected_month?>/offer_id/<?php echo (int)$offer_id ?>/company_id/<?php echo (int)$company_id ?>/section/<?php echo $section?>" target="_blank">
					<img src="/images/icons/print.png" >
				</a>
				</form>
				<?php echo $usersChart;?>
				
				<h3>Cv's</h3>
				Total Cv's: <?php echo $totalCvs;?>
				<br/>
				<br/>
				<form method="GET" action="" name="usersFilter">
				<input type="hidden" value="stats" name="custom_module"/>
				<select name="month" onchange="usersFilter.submit();">
				<option value="0">All</option>
					<?php 
					foreach ($months as $k=>$month):
					if ($k==$selected_month) $selected = "selected"; else $selected = "";
					echo '<option value="'.$k.'" '.$selected.'>'.$month.'</option>';
					endforeach;
					?>
				</select>
				
				<select name="year" onchange="usersFilter.submit();">
					<?php foreach ($years as $year): 
					if ($year==$selected_year) $selected = "selected"; else $selected = "";
					echo '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';
					endforeach;
					?>
				</select>
				<input type="submit" value="Show"/>
				&nbsp;&nbsp;
				<a href="/admin/admin/printChart/chart/5/year/<?php echo (int)$selected_year?>/month/<?php echo (int)$selected_month?>/offer_id/<?php echo (int)$offer_id ?>/company_id/<?php echo (int)$company_id ?>/section/<?php echo $section?>" target="_blank">
					<img src="/images/icons/print.png" >
				</a>
				</form>
				<?php echo $cvChart;?>
				
				
		</div>
	</div>
</div>
						
						