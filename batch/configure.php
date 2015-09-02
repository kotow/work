<?php

function writeFile($filename, $content = null, $keepData = false)
{
	$keepData ? $mode = "a+" : $mode = "w+";

	if (!$handle = fopen($filename, $mode))
	{
		//echo "Error oppening file '$filename' : ".$handle;
		return false;
	}

	if (fwrite($handle, $content) === FALSE)
	{
		//echo "Error writing file '$filename' : ".$handle;
		return false;
	}

	fclose($handle);
	chmod($filename, 0777);
	return true;
}

// arguments -> projectname, username, pass, database, server
// example:		cms, depotest_test, 1234, depotest_cms, 127.0.0.1
/*
$i = 0;
foreach ($argv as $arg)
{
	echo "argument $i => ".$arg."\n";
	$i++;
}
*/
$argCount = count($argv);
if ($argCount < 5)
{
	echo "\nUsage: ".$argv[0]." project_name db_username db_pass db_name [server]\n".
		" (server = 127.0.0.1 by default)\n";
//	var_dump($argv);
	exit;
}
$arg_project = $argv[1];
$arg_user = $argv[2];
$arg_pass = $argv[3];
$arg_database = $argv[4];
if (count($argv) > 5)
{
	$arg_server = $argv[5];
}
if (!$arg_server)
{
	$arg_server = "127.0.0.1";
}

//========================== "config.php" ==============================
$pwd = getcwd();
$content = "<?php\n".
	"\$sf_symfony_lib_dir  = '".$pwd."/lib/symfony';\n".
	"\$sf_symfony_data_dir = '".$pwd."/lib/symfony/data';\n";
$filename = "config/config.php";
if (!writeFile($filename, $content, false))
{
	exit("Error writing ".$filename."\n");
}
else
{
	echo "Writing $filename successfully\n";
}

//========================== "databases.yml" ==============================

$content =
	"all:\n".
	"  propel:\n".
	"    class:      sfPropelDatabase\n".
	"    param:\n".
	"      phptype:  mysql\n".
	"      host:     ".$arg_server."\n".
	"      database: ".$arg_database."\n".
	"      username: ".$arg_user."\n";
if ($arg_pass)
{
	$content .=	"      password: '".$arg_pass."'\n";
}
$content .=
	"      encoding: utf8\n".
	"  ".$arg_database.":\n".
	"    class:      sfPropelDatabase\n".
	"    param:\n".
	"      phptype:  mysql\n".
	"      host:     ".$arg_server."\n".
	"      database: ".$arg_database."\n".
	"      username: ".$arg_user."\n";
if ($arg_pass)
{
	$content .=	"      password: '".$arg_pass."'\n";
}
$content .=
	"      encoding: utf8\n";

$filename = "config/databases.yml";
if (!writeFile($filename, $content, false))
{
	exit("Error writing ".$filename."\n");
}
else
{
	echo "Writing $filename successfully\n";
}

//========================== "properties.ini" ==============================

$content =
	"[symfony]\n".
	"  name=".$arg_project."\n";
$filename = "config/properties.ini";
if (!writeFile($filename, $content, false))
{
	exit("Error writing ".$filename."\n");
}
else
{
	echo "Writing $filename successfully\n";
}

//========================== "propel.ini" ==============================

$filename = "config/propel.ini";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$lines = explode("\n", $contents);
$lines[0] = "propel.output.dir          = ".$pwd;
$lines[1] = "propel.project             = ".$arg_project;
if ($arg_pass)
{
	$passStr = ':'.$arg_pass;
}
$lines[2] = "propel.database.createUrl  = mysql://".$arg_user.$passStr."@".$arg_server."/";
$lines[3] = "propel.database.url        = mysql://".$arg_user.$passStr."@".$arg_server."/".$arg_database;

$newContent = implode("\n", $lines);
if (!writeFile($filename, $newContent, false))
{
	exit("Error writing ".$filename."\n");
}
else
{
	echo "Writing $filename successfully\n";
}

//========================== "schema.xml" ==============================

$filename = "config/schema.xml";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$lines = explode("\n", $contents);
$lines[1] = '<database name="'.$arg_database.'" defaultIdMethod="native" noxsd="true">';

$newContent = implode("\n", $lines);
if (!writeFile($filename, $newContent, false))
{
	exit("Error writing ".$filename."\n");
}
else
{
	echo "Writing $filename successfully\n";
}

echo "\n\n".$argv[0]." is done.\n";

mysql_connect($arg_server, $arg_user, $arg_pass);
$res = mysql_query('CREATE DATABASE `'.$arg_database.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;'); 
if(!$res) echo "!!! ERROR WHILE CREATING DATABASE !!!";

?>