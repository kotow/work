<?php

/*
* This file is part of the symfony package.
* (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

function echo_cms($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'CMS'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'CMS'), pakeApp::excerpt("", null))."\n";
	}
}
function echo_cms_line($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'CMS'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'CMS'), pakeApp::excerpt("", null));
	}
}
function echo_cms_error($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'ERROR'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'ERROR'), pakeApp::excerpt("", null))."\n";
	}
}
function echo_cms_title($section)
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'CMSTITLE'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize($section, 'CMSTITLE'), pakeApp::excerpt("", null))."\n";
	}
}
function echo_cms_sep()
{
	if (pakeApp::get_instance()->get_verbose())
	{
		$width = 9 + strlen(pakeColor::colorize('', 'SEP'));
		echo sprintf(' %-'.$width.'s %s', pakeColor::colorize("", 'SEP'), pakeApp::excerpt("", null))."\n";
	}
}

pake_desc('clear cached information');
pake_task('clear-cache', 'project_exists');
pake_alias('cc', 'clear-cache');

pake_desc('clear controllers');
pake_task('clear-controllers', 'project_exists');

pake_desc('fix directories permissions');
pake_task('fix-perms', 'project_exists');

pake_desc('rotates an applications log files');
pake_task('log-rotate', 'app_exists');

pake_desc('purges an applications log files');
pake_task('log-purge', 'project_exists');

pake_desc('enables an application in a given environment');
pake_task('enable', 'app_exists');

pake_desc('disables an application in a given environment');
pake_task('disable', 'app_exists');

pake_desc('creates backend listing and menues');
pake_task('build-backend', 'project_exists');
pake_alias('bb', 'build-backend');

pake_desc('creates backend forms');
pake_task('build-forms', 'project_exists');
pake_alias('bf', 'build-forms');

pake_desc('creates panel forms');
pake_task('build-panel', 'project_exists');
pake_alias('bp', 'build-panel');

pake_desc('creates cache for objects listed in apps/frontend/config/cachedObjects.xml file');
pake_task('generate-cache', 'project_exists');
pake_alias('gc', 'generate-cache');

pake_desc('
	runs in order:
	1. propel build model
	2. clear cache
	3. backend bindings build
	4. backend forms build
	5. cache generation
	6. tags generation
	7. url generation
	8. compile locales
	9. compile rights
	10. index documents
	');

pake_task('build-all', 'project_exists');
pake_alias('all', 'build-all');

pake_desc('compile locales');
pake_task('compile-locales', 'project_exists');
pake_alias('cl', 'compile-locales');

pake_desc('compile settings');
pake_task('compile-settings', 'project_exists');
pake_alias('cs', 'compile-settings');

pake_desc('compile right');
pake_task('compile-rights', 'project_exists');
pake_alias('cr', 'compile-rights');

pake_desc('create module: <module_name> <lib>');
pake_task('create-module', 'project_exists');
pake_alias('cm', 'create-module');

pake_task('compress-files', 'project_exists');
pake_alias('cf', 'compress-files');

pake_task('newsletter', 'project_exists');
pake_alias('nl', 'newsletter');

pake_task('tags-relations', 'project_exists');
pake_alias('tr', 'tags-relations');

pake_task('url-relations', 'project_exists');
pake_alias('ur', 'url-relations');

function run_compress_files($task, $args)
{
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	//$files = FileHelper::getSubElements(SF_ROOT_DIR.DIRECTORY_SEPARATOR."www".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."frontend");
	//$files = FileHelper::getSubElements(SF_ROOT_DIR.DIRECTORY_SEPARATOR."www".DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."backend");
	$files = FileHelper::getSubElements(SF_ROOT_DIR.DIRECTORY_SEPARATOR."www".DIRECTORY_SEPARATOR."css");

	foreach ($files as $file)
	{
		$ext = strrchr($file, ".");
		if ($ext != ".css" || $ext != ".js" || $ext != ".php") continue;

		$content = '';
		$lines = file($file);
		$closed = true;
		foreach ($lines as $k => $line)
		{
			if (strpos($line, "/*") !== false)
			{
				$pos = strpos($line, "/*");
				if (strpos($line, "*/") !== false)
				{
					$pos2 = strpos($line, "*/");
					$p = intval($pos)-1;
					if($p < 0) $p = 0;

					$p2 = intval($pos)-1;
					if($p2 < 0) $p2 = 0;

					$p2 = $p1 - $p2;
					if($p2 < 0) $p2 = 0;

					$line = substr($line, $p, $p2);
					$closed = true;
				}
				else
				{
					$l = intval($pos)-1;
					if($l < 0) $l = 0;
					$line = substr($line, 0, $l);
					echo $line;
					$content .= $line;
					$closed = false;
				}
			}
			elseif (!$closed && strpos($line, "*/") !== false)
			{
				$pos2 = strpos($line, "*/");

				$p = intval($pos)-1;
				if($p < 0) $p = 0;

				$p2 = intval($pos)-1;
				if($p2 < 0) $p2 = 0;

				$p2 = $p1 - $p2;
				if($p2 < 0) $p2 = 0;

				$line = substr($line, $p, $p2);
				$closed = true;
			}

			if ($closed && (strpos($line, "//") !== false))
			{
				$pos = strpos($line, "//");
				$l = intval($pos)-1;
				if($l < 0) $l = 0;

				if(substr($line, $l, 1) != ":")
				{
					$l = intval($pos)-1;
					if($l < 0) $l = 0;
					$line = substr($line, 0, $l);
				}
			}

			if ($closed)
			{
				$content .= $line;
			}
			else if (strpos($line, "*/") !== false)
			{
				$pos = strpos($line, "*/");
				$line = substr($line, (intval($pos)+1));
				$content .= $line;
			}
		}

		$pattern = "/[\t\n\r]/";
		$replacement = '';
		$content = preg_replace($pattern, $replacement, $content);
		$content = str_replace("\r\n\r\n", "\n", $content);
		$content = str_replace("\n\n", "\n", $content);
		$content = str_replace("\r\r", "\n", $content);
		FileHelper::writeFile($file."_new.css", $content);
		//FileHelper::writeFile($file, $content);

		echo "Done";
		//break;
	}
}

function run_newsletter($task, $args)
{
	ini_set("memory_limit","2048M");
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	/*$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();*/

	try
	{
		$controler = sfContext::getInstance()->getController();
		$newsletterHtml = $controler->getPresentationFor("news", "composeNewsletter");
		$newsletter = new Newsletter();
		$today = UtilsHelper::DateBG(date('Y-m-d H:i:s', time()), 'd F, Y г.');
		$newsletter->setLabel($today);
		$newsletter->setContent($newsletterHtml);
		$newsletter->save();

		$mailinglist = Document::getDocumentByExclusiveTag("newsletter_mailinglist_default");
		if ($mailinglist) $subscribers = Document::getChildrenOf($mailinglist->getId(), "Subscriber");

		$subject = "Sgrada.com - ежедневен бюлетин";
		$i = $ind = 0;
		$mailAddresses = array();
		$cnt = count($subscribers);
		foreach ($subscribers as $subscriber)
		{
			$ind++;
			if ($subscriber->getPublicationStatus() == "ACTIVE")
			{
				$mailAddresses[] = $subscriber->getEmail();
				echo " ====> ".$subscriber->getEmail()."\n";
				$i++;
			}

			if ($i == 100 || $ind == $cnt)
			{
				if (!empty($mailAddresses))
				{
					//sendMail($mailAddresses, $subject, $newsletterHtml);
					$mail = new sfMail();
					$mail->initialize();
					$mail->setMailer('sendmail');
					$mail->setCharset('utf-8');
					$mail->setSender(UtilsHelper::NO_REPLY_MAIL, UtilsHelper::SYSTEM_SENDER);
					$mail->setFrom(UtilsHelper::NO_REPLY_MAIL, UtilsHelper::SYSTEM_SENDER);

					$mail->addAddress(UtilsHelper::NO_REPLY_MAIL);

					foreach ($mailAddresses as $mailAdd)
					{
						$mail->addBcc($mailAdd);
					}

					$mail->setContentType('text/html');

					$mail->setSubject($subject);
					$mail->setBody($newsletterHtml);
					$mail->send();
				}
				$mailAddresses = array();
				$i = 0;
			}
		}
	}
	catch (Exception $e)
	{
		$newsletter->setLabel("ERROR! ".$today);
		$newsletter->save();
		FileHelper::Log("TASK run_newsletter: ".$e->getMessage(), UtilsHelper::MSG_ERROR);
	}
}

function run_build_all($task, $args)
{
	ini_set("memory_limit","2048M");
	echo "\n||||||||||||||||||||||||| => STARTS PROPEL BUILD MODEL <= |||||||||||||||||||||||||||\n\n";
	run_propel_build_model($task, $args);
	echo "\n||||||||||||||||||||||||||||| => STARTS CLEAR CACHE <= ||||||||||||||||||||||||||||||\n\n";
	run_clear_cache($task, $args);
	echo "\n||||||||||||||||||||||| => STARTS BACKEND BINDINGS BUILD <= |||||||||||||||||||||||||\n\n";
	run_build_backend($task, $args);
	echo "\n||||||||||||||||||||||||| => STARTS BACKEND FORMS BUILD <= ||||||||||||||||||||||||||\n\n";
	run_build_forms($task, $args);
	echo "\n||||||||||||||||||||||||| => STARTS PANEL FORMS BUILD <= ||||||||||||||||||||||||||\n\n";
	run_build_panel($task, $args);
	echo "\n|||||||||||||||||||||||||| => STARTS CACHE GENERATION <= ||||||||||||||||||||||||||||\n\n";
	run_generate_cache($task, $args);
	echo "\n|||||||||||||||||||||||||| => STARTS TAGS GENERATION <= |||||||||||||||||||||||||||||\n\n";
	run_tags_relations($task, $args);
	echo "\n|||||||||||||||||||||||||| => STARTS URL GENERATION <= ||||||||||||||||||||||||||||||\n\n";
	run_url_relations($task, $args);
	echo "\n|||||||||||||||||||||||||| => STARTS COMPILE LOCALES <= |||||||||||||||||||||||||||||\n\n";
	run_compile_locales($task, $args);
	echo "\n|||||||||||||||||||||||||| => STARTS COMPILE RIGHTS <= ||||||||||||||||||||||||||||||\n\n";
	run_compile_rights($task, $args);
	//echo "\n|||||||||||||||||||||||||| => STARTS INDEX DOCUMENTS <= |||||||||||||||||||||||||||||\n\n";
	//run_index_documents($task, $args);
}

