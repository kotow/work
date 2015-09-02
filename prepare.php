<?php
$pwd = getcwd();

echo "fixing /apps folder...";
$output = array();
$filename = $pwd."/apps";
@chmod($filename, 0755);
$res = exec("chmod -R 0755 ".$filename."/*", $output);
echo "done\n";

echo "fixing /cache folder...";
$output = array();
$filename = $pwd."/cache";
@chmod($filename, 0777);
$res = exec("chmod -R 0777 ".$filename, $output);
echo "done\n";

echo "fixing /lib folder...";
$output = array();
$filename = $pwd."/lib";
@chmod($filename, 0755);
$res = exec("chmod -R 0755 ".$filename."/*", $output);
echo "done\n";

echo "fixing /log folder...";
$output = array();
$filename = $pwd."/log";
@chmod($filename, 0777);
$res = exec("chmod -R 0777 ".$filename, $output);
echo "done\n";

echo "fixing /www/media folder...";
$output = array();
$filename = $pwd."/www/media";
//@chmod($filename, 0777);
$res = exec("chmod -R 0777 ".$filename, $output);
echo "done\n";

$output = array();
$res = exec("ln -s root www", $output);

?>