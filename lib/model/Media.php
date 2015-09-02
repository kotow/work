<?php
/**
 * Subclass for representing a row from the 'm_media' table.
 * @package lib.model
 */

class Media extends BaseMedia
{

	public static function displayThumb($id, $width, $height, $floatbox = true, $class = false, $element_id = false, $style = false)
	{
		$html = "";
		$force_height = null;
		$force_width = null;
		$media = Document::getDocumentInstance($id);
		if(!$media) return false;
		list($thumb_width, $thumb_height) = getimagesize($media->getServerAbsoluteThumbUrl());

		$img_ratio = $thumb_width / $thumb_height;
		$box_ratio = $width / $height;

		if($thumb_width > $width || $thumb_height > $height)
		{
			if($img_ratio > $box_ratio) // image thiner
			{
				$ratio = $thumb_width / $width;
				$thumb_width = $force_width = $width;
				$thumb_height = $force_height = $thumb_height / $ratio;
			}
			else
			{
				$ratio = $thumb_height / $height;
				$thumb_height = $force_height = $height;
				$thumb_width = $force_width = $thumb_width / $ratio;
			}
		}

		$margin_h = ($height-$thumb_height)/2;
		$margin_w = ($width-$thumb_width)/2;

		$style .= "margin:".$margin_h."px ".$margin_w."px";

		if($floatbox) 		$html .= "<a href='".$media->getRelativeUrl()."' rel='example_group'>";
							$html .= "<img src='".$media->getRelativeThumbUrl()."' border='0'";

		if($force_height) 	$html .= " height='$force_height'";
		if($force_width) 	$html .= " width='$force_width'";

		if($class) 			$html .= " class='$class'";
		if($element_id)		$html .= " id='$element_id'";
		if($style) 			$html .= " style='$style'";
							$html .= ">";
		if($floatbox) 		$html .= "</a>";
		return $html;
	}

	public static function mime_content_type($fileName)
	{
		if (stristr($_SERVER['SERVER_SOFTWARE'], 'win'))
		{
			$mime = array(
				'.bmp' => 'image/bmp',
				'.jpg' => 'image/jpeg',
				'.png' => 'image/png',
				'.gif' => 'image/gif',
				'.jpeg' => 'image/jpeg',
			);
			$extension = strtolower(self::getExtention($fileName));
			return $mime[$extension];
		}
		else
		{
			$fileName = escapeshellarg($fileName);
			$res = trim(`file -bi $fileName`);
			$ext = explode(';', $res);
			return $ext[0];
		}
	}

