<?php
/**
 * @package    cms
 * @subpackage core media
 * @author     Jordan Hristov / Ilya Popivanov
 */

class mediaCoreActions extends sfActions
{

	public function executeMediaDetail()
	{
		$this->attachment = Document::getDocumentInstance($this->getRequestParameter('id'));
		$this->setLayout(false);
	}

	public function executeFolderDetail()
	{
		$this->setLayout(false);
		$this->images = Document::getChildrenOf($this->getRequestParameter('id'), "Media");
	}

	/**
	* Executes MEDIA display action
	*
	*/
	function executeDisplay()
	{
		$this->setLayout(false);
		$media = Document::getDocumentInstance($this->getRequestParameter('id'));
		$name = $media->getFileName();

		if ($thumbPath = $this->getRequestParameter('thumb'))
		{
			if ($thumbPath == "thumbs")
			{
				$thumbPath = "";
			}
			else if(substr($thumbPath, 0, 8) == "richtext")
			{
				$name = $media->getId()."-".$this->getRequestParameter('freeimg').".".$media->getExtention();
			}

			$thumbPath = str_replace("-", "/", $thumbPath);
			$thumbPath .= "/";

			$location = "Location: http://" . $_SERVER['HTTP_HOST'] . str_replace("\\", "/", $media->getRelativeDirUrl()).'thumbs/'.$thumbPath.$name."?".time();
		}
		else
		{
			$location = "Location: http://" . $_SERVER['HTTP_HOST'] . str_replace("\\", "/", $media->getRelativeUrl())."?".time();
		}
		header($location);
	}

	function executeDownload()
	{
		$media = Document::getDocumentInstance($this->getRequestParameter('id'));
		if ($media && get_class($media) == 'Media')
		{
			$name = $media->getLabel();
			header("Content-Disposition: attachment; filename=\"$name\"");
			header("Content-Type: ".$media->getFiletype());
			//header('Content-type: audio/mpeg3');
			//$location = "Location: http://" . $_SERVER['HTTP_HOST'] . str_replace("\\", "/", $media->getRelativeUrl())."?".time();
			$file = $media->getServerAbsoluteUrl();
			readfile($file);
		}
		exit();
	}

	private function getPager($c = null, $nbr = 4)
	{
		if (!is_null($c))
		{
			$pager = new sfPropelPager('Relation', $nbr);
			$pager->setCriteria($c);
			$pager->setPage($this->getRequestParameter('page', 1));
			$pager->init();
		}

		return $pager;
	}

	public function executeGallery()
	{
		$params = $this->getRequestParameter('params');
		if ($params['type'])
		{
			$galleryFolder = Document::getDocumentByExclusiveTag("media_gallery_".$params['type']);
			$this->tag = "media_gallery_".$params['type'];
		}
		else
		{
			$galleryFolder = Document::getDocumentByExclusiveTag("media_gallery_pic");
			$this->tag = "media_gallery_pic";
		}

		if ($galleryFolder)
		{
			$c = new Criteria();
			$c->add(RelationPeer::ID1, $galleryFolder->getId());
			$c->add(RelationPeer::DOCUMENT_MODEL2, "Media");
		}

		$this->setLayout(false);
		$this->pager = $this->getPager($c, 8);
	}

/*	public function executePageGallery()
	{
		$this->setLayout(false);
		$id = $this->getRequestParameter('pageref');
		$page = Document::getDocumentInstance($id);
		if ($page)
		{
			$this->images = Document::getChildrenOf($id, "Media");
			$this->galleryLabel = $page->getGalleryLabel();
		}
	}*/

