<?php
/**
 * @package    cms
 * @subpackage media
 * @author     Jordan Hristov / Ilya Popivanov
 */

class mediaActions extends sfActions
{

	public function executeGetDocName()
	{
		if($id = $this->getRequestParameter("id"))
		{
			if($doc = Document::getDocumentInstance($id))
			{
				exit($doc->getLabel());
			}
		}
		exit();
	}

	public function executeUploadMediaContainer()
	{
	}

	public function executeGalleryPicsList()
	{
		$parentId = $this->getRequestParameter("parentMediaId");
		$type = $this->getRequestParameter("gallery_type");
		$code = '';
		if ($type == 1)
		{
			if ($I18n = Document::getDocumentByCulture($parentId, null, true))
				$parentId = $I18n->getId();
			else
				exit($code);
		}

		if ($deleteId = $this->getRequestParameter("deleteId"))
		{
			if ($delObj = Document::getDocumentInstance($deleteId))
			{
				$delObj->delete();
			}
		}
		$children = Document::getChildrenOf($parentId, "Media");
		if ($type == 1)  // panel gallery
		{
//			var_dump($children);
			$res = '
	<ul id="images-grid" class="ui-sortable">
		###images###
	</ul>
	<div class="clear"></div>
';
			foreach ($children as $pic)
			{
				$code .= '
		<li id="image_'.$pic->getId().'" class="ui-state-default">
			<img src="'.$pic->getRelativeThumbUrl().'">
			<div class="image-options">
				<!--<a class="image-zoom" href="javascript:void(0);"></a> <a class="image-edit" href="javascript:void(0);"></a>--> <a class="image-delete" href="javascript:void(0);"></a>
			</div>
		</li>
';
			}
			
			if ($code)
				exit(str_replace('###images###', $code, $res));
			else
				exit($code);
		}
		else // backend gallery
		{
			$code = "";
			foreach ($children as $pic)
			{
				$code .= "<li><img src='".$pic->getRelativeThumbUrl()."'><img onclick='deleteGalleryMedia(".$parentId.", ".$pic->getId().");' src='/images/icons/delete.png'/></li>";
			}
		}
		exit($code);
	}

	public function executeUploadGalleryMediaContainer()
	{
		$this->paramsStr = str_replace("-", "/", $this->getRequestParameter("paramsStr"));
	}

	public function executeUploadGalleryMedia()
	{
		try
		{
			$request = $this->getRequest();
			if ($this->getRequestParameter("submitted"))
			{
				$parentId = $this->getRequestParameter("parentMediaId");
				$request->setParameter("parent", $parentId);
				$request->setParameter("attrLabel", $parentId." gallery pic");
				//exit(str_replace("_", "/", $this->getRequestParameter("gp")));
				$media = Media::upload('galleryPic', str_replace("_", "/", $this->getRequestParameter("gp")), array("image/gif", "image/jpeg", "image/pjpeg"), false);

				if ($media && $media->IsImage())
				{
					$media->resizeImage("small", null, 170);
					$media->resizeImage("thumbs", null, 202, null, array(202,158));
					//$media->resizeImage(null, null, 522);
					/*$media->resizeImage(
						null,
						$this->getRequestParameter("gh"),
						$this->getRequestParameter("gw")
					);
					$media->resizeImage(
						1,
						$this->getRequestParameter("gth"),
						$this->getRequestParameter("gtw")
					);*/
				}
			}
		}
		catch (Exception $e)
		{
			$this->message = UtilsHelper::Localize("media.backend.".$e->getMessage());
		}
	}

	public function executeUploadMedia()
	{
		//$this->tree = BackendService::getRightTree("media");
		try
		{
			$request = $this->getRequest();
			if($this->getRequestParameter("submitted"))
			{
				$fileName = $request->getFilePath('mainPic');
				list($w, $h) = getimagesize($fileName);
				$this->w = $w; $this->h = $h;
				/*if (($w < 400) || ($h < 300))
				{
					$this->message = UtilsHelper::Localize("media.backend.image_size_too_small");
				}
				else*/
				{
					$allowedArr = null;

					$allowedParam = $this->getRequestParameter("allowed");

					if ($allowedParam == "images")
						$allowedArr = array("image/gif", "image/jpeg", "image/pjpeg");
					else if(!empty($allowedParam))
						$allowedArr = explode(",", $this->getRequestParameter("allowed"));

					//$this->getRequest()->setParameter("parent", 11);
					$media = Media::upload('mainPic', "upload", $allowedArr);

					$this->newId = $media->getId();
					$this->isImg = $media->isImage();

					if($media && $media->IsImage())
					{
						$media->resizeImage("small", null, 170);
						$media->resizeImage("thumbs", null, 202, null, array(202,158));
						$media->resizeImage(null, null, 522);
						/*
						list($originalWidth, $originalHeight) = getimagesize($media->getServerAbsoluteUrl());

						if($originalWidth > $originalHeight && $originalWidth > 800)
						{
							$media->resizeImage(null, null, 800);
						}
						else if($originalHeight > 600)
						{
							$media->resizeImage(null, 600);
						}
				
						$t_done = false;
						if ($h > $w && $h > UtilsHelper::THUMB_HEIGHT)
						{
							$media->resizeImage("thumbs", UtilsHelper::THUMB_HEIGHT);
							$t_done = true;
						}
						else if ($w > UtilsHelper::THUMB_WIDTH)
						{
							$media->resizeImage("thumbs", null, UtilsHelper::THUMB_WIDTH);
							$t_done = true;
							
						}
						
						if(!$t_done) $media->resizeImage("thumbs");
						*/
					}
				}
			}
		}
		catch (Exception $e)
		{
			$this->message = UtilsHelper::Localize("media.backend.".$e->getMessage());
		}
	}