	public static function upload($fieldName, $to = "upload", $accept = array())
	{
		$request = sfContext::getInstance()->getRequest();
		if (strpos($fieldName, '/') === false)
		{
			$fileName =	$request->getFileName($fieldName);
			$filePath =	$request->getFilePath($fieldName);
			$error = $request->getFileValue($fieldName, "error");
			$real_file = false;
		}
		else
		{
			$fileName = $fieldName;
			$filePath = $fieldName;
			$error = 0;
			$real_file = true;
		}

		$fileType = self::mime_content_type($filePath);
		$fileTypes = explode(";", $fileType);
		$fileType = array_shift($fileTypes);
		if ( $error = $request->getFileValue($fieldName, "error") )
		{
			switch ($error)
			{
				case 1: $errorMsg = "UPLOAD_ERR_INI_SIZE"; break;
				case 2: $errorMsg = "UPLOAD_ERR_FORM_SIZE"; break;
				case 3: $errorMsg = "UPLOAD_ERR_PARTIAL"; break;
				case 4: $errorMsg = "UPLOAD_ERR_NO_FILE"; break;
				case 5: $errorMsg = "UPLOAD_ERR_NO_TMP_DIR"; break;
				case 6: $errorMsg = "UPLOAD_ERR_CANT_WRITE"; break;
			}
		}

		if (!empty($accept))
		{
			if (!empty($fileName) && !in_array($fileType, $accept))
			{
				throw new Exception("UPLOAD_ERR_WRONG_FILE_TYPE");
			}
		}

		if ($request->getParameter('parent'))
		{
			$parent = Document::getDocumentInstance($request->getParameter('parent'));
		}
		else
		{
			$parent = Rootfolder::getRootfolderByModule('media');
		}

		$len = strlen(DIRECTORY_SEPARATOR);
		if (substr($to, -$len, $len) != DIRECTORY_SEPARATOR)
			$to = $to.DIRECTORY_SEPARATOR;
		//TODO
		$toPath = '/Applications/MAMP/trademark/httpdocs/media/upload/';//self::getMediaPath().$to;//
		$dirs = explode(DIRECTORY_SEPARATOR, $toPath); $thumbDir = '';
		foreach ($dirs as $dir)
		{
			$thumbDir .= $dir.DIRECTORY_SEPARATOR;
			try
			{
				if (!is_dir($thumbDir))
				{
					mkdir($thumbDir, 0777, true);
				}
			}
			catch (Exception $e)
			{
				throw new Exception("UPLOAD_ERR_CANT_CREATE_DIR");
			}
		}

		if (!$request->getParameter('id'))
		{
			if ($error)
			{
				throw new Exception($errorMsg);
			}
			$media = new Media();
			$media->save(null, $parent, false);
		}
		else
		{
			if ($error && ($error != 4) && !empty($fileName))
			{
				throw new Exception($errorMsg);
			}
			$media = Document::getDocumentInstance($request->getParameter('id'));

			if(!$media || get_class($media) != "Media")
			{
				$media = new Media();
				$media->save(null, $parent, false);
			}
			elseif ($error != 4)
			{
				if (file_exists( $file = $media->getServerAbsoluteUrl() ))
				{
					@unlink($file);
				}
				if (file_exists( $thumb = $media->getServerAbsoluteThumbUrl() ))
				{
					@unlink($thumb);
				}
			}
		}

		$ext = $media->getExtention($fileName);
		$extLen = strlen($ext);

		$saveFileName = $media->getId().".".$ext;
		if ($real_file)
		{
			@copy($fileName, $toPath.$saveFileName);
			@chmod($toPath.$saveFileName, 0777);
			@copy($fileName, $toPath.'thumbs'.DIRECTORY_SEPARATOR.$saveFileName);
			@chmod($toPath.'thumbs'.DIRECTORY_SEPARATOR.$saveFileName, 0777);
		}
		else
		{
			$request->moveFile($fieldName, $toPath.$saveFileName);
			@chmod($toPath.$saveFileName, 0777);
		}
		$media->setFilesize( filesize($toPath.$saveFileName) );
		if (!$request->getParameter('attrLabel'))
			$media->setLabel($fileName);
		else
			$media->setLabel($request->getParameter('attrLabel'));
		$media->setDescription($request->getParameter('attrDescription'));

		if ($fileName != "")
		{
			$media->setFilename($saveFileName);
			$media->setFiledirpath(str_replace("\\", DIRECTORY_SEPARATOR, $to));
			$media->setFiletype($fileType);
		}

		$media->save(null, $parent);
		return $media;
	}

	public function saveFlv($height = null, $width = null)
	{
		if (is_null($width))
		{
			$width = 320;
		}
		if (is_null($height))
		{
			$height = 240;
		}

		$destFolder = $this->getServerAbsoluteDirUrl()."flv".DIRECTORY_SEPARATOR;
		$image_destFolder = $destFolder."thumbs".DIRECTORY_SEPARATOR;

		$output_image = $image_destFolder.$this->getId().".jpg";
		$output_flv = $destFolder.$this->getId().".flv";

		if(!is_dir($destFolder))
		{
			mkdir($destFolder);
		}

		if(!is_dir($image_destFolder))
		{
			mkdir($image_destFolder);
		}

		if(file_exists($output_image))
		{
			unlink($output_image);
		}

		if(file_exists($output_flv))
		{
			unlink($output_flv);
		}

		exec('ffmpeg -i '.$this->getServerAbsoluteUrl().' -vcodec mjpeg -vframes 1 -an -f rawvideo -s '.$width.'x'.$height.' -ss 4 '.$output_image);
		if (rename($this->getServerAbsoluteUrl(), $output_flv))
		{
			$this->setFiledirpath($this->getFiledirpath()."flv".DIRECTORY_SEPARATOR);
			$this->setFilename($this->getId().".flv");
			$this->save();
		}
	}