	public function executeForceDownload()
	{
		set_time_limit(0);

		$baseDir = $this->getRequestParameter('dir');
		$baseDir = "./".str_replace("DIR_SEP", "/", $baseDir);
		if(substr($baseDir, -1) != "/") $baseDir .= "/";

		$defWebsite = Document::getDocumentByExclusiveTag("website_website_default");
		if($defWebsite)
		{
			$allowed_referrer = $defWebsite->getUrl();
			if(empty($allowed_referrer))
				FileHelper::Log("Default website URL is not defined", UtilsHelper::MSG_ERROR);
		}
		else
		{
			FileHelper::Log("website_website_default tag is not defined", UtilsHelper::MSG_ERROR);
		}

		$allowed_ext = array (
		'zip' => 'application/zip',
		'pdf' => 'application/pdf',
		'doc' => 'application/msword',
		'xls' => 'application/vnd.ms-excel',
		'ppt' => 'application/vnd.ms-powerpoint',
		'exe' => 'application/octet-stream',
		'gif' => 'image/gif',
		'png' => 'image/png',
		'jpg' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'mp3' => 'audio/mpeg',
		'wav' => 'audio/x-wav',
		'mpeg' => 'video/mpeg',
		'3gp' => 'video/3gpp',
		'mpg' => 'video/mpeg',
		'mpe' => 'video/mpeg',
		'mov' => 'video/quicktime',
		'avi' => 'video/x-msvideo'
		);

		// If hotlinking not allowed then make hackers think there are some server problems
		//if ((!isset($_SERVER['HTTP_REFERER']) || strpos(strtoupper($_SERVER['HTTP_REFERER']), strtoupper($allowed_referrer)) === false))
		//{
			//die("Internal server error. Please contact system administrator.");
		//}
		if (!$this->getRequestParameter('file'))
		{
			die("Please specify file name for download.");
		}

		$fname = basename($this->getRequestParameter('file'));
		function find_file ($dirname, $fname, &$file_path)
		{
			$dir = opendir($dirname);
			while ($file = readdir($dir))
			{
				if (empty($file_path) && $file != '.' && $file != '..')
				{
					if (is_dir($dirname.'/'.$file))
					{
						find_file($dirname.'/'.$file, $fname, $file_path);
					}
					else
					{
						if (file_exists($dirname.'/'.$fname))
						{
							$file_path = $dirname.'/'.$fname;
							return;
						}
					}
				}
			}
		}

		$file_path = '';
		find_file($baseDir, $fname, $file_path);

		if (!is_file($file_path))
		{
			die("File does not exist. Make sure you specified correct file name.");
		}

		$fsize = filesize($file_path);
		$fext = strtolower(substr(strrchr($fname,"."), 1));
		if (!array_key_exists($fext, $allowed_ext))
		{
			die("File type not allowed.");
		}

		if ($allowed_ext[$fext] == '')
		{
			$mtype = '';
			if (function_exists('mime_content_type'))
			{
				$mtype = mime_content_type($file_path);
			}
			else if (function_exists('finfo_file'))
			{
				$finfo = finfo_open(FILEINFO_MIME);
				$mtype = finfo_file($finfo, $file_path);
				finfo_close($finfo);
			}

			if ($mtype == '')
			{
				$mtype = "application/force-download";
			}
		}
		else
		{
			$mtype = $allowed_ext[$fext];
		}

		if(!$this->getRequestParameter('newname'))
		{
			$asfname = $fname;
		}
		else
		{
			$asfname = str_replace(array('"',"'",'\\','/'), '', $this->getRequestParameter('newname'));
			if ($asfname === '') $asfname = 'NoName';
		}

		$headers = get_headers($_SERVER['HTTP_REFERER'], 1);

		if(!$headers) die("Internal server error. Please contact system administrator.");

		/*header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");*/
		header("Content-Type: $mtype");
		header("Content-Disposition: attachment; filename=\"$asfname\"");
		//header("Content-Transfer-Encoding: binary");
		//header("Content-Length: " . $fsize);

		$file = @fopen($file_path,"rb");
		if ($file)
		{
			while(!feof($file))
			{
				print(fread($file, 1024*8));
				flush();
				if (connection_status()!=0)
				{
					@fclose($file);
					die();
				}
			}
			@fclose($file);
		}

		header("Content-Type: text/html; charset=utf-8");
		header("Content-Disposition: inline");
	}
}