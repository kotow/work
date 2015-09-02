<?php
class FileHelper
{
	//===================================================================================================================== CONSTANTS
	const MUTEXT_LOCK = 1;
	const MUTEXT_UNLOCK = 0;
	const MUTEXT_RELEASED = 2;
	
	public static function Mutex($mutex, $operation)
	{
		$path = sfConfig::get('sf_root_dir') . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
		$file = $path.$mutex.'.lck';
		switch ($operation)
		{
			case 0: // unlock
			{
				@unlink($file);
				return;
			}
			case 1: // lock
			{
				while (!($fp = @fopen($file, 'x')))
				{
					;
				}
				fclose($fp);
				return;
			}
			case 2: // check released
			{
				$fp = @fopen($file, 'x');
				if ($fp)
				{
					fclose($fp);
					@unlink($file);
					return 1;
				}
				return 0;
			}
		}
	}

	public static function Log($message, $type =  UtilsHelper::MSG_INFO)
	{
		switch ($type)
		{
			case UtilsHelper::MSG_INFO:
				$logFile = sfConfig::get('sf_root_dir')."/log/info_log.txt";
				break;
			case UtilsHelper::MSG_ERROR:
				$logFile = sfConfig::get('sf_root_dir')."/log/error_log.txt";
				break;
			case UtilsHelper::USE_DEBUG:
				$logFile = sfConfig::get('sf_root_dir')."/log/debug_log.txt";
				break;
		}

		if (!is_readable($logFile))
		{
			self::writeFile($logFile, "", false);
		}
		self::writeFile($logFile, date("d.m.Y H:i:s", time())." ==> ".$message."\n", true);
	}

	public static function generatePdfFromHtml($html, $toFile = null, $orientation = "portrait", $paper = "letter")
	{
		if (is_null($toFile))
		{
			$toFile = sfConfig::get('sf_symfony_web_dir')."/media/pdf/".uniqid(rand()).".pdf";
		}

		require_once(sfConfig::get('sf_symfony_lib_dir')."/pdf/dompdf_config.inc.php");
		if ( get_magic_quotes_gpc() ) $html = stripslashes($html);

		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper($paper, $orientation);
		$dompdf->render();
		$dompdf->stream($toFile);

		//return $toFile;
	}

	public static function writeFile($filename, $content = null , $keepData = false)
	{
		$keepData ? $mode = "a+" : $mode = "w+";

		if (!$handle = fopen($filename, $mode))
		{
			return false;
		}

		if (fwrite($handle, $content) === FALSE)
		{
			return false;
		}

		fclose($handle);
		@chmod($filename, 0777);
		return true;
	}

	public static function searchInFolder($folder, $file_name, $recursive = true)
	{
		if(substr($folder,-1) != "/") $folder .= "/";

		//search for file in given folder
		if (is_file($folder.$file_name))
		{
			return $folder.$file_name;
		}
		else if($recursive)
		{
			//if file not foud at 1ast level try to open given folder
			if(($dir=@opendir($folder)) === false)
			{
				return false;
			}

			while($name = @readdir($dir))
			{
				//if($name === '.' or $name === '..') continue;
				if(substr($name, 0, 1) == '.') continue;

				$subFolder = $folder.$name;
				$fullFileName = $subFolder . "/" . $file_name;

				if(!is_dir($subFolder))  continue;

				$found = searchInFolder($subFolder, $file_name);
				if ($found) return $found;
			}
		}

		return false;
	}

	public static function getSubElements($folder, $retrieve = "all")
	{
		if(substr($folder,-1) != "/") $folder .= "/";

		if(($dir= opendir($folder)) === false)
		{
			return false;
		}

		while($name = @readdir($dir))
		{
			if(substr($name,0,1) == '.') continue;

			$element = $folder.$name;

			switch ($retrieve)
			{
				case "all": $result[$name] = $element;
				break;
				case "folder": if(is_dir($element)) $result[$name] = $element;
				break;
				case "file": if(is_file($element)) $result[$name] = $element;
				break;
			}
		}
		return $result;
	}

}