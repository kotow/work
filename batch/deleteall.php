<?php

function DumpDir($dir)
{
	if (!$dh = @opendir($dir)) return;
	while (false !== (($obj = readdir($dh))))
	{
		$newDir = $dir.'\\'.$obj;
		echo "-->".$newDir."                                                                                                       \r";
	}
}
function DeleteDir($switchArr, $dir, $name, &$p)
{
  
	if (!$dh = @opendir($dir)) return;
	while (false !== (($obj = readdir($dh))))
	{
		if ($obj=='.' || $obj=='..') continue;
		$newDir = $dir.'\\'.$obj;
		if (empty($name) || ($obj == $name))
		{
			if (($switchArr['d'] || $switchArr['a']) && is_dir($newDir))
			{
				if ($switchArr['v'])
					//echo "Removing dir: ".$newDir."                                                                                      \r";
          $p++;
          echo "Competed ".(round($p*3.4))." %                                                                                              \r";
				RemoveDir($newDir, $switchArr['v']);
			}
			elseif (($switchArr['f'] || $switchArr['a']) && is_file($newDir))
			{
				if ($switchArr['v'])
					//echo "Deleting file: ".$newDir."                                                                                      \r";
				  $p++;
          echo "Competed ".(round($p*3.4))." %                                                                                              \r";
        @unlink($newDir);
			}
			else 
			{
//				if ($switchArr['v'])
//					echo "do nothing on: ".$newDir."\n";
				if ($switchArr['r'] && is_dir($newDir))
				{
					if ($switchArr['v'])
						//echo "Processing: ".$newDir."\n";
					DeleteDir($switchArr, $newDir, $name, $p);
				}
			}
		}
		else
		{
			if ($switchArr['r'] && is_dir($newDir))
			{
				if ($switchArr['v'])
					//echo "Processing: ".$newDir."\n";
				DeleteDir($switchArr, $newDir, $name, $p);
			}
		}
	}
}

function RemoveDir($dir, $verbose)
{
	if(!$dh = @opendir($dir))
	{
		if ($verbose)
			echo "can't open $dir                                                                                                    \r";
		return;
	}
	else
	{
		while (false !== (($obj = readdir($dh))))
		{
			if($obj=='.' || $obj=='..') continue;
			$newDir = $dir.'\\'.$obj;
			if (@unlink($newDir))
			{
				if ($verbose)
					echo "file deleted $newDir...                                                                                           \r";
				//$file_deleted++;
			}
			else
			{
				RemoveDir($newDir, $verbose);
			}
		}
	}
	$cmdline = "cmd /c rmdir $dir";
	$WshShell = new COM("WScript.Shell");
	// Make the command window but dont show it.
	$oExec = $WshShell->Run($cmdline, 0, false);
}

$name = null;
if (count($argv) < 3)
{
	echo "\nUsage: ".$argv[0]." <switch> <dir> [name]\n";
	echo " switch:\n";
	echo "	-d = delete dirs\n";
	echo "	-f = delete files\n";
	echo "	-a = delete all\n";
	echo "	-v = verbose\n";
	echo "	-r = recursive\n";
	echo "\n Example: ".$argv[0]." -rdv <dir> <name>\n";
}
else
{
	$switch = $argv[1];
	$switches['a'] = strpos($switch, 'a');
	$switches['d'] = strpos($switch, 'd');
	$switches['f'] = strpos($switch, 'f');
	$switches['r'] = strpos($switch, 'r');
	$switches['v'] = strpos($switch, 'v');
	$dir = $argv[2];
	if (count($argv) > 3)
	{
		$name = $argv[3];
	}
	//var_dump($switches);
	$p = 0;
	DeleteDir($switches, $dir, $name, $p);
}
echo "Competed 100 %                                                                                              \r";
echo "\n\n".$argv[0]." is done.\n"

?>