	public function convertToFlv($height = null, $width = null)
	{
		if (is_null($width)) $width = 320;
		if (is_null($height)) $height = 240;

		$destFolder = $this->getServerAbsoluteDirUrl()."flv".DIRECTORY_SEPARATOR;
		$image_destFolder = $destFolder."thumbs".DIRECTORY_SEPARATOR;

		$output_image= $image_destFolder.$this->getId().".jpg";
		$output_flv = $destFolder.$this->getId().".flv";

		if (!is_dir($destFolder))
		{
			mkdir($destFolder, 0777, true);
		}

		if(!is_dir($image_destFolder))
		{
			mkdir($image_destFolder, 0777, true);
		}

		if (file_exists($output_image))
		{
			unlink($output_image);
		}

		if (file_exists($output_flv))
		{
			unlink($output_flv);
		}

		$command =  "ffmpeg -i ".$this->getServerAbsoluteUrl()." -ar 22050 -ab 32 -f flv -s ".$width."x".$height." -qcomp 0.6 -qmax 15 -qdiff 4 -i_qfactor 0.71428572 -b_qfactor 0.76923078 ".$output_flv;
		exec($command);

		if (unlink($this->getServerAbsoluteUrl()))
		{
			$this->setFiledirpath($this->getFiledirpath()."flv".DIRECTORY_SEPARATOR);
			$this->setFiletype("video/x-flv");
			$this->setFilename($this->getId().".flv");
			$this->save();
		}

		$mov = new ffmpeg_movie($this->getServerAbsoluteUrl());
		if($mov) $ff_frame = $mov->getFrame(100);
		if ($ff_frame)
		{
			$gd_image = $ff_frame->toGDImage();
			if ($gd_image)
			{
				imagejpeg($gd_image, $output_image);
			}
		}
	}

	public function getExtention($str = null)
	{
		if(!$str && $this) $str = $this->getFilename();
		$pos = strrpos($str, ".");
		$ext = substr($str, $pos+1);
		return $ext;
	}