function run_compile_rights($task, $args)
{
	ini_set("memory_limit","2048M");
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
//	define('SF_APP',         'panel');
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	if (!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if (!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	$appArray = array('backend', 'panel');
	foreach ($appArray as $app)
	{
		if ($app == 'backend')
			$rightsFile = sfConfig::get('sf_root_dir')."/cache/rights.php";
		else
			$rightsFile = sfConfig::get('sf_root_dir')."/cache/".$app."_rights.php";

		echo_cms_title("Compiling rights '$rightsFile'...");

		if (is_readable(SF_ROOT_DIR."/apps/".$app."/config/rights.xml"))
		{
			$objects = XMLParser::getXMLdataValues(SF_ROOT_DIR."/apps/".$app."/config/rights.xml");
		}

		$content = "<?php\n\n".
		"\t\$allRights = array();\n";

		$user = null; $module = null;
		foreach ($objects as $obj)
		{
			if (($obj['tag'] == 'USER') && ($obj['type'] == 'open'))
			{
				$user = $obj['attributes']['LABEL'];
				$content .= "\n\t/*------------- ".$user." user rights ----------------*/\n\n";
			}

			if (($obj['tag'] == 'user') && ($obj['type'] == 'close'))
			{
				$user = null;
			}

			// USER TAG CONTENT
			if(!is_null($user))
			{
				if (($obj['tag'] == 'MODULE') && ($obj['type'] == 'open'))
				{
					$module = $obj['attributes']['NAME'];
				}

				if (($obj['tag'] == 'MODULE') && ($obj['type'] == 'close'))
				{
					$module = null;
				}

				if (!is_null($module))
				{
					if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
					{
						$commands = explode(",", $obj['attributes']['COMMANDS']);
						$fc = array();
						foreach ($commands as $command)
						{
							$val = "true";

							if (substr($command, 0, 1) == "-")
							{
								$val = "false";
								$command = substr($command, 1);
								$fc[] = $command;
							}
							else
							{
								$ac[] = $command;
							}

							$content .= "\t\$allRights['$user']['$module']['$obj[value]']['$command'] = $val;\n";
						}
						if (!in_array("delete", $fc) && !in_array("delete", $ac))
						{
							$content .= "\t\$allRights['$user']['$module']['$obj[value]']['delete'] = true;\n";
						}
						if (!in_array("edit", $fc) && !in_array("edit", $ac))
						{
							$content .= "\t\$allRights['$user']['$module']['$obj[value]']['edit'] = true;\n";
						}
						if (!in_array("order", $fc) && !in_array("order", $ac))
						{
							$content .= "\t\$allRights['$user']['$module']['$obj[value]']['order'] = true;\n";
						}
					}
				}
			}
		}
		$content .= "\n?>";

		echo_cms_sep();
		if (FileHelper::writeFile($rightsFile, $content))
		{
			echo_cms($rightsFile." written successfully.");
		}
		else
		{
			echo_cms_error("Error writing ".$rightsFile."!");
		}
		echo_cms_sep();
	}
}


function run_compile_locales($task, $args)
{
	ini_set("memory_limit","2048M");
	// get configuration
	// define constants
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	//	$databaseManager = new sfDatabaseManager();
	//	$databaseManager->initialize();

	$root = sfConfig::get('sf_root_dir');
	if (!class_exists("XMLParser")) include $root."/lib/tools/XMLParser.class.php";
	if (!class_exists("FileHelper")) include $root."/lib/helper/FileHelper.php";

	$xmlFile = $root."/config/locales.xml";
	$localeFile = $root."/cache/locales.php";

	echo_cms_title("Compiling locales '$xmlFile'...");

	if (is_readable($root."/config/locales.xml"))
	{
		$objects = XMLParser::getXMLdataValues($root."/config/locales.xml", true, true);

		$content = "<?php\n\n".
		"\t\$locales = array();\n";
		$existingLocale = array();

		echo_cms("Creating locales: '$localeFile' ...");
		foreach ($objects as $obj)
		{
			if (($obj['tag'] == 'LOCALE') && ($obj['type'] == 'open'))
			{
				$objName = $obj['attributes']['LABEL'];
			}

			if (($obj['tag'] == 'ITEM') && ($obj['type'] == 'complete'))
			{
				//$lang = $obj['attributes']['LANG'];
				$val = $obj['attributes']['VALUE'];

				$localeName = $objName; //$localeName = strtolower($objName);
				if (!in_array($localeName, $existingLocale))
				{
					//$content .= "\t\$locales['".$localeName."'] = \"".str_replace('"', '\"', utf8_decode($val))."\";\n";
					$v = htmlspecialchars(utf8_decode($val));
					$v = str_replace('"', '\"', $v);
					$content .= "\t\$locales['".$localeName."'] = \"$v\";\n";
					$existingLocale[] = $localeName;
				}
			}
		}
		$content .= "\n?>";
		echo_cms_sep();
		if (FileHelper::writeFile($localeFile, $content))
		{
			echo_cms($localeFile." written successfully");
		}
		else
		{
			echo_cms_error("Error writing ".$localeFile."!");
		}
	}
	else
	{
		echo_cms("No locales (XML file) found!");
	}
	echo_cms_sep();
}

function run_compile_settings($task, $args)
{
	ini_set("memory_limit","2048M");
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'panel');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
	if (!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if (!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	$settingsFile = sfConfig::get('sf_root_dir')."/cache/settings.php";
	$settingsXml = sfConfig::get('sf_root_dir')."/config/settings.xml";

	echo_cms_title("Compiling settings '$settingsXml'...");

	$content = "<?php\n\n".
	"\t\$settings = array();\n";

	$existingSetting = array();

	if (is_readable($settingsXml))
	{
		$objects = XMLParser::getXMLdataValues($settingsXml, true, true);

		foreach ($objects as $obj)
		{
			if (($obj['tag'] == 'ELEMENT') && ($obj['type'] == 'open')) $objName = $obj['attributes']['LABEL'];
			if (($obj['tag'] == 'ITEM') && ($obj['type'] == 'complete'))
			{
				$lang = $obj['attributes']['LANG'];
				$val = $obj['attributes']['VALUE'];
				$settingName = strtolower($objName);
				if (!in_array($settingName, $existingSetting))
				{
					$content .= "\t\$settings['".$settingName."'] = \"".str_replace('"', '\"', utf8_decode($val))."\";\n";
					$existingSetting[] = $settingName;
				}
			}
		}
		$content .= "\n?>";
		echo_cms_sep();
		if (FileHelper::writeFile($settingsFile, $content))
		{
			echo_cms($settingsFile." written successfully");
		}
		else
		{
			echo_cms_error("Error writing ".$settingsFile."!");
		}
	}
	echo_cms_sep();
}

function run_build_forms($task, $args)
{
	ini_set("memory_limit","2048M");
	// get configuration
	// define constants
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	//	$databaseManager = new sfDatabaseManager();
	//	$databaseManager->initialize();

	if(!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if(!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	$overwrite = false;
	if (isset($args[0]))
	{
		$overwrite = ($args[0] == "overwrite");
	}

	$formFile = sfConfig::get('sf_root_dir')."/config/form.xml";

	echo_cms_title("Building backend forms '$formFile'...");

	if (is_readable($formFile))
	{
		$objects = XMLParser::getXMLdataValues($formFile);
		//		var_dump($objects);
		$haveTabs = ""; $contentTabs = "";

		foreach ($objects as $obj)
		{
			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'open'))
			{
				$objName = $obj['attributes']['NAME'];

				//$formObjName = strtolower($objName);
				$formObjName = "obj";

				$objModule = $obj['attributes']['MODULE'];
				if (!$objModule)
				{
					$objModule = strtolower(str_replace('I18n', '', $objName));
				}
				$tabIndex = 0; $imageFields = "";
				$formEditTemplate = sfConfig::get('sf_root_dir')."/apps/".SF_APP."/modules/".$objModule."/templates/edit".$objName."Success.php";
				if (file_exists($formEditTemplate) && !$overwrite)
				{
					$skipFile = true;
				}
				else
				{
					$skipFile  = false;
					echo_cms("Generating '".$objName."' form...");
					$content = "<?php echo \$sf_params->get('backendMsg');?>\n";
					$content .= "<div id='content_tabs'>\n";
					$content .= "<form id='form' name='form' action='<?php echo \$formAction; ?>' onsubmit='return validateEditForm()' method='POST'>\n";
					$content .= "\t<?php if (\$moduleName && \$documentName): ?>\n";
					$content .= "\t\t<?php echo backend_hidden('moduleName', \$moduleName); ?>\n";
					$content .= "\t\t<?php echo backend_hidden('documentName', \$documentName); ?>\n";
					$content .= "\t<?php endif; ?>\n";
				}
				$flagRequired = false;
				$fieldLabels[] = array();
			}

			if (!$skipFile && ($obj['tag'] == 'TAB') && ($obj['type'] == 'open'))
			{
				$tabIndex++;
				if ($tabIndex == 1)
				{
					$contentTabs = "<div id='tabs' class='tabsmenu'>\n\t<ul>\n";
					$tabSelected = " class='selected'";
					$display = "";
				}
				else
				{
					$tabSelected = "";
					$display = " style='display: none'";
				}
				$content .= "\t<div id='tab".$tabIndex."' name='tab".$obj['attributes']['NAME']."'".$display.">\n";
				$haveTabs = "\t";
				$contentTabs .=	"\t\t<li><a href='#' rel='tab".$tabIndex."' onclick='SelectTab(this)'".$tabSelected.">".$obj['attributes']['NAME']."</a></li>\n";
			}

			if (!$skipFile && ($obj['tag'] == 'COLUMN') && ($obj['type'] == 'complete'))
			{
				$attrs = "";
				$paramName = $obj['attributes']['NAME'];
				if (strpos($paramName, "_") !== false)
				{
					$p = strpos($paramName, "_");
					$paramName = substr($paramName, 0, $p).ucfirst(substr($paramName, $p+1));
				}
				$paramUpName = ucfirst($paramName);

				$paramType = $obj['attributes']['TYPE'];
				$paramListId = $obj['attributes']['LIST-ID'];
				$paramHidden = $obj['attributes']['HIDDEN'];
				$paramPassword = $obj['attributes']['PASSWORD'];
				$paramSize = $obj['attributes']['SIZE'];
				$paramRows = $obj['attributes']['ROWS'];
				$paramPreview = $obj['attributes']['PREVIEW'];
				$paramRichtext = $obj['attributes']['RICHTEXT'];
				$paramLabel = $obj['attributes']['LABEL'];
				$paramThumbs = $obj['attributes']['THUMBS'];

				$paramRequired = $obj['attributes']['REQUIRED'];
				$paramValidate = $obj['attributes']['VALIDATE'];
				$paramUnique = $obj['attributes']['UNIQUE'];
				$paramCompare = $obj['attributes']['COMPARE'];

				// send object MODEL to functions as option attribute
				$attrs .= ", 'model' => '".ucfirst($objName)."'";
				if ($paramUnique)
				{
					$attrs .= ", 'unique' => '".$paramUnique."'";
				}
				if ($paramPassword)
				{
					$attrs .= ", 'password' => '".$paramPassword."'";
				}

				echo_cms("  -> field='".$paramUpName."'  type='".$paramType);
				if (!$paramLabel)
				{
					$paramLabel = $paramUpName;
				}
				$fieldLabels[$paramName] = $paramLabel;

				if ($paramSize)
				{
					if ($paramType == "textarea")
					{
						$attrs .= ", 'size' => '".$paramSize."'";
					}
					else
					{
						$attrs .= ", 'maxlength' => '".$paramSize."'";
					}
				}
				if ($paramRichtext)
				{
					$attrs .= ", 'richtext' => 'true'";
				}
				if ($paramRows)
				{
					$attrs .= ", 'rows' => '".$paramRows."'";
				}
				if ($paramRequired)
				{
					$attrs .= ", 'required' => '".$paramRequired."'";
					$requredOnChange = " validateEditForm();";
					$flagRequired = true;
				}
				else
				{
					$requredOnChange = "";
				}

				if ($paramType == "list")
				{
					$onChangeCommand = "onchange";
				}
				else
				{
					$onChangeCommand = "onfocus";
				}

				if ($paramCompare)
				{
					$attrPrefix = "";
				}
				else
				{
					$attrPrefix = "attr";
				}
				if ($paramValidate)
				{
					if (substr($paramValidate, 0, 6) == "regexp")
					{
						$regexp = urlencode(substr($paramValidate, 7));
						$pattern = "?pattern=".$regexp;
						$validator = ucfirst(substr($paramValidate, 0, 6));
					}
					else
					{
						$validator = ucfirst($paramValidate);
						$pattern = "";
					}
					//					$attrs .= ", 'onchange' => remote_function (array ( 'update' => '".$attrPrefix.$paramUpName."Error', 'url' => 'admin/validate".$validator.$pattern."', 'with' => \"'value=' + this.value\" ) )";
					$attrs .= ", 'validate' => '".$validator."', '".$onChangeCommand."' => 'validateField(\'attr".$paramUpName."\', \'admin/validate".$validator.$pattern."\');'";
				}
				else if ($paramCompare)
				{
					if (strpos($paramCompare, "_") !== false)
					{
						$p = strpos($paramCompare, "_");
						$paramCompare = substr($paramCompare, 0, $p).ucfirst(substr($paramCompare, $p+1));
					}
					$attrs .= ", 'validate' => 'compare', '".$onChangeCommand."' => 'validateCompare(this.id, \'attr".ucfirst($paramCompare)."\', \'".$fieldLabels[$paramCompare]."\'); ".$requredOnChange."'";
				}
				else
				{
					if ($requredOnChange)
					{
						$attrs .= ", '".$onChangeCommand."' => '".$requredOnChange."'";
					}
				}

				if ($paramHidden)
				{
					if ($paramName == 'id')
					{
						$content .= $haveTabs."\t<?php echo backend_hidden('".$paramName."', $".$formObjName.", '', 'get".$paramUpName."'); ?>\n";
						$content .= $haveTabs."\t<?php echo backend_hidden('parent', ".'$'."sf_request->getParameter('parent')); ?>\n";
						$content .= $haveTabs."\t<?php if ($".$formObjName.") echo 'ID: '.$".$formObjName."->getId(); ?>";
						if (strtolower($objName) == 'pagei18n')
						{
							$content .= "<br>\n\t<?php if ($".$formObjName."): ?><a href='<?php echo $".$formObjName."->getHref(); ?>' target='_blank'><img id='btnEditPage' align='absbottom' src='/images/btn_editpage.gif'/></a><?php endif; ?>\n";
						}
						else
						{
							$content .= "\n";
						}
					}
					else
					{
						$content .= $haveTabs."\t<?php echo backend_hidden('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
				}
				else
				{
					if ($paramType == "list")
					{
						if ($paramListId)
						{
							$content .= $haveTabs."\t<?php echo backend_select('".$attrPrefix.$paramUpName."', $".$formObjName.", Lists::getListitemsForSelect('".$paramListId."'), array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
						}
						else
						{
							$content .= $haveTabs."\t<?php echo backend_select('".$attrPrefix.$paramUpName."', $".$formObjName.", $".$paramName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
						}
					}
					else if ($paramType == "boolean")
					{
						$content .= $haveTabs."\t<?php echo backend_checkbox('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
					else if ($paramType == "textarea")
					{
						$content .= $haveTabs."\t<?php echo backend_textarea('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
					else if (($paramType == "timestamp") || ($paramType == "date"))
					{
						$content .= $haveTabs."\t<?php echo backend_date('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
					// Preview (type='droppable')
					else if (($paramType == 'droppable') || ($paramType == 'file'))
					{
						$prevAttr = "";
						if ($paramThumbs)
						{
							$thumbs = explode(" ", $paramThumbs);
							if (!empty($thumbs))
							{
								$prevAttr .= " 'path' => '".$objModule."' ,";
								$imageFields .= $paramUpName.",";
							}
							foreach ($thumbs as $thumb)
							{
								$wpos = strpos($thumb, "width=");
								if ($wpos !== false)
								{
									$widthValue = substr($thumb, $wpos+6);
									$prevAttr .= " 'width' => '".$widthValue."' ,";
								}
								$hpos = strpos($thumb, "height=");
								if ($hpos !== false)
								{
									$heightValue = substr($thumb, $hpos+7);
									$prevAttr .= " 'height' => '".$heightValue."' ,";
								}
							}
							$prevAttr = substr($prevAttr, 0, -1);
						}
						// Preview (type='file')
						if ($paramType == 'file')
						{
							$content .= $haveTabs."\t<?php echo backend_file('".$paramUpName."', $".$formObjName.", array(".$prevAttr."), 'get".$paramUpName."'); ?>\n";
						}
						else
						// Preview (type='droppable')
						{
							$content .= $haveTabs."\t<?php echo backend_droppable('".$paramUpName."', $".$formObjName.", array(".$prevAttr."), 'get".$paramUpName."'); ?>\n";
						}
					}
					else
					{
						$content .= $haveTabs."\t<?php echo backend_input('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
				}
				/*
				// Thumbs
				if ($paramThumbs)
				{
				$thumbWidth = $thumbHeight = null;
				$thumbs = explode(" ", $paramThumbs);
				foreach ($thumbs as $thumb)
				{
				$wpos = strpos($thumb, "width=");
				if ($wpos !== false)
				{
				$widthValue = substr($thumb, $wpos+6);
				$content .= $haveTabs."\t<?php echo backend_hidden('thumbwidth', ".$widthValue."); ?>\n";
				}
				$hpos = strpos($thumb, "height=");
				if ($hpos !== false)
				{
				$heightValue = substr($thumb, $hpos+7);
				$content .= $haveTabs."\t<?php echo backend_hidden('thumbheight', ".$heightValue."); ?>\n";
				}
				}
				}
				*/
			}

			if (!$skipFile && ($obj['tag'] == 'COLUMN') && ($obj['type'] == 'close'))
			{
				$content .= "\n";
			}

			if (!$skipFile && ($obj['tag'] == 'TAB') && ($obj['type'] == 'close'))
			{
				if ($tabIndex == 1)
				{
					$content .= $haveTabs."\t<?php echo backend_tags(\$tags, \$obj); ?>\n";
				}
				$content .= "\t</div>\n\n";
				$haveTabs = "";
			}

			if (!$skipFile && ($obj['tag'] == 'OBJECT') && ($obj['type'] == 'close'))
			{
				echo_cms_sep();
				if ($contentTabs)
				{
					$contentTabs .= "\t</ul>\n</div>\n";
				}
				if ($imageFields)
				{
					$imageFields = substr($imageFields, 0, -1);
					$content .= "\t<?php echo backend_hidden('imageFields', '".$imageFields."'); ?>\n";
				}
				if ($tabIndex == 0)
				{
					$content .= $haveTabs."\t<?php echo backend_tags(\$tags, \$obj); ?>\n";
				}
				$content .= "\t<div id='line'></div>\n";
				//				$content .= "<input id='btnSubmit' type='submit' src='/../images/btn_save.png' class='save_btn' />\n";
				if ($flagRequired)
				{
					$disabled = "disabled";
				}
				else
				{
					$disabled = "";
				}

				$content .= "\t<input id='btnSubmit' type='submit' class='save_btn".$disabled."' value='' ".$disabled."/>\n";
				/*$content .= "<input id=\"btnSubmit\" onclick=\"saveForm('<?php echo \$formAction; ?>','<?php echo \$moduleName?>','<?php echo \$documentName?>')\" type=\"button\" class=\"save_btndisabled\" value=\"\" disabled/>";*/
				$content .= "</form>\n</div>\n";
				$content .= "<script type='text/javascript'>setTimeout(function(){\$('#backendMsg').fadeOut(1000)},2000);</script>\n";
				// Adding TABs section in TOP of contents
				$content = $contentTabs.$content;
				$contentTabs = "";
				echo_cms_sep();
				if (!$skipFile && FileHelper::writeFile($formEditTemplate, $content))
				{
					echo_cms("$formEditTemplate written successfully");
				}
				else
				{
					echo_cms_error("Error writing $formEditTemplate !!!");
				}
				echo_cms_sep();
			}
		}
	}
	else
	{
		echo_cms_error("Error reading ".$formFile);
	}
}

function run_build_backend($task, $args)
{
	ini_set("memory_limit","2048M");
	// get configuration
	// define constants
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	//	$databaseManager = new sfDatabaseManager();
	//	$databaseManager->initialize();

	if (!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if (!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	$modules = FileHelper::getSubElements(sfConfig::get('sf_root_dir')."/apps/".SF_APP."/modules", "folder");
	$content = "function initBindings()\n{\n";
	$contentTemplate = "";

	echo_cms_title("Building backend...");

	foreach ($modules as $module => $path)
	{
		if ($module == "admin")
		{
			$module = "tag";
		}

		if(substr($module,0,1) == ".") continue;
		$objects1 = array(); $objects2 = array(); $objectsDone = array();
		if (!is_readable($path."/config/leftTree.xml") && !is_readable($path."/config/mainList.xml"))
		{
			continue;
		}
		else
		{
			$objects1 = XMLParser::getXMLdataValues($path."/config/leftTree.xml");
			$objects2 = XMLParser::getXMLdataValues($path."/config/mainList.xml");
		}

		$objects = array_merge($objects1, $objects2);

		$content .= "\n/*------------- MODULE ".$module." ----------------*/\n\n";

		$contentTemplate .= "\n<!-- -------------------- MODULE ".$module." -------------------- -->\n\n";
		$contentTemplate .= "<?php if(\$userRights['$module']): ?>\n";

		echo_cms_sep();
		echo_cms("Module ".$module);
		echo_cms_sep();

		foreach ($objects as $obj)
		{
			$createCommands = "";
			$contentTemplateLiTags = "";
			$forbidenGenericCommands = array();

			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
			{
				$objName = $obj['value'];
				if (in_array($objName, $objectsDone))
				{
					continue;
				}
				$objectsDone[] = $objName;
				echo_cms(" Writing commands for : ".$objName);
				$params = $obj['attributes']['COMMANDS'];
				if ($params)
				{
					$commands = explode(",",$params);
					foreach ($commands as $command)
					{
						if(substr($command,0,1) == "-")
						{
							$forbidenGenericCommands[] = substr($command,1);
						}
						else
						{
							$docType = substr($command, 6);
							$commandTitle = $docType;
							if(substr($docType, -4) == "I18n")
							{
								$commandTitle = substr($docType, 0, -4)." (Language version)";
							}

							$createCommands .= "\t\t\t'".$command."': function(t) {createDocument('".$docType."', t.id);},\n";

							$contentTemplateLiTags .= "\t\t\t<?php if(\$userRights['$module']['$objName']['$command']): ?>\n";
							$contentTemplateLiTags .= "\t\t\t\t<li id='".$command."'><img src='/images/icons/".strtolower($docType).".png'/>Create ".ucfirst($commandTitle)."</li>\n";
							$contentTemplateLiTags .= "\t\t\t<?php endif; ?>\n";
						}
					}
				}

				if ($objName != "Rootfolder")
				{
					if(!in_array("delete", $forbidenGenericCommands))
					{
						$createCommands .= "\t\t\t'deleteDocument': function(t) {deleteDocument(t.id);},\n";

						$contentTemplateLiTags .= "\t\t\t<?php if(\$userRights['$module']['$objName']['delete']): ?>\n";
						$contentTemplateLiTags .= "\t\t\t\t<li id='deleteDocument'><img src='/images/icons/delete_document.png'/>Delete</li>\n";
						$contentTemplateLiTags .= "\t\t\t<?php endif; ?>\n";
					}

					if(!in_array("edit", $forbidenGenericCommands))
					{
						$createCommands .= "\t\t\t'editDocument': function(t) {editDocument('".$objName."', t.id);},\n";

						$contentTemplateLiTags .= "\t\t\t<?php if(\$userRights['$module']['$objName']['edit']): ?>\n";
						$contentTemplateLiTags .= "\t\t\t\t<li id='editDocument'><img src='/images/icons/edit_document.png'/>Edit</li>\n";
						$contentTemplateLiTags .= "\t\t\t<?php endif; ?>\n";
					}

					if(!in_array("order", $forbidenGenericCommands))
					{
						$createCommands .= "\t\t\t'orderDocumentUp': function(t) {orderDocument(t.id,true);},\n";
						$createCommands .= "\t\t\t'orderDocumentDown': function(t) {orderDocument(t.id,false);},\n";

						$contentTemplateLiTags .= "\t\t\t<?php if(\$userRights['$module']['$objName']['order']): ?>\n";
						$contentTemplateLiTags .= "\t\t\t\t<li id='orderDocumentUp'><img src='/images/icons/arrow_up.png'/>Move Up</li>\n";
						$contentTemplateLiTags .= "\t\t\t\t<li id='orderDocumentDown'><img src='/images/icons/arrow_down.png'/>Move Down</li>\n";
						$contentTemplateLiTags .= "\t\t\t<?php endif; ?>\n";
					}
				}

				$createCommands = substr($createCommands,0,-2)."\n";

				$contentTemplate .= "\t<?php if(\$userRights['$module']['$objName']): ?>\n";
				$contentTemplate .= "\t<div class='contextMenu' id='".$module."_".strtolower($objName)."'>\n\t<ul>\n";
				$content .= "\t$('span.".$module."_".strtolower($objName)."').contextMenu('".$module."_".strtolower($objName)."', {\n".
				"\t\tbindings: {\n";

				$contentTemplate .= $contentTemplateLiTags;
				$content .= $createCommands;
				$content .= "\t\t}\n\t});\n\n";
				$contentTemplate .= "\t\t</ul>\n".
				"\t</div>\n";
				$contentTemplate .= "\t<?php endif; ?>\n\n";
			}
		}
		$contentTemplate .= "<?php endif; ?>\n";
	}

	$content .= "}";

	$contextMenusTemplate = sfConfig::get('sf_root_dir')."/apps/".SF_APP."/modules/admin/templates/contextMenusSuccess.php";
	$contextMenusJs = sfConfig::get('sf_web_dir')."/js/".SF_APP."/contextMenus.js";

	echo_cms_sep();
	if (FileHelper::writeFile($contextMenusTemplate, $contentTemplate))
	{
		echo_cms("contextMenusSuccess.php written successfully");
	}
	else
	{
		echo_cms_error("Error writing contextMenusSuccess.php !");
	}

	if (FileHelper::writeFile($contextMenusJs, $content))
	{
		echo_cms("contextMenus.js written successfully");
	}
	else
	{
		echo_cms_error("Error writing contextMenus.js !");
	}
	echo_cms_sep();
}

function run_build_panel($task, $args)
{
	ini_set("memory_limit","2048M");
	// get configuration
	// define constants
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'panel');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	//	$databaseManager = new sfDatabaseManager();
	//	$databaseManager->initialize();

	if(!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if(!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	$overwrite = false;
	if (isset($args[0]))
	{
		$overwrite = ($args[0] == "overwrite");
	}

	$formFile = sfConfig::get('sf_root_dir')."/config/form.xml";

	echo_cms_title("Building PANEL forms from XML file: '$formFile'...");

	if (is_readable($formFile))
	{
		$objects = XMLParser::getXMLdataValues($formFile);
		//var_dump($objects);
		$haveTabs = ""; //$contentTabs = "";

		foreach ($objects as $obj)
		{
			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'open'))
			{
				$objName = $obj['attributes']['NAME'];

				//$formObjName = strtolower($objName);
				$formObjName = "obj";

				$objModule = $obj['attributes']['MODULE'];
				if (!$objModule)
				{
					$objModule = strtolower(str_replace('I18n', '', $objName));
				}
				$tabIndex = 0; $imageFields = "";
				$formEditTemplate = sfConfig::get('sf_root_dir')."/apps/".SF_APP."/modules/".$objModule."/templates/edit".$objName."Success.php";
				if (file_exists($formEditTemplate) && !$overwrite)
				{
					$skipFile = true;
					echo_cms("*** Skip '".$objName."' form...");
				}
				else
				{
					$skipFile  = false;
					echo_cms("Generating '".$objName."' form...");

					$hasImages = false;
					$content = "<!-- START CONTENT -->\n";
					$content .= "<?php echo \$sf_params->get('backendMsg'); ?>\n";
					$content .= "<?php echo panel_heading('attrLabel', \$obj, 'getLabel', 'Create new', \$documentName); ?>\n";
					$content .= "<form method='POST' action='<?php echo \$formAction; ?>' name='editForm' id='editForm'>\n";
					$content .= "	<?php if (\$moduleName && \$documentName): ?>\n";
					$content .= "		<?php echo panel_hidden('moduleName', \$moduleName); ?>\n";
					$content .= "		<?php echo panel_hidden('documentName', \$documentName); ?>\n";
					$content .= "	<?php endif; ?>\n";
					$content .= "	<?php echo panel_hidden('id', \$obj, '', 'getId'); ?>\n";
					$content .= "	<?php echo panel_hidden('parent', \$sf_request->getParameter('parent')); ?>\n";
					$content .= "	<fieldset class='drop-shadow'>\n";
					$content .= "\n";
				}
				$flagRequired = false;
				$fieldLabels[] = array();
			}

			/*if (!$skipFile && ($obj['tag'] == 'TAB') && ($obj['type'] == 'open'))
			{
			$tabIndex++;
			if ($tabIndex == 1)
			{
			$contentTabs = "<div id='tabs' class='tabsmenu'>\n\t<ul>\n";
			$tabSelected = " class='selected'";
			$display = "";
			}
			else
			{
			$tabSelected = "";
			$display = " style='display: none'";
			}
			$content .= "\t<div id='tab".$tabIndex."' name='tab".$obj['attributes']['NAME']."'".$display.">\n";
			$haveTabs = "\t";
			$contentTabs .=	"\t\t<li><a href='#' rel='tab".$tabIndex."' onclick='SelectTab(this)'".$tabSelected.">".$obj['attributes']['NAME']."</a></li>\n";
			}*/

			if (!$skipFile && ($obj['tag'] == 'COLUMN') && ($obj['type'] == 'complete'))
			{
				$attrs = "";
				$paramName = $obj['attributes']['NAME'];
				if (strpos($paramName, "_") !== false)
				{
					$p = strpos($paramName, "_");
					$paramName = substr($paramName, 0, $p).ucfirst(substr($paramName, $p+1));
				}
				$paramUpName = ucfirst($paramName);

				$paramType = $obj['attributes']['TYPE'];
				$paramListId = $obj['attributes']['LIST-ID'];
				$paramHidden = $obj['attributes']['HIDDEN'];
				$paramPassword = $obj['attributes']['PASSWORD'];
				$paramSize = $obj['attributes']['SIZE'];
				$paramRows = $obj['attributes']['ROWS'];
				$paramRichtext = $obj['attributes']['RICHTEXT'];
				$paramLabel = $obj['attributes']['LABEL'];
				$paramThumbs = $obj['attributes']['THUMBS'];

				$paramRequired = $obj['attributes']['REQUIRED'];
				$paramValidate = $obj['attributes']['VALIDATE'];
				$paramUnique = $obj['attributes']['UNIQUE'];
				$paramCompare = $obj['attributes']['COMPARE'];

				// send object MODEL to functions as option attribute
				$attrs .= ", 'model' => '".ucfirst($objName)."'";
				if ($paramUnique)
				{
					$attrs .= ", 'unique' => '".$paramUnique."'";
				}
				if ($paramPassword)
				{
					$attrs .= ", 'password' => '".$paramPassword."'";
				}

				echo_cms("  -> field='".$paramUpName."'  type='".$paramType);
				if (!$paramLabel)
				{
					$paramLabel = $paramUpName;
				}
				$fieldLabels[$paramName] = $paramLabel;

				if ($paramSize)
				{
					if ($paramType == "textarea")
					{
						if ($paramRows)
						$rows = $paramRows;
						else
						$rows = 5;
						$attrs .= ", 'size' => '".$paramSize."x".$rows."'";
					}
					else
					{
						$attrs .= ", 'maxlength' => '".$paramSize."'";
					}
				}
				if ($paramRichtext)
				{
					$attrs .= ", 'richtext' => 'true'";
				}
				if ($paramRows)
				{
					$attrs .= ", 'rows' => '".$paramRows."'";
				}
				if ($paramRequired)
				{
					$attrs .= ", 'required' => '".$paramRequired."'";
					//$requredOnChange = " validateEditForm();";
					$flagRequired = true;
				}
				else
				{
					//$requredOnChange = "";
				}

				if ($paramType == "list")
				{
					//$onChangeCommand = "onchange";
				}
				else
				{
					//$onChangeCommand = "onfocus";
				}

				if ($paramCompare)
				{
					$attrPrefix = "";
				}
				else
				{
					$attrPrefix = "attr";
				}
				if ($paramValidate)
				{
					if (substr($paramValidate, 0, 6) == "regexp")
					{
						$regexp = urlencode(substr($paramValidate, 7));
						$pattern = "?pattern=".$regexp;
						$validator = ucfirst(substr($paramValidate, 0, 6));
					}
					else
					{
						$validator = ucfirst($paramValidate);
						$pattern = "";
					}
					//$attrs .= ", 'onchange' => remote_function (array ( 'update' => '".$attrPrefix.$paramUpName."Error', 'url' => 'admin/validate".$validator.$pattern."', 'with' => \"'value=' + this.value\" ) )";
					//					$attrs .= ", 'validate' => '".$validator."', '".$onChangeCommand."' => 'validateField(\'attr".$paramUpName."\', \'admin/validate".$validator.$pattern."\');'";
					$attrs .= ", 'validate' => '".$validator."'";
				}
				else if ($paramCompare)
				{
					if (strpos($paramCompare, "_") !== false)
					{
						$p = strpos($paramCompare, "_");
						$paramCompare = substr($paramCompare, 0, $p).ucfirst(substr($paramCompare, $p+1));
					}
					//$attrs .= ", 'validate' => 'compare', '".$onChangeCommand."' => 'validateCompare(this.id, \'attr".ucfirst($paramCompare)."\', \'".$fieldLabels[$paramCompare]."\'); ".$requredOnChange."'";
					$attrs .= ", 'validate' => 'compare'";
				}
				else
				{
					if ($requredOnChange)
					{
						$attrs .= ", '".$onChangeCommand."' => '".$requredOnChange."'";
					}
				}

				if ($paramHidden)
				{
					if ($paramName == 'id')
					{
						/*$content .= $haveTabs."\t<?php echo panel_hidden('".$paramName."', $".$formObjName.", '', 'get".$paramUpName."'); ?>\n";
						$content .= $haveTabs."\t<?php echo panel_hidden('parent', ".'$'."sf_request->getParameter('parent')); ?>\n";
						$content .= $haveTabs."\t<?php if ($".$formObjName.") echo 'ID: '.$".$formObjName."->getId(); ?>";
						if (strtolower($objName) == 'pagei18n')
						{
						$content .= "<br>\n\t<?php if ($".$formObjName."): ?><a href='<?php echo $".$formObjName."->getHref(); ?>' target='_blank'><img id='btnEditPage' align='absbottom' src='/images/btn_editpage.gif'/></a><?php endif; ?>\n";
						}
						else
						{
						$content .= "\n";
						}*/
					}
					else
					{
						$content .= $haveTabs."\t<?php echo panel_hidden('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
				}
				else
				{
					if ($paramType == "list")
					{
						$attrs .= ", 'class'=>'medium'";
						if ($paramListId)
						{
							$content .= $haveTabs."\t<?php echo panel_select('".$attrPrefix.$paramUpName."', $".$formObjName.", Lists::getListitemsForSelect('".$paramListId."'), array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
						}
						else
						{
							$content .= $haveTabs."\t<?php echo panel_select('".$attrPrefix.$paramUpName."', $".$formObjName.", $".$paramName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
						}
					}
					else if ($paramType == "boolean")
					{
						$content .= $haveTabs."\t<?php echo panel_checkbox('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
					else if ($paramType == "textarea")
					{
						if ($paramRichtext)
						$attrs .= ", 'class' => 'mceEditor'";
						$content .= $haveTabs."\t<?php echo panel_textarea('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
					else if (($paramType == "timestamp") || ($paramType == "date"))
					{
						$content .= $haveTabs."\t<?php echo panel_date('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
					else if (($paramType == 'gallery') || ($paramType == 'image'))
					{
						$hasImages = true;
						if ($paramThumbs)
						{
							$prevAttr = "";
							$thumbs = explode(" ", $paramThumbs);
							foreach ($thumbs as $thumb)
							{
								$wpos = strpos($thumb, "tw=");
								if ($wpos === 0)
								{
									$widthValue = substr($thumb, $wpos+3);
									$prevAttr .= " 'thumb_width' => '".$widthValue."' ,";
								}
								$wpos = strpos($thumb, "w=");
								if ($wpos === 0)
								{
									$widthValue = substr($thumb, $wpos+2);
									$prevAttr .= " 'width' => '".$widthValue."' ,";
								}
								$hpos = strpos($thumb, "hw=");
								if ($hpos !== false)
								{
									$heightValue = substr($thumb, $hpos+3);
									$prevAttr .= " 'thumb_height' => '".$heightValue."' ,";
								}
								$hpos = strpos($thumb, "h=");
								if ($hpos !== false)
								{
									$heightValue = substr($thumb, $hpos+2);
									$prevAttr .= " 'height' => '".$heightValue."' ,";
								}
							}
							//$prevAttr = substr($prevAttr, 0, -1);
						}
						if ($paramType == 'gallery')
						{
							$content .= $haveTabs."\t<?php
	if (\$obj)
	{
		echo panel_gallery(\$".$formObjName."->getId(),
		array(
			'labelname' => 'Images gallery',
			$prevAttr
			'path' => 'upload'
		));
	}
?>\n";
						}
						else if ($paramType == 'image')
						{
							if ($allowed = $obj['attributes']['ALLOWED'])
							{
								$attrs .= ", 'allowed' => '$allowed'";
							}
							else
							{
								$attrs .= ", 'allowed' => 'images'";
							}
							$content .= $haveTabs."\t<?php echo panel_image('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
						}
					}
					/*					// Preview (type='droppable')
					else if (($paramType == 'droppable') || ($paramType == 'file'))
					{
					$prevAttr = "";
					if ($paramThumbs)
					{
					$thumbs = explode(" ", $paramThumbs);
					if (!empty($thumbs))
					{
					$prevAttr .= " 'path' => '".$objModule."' ,";
					$imageFields .= $paramUpName.",";
					}
					foreach ($thumbs as $thumb)
					{
					$wpos = strpos($thumb, "width=");
					if ($wpos !== false)
					{
					$widthValue = substr($thumb, $wpos+6);
					$prevAttr .= " 'width' => '".$widthValue."' ,";
					}
					$hpos = strpos($thumb, "height=");
					if ($hpos !== false)
					{
					$heightValue = substr($thumb, $hpos+7);
					$prevAttr .= " 'height' => '".$heightValue."' ,";
					}
					}
					$prevAttr = substr($prevAttr, 0, -1);
					}
					// Preview (type='file')
					if ($paramType == 'file')
					{
					$content .= $haveTabs."\t<?php echo panel_file('".$paramUpName."', $".$formObjName.", array(".$prevAttr."), 'get".$paramUpName."'); ?>\n";
					}
					else
					// Preview (type='droppable')
					{
					$content .= $haveTabs."\t<?php echo panel_droppable('".$paramUpName."', $".$formObjName.", array(".$prevAttr."), 'get".$paramUpName."'); ?>\n";
					}
					}*/
					else
					{
						$attrs .= ", 'class' => 'large'";
						$content .= $haveTabs."\t<?php echo panel_input('".$attrPrefix.$paramUpName."', $".$formObjName.", array('labelname' => '".$paramLabel."' ".$attrs."), 'get".$paramUpName."'); ?>\n";
					}
				}
				/*
				// Thumbs
				if ($paramThumbs)
				{
				$thumbWidth = $thumbHeight = null;
				$thumbs = explode(" ", $paramThumbs);
				foreach ($thumbs as $thumb)
				{
				$wpos = strpos($thumb, "width=");
				if ($wpos !== false)
				{
				$widthValue = substr($thumb, $wpos+6);
				$content .= $haveTabs."\t<?php echo panel_hidden('thumbwidth', ".$widthValue."); ?>\n";
				}
				$hpos = strpos($thumb, "height=");
				if ($hpos !== false)
				{
				$heightValue = substr($thumb, $hpos+7);
				$content .= $haveTabs."\t<?php echo panel_hidden('thumbheight', ".$heightValue."); ?>\n";
				}
				}
				}
				*/
			}

			if (!$skipFile && ($obj['tag'] == 'COLUMN') && ($obj['type'] == 'close'))
			{
				$content .= "\n";
			}

			/*			if (!$skipFile && ($obj['tag'] == 'TAB') && ($obj['type'] == 'close'))
			{
			if ($tabIndex == 1)
			{
			$content .= $haveTabs."\t<?php echo panel_tags(\$tags, \$obj); ?>\n";
			}
			$content .= "\t</div>\n\n";
			$haveTabs = "";
			}*/

			if (!$skipFile && ($obj['tag'] == 'OBJECT') && ($obj['type'] == 'close'))
			{
				/*
				echo_cms_sep();
				if ($contentTabs)
				{
				$contentTabs .= "\t</ul>\n</div>\n";
				}
				if ($imageFields)
				{
				$imageFields = substr($imageFields, 0, -1);
				$content .= "\t<?php echo panel_hidden('imageFields', '".$imageFields."'); ?>\n";
				}
				if ($tabIndex == 0)
				{
				$content .= $haveTabs."\t<?php echo panel_tags(\$tags, \$obj); ?>\n";
				}
				$content .= "\t<div id='line'></div>\n";
				//				$content .= "<input id='btnSubmit' type='submit' src='/../images/btn_save.png' class='save_btn' />\n";
				if ($flagRequired)
				{
				$disabled = "disabled";
				}
				else
				{
				$disabled = "";
				}

				$content .= "\t<input id='btnSubmit' type='submit' class='save_btn".$disabled."' value='' ".$disabled."/>\n";
				//$content .= "<input id=\"btnSubmit\" onclick=\"saveForm('<?php echo \$formAction; ?>','<?php echo \$moduleName?>','<?php echo \$documentName?>')\" type=\"button\" class=\"save_btndisabled\" value=\"\" disabled/>";
				$content .= "</form>\n</div>\n";
				$content .= "<script type='text/javascript'>setTimeout(function(){\$('#backendMsg').fadeOut(1000)},2000);</script>\n";
				// Adding TABs section in TOP of contents
				$content = $contentTabs.$content;
				$contentTabs = "";
				*/
				$content .= "\n";
				$content .= "	<?php echo panel_separator('hr', array('class' => 'brake')); ?>\n";
				$content .= "	<?php if (count(\$tags)>0) { echo panel_tags(\$tags, \$obj); echo panel_separator('hr', array('class' => 'brake')); } ?>\n";
				$content .= "	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>\n";
				if ($hasImages)
				$content .= "	<?php echo panel_modal_images(); ?>\n";
				$content .= "	</fieldset>\n";
				$content .= "</form>\n";
				$content .= "<div class='clear'></div>\n";
				$content .= "<!-- END CONTENT -->\n";
				echo_cms_sep();
				if (!$skipFile && FileHelper::writeFile($formEditTemplate, $content))
				{
					echo_cms("$formEditTemplate written successfully");
				}
				else
				{
					echo_cms_error("Error writing $formEditTemplate !!!");
				}
				echo_cms_sep();
			}
		}
	}
	else
	{
		echo_cms_error("Error reading ".$formFile);
	}
}

function getActionsContent($moduleName, $core = "Core", $sfActions = "sf", $documents = null)
{
	ini_set("memory_limit","2048M");
	$moduleUpName = ucfirst($moduleName);
	$content = "<?php\n\n".
	"/**\n".
	" * ".$moduleUpName." ".$core." actions.\n".
	" *\n".
	" * @package\t\tXXXXXX\n".
	" * @subpackage\t".$moduleName."\n".
	" */\n\n".
	"class ".$moduleName.$core."Actions extends ".$sfActions."Actions\n".
	"{\n";
	if ($documents)
	{
		foreach ($documents as $docName)
		{
			$content .= "\n\tpublic function executeEdit".$docName."()\n".
			"\t{\n".
			"\t\tBackendService::objectEdit('".$moduleName."', '".$docName."', \$this);\n".
			"\t}\n";
		}
	}
	$content .= "\n}";
	return $content;
}

function createXMLContent($kind, $moduleName, $documents)
{
	ini_set("memory_limit","2048M");
	if ($kind == 'blocks')
	{
		$content =
		'<?xml version="1.0" encoding="UTF-8"?>'."\n".
		'<blocks>'."\n".
		"\n".
		"\t".'<!--<block label="'.ucfirst($moduleName).' xxx" id="'.$moduleName.'/yyy" parameters="zzz=0" />-->'."\n".
		"\n".
		'</blocks>';
	}
	else if ($kind == 'left')
	{
		$content =
		'<?xml version="1.0" encoding="UTF-8"?>'."\n".
		'<objects>'."\n".
		"\n".
		"\t".'<object commands="createFolder">Rootfolder</object>'."\n".
		"\t".'<object commands="createFolder">Folder</object>'."\n";
		foreach ($documents as $docName)
		{
			$content .= "\t".'<object commands="">'.$docName.'</object>'."\n";
		}
		$content .=
		"\n".
		'</objects>';
	}
	else if ($kind == 'main')
	{
		$content =
		'<?xml version="1.0" encoding="UTF-8"?>'."\n".
		'<objects>'."\n".
		"\n".
		"\t".'<object commands="">Folder</object>'."\n";
		foreach ($documents as $docName)
		{
			$content .= "\t".'<object commands="">'.$docName.'</object>'."\n";
		}
		$content .=
		"\n".
		'</objects>';
	}
	else if ($kind == 'right')
	{
		$content =
		'<?xml version="1.0" encoding="UTF-8"?>'."\n".
		'<objects>'."\n".
		"\n".
		"\t".'<!--<object>[object_name]</object>-->'."\n".
		"\n".
		'</objects>';
	}
	else if ($kind == 'resources')
	{
		$content =
		'<?xml version="1.0" encoding="UTF-8"?>'."\n".
		'<resources>'."\n".
		"\n".
		"\t".'<!--<resource id="Media"/>-->'."\n".
		"\n".
		'</resources>';
	}
	return $content;
}

function createFolder($folder)
{
	ini_set("memory_limit","2048M");
	$path = sfConfig::get('sf_root_dir')."/".$folder."/";
	if (!is_dir($path))
	{
		mkdir($path);
	}
	chmod($path, 0777);
}

function writeContentToFile($fileName, $content)
{
	ini_set("memory_limit","2048M");
	echo_cms_sep();
	if (file_exists($fileName))
	{
		echo_cms_title("File ".$fileName." already exists!");

	}
	else
	{
		if (FileHelper::writeFile($fileName, $content))
		{
			echo_cms($fileName." written successfully\n");
		}
		else
		{
			echo_cms_error("Error writing ".$fileName." !");
		}
	}
	echo_cms_sep();
}

function run_create_module($task, $args)
{
	ini_set("memory_limit","2048M");
	// get configuration
	// define constants
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'backend');
	define('SF_ENVIRONMENT', 'prod');
	define('SF_DEBUG',       false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	if(!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	$createLib = true;
	if (isset($args[1]))
	{
		$createLib = ($args[1] == "lib");
	}
	if (isset($args[0]))
	{
		$moduleName = strtolower($args[0]);
	}
	else
	{
		echo_cms_sep();
		echo_cms_title("\tUsage: symfony create-module <module_name> <lib>");
		echo_cms_sep();
		exit();
	}

	$formFile = sfConfig::get('sf_root_dir')."/config/form.xml";
	if (is_readable($formFile))
	{
		$objects = XMLParser::getXMLdataValues($formFile);
		$objList = array();

		foreach ($objects as $obj)
		{
			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'open'))
			{
				$objName = $obj['attributes']['NAME'];
				$objModule = strtolower($obj['attributes']['MODULE']);
				if (!$objModule)
				{
					$objModule = strtolower(str_replace('I18n', '', $objName));
				}
				if ($objModule == $moduleName)
				{
					$objList[] = $objName;
				}
			}
		}
	}

	if (empty($objList))
	{
		echo_cms_error("\tError: No objects found for module ".$moduleName." in form.xml file!");
		exit();
	}

	if ($createLib)
	{
		$libActionsContent = getActionsContent($moduleName); // class mediaCoreActions extends sfActions

		$sf = $moduleName."Core";
		// Lib folders
		$libFolder = "lib/modules/";
		createFolder($libFolder.$moduleName);
		createFolder($libFolder.$moduleName."/actions");
		createFolder($libFolder.$moduleName."/config");
		createFolder($libFolder.$moduleName."/templates");
		$libActionsFile = $libFolder.$moduleName."/actions/actions.class.php";
		writeContentToFile($libActionsFile, $libActionsContent);
	}
	else
	{
		$sf = "";
	}

	// Creating apps/frontend, apps/backend files...
	$appBackActionsContent = getActionsContent($moduleName, "", "sf", $objList);	// Example: class userActions extends sfActions
	$appFrontActionsContent = getActionsContent($moduleName, "", $sf);				// Example: class newsActions extends newsCoreActions || sfActions

	// Backend folders
	$backFolder = "apps/backend/modules/";
	createFolder($backFolder.$moduleName);
	createFolder($backFolder.$moduleName."/actions");
	createFolder($backFolder.$moduleName."/config");
	createFolder($backFolder.$moduleName."/templates");
	$backActionsFile = $backFolder.$moduleName."/actions/actions.class.php";
	writeContentToFile($backActionsFile, $appBackActionsContent);

	// Frontend folders
	$frontFolder = "apps/frontend/modules/";
	createFolder($frontFolder.$moduleName);
	createFolder($frontFolder.$moduleName."/actions");
	createFolder($frontFolder.$moduleName."/config");
	createFolder($frontFolder.$moduleName."/templates");
	$ftontActionsFile = $frontFolder.$moduleName."/actions/actions.class.php";
	writeContentToFile($ftontActionsFile, $appFrontActionsContent);

	// ------------------------------------------------------------------------------------------
	$configFolder = $backFolder.$moduleName."/config/";

	$leftFile = $configFolder."leftTree.xml";
	$leftContent = createXMLContent("left", $moduleName, $objList);
	writeContentToFile($leftFile, $leftContent);

	$mainFile = $configFolder."mainList.xml";
	$mainContent = createXMLContent("main", $moduleName, $objList);
	writeContentToFile($mainFile, $mainContent);

	$rightFile = $configFolder."rightTree.xml";
	$rightContent = createXMLContent("right", $moduleName, $objList);
	writeContentToFile($rightFile, $rightContent);

	$resourcesFile = $configFolder."resources.xml";
	$resourcesContent = createXMLContent("resources", $moduleName, $objList);
	writeContentToFile($resourcesFile, $resourcesContent);

	$blocksFile = $frontFolder.$moduleName."/config/"."blocks.xml";
	$blocksContent = createXMLContent("blocks", $moduleName, $objList);
	writeContentToFile($blocksFile, $blocksContent);

	echo_cms("Done!");
	echo_cms_sep();
}

/**
 * fixes permissions in a symfony project
 *
 * @example symfony fix-perms
 *
 * @param object $task
 * @param array $args
 */
function run_fix_perms($task, $args)
{
	ini_set("memory_limit","2048M");
	$sf_root_dir = sfConfig::get('sf_root_dir');

	pake_chmod(sfConfig::get('sf_cache_dir_name'), $sf_root_dir, 0777);
	pake_chmod(sfConfig::get('sf_log_dir_name'), $sf_root_dir, 0777);
	pake_chmod(sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.'search', $sf_root_dir, 0777);
	pake_chmod(sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name'), $sf_root_dir, 0777);
	pake_chmod('symfony', $sf_root_dir, 0777);

	$dirs = array(sfConfig::get('sf_cache_dir_name'), sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.sfConfig::get('sf_upload_dir_name'), sfConfig::get('sf_log_dir_name'));
	$dir_finder = pakeFinder::type('dir')->ignore_version_control();
	$file_finder = pakeFinder::type('file')->ignore_version_control();
	foreach ($dirs as $dir)
	{
		pake_chmod($dir_finder, $dir, 0777);
		pake_chmod($file_finder, $dir, 0666);
	}
}

/**
 * clears symfony project cache
 *
 * @example symfony clear-cache
 * @example symfony cc
 *
 * @param object $task
 * @param array $args
 */
function run_clear_cache($task, $args)
{
	ini_set("memory_limit","2048M");
	$cache_dir = sfConfig::get('sf_cache_dir_name');
	if (!file_exists($cache_dir))
	{
		throw new Exception('Cache directory "'.$cache_dir.'" doesn\'t exist.');
	}

	// app
	$main_app = '';
	/*	if (isset($args[0]))
	{
	$main_app = $args[0];
	}*/
	// type (template, i18n or config)
	$main_type = '';
	/*	if (isset($args[1]))
	{
	$main_type = $args[1];
	}*/
	// declare type that must be cleaned safely (with a lock file during cleaning)
	$safe_types = array(sfConfig::get('sf_app_config_dir_name'), sfConfig::get('sf_app_i18n_dir_name'));

	// finder to remove all files in a cache directory
	$finder = pakeFinder::type('file')->ignore_version_control()->discard('.sf');

	// finder to find directories (1 level) in a directory
	$dir_finder = pakeFinder::type('dir')->ignore_version_control()->discard('.sf')->maxdepth(0)->relative();

	// iterate through applications
	$apps = array();
	if ($main_app)
	{
		$apps[] = $main_app;
	}
	else
	{
		$apps = $dir_finder->in($cache_dir);
	}

	echo "sf_cache_objects = ". sfConfig::get('sf_cache_objects'). "\n";
	echo "sf_cache_relations = ". sfConfig::get('sf_cache_relations'). "\n";
	echo "sf_cache_trees = ". sfConfig::get('sf_cache_trees'). "\n";
	echo "\n\n";

	// if param setdo not delete objects from cache!
	if (isset($args[0]))
	{
		// don't delete objcache files
		$objKey = array_search("objcache", $apps);
		if ( is_int($objKey))
		{
			unset($apps[$objKey]);
		}

		// deleting TREE files
		if ($args[0] == "tree")
		{
			echo "Removing TREE CACHE files...\n";
			foreach ($finder->in($cache_dir.'/backend') as $env)
			{
				if ((substr($env, -8) == "Tree.php") || (substr($env, -9) == "Tree.html"))
				{
					echo "Removing: ".$env."\n";
					@unlink($env);
				}
			}
		}

		// deleting REALTIONS cache
		if (substr($args[0], 0, 3) == "rel")
		{
			// finder to remove all files in a cache directory
			$finderRel = pakeFinder::type('file')->ignore_version_control()->discard('.sf')->maxdepth(1);

			// delete RELATIONS files
			echo "Removing RELATIONS CACHE files...\n";
			foreach ($finderRel->in($cache_dir) as $env)
			{
				if (substr($env, -13) == "Relations.php")
				{
					echo "Removing: ".$env."\n";
					@unlink($env);
				}
			}
		}

		// deleting LIST cache
		if (substr($args[0], 0, 4) == "list")
		{
			// finder to remove all files in a cache directory
			$finderList = pakeFinder::type('file')->ignore_version_control()->discard('.sf')->maxdepth(1);

			// delete RELATIONS files
			echo "Removing LIST CACHE files...\n";
			foreach ($finderList->in($cache_dir.'/listscache') as $env)
			{
				echo "Removing: ".$env."\n";
				@unlink($env);
			}
		}
	}
	foreach ($apps as $app)
	{
		if (!is_dir($cache_dir.'/'.$app))
		{
			continue;
		}

		// remove cache for all environments
		foreach ($dir_finder->in($cache_dir.'/'.$app) as $env)
		{
			// which types?
			$types = array();
			if ($main_type)
			{
				$types[] = $main_type;
			}
			else
			{
				$types = $dir_finder->in($cache_dir.'/'.$app.'/'.$env);
			}

			$sf_root_dir = sfConfig::get('sf_root_dir');

			foreach ($types as $type)
			{
				$sub_dir = $cache_dir.'/'.$app.'/'.$env.'/'.$type;

				if (!is_dir($sub_dir))
				{
					continue;
				}

				// remove cache files
				if (in_array($type, $safe_types))
				{
					$lock_name = $app.'_'.$env;
					_safe_cache_remove($finder, $sub_dir, $lock_name);
				}
				else
				{
					pake_remove($finder, $sf_root_dir.'/'.$sub_dir);
				}
			}
		}
	}
}

function run_tags_relations($task, $args)
{
	ini_set("memory_limit","2048M");
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'dev');
	define('SF_DEBUG',       false);
	sfConfig::set("sf_use_relations_cache", false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	echo_cms_title("GENERATING TAGS RELATION CACHE...");

	//if(!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if(!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	//echo_cms_sep();


	$tagRelationsFile = sfConfig::get('sf_root_dir')."/cache/objcache/tagsRelations.php";

	try
	{
		$c = new Criteria();
		$allTags = TagPeer::doSelect($c);

		//echo_cms("Processing tags :");
		$i = 0;
		$content = "<?php \n";

		foreach($allTags as $singleTag)
		{
			$c = new Criteria();
			$c->add(TagrelationPeer::TAG_ID, $singleTag->getId());
			$tagRelations = TagrelationPeer::doSelect($c);

			if($tagRelations)
			{
				$elementsArr = "array(";
				foreach($tagRelations as $tagRelation)
				{
					$elementsArr .= $tagRelation->getId().",";
					$i++;
				}
				$content .= "\$_TagRel['".$singleTag->getTagId()."'] = ". substr($elementsArr, 0 , -1).");\n";
			}

		}

		echo " ====> ".$i." tags cached\n";
		$content .= "\n?>";

		if (FileHelper::writeFile($tagRelationsFile, $content))
		{
			echo_cms($tagRelationsFile." Written successfully");
		}
		else
		{
			echo_cms_error("Error writing ".$tagRelationsFile." !");
		}
		//echo_cms_sep();
	}
	catch(Exception $e)
	{
		echo "Error: ".$e->getMessage();
	}

	sfConfig::set("sf_use_relations_cache", true);
	//echo_cms_sep();
}

function run_url_relations($task, $args)
{
	ini_set("memory_limit","2048M");
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'dev');
	define('SF_DEBUG',       false);
	sfConfig::set("sf_use_relations_cache", false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	echo_cms_title("GENERATING URL RELATION CACHE...");

	if(!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";
	$urlRelationsFile = sfConfig::get('sf_root_dir')."/cache/objcache/urlRelations.php";
	try
	{
		$c = new Criteria();
		$rewriteUrls = UrlrewritePeer::doSelect($c);

		echo_cms("Processing urls :");
		$i  = 0;
		$content = "<?php \n";

		foreach($rewriteUrls as $singleUrl)
		{
			$content .= "\$_UrlRel['".$singleUrl->getlabel()."'] = ".$singleUrl->getPageId().";\n";
			$i++;
		}

		echo " ====> ".$i." urls cached\n";
		$content .= "\n?>";

		if (FileHelper::writeFile($urlRelationsFile, $content))
		{
			echo_cms($urlRelationsFile." Written successfully");
		}
		else
		{
			echo_cms_error("Error writing ".$urlRelationsFile." !");
		}
		//echo_cms_sep();
	}
	catch(Exception $e)
	{
		echo "Error: ".$e->getMessage();
	}

	sfConfig::set("sf_use_relations_cache", true);
	//echo_cms_sep();
}

function run_generate_cache($task, $args)
{

	ini_set("memory_limit","2048M");
	ini_set("display_errors", 1);
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         'frontend');
	define('SF_ENVIRONMENT', 'dev');
	define('SF_DEBUG',       false);
	sfConfig::set("sf_use_relations_cache", false);

	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	$databaseManager = new sfDatabaseManager();
	$databaseManager->initialize();

	run_url_relations($task, $args);
	run_tags_relations($task, $args);

	echo_cms_title("GENERATING CACHE...");

	if(!class_exists("XMLParser")) include sfConfig::get('sf_root_dir')."/lib/tools/XMLParser.class.php";
	if(!class_exists("FileHelper")) include sfConfig::get('sf_root_dir')."/lib/helper/FileHelper.php";

	//echo_cms_sep();
	echo_cms("sf_cache_objects = ". sfConfig::get('sf_cache_objects'));
	echo_cms("sf_cache_relations = ". sfConfig::get('sf_cache_relations'));
	echo_cms("sf_cache_trees = ". sfConfig::get('sf_cache_trees'));
	//echo_cms_sep();

	if (count($args) > 0)
	{
		$relationsFlag = substr($args[0], 0, 3) == "rel";
		$listsFlag = substr($args[0], 0, 4) == "list";

		$cacheModel = $args[0];
		if (is_numeric($cacheModel))
		{
			$obj = Document::getDocumentInstance($cacheModel);
			if ($obj)
			{
				$phpName = get_class($obj);
			}
			else
			{
				echo_cms_error("Object with ID=".$cacheModel." not found!");
				exit();
			}
		}
	}
	// parse schema file to make Schema.class.php
	$objects = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/config/schema.xml");
	$schemaFile = sfConfig::get('sf_root_dir')."/config/Schema.class.php";
	$content = $content = "<?php\n class Schema\n{\n\n";
	echo_cms("Building ".$schemaFile."... ");
	foreach ($objects as $obj)
	{
		if (($obj['tag'] == 'TABLE') && ($obj['type'] == 'open'))
		{
			$table = $obj['attributes']['PHPNAME'];
			if ($phpName && ($phpName == $table))
			{
				$tableName = $obj['attributes']['NAME'];
			}

			// if object is not I18nget caching Trees for it
			//			if (substr($tabele, -4) != '"I18n')
			{
				$trees = explode(",", $obj['attributes']['TREE']);

				$content .= "\tpublic static function get".$table."Trees()\n\t{\n";
				$content .= "\t\treturn array(";
				foreach ($trees as $tree)
				{
					$content .= "'".strtolower($tree)."', ";
				}
				$content = substr($content, 0, -2);
				$content .= ");\n\t}\n\n";
			}
			$content .= "\tpublic static function get".$table."Properties()\n\t{\n";
			$content .= "\t\treturn array(";
		}

		if (($obj['tag'] == 'COLUMN') && ($obj['type'] == 'complete'))
		{
			$property = $obj['attributes']['NAME'];
			$getProperty = UtilsHelper::convertFieldName($property);
			$content .= "'".$getProperty."', ";
		}

		if (($obj['tag'] == 'TABLE') && ($obj['type'] == 'close'))
		{
			$content = substr($content, 0, -2);
			$content .= ");\n\t}\n\n";
		}
	}
	$content .= "\n}";
	//echo_cms_sep();
	if (FileHelper::writeFile($schemaFile, $content))
	{
		echo_cms($schemaFile." writen successfully!");
	}
	else
	{
		echo_cms_error("Error writing ".$schemaFile."!");
	}
	echo "\n";
	//echo_cms_sep();

	if (substr($args[0], 0, 5) == "schema")
	{
		echo_cms(" Done!");;
		exit();
	}

	if (!$relationsFlag && !$listsFlag)
	{
		try
		{
			if (is_numeric($cacheModel))
			{
				$obj = array();
				$obj['tag'] = 'OBJECT';
				$obj['type'] = 'complete';
				$obj['id'] = $cacheModel;
				$objects = array($obj);
				$exit = true;
			}
			elseif ($cacheModel)
			{
				$obj = array();
				$obj['tag'] = 'OBJECT';
				$obj['type'] = 'complete';
				$obj['value'] = $cacheModel;
				$objects = array($obj);
				$exit = true;
			}
			else
			{
				$objects = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/config/cachedObjects.xml");
			}

			foreach ($objects as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
				{
					if ($id = $obj['id'])
					{
						$obj = Document::getDocumentInstance($id);
						$model = get_class($obj);
						$c = new Criteria();
						$c->add($tableName.'.ID', $id);
					}
					else
					{
						$model = $obj['value'];
						$c = new Criteria();
					}
					$classPeer = ucfirst($model)."Peer";
					//$c = new Criteria();
					//$results = call_user_func(array($classPeer, 'doSelect'), $c);
					$peerMethod = "doSelect";

					$results = call_user_func(array($classPeer, $peerMethod), $c);

					echo_cms("  Caching ".$model." documents");
					$ind = 0;
					foreach ($results as $result)
					{
						if($ind%20 == 0)
						{
							echo $ind."  .\r";
						}
						else if($ind%10 == 0)
						{
							echo $ind."  o\r";
						}
						$ind++;
						Document::cacheObj($result, $model, false);
					}
					echo_cms(" ====> ".$ind." ".$model." Document(s) cached.");
					//echo_cms_sep();
				}
			}
			if ($exit) exit();
		}
		catch (Expection $e)
		{
			echo_cms_error(" Error: $e");
		}
	}

	if (!$listsFlag)
	{
		echo "\n";
		//echo_cms_sep();
		echo_cms("Writing relations cache");

		Relation::checkRelationCache('lock');
		try
		{
			$c = new Criteria();
			$c->addAscendingOrderByColumn('id1');
			$c->addAscendingOrderByColumn('document_model2');
			$c->addAscendingOrderByColumn('sort_order');
			$relations = RelationPeer::doSelect($c);
			$relationsFile = sfConfig::get('sf_root_dir')."/cache/objcache/childrenRelations.php";

			echo_cms("Processing children :");
			$i = 0;
			$content = "<?php \n";
			$oldIDModel = ''; $currIDModel = ''; $idStr = '';

			foreach ($relations as $relation)
			{
				$currIDModel = $relation->getId1().':'.$relation->getDocumentModel2();
				if ($i == 0)
				{
					$oldIDModel = $currIDModel;
				}

				$i++;
				echo $i."\t\t\r";
				if ($currIDModel == $oldIDModel)
				{
					$idStr .= ",".$relation->getId2();
				}
				else
				{
					$idStr = substr($idStr, 1);
					$content .= "\$_Rel[".$oldId1."][\"".$oldModel2."\"] = explode(\",\", \"".$idStr."\");\n";
					$idStr = ",".$relation->getId2();
				}
				$oldIDModel = $currIDModel;
				$oldId1 = $relation->getId1();
				$oldModel2 = $relation->getDocumentModel2();
			}
			if ($idStr)
			{
				$idStr = substr($idStr, 1);
				$content .= "\$_Rel[".$oldId1."][\"".$oldModel2."\"] = explode(\",\", \"".$idStr."\");\n";
			}
			echo "\n";
			$content .= "\n?>";

			//echo_cms_sep();
			if (FileHelper::writeFile($relationsFile, $content))
			{
				echo_cms($relationsFile." written successfully");
			}
			else
			{
				echo_cms_error("Error writing ".$relationsFile." !");
			}
			//echo_cms_sep();
		}
		catch(Exception $e)
		{
			echo "Error: ".$e->getMessage();
		}
		Relation::checkRelationCache('unlock');
	}

	if (!$relationsFlag)
	{
		echo "\n";
		//echo_cms_sep();
		echo_cms_title("Writing Lists cache");

		$listsRootFolder = Rootfolder::getRootfolderByModule("lists");
		if ($listsRootFolder)
		{
			$lists = Document::getChildrenOf($listsRootFolder->getId(), "Lists");
		}

		foreach ($lists as $list)
		{
			$listId = $list->getListId();

			echo "\t\tprocessing \"".$listId."\" list ...";

			$listPath = sfConfig::get('sf_root_dir')."/cache/listscache/".$listId.".php";
			@unlink($listPath);

			$content = "<?php \n";
			$content .= "\$listItemsForSelect = array(\n";

			$items = Lists::getListitemsForSelect($listId, array(), false);
			foreach ($items as $key => $item)
			{
				$content .= "\"".str_replace("\"", "\\\"", $key)."\" => \"".str_replace("\"", "\\\"", $item)."\",\n";
			}
			$content .= ");\n?>";

			if (FileHelper::writeFile($listPath, $content))
			{
				echo_cms(" Done!");
			}
			else
			{
				echo_cms_error(" Error!");
			}
		}
		//echo_cms_sep();
	}
	sfConfig::set("sf_use_relations_cache", true);
}

/**
 * clears all controllers in your web directory other than one running in a produciton environment
 *
 * @example symfony clear-controllers
 *
 * @param object $task
 * @param array $args
 */
function run_clear_controllers($task, $args)
{
	ini_set("memory_limit","2048M");
	$web_dir = sfConfig::get('sf_web_dir');
	$app_dir = sfConfig::get('sf_app_dir');

	$apps = count($args) > 1 ? $args : null;

	// get controller
	$controllers = pakeFinder::type('file')->ignore_version_control()->maxdepth(1)->name('*.php')->in($web_dir);

	foreach ($controllers as $controller)
	{
		$contents = file_get_contents($controller);
		preg_match('/\'SF_APP\',[\s]*\'(.*)\'\)/', $contents, $found_app);
		preg_match('/\'SF_ENVIRONMENT\',[\s]*\'(.*)\'\)/', $contents, $env);

		// remove file if it has found an application and the environment is not production
		if (isset($found_app[1]) && isset($env[1]) && $env[1] != 'prod')
		{
			pake_remove($controller, '');
		}
	}
}

/**
 * safely removes directory via pake
 *
 * @param object $finder
 * @param string $sub_dir
 * @param string $lock_name
 */
function _safe_cache_remove($finder, $sub_dir, $lock_name)
{
	ini_set("memory_limit","2048M");
	$sf_root_dir = sfConfig::get('sf_root_dir');

	// create a lock file
	pake_touch($sf_root_dir.'/'.$lock_name.'.lck', '');

	// change mode so the web user can remove it if we die
	pake_chmod($lock_name.'.lck', $sf_root_dir, 0777);

	// remove cache files
	pake_remove($finder, $sf_root_dir.'/'.$sub_dir);

	// release lock
	pake_remove($sf_root_dir.'/'.$lock_name.'.lck', '');
}

/**
 * forces rotation of the given log file
 *
 * @example symfony log-rotate
 *
 * @param object $task
 * @param array $args
 */
function run_log_rotate($task, $args)
{
	ini_set("memory_limit","2048M");
	// handling two required arguments (application and environment)
	if (count($args) < 2)
	{
		throw new Exception('You must provide the environment of the log to rotate');
	}
	$app = $args[0];
	$env = $args[1];

	// define constants
	define('SF_ROOT_DIR',    sfConfig::get('sf_root_dir'));
	define('SF_APP',         $app);
	define('SF_ENVIRONMENT', $env);
	define('SF_DEBUG',       true);

	// get configuration
	require_once SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';

	sfLogManager::rotate($app, $env, sfConfig::get('sf_logging_period'), sfConfig::get('sf_logging_history'), true);
}

/**
 * purges the application log directory as per settings in logging.yml
 *
 * @example symfony log-purge
 *
 * @param object $task
 * @param array $args
 */
function run_log_purge($task, $args)
{
	ini_set("memory_limit","2048M");
	$sf_symfony_data_dir = sfConfig::get('sf_symfony_data_dir');

	$default_logging = sfYaml::load($sf_symfony_data_dir.'/config/logging.yml');
	$app_dir = sfConfig::get('sf_app_dir');
	$apps = pakeFinder::type('dir')->maxdepth(0)->relative()->ignore_version_control()->in('apps');
	$ignore = array('all', 'default');

	foreach ($apps as $app)
	{
		$logging = sfYaml::load($app_dir.'/'.$app.'/config/logging.yml');
		$logging = array_merge($default_logging, $logging);

		foreach ($logging as $env => $config)
		{
			if (in_array($env, $ignore))
			{
				continue;
			}
			$props = array_merge($default_logging['default'], is_array($config) ? $config : array());
			$active = isset($props['active']) ? $props['active'] : true;
			$purge  = isset($props['purge']) ? $props['purge'] : true;
			if ($active && $purge)
			{
				$filename = sfConfig::get('sf_log_dir').'/'.$app.'_'.$env.'.log';
				if (file_exists($filename))
				{
					pake_remove($filename, '');
				}
			}
		}
	}
}

function run_enable($task, $args)
{
	ini_set("memory_limit","2048M");
	// handling two required arguments (application and environment)
	if (count($args) < 2)
	{
		throw new Exception('You must provide an environment for the application.');
	}

	$app = $args[0];
	$env = $args[1];

	$lockFile = $app.'_'.$env.'.clilock';
	$locks = pakeFinder::type('file')->prune('.svn')->discard('.svn')->maxdepth(0)->name($lockFile)->relative()->in('./');

	if (file_exists(sfConfig::get('sf_root_dir').'/'.$lockFile))
	{
		pake_remove($lockFile, '');
		run_clear_cache($task, array());
		pake_echo_action('enable', "$app [$env] has been ENABLED");

		return;
	}

	pake_echo_action('enable', "$app [$env] is currently ENABLED");
}

function run_disable($task, $args)
{
	ini_set("memory_limit","2048M");
	// handling two required arguments (application and environment)
	if (count($args) < 2)
	{
		throw new Exception('You must provide an environment for the application.');
	}

	$app = $args[0];
	$env = $args[1];

	$lockFile = $app.'_'.$env.'.clilock';

	if (!file_exists(sfConfig::get('sf_root_dir').'/'.$lockFile))
	{
		pake_touch(sfConfig::get('sf_root_dir').'/'.$lockFile, '777');

		pake_echo_action('enable', "$app [$env] has been DISABLED");

		return;
	}

	pake_echo_action('enable', "$app [$env] is currently DISABLED");

	return;
}