	public function executeIndex()
	{
		$this->redirect('admin/index');
	}

	public function executeRotate()
	{
		$media = Document::getDocumentInstance($this->getRequestParameter('imgid'));

		if ($media)
		{
			$media->rotateImage($this->getRequestParameter('angle'));
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><result>rotated</result>";
		}
		else
		{
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><result>error!</result>";
		}
		exit();
	}

	public function executeCrop()
	{
		$ratio = $this->getRequestParameter('ratio');

		$imgw = $this->getRequestParameter('imgw');
		$imgh = $this->getRequestParameter('imgh');

		$xpos = $this->getRequestParameter('xpos')/($ratio/10000);
		$ypos = $this->getRequestParameter('ypos')/($ratio/10000);

		$xsize = $this->getRequestParameter('xsize')/($ratio/10000);
		$ysize = $this->getRequestParameter('ysize')/($ratio/10000);


		if ($xsize < 0)
		{
			$xsize = $xsize*-1;
			$xpos = $xpos-$xsize;
		}

		if ($ysize < 0)
		{
			$ysize = $ysize*-1;
			$ypos = $ypos-$ysize;
		}

		if(($xpos+$xsize) > $imgw) $xsize = $imgw-$xpos;
		if(($ypos+$ysize) > $imgh) $ysize = $imgh-$ypos;

		$xsize = round($xsize);
		$ysize = round($ysize);
		$xpos = round($xpos);
		$ypos = round($ypos);

		$media = Document::getDocumentInstance($this->getRequestParameter('imgid'));

		if ($media)
		{
			$media->resizeImage(null, $ysize, $xsize, null, array($xpos, $ypos));
			$media->resizeImage("thumbs", 100);

			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><result>croped</result>";
		}
		else
		{
			echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><result>error!</result>";
		}

		exit();
	}

	public function executeEditMedia()
	{
		// CROP SWF FIX
		if($this->getRequestParameter("id") == "media")
		{
			$vars = explode("/", $_SERVER['REQUEST_URI']);
			$request = $this->getRequest();
			if($vars[6]=='crop')
			{
				$request->setParameter("xpos", $vars[8]);
				$request->setParameter("ypos", $vars[10]);
				$request->setParameter("xsize", $vars[12]);
				$request->setParameter("ysize", $vars[14]);
				$request->setParameter("imgid", $vars[16]);
				$request->setParameter("ratio", $vars[18]);
				$request->setParameter("imgw", $vars[20]);
				$request->setParameter("imgh", $vars[22]);
				
				$result = $this->getPresentationFor("media", "crop");
			}
			elseif($vars[6]=='rotate')
			{
				$request->setParameter("angle", $vars[8]);
				$request->setParameter("imgid", $vars[10]);
				$result = $this->getPresentationFor("media", "rotate");
			}
		}
		/////////////////
		BackendService::objectEdit("media", "Media", $this);
		$this->err = $this->getRequestParameter('err');
	}

	public function executeSaveMedia()
	{
		try
		{

			$media = Media::upload('attrFilename');

			if($media && $media->IsImage())
			{
				list($originalWidth, $originalHeight) = getimagesize($media->getServerAbsoluteUrl());

				if($originalWidth > $originalHeight && $originalWidth > 1500)
				{
					$media->resizeImage(null, null, 1500);
				}
				else if($originalHeight > 1500)
				{
					$media->resizeImage(null, 1500);
				}

				$media->resizeImage("thumbs", 100);
			}
			else if($media && in_array($media->getFiletype(), array("video/x-msvideo", "video/mpeg", "video/mp4", "video/quicktime", "video/x-ms-wmv", "video/avi", "video/wmv")))
			{
				$media->convertToFlv();
			}
			else if($media && in_array($media->getFiletype(), array("video/x-flv", "flv-application/octet-stream")))
			{
				$media->saveFlv();
			}
			else if($media && in_array($media->getFiletype(), array("application/octet-stream")) && substr($media->getFilename(),-4) == ".flv")
			{
				$media->saveFlv();
			}
			else if
			(
			($media && in_array($media->getFiletype(), array("application/binary")) && substr($media->getFilename(),-4) == ".mpg") ||
			($media && in_array($media->getFiletype(), array("application/binary")) && substr($media->getFilename(),-5) == ".mpeg")
			)
			{
				$media->convertToFlv();
			}

			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			
			UtilsHelper::setBackendMsg("Error while saving: ". UtilsHelper::Localize("media.backend.".$e->getMessage(), "en"), "error");
		}
		$this->forward(strtolower($this->getRequestParameter('moduleName')), "edit".$this->getRequestParameter('documentName'));
	}
}