	public function resizeImage($thumb = null, $height = null, $width = null, $newname = null, $cropData = array(0,0))
	{
		$ext = $this->getExtention();
		$extLen = strlen($ext);

		if(is_null($newname))
		{
			$newname = substr($this->getFilename(), 0, 0-$extLen).$ext;
		}
		else
		{
			$newname = $this->getId()."-".$newname.".".$ext;
		}

		if($thumb == "thumbs")
		{
			$thumbDir = $this->getServerAbsoluteDirUrl()."thumbs".DIRECTORY_SEPARATOR;
			if (!is_dir($thumbDir))
			{
				mkdir($thumbDir, 0777, true);
			}

			$fileThumbFullPath = $thumbDir.$newname;
		}
		else if(!is_null($thumb))
		{
			$thumbDir = $this->getServerAbsoluteDirUrl()."thumbs".DIRECTORY_SEPARATOR;

			if($thumb !== 1)
			{
				$thumbDir .= $thumb.DIRECTORY_SEPARATOR;
			}

			if (!is_dir($thumbDir))
			{
				mkdir($thumbDir, 0777, true);
			}

			$fileThumbFullPath = $thumbDir.$newname;
		}
		else
		{
			$fileThumbFullPath = $this->getServerAbsoluteUrl();
		}

		$type = self::mime_content_type($this->getServerAbsoluteUrl());

		switch($type)
		{
			case "image/jpeg"		:
			case "image/pjpeg"		:	$function_image_create = "ImageCreateFromJpeg"; $function_image_new = "ImageJpeg";break;

			case "image/png"		:
			case "image/x-png"		:	$function_image_create = "ImageCreateFromPng"; $function_image_new = "ImagePng";break;

			case "image/gif"		:	$function_image_create = "ImageCreateFromGif"; $function_image_new = "ImageGif";break;

			default					:	throw new Exception("invalide image");
		}

		list($originalWidth, $originalHeight) = getimagesize($this->getServerAbsoluteUrl());
		$ratio = $originalHeight/$originalWidth;

		if (is_null($height) && is_null($width))
		{
			$newheight = $originalHeight;
			$newwidth = $originalWidth;
		}
		else if(!is_null($height) && !is_null($width))
		{
			$newheight = $height;
			$newwidth = $width;
		}
		else if(is_null($height) && !is_null($width))
		{
			$newheight = $width*$ratio;
			$newwidth = $width;
		}
		else if(!is_null($height) && is_null($width))
		{
			$newheight = $height;
			$newwidth = $height/$ratio;
		}

		$source = $function_image_create($this->getServerAbsoluteUrl());

		if($cropData[0] > 0 && $cropData[1] > 0)
		{
			$crop_width = $cropData[0];
			$crop_height = $cropData[1];

			$thumbRC = ImageCreateTrueColor($crop_width, $crop_height);
			if($type == "image/png" || $type == "image/x-png")
			{
				imagealphablending($thumbRC, false);
				imagesavealpha($thumbRC, true);
			}

			$wm = $originalWidth / $crop_width;
			$hm = $originalHeight / $crop_height;
			$h_height = $crop_height/2;
			$w_width = $crop_width/2;

			$originalRatio  = $originalWidth/$originalHeight;
			$cropedRatio = $crop_width/$crop_height;

			if ($originalRatio > $cropedRatio)
			{
				$adjusted_width = $originalWidth / $hm;
				$half_width = $adjusted_width / 2;
				$int_width = $half_width - $w_width;

				ImageCopyResampled($thumbRC, $source, -$int_width, 0,0,0, $adjusted_width, $crop_height, $originalWidth, $originalHeight);
			}
			elseif ($originalRatio < $cropedRatio)
			{
				$adjusted_height = $originalHeight / $wm;
				$half_height = $adjusted_height / 2;
				$int_height = $half_height - $h_height;

				ImageCopyResampled($thumbRC, $source, 0,-$int_height,0,0, $crop_width, $adjusted_height, $originalWidth, $originalHeight);
			}
			else
			{
				ImageCopyResampled($thumbRC, $source, 0,0,0,0, $crop_width, $crop_height, $originalWidth, $originalHeight);
			}
		}
		else
		{
			$thumbRC = ImageCreateTrueColor($newwidth, $newheight);

			if($type == "image/png" || $type == "image/x-png")
			{
				imagealphablending($thumbRC, false);
				imagesavealpha($thumbRC, true);
			}

			ImageCopyResampled($thumbRC, $source, 0, 0, 0, 0, $newwidth, $newheight, $originalWidth, $originalHeight);
		}
		if ($function_image_new == "ImageJpeg")
		{
			@$function_image_new($thumbRC, $fileThumbFullPath, 100);
		}
		else
		{
			@$function_image_new($thumbRC, $fileThumbFullPath);
		}
		@chmod($fileThumbFullPath, 0777);
	}

	public function rotateImage($angle)
	{
		$fileFullPath = $this->getServerAbsoluteUrl();
		$type = strtolower($this->getFiletype());

		switch($type)
		{
			case "image/jpeg"		:
			case "image/pjpeg"		:	$function_image_create = "ImageCreateFromJpeg"; $function_image_new = "ImageJpeg";break;

			case "image/png"		:
			case "image/x-png"		:	$function_image_create = "ImageCreateFromPng"; $function_image_new = "ImageJpeg";break;

			case "image/gif"		:	$function_image_create = "ImageCreateFromGif"; $function_image_new = "ImageGif";break;

			default					:	throw new Exception("invalide image");
		}

		$source = @$function_image_create($fileFullPath);
		$thumb = imagerotate($source, $angle, 0);
		if ($function_image_new == "ImageJpeg")
		{
			@$function_image_new($thumb, $fileFullPath, 100);
		}
		else
		{
			 @$function_image_new($thumb, $fileFullPath);
		}
		$this->resizeImage("thumbs", 100);
	}

	public static function getMediaPath()
	{
		return sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR;
	}

