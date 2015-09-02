<?php 
	$nb = count($tree);
	$i = 1;

	foreach ($tree as $item)
	{
		$class = get_class($item);
		$lcl = strtolower($class);
		$lmn = strtolower($moduleName);

		$id = $item->getId();
		if (Document::hasChildren($id))
		{
			echo "<span id='".$id."' class='".$lmn."_".$lcl."' onclick='parseMainList(null, ".$id.")'>";
		}
		else
		{
			echo "<span id='".$id."' class='".$lmn."_".$lcl."' onclick='editDocument(\"".$class."\", \"".$id."\")'>";
		}
		if ($i == $nb)
		{
			echo "<b>";
		}
		echo $item->getlabel();
		echo "</span>";
		if($i < $nb)
		{
			echo " > ";
		}
		
		if ($i == $nb)
		{
			if (substr($class, -4) == "I18n")
			{
				echo " ( ".substr($class, 0, -4)." ".$item->getCulture()." )";
			}
			else 
			{
				echo " ( ".$class." )";
			}
			echo "</b>";
		}
		$i++;
	}
?>