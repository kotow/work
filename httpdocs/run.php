<?php

error_reporting(0);
//exit();
// INIT
//$path = realpath(dirname(__FILE__).'/..');
$accepted_params = array(
						"command",
						"project",
						"db_user",
						"db_pass",
						"db_name",
						"server"
						);

chdir("..");

foreach ($_REQUEST as $param => $value)
{
	if(in_array($param, $accepted_params))
	{
		$$param = $value;
	}
}

///////////////////////////////////////////
/*switch ($command)
{
	case "install": exec("php install_web.php", $output, $status); break;
	default: exec("php ".$command, $output, $status); break;
}*/
if($command == "install_web.php")
{
	if(!$server) $server = "127.0.0.1";
	if(!$db_pass) $db_pass = '""';
	
	$command .= " ".$project;
	$command .= " ".$db_user;
	$command .= " ".$db_pass;
	$command .= " ".$db_name;
	$command .= " ".$server;
}
exec("php ".$command, $output, $status);
//$output2 = array("mysql -u $db_user -p$db_pass -h $server --database $db_name < install.sql");
exec("mysql -u $db_user -p$db_pass -h $server --database $db_name < install.sql", $output2, $status2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>DONE.CMS INISTALL</title>
		<link href="/css/panel/reset.css" type="text/css" rel="stylesheet" />
		<link href="/css/panel/jquery-ui-min.css" type="text/css" rel="stylesheet" />
		<link href="/css/panel/layout.css" type="text/css" rel="stylesheet" />
		<link href="/css/panel/typography.css" type="text/css" rel="stylesheet" />
		<link href="/css/panel/style.css" type="text/css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
		<script src="/js/panel/jquery-1.5.1.js" type="text/javascript"></script>
	</head>
	<body>

<div id="content">
<h1 class="lead-heading">DONE.CMS INISTALL</h1>

	<fieldset class="drop-shadow">
		<img src="/images/set2/cursor_H_split_icon&16.png" onclick="$('#install').toggle('slow');" style="float:right"> <b>INSTALLATION</b><br>
		<form style="display:none" action="" id='install'>
			<br>
			<!--<div style="height:35px;"><div style="width:150px;float:left">&nbsp;</div><input type="submit" name="command" value="prepare.php" style="width:320px;font-weight:bold"></div>
			<div style="border-bottom:solid 1px #ccc; height:10px;margin-bottom:10px"></div>-->
			<div style="height:35px;"><div style="width:150px;float:left">Project* </div><input type="input" name="project" style="width:308px;font-weight:bold;float:left"></div>
			<div style="height:35px;"><div style="width:150px;float:left">DB name* </div><input type="input" name="db_name" style="width:308px;font-weight:bold;float:left"></div>
			<div style="height:35px;"><div style="width:150px;float:left">DB user* </div><input type="input" name="db_user" style="width:308px;font-weight:bold;float:left"></div>
			<div style="height:35px;"><div style="width:150px;float:left">DB pass* </div><input type="input" name="db_pass" style="width:308px;font-weight:bold;float:left"></div>
			<div style="height:35px;"><div style="width:150px;float:left">Server</div><input type="input" name="server" style="width:308px;font-weight:bold;float:left"></div>
			<div style="height:35px;"><div style="width:150px;float:left">&nbsp;</div><input type="submit" name="command" value="install_web.php" style="width:320px;font-weight:bold"></div>
		</form>
		
	</fieldset>
	<fieldset class="drop-shadow">
		<img src="/images/set2/cursor_H_split_icon&16.png" onclick="$('#commands').toggle('slow');" style="float:right"> <b>COMMANDS</b><br>
		<div style="display:block" id='commands'>
			
			<br>
			
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony clear-cache">
				<input type="submit" value="Clear cache" style="width:308px;font-weight:bold">
			</form>
			
			<div style="border-bottom:solid 1px #ccc; height:10px;margin-bottom:10px"></div>
			
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony generate-cache">
				<input type="submit" value="Generate cache" style="width:308px;font-weight:bold">
			</form>
			
			<div style="border-bottom:solid 1px #ccc; height:10px;margin-bottom:10px"></div>	
				
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony propel-build-model">
				<input type="submit" value="Build model" style="width:308px;font-weight:bold">
			</form>
			
			<div style="border-bottom:solid 1px #ccc; height:10px;margin-bottom:10px"></div>
			
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony compile-locales">
				<input type="submit" value="Compile locales" style="width:308px;font-weight:bold">
			</form>
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony compile-rights">
				<input type="submit" value="Compile rights" style="width:308px;font-weight:bold">
			</form>
			
			<div style="border-bottom:solid 1px #ccc; height:10px;margin-bottom:10px"></div>
			
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony url-relations">
				<input type="submit" value="Cache Url Relations" style="width:308px;font-weight:bold">
			</form>
			<form style="display:inline">
				<input type="hidden" name="command" value="symfony tag-relations">
				<input type="submit" value="Cache Tag Relations" style="width:308px;font-weight:bold">
			</form>
			
		</div>
	</fieldset>

	<fieldset class="drop-shadow">
		<div class="table-list" id="results" style="display:none">
			<div class="row lead" style="height:15px">
				<div class="col-a"><strong>RESULTS</strong></div>
			</div>
			<ul id="sortable" class="ui-sortable">
						<?php //if(!$status)
						{
							foreach ($output as $val)
							{
								if($val)
								echo "<li class='ui-state-default'><div class='row'><img src='/images/set2/flag_icon&16.png' align='absbottom'> ".$val."</div></li><div class='clear'></div>";
							}
						}
						?>
				</ul>
			
			<div class="clear"></div>
		</div>
	</fieldset>
	
<div class="clear"></div>
</div>
<?php if(!empty($output)):?>
	<script type="text/javascript">
		$('#results').show('slow');
	</script>
<?php endif;?>
	</body>
</html>