	public function getAbsoluteUrl($pre = 'http://')
	{
		return $pre.$_SERVER['HTTP_HOST'].$this->getRelativeUrl();
	}

	public function getAbsoluteThumbUrl($relativeTo='', $pre = 'http://')
	{
		return $pre.$_SERVER['HTTP_HOST'].$this->getRelativeThumbUrl($relativeTo);
	}

	public function getAbsoluteDirUrl($pre = 'http://')
	{
		return $pre.$_SERVER['HTTP_HOST'].$this->getRelativeDirUrl();
	}

	public function getServerAbsoluteDirUrl()
	{
		return self::getMediaPath().$this->getFiledirpath();
	}

	public function getServerAbsoluteUrl()
	{
		return $this->getServerAbsoluteDirUrl().$this->getFilename();
	}

	public function getServerAbsoluteThumbUrl()
	{
		return $this->getServerAbsoluteDirUrl()."thumbs".DIRECTORY_SEPARATOR.$this->getFilename();
	}

	public function getRelativeUrl(/*$relativeTo = null*/)
	{
		/*		if(is_null($relativeTo))
		{
		$relativeTo = sfConfig::get('sf_root_dir')."/".sfConfig::get('sf_web_dir_name')."/";
		}

		$abspath = $this->getServerAbsoluteUrl();
		$len = strlen($relativeTo);

		return "/".substr($abspath, $len);*/
		return DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$this->getFiledirpath().$this->getFilename();
	}

	public function getRelativeThumbUrl($relativeTo = '')
	{
		/*if(is_null($relativeTo))
		{
		$relativeTo = sfConfig::get('sf_root_dir')."/".sfConfig::get('sf_web_dir_name')."/";
		}

		$abspath = $this->getServerAbsoluteDirUrl()."thumbs/".$this->getFilename();
		$len = strlen($relativeTo);

		return "/".substr($abspath, $len);*/
		if ($relativeTo) $relativeTo .= DIRECTORY_SEPARATOR;
		return DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$this->getFiledirpath()."thumbs".DIRECTORY_SEPARATOR.$relativeTo.$this->getFilename();
	}

	public function getRelativeDirUrl(/*$relativeTo = null*/)
	{
		/*if(is_null($relativeTo))
		{
		$relativeTo = sfConfig::get('sf_root_dir')."/".sfConfig::get('sf_web_dir_name')."/"."media"."/";
		}

		$abspath = $this->getServerAbsoluteDirUrl();
		$len = strlen($relativeTo);

		return "/".substr($abspath, $len);*/
		return DIRECTORY_SEPARATOR."media".DIRECTORY_SEPARATOR.$this->getFiledirpath();
	}

	public function save($con = null, $parent = null, $refreshTree = true)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();

			$genericDoc = Document::getGenericDocument($this);
			if (!$this->getId())
			{
				$this->setId($genericDoc->getId());
			}

			parent::save($con);

			// create relationship
			if (!$parent)
			{
				$parent = Document::getParentOf($this->getId(), null, true, false);
				if (empty($parent))
				{
					$parent = Rootfolder::getRootfolder($this);
				}
			}
			Relation::saveRelation($parent, $this);
			$con->commit();
			Document::cacheObj($this, "Media", $refreshTree);
			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

	public function delete($con = null)
	{
		$file = $this->getServerAbsoluteUrl();
		$thumb = $this->getServerAbsoluteThumbUrl();

		$filedeleted = true;
		$thumbdeleted = true;

		if (file_exists($file))
		$filedeleted = unlink($file);
		if (file_exists($thumb))
		$thumbdeleted = unlink($thumb);

		if (!$filedeleted)
		{
			FileHelper::Log("\tError: file '".$file."' could not be deleted!");
		}

		try
		{
			$con = Propel::getConnection();
			$con->begin();

			//deletes generic document
			$genericDocument = Document::getGenericDocument($this);
			if($genericDocument) $genericDocument->delete();

			$con->commit();
			Document::deleteObjCache($this);
			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

	public function isImage()
	{
		return in_array($this->getExtention(), array("gif","png","jpeg","jpg","GIF","PNG","JPEG","JPG"));
	}

}