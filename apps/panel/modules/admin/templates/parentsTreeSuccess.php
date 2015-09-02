<?php if (isset($tree)): ?>
<?php $nb = count($tree); if($nb): ?>
<div id="subnav-con"> 
	<div id="sub-nav">  
		<?php 
			$i = 1;
			echo "<ul class='clearfix'>";
			foreach ($tree as $item)
			{
				if (empty($item))
					continue;
				$lmn = strtolower($moduleName);

				$class = get_class($item);
				if ($lmn != 'labels' && $lmn != 'settings')
					$id = $item->getId();

				$check = isset($module_rights[$class]) ? $module_rights[$class] : '';
//				if ((!Document::hasChildren($id) || Document::hasI18nChildrenOnly($id)) && $lmn != 'labels' && $lmn != 'settings')
				if ( $lmn != 'labels' && $lmn != 'settings' && empty($check) )
				{
					$href = "";
				}
				elseif ($lmn == 'labels')
				{
					if($item == 'labels') 
						$href = "href='/panel/?m=labels'";
					else
						$href = "";
				}
				elseif ($lmn == 'settings')
				{
					if($item == 'settings') 
						$href = "href='/panel/?m=settings'";
					else
						$href = "";
				}
				else
				{
					$href = "href='/panel/?m=".$lmn."&p=".$id."'";
				}
				
				if ($i == $nb)
				{
					echo "<li><a class='active' $href>";
				}
				else
				{
					echo "<li><a $href>";
				}
				if ($lmn != 'labels' && $lmn != 'settings')
				{
					$label = $item->getlabel();
					$label == "Website" ? $label = "Pages" : '';
				}
				else
				{
					$label = $item;
					if ($i == 1)
						$label = ucfirst($label);
				}

				echo $label;
				/*if ($i == $nb)
				{
					if (substr($class, -4) == "I18n")
					{
						echo " ( ".substr($class, 0, -4)." ".$item->getCulture()." )";
					}
					else 
					{
						echo " ( ".$class." )";
					}
				}*/
				echo "</a></li>";
				$i++;
			}
			echo "</ul>";
		?>
		<div class="clear"></div>
	</div>
</div>
<?php endif;?>
<?php endif;?>