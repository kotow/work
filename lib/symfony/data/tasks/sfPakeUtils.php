<?php

function getImage($img)
{
	try
	{
		if(strpos($img , 'http://') !== false)
		{
			$original_url = $img;
			$pos = strrpos($img, ".");
			$ext = substr($img, $pos+1);

			$media = new Media();
			$media->save();
			$fileName = $media->getId().".".$ext;
			$basePath = sfConfig::get('sf_web_dir')."/media/upload/";
			file_put_contents($basePath.$fileName, file_get_contents($img));
			$mime = explode(";", Media::mime_content_type($basePath.$fileName));
			$mime = $mime[0];

			$media->setFilename($fileName);
			$media->setFiletype($mime);
			$media->setFiledirpath($basePath);
			$media->save(null, $o);
			chmod($basePath.$fileName, 0777);
			$media->resizeImage(null, 450);
			$media->resizeImage(1, 150);

		}
		elseif(base64_decode($img))
		{
			$ext = "jpg";

			$media = new Media();
			$media->save();
			$fileName = $media->getId().".".$ext;
			$basePath = sfConfig::get('sf_web_dir')."/media/upload/";
			file_put_contents($basePath.$fileName, base64_decode($img));
			$mime = explode(";", Media::mime_content_type($basePath.$fileName));
			$mime = $mime[0];

			$media->setFilename($fileName);
			$media->setFiletype($mime);
			$media->setFiledirpath($basePath);
			$media->save(null, $o);
			chmod($basePath.$fileName, 0777);
			$media->resizeImage(null, 450);
			$media->resizeImage(1, 150);
		}
	}
	catch (Exception $e)
	{
		$media->delete();
		FileHelper::Log("CRON ERROR >>> Field : ".$k." on item ".$o->getId()."(".$offer['originalid'].") is not a valid image. [".$original_url."]");
		echo_cms("CRON ERROR >>> Field : ".$k." on item ".$o->getId()."(".$offer['originalid'].") is not a valid image. [".$original_url."]");
	}
}