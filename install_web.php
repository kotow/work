<?php

error_reporting(0);

$pwd = getcwd();

$filename = $pwd."/cache";
@chmod($filename, 0777);
$res = exec("chmod -R 777 ".$filename."/*", $output);

$output = array();;
$filename = $pwd."/www/media";
//@chmod($filename, 0777);
$res = exec("chmod -R 777 ".$filename."/*", $output);
echo "<b>Folder rights defined\n</b>";

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

$argCount = count($argv);
if ($argCount < 5)
{
	echo "Usage: ".$argv[0]." project_name db_username db_pass db_name [server] (server = 127.0.0.1 by default)\n";
	exit;
}
$arg_project = $argv[1];
$arg_user = $argv[2];
$arg_pass = $argv[3];
$arg_database = $argv[4];
$create_database = false;
$arg_server = "127.0.0.1";

if (count($argv) > 5)
{
	$arg_server = $argv[5];
	$create_database = $argv[6];
}


//========================== "config.php" ==============================
$content = "<?php\n".
"\$sf_symfony_lib_dir  = '".$pwd."/lib/symfony';\n".
"\$sf_symfony_data_dir = '".$pwd."/lib/symfony/data';\n".
"\$sf_use_relations_cache = false;\n".
"\$sf_cache_relations = false;\n".
"\$sf_cache_objects = true;\n".
"\$sf_cache_trees = false;";

$filename = $pwd."/config/config.php";
if (!writeFile($filename, $content, false))
{
	exit("<span style='color:red'>Error writing ".$filename."</span>\n");
}
else
{
	echo "<b>$filename</b> was written successfully\n";
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

$filename = $pwd."/config/databases.yml";
if (!writeFile($filename, $content, false))
{
	exit("<span style='color:red'>Error writing ".$filename."</span>\n");
}
else
{
	echo "<b>$filename</b> was written successfully\n";
}

//========================== "properties.ini" ==============================
$content =
"[symfony]\n".
"  name=".$arg_project."\n";
$filename = $pwd."/config/properties.ini";
if (!writeFile($filename, $content, false))
{
	exit("<span style='color:red'>Error writing ".$filename."</span>\n");
}
else
{
	echo "<b>$filename</b> was written successfully\n";
}

//========================== "propel.ini" ==============================
$filename = $pwd."/config/propel.ini";
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
	exit("<span style='color:red'>Error writing ".$filename."</span>\n");
}
else
{
	echo "<b>$filename</b> was written successfully\n";
}

//========================== "schema.xml" ==============================

$filename = $pwd."/config/schema.xml";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$lines = explode("\n", $contents);
$lines[1] = '<database name="'.$arg_database.'" defaultIdMethod="native" noxsd="true">';

$newContent = implode("\n", $lines);
if (!writeFile($filename, $newContent, false))
{
	exit("<span style='color:red'>Error writing ".$filename."</span>\n");
}
else
{
	echo "<b>$filename</b> was written successfully\n";
}

echo "<span style='color:green'>".strtoupper($argv[0])." IS DONE.</span>\n
Please run in order:\n

=> build model\n
=> clear cache\n
=> generate cache\n
=> compile rights\n
=> compile locales\n";

//============================ Database =================================
$connect = mysql_connect($arg_server, $arg_user, $arg_pass);
$select = mysql_select_db($arg_database);

if(!$connect || !$select)
	die("<span style='color:red'>ERROR WHILE CONNECTING TO DB, PLEASE CHECK USER, PASS, HOST OR DB NAME</span>");

//$sql = file_get_contents($pwd."/install.sql");

/*if($create_database) 
{
	$res = mysql_query('CREATE DATABASE `'.$arg_database.'` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;');
	if(!$res) die("<span style='color:red'>ERROR WHILE CREATING DATABASE</span>");
}*/

/*$res_sql = mysql_query($sql);
if(!$res_sql)
 die('Invalid query: ' . mysql_error());
*/

?>