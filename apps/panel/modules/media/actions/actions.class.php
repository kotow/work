<?php
/**
 * media actions.
 *
 * @package    cms
 * @subpackage media
 */

class mediaActions extends sfActions
{

	public function executeGetDocName()
	{
		if ($id = $this->getRequestParameter("id"))
		{
			if($doc = Document::getDocumentInstance($id))
			{
				exit($doc->getLabel());
			}
		}
		exit();
	}

	public function executeUploadGalleryMediaContainer()
	{
		$this->paramsStr = str_replace("-", "/", $this->getRequestParameter("paramsStr"));
	}

	public function executeGalleryPicsList()
	{
		$parentId = $this->getRequestParameter("parentMediaId");
		$code = '';

		if ($deleteId = $this->getRequestParameter("deleteId"))
		{
			if ($delObj = Document::getDocumentInstance($deleteId))
				$delObj->delete();
		}

		$children = Document::getChildrenOf($parentId, "Media");
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
						<img src="'.$pic->getRelativeThumbUrl().'" title="'.$pic->getDescription().'">
						<div class="image-options">
							<!--a class="image-zoom" href="javascript:void(0);"></a-->
							<a class="image-edit" href="javascript:void(0);"></a>
							<a class="image-delete" href="javascript:void(0);"></a>
						</div>
					</li>
			';
		}

		if ($code)
			exit(str_replace('###images###', $code, $res));
		else
			exit($code);
	}

	public function executeUploadGalleryMedia()
	{
		try
		{
			$request = $this->getRequest();
			$params = array();
			if ($this->getRequestParameter("submitted"))
			{
				$parentId = $this->getRequestParameter("parentMediaId");
				$request->setParameter("parent", $parentId);
				$request->setParameter("attrLabel", $parentId." gallery pic");

				if ($pathParam = trim($this->getRequestParameter("gp")))
				{
					$pathAdd = DIRECTORY_SEPARATOR.str_replace("_", DIRECTORY_SEPARATOR, $pathParam);
				}

				// check for TAGged folder
				if ($parent = Document::getDocumentByExclusiveTag('media_folder_'.$pathParam, false))
				{
					$this->getRequest()->setParameter("parent", $parent->getId());
				}

				$allowedParam = trim($this->getRequestParameter("allowed"));
				if ($allowedParam == "images")
					$allowedArr = array("image/gif", "image/jpeg", "image/pjpeg");
				else if (!empty($allowedParam))
					$allowedArr = explode(",", $this->getRequestParameter("allowed"));

				$media = Media::upload('galleryPic', "upload".$pathAdd, $allowedArr, false);
//				$media = Media::upload('galleryPic', "upload", $allowedArr, false);

				if ($media && $media->IsImage())
				{
					$fileName = $media->getServerAbsoluteUrl(); //$media->getFiledirpath().$media->getFilename();
					list($w, $h) = getimagesize($fileName);

					$params['gw'] = $this->getRequestParameter("gw");
					$params['gh'] = $this->getRequestParameter("gh");
					$params['gtw'] = $this->getRequestParameter("gtw");
					$params['gth'] = $this->getRequestParameter("gth");
					$params['gcw'] = $this->getRequestParameter("gcw");
					$params['gch'] = $this->getRequestParameter("gch");
					$cropData = array(0,0);
					if ($params['gcw'] || $params['gch'])
					{
						if ($params['gcw'] && $params['gch'])
							$cropData = array($params['gcw'], $params['gch']);
						else if ($params['gcw'])
							$cropData = array($params['gcw'],0);
						else
							$cropData = array(0,$params['gch']);
					}
					if ($params['gw'] || $params['gh'])
					{
						if (($params['gw']>0 && $w > $params['gw']) || ($params['gh']>0 && $h > $params['gh']))
							$media->resizeImage(null, $params['gh'], $params['gw'], null, $cropData);
						else
							$media->resizeImage(null, null, 800, null, array(800,600));
					}
					else
					{
						$media->resizeImage(null, null, 800, null, array(800,600));
					}

					// thumbs
					if ($params['gtw'] || $params['gth'])
					{
						$media->resizeImage("thumbs", $params['gth'], $params['gtw']);
					}
					else
					{
						if ($h > $w)
						{
							$media->resizeImage("thumbs", 80, null, null, array(120, 80));
						}
						else
						{
							$media->resizeImage("thumbs", null, 120, null, array(120, 80));
						}
					}

/*					if ($h > $w)
					{
						$media->resizeImage(null, 600);
						$media->resizeImage(1, 80, null, null, array(120, 80));
					}
					else
					{
						$media->resizeImage(null, null, 800);
						$media->resizeImage(1, null, 120, null, array(120, 80));
					}*/
				}
			}
		}
		catch (Exception $e)
		{
//			$this->message = $e->getMessage();
			$this->message = UtilsHelper::Localize("media.".$e->getMessage());
		}
	}

	public function executeUploadMedia()
	{
		try
		{
			$request = $this->getRequest();
			if ($this->getRequestParameter("submitted"))
			{
				$fileName = $request->getFilePath('mainPic');
				list($w, $h) = getimagesize($fileName);
				$this->w = $w; $this->h = $h;
				/*if ($w < 581 || $h < 250)
				{
					$this->message = "Image is too small";
				}
				else*/
				{
					$pathadd = '';
					if ($pathParam = trim($this->getRequestParameter("gp")))
					{
						$pathAdd = DIRECTORY_SEPARATOR.str_replace("_", DIRECTORY_SEPARATOR, $pathParam);
					}

					$allowedArr = null;
					$allowedParam = $this->getRequestParameter("allowed");

					if ($allowedParam == "images")
					{
						$allowedArr = array("image/gif", "image/jpeg", "image/pjpeg");
					}
					else if(!empty($allowedParam))
					{
						$allowedArr = explode(",", $this->getRequestParameter("allowed"));
					}
					$media = Media::upload('mainPic', "upload".$pathAdd, $allowedArr);

					$this->newId = $media->getId();
					$this->isImg = $media->isImage();
					if ($media && $media->IsImage())
					{
						list($w, $h) = getimagesize($media->getServerAbsoluteUrl());

						$params['gw'] = $this->getRequestParameter("gw");
						$params['gh'] = $this->getRequestParameter("gh");
						$params['gtw'] = $this->getRequestParameter("gtw");
						$params['gth'] = $this->getRequestParameter("gth");

						if ($params['gw'] || $params['gh'])
						{
							if (($params['gw']>0 && $w > $params['gw']) || ($params['gh']>0 && $h > $params['gh']))
								$media->resizeImage(null, $params['gh'], $params['gw']);
							else
								if ($w > 800) $media->resizeImage(null, null, 800);
						}
						else
						{
							if ($w > 800) $media->resizeImage(null, null, 800);
						}
						if ($params['gtw'] || $params['gth'])
						{
							$media->resizeImage(1, $params['gth'], $params['gtw']);
						}
						else
						{
							$media->resizeImage("thumbs", null, 100);
						}
					}
				}
			}
			elseif ($id = $this->getRequestParameter("id"))
			{
				if ($media = Document::getDocumentInstance($id))
				$this->label = $media->getLabel();
				$this->description = $media->getDescription();
				$this->isImg = $media->isImage();
				$this->newId = $media->getId();
			}
		}
		catch (Exception $e)
		{
			$this->message = UtilsHelper::Localize("media.".$e->getMessage());
		}
	}

	public function executeEditGalleryMedia()
	{
		try
		{
			$request = $this->getRequest();
//			$params = array();
			if ($id = $this->getRequestParameter("id"))
			{
				$media = Document::getDocumentInstance($id);
				$parentId = Document::getParentOf($id, null, false);
				$request->setParameter("parent", $parentId);
				$request->setParameter("attrLabel", $parentId." gallery pic");

				if ($this->getRequestParameter("submitted"))
				{
					if ($pathParam = trim($this->getRequestParameter("gp")))
					{
						$pathAdd = DIRECTORY_SEPARATOR.str_replace("_", DIRECTORY_SEPARATOR, $pathParam);
					}

					// check for TAGged folder
					if ($parent = Document::getDocumentByExclusiveTag('media_folder_'.$pathParam, false))
					{
						$this->getRequest()->setParameter("parent", $parent->getId());
					}

					$allowedParam = trim($this->getRequestParameter("allowed"));
					if ($allowedParam == "images") //if ($allowedParam == "images" || empty($allowedParam))
						$allowedArr = array("image/gif", "image/jpeg", "image/pjpeg");
					elseif (!empty($allowedParam))
						$allowedArr = explode(",", $this->getRequestParameter("allowed"));

					$media = Media::upload('galPic', "upload".$pathAdd, $allowedArr, false);
//					$media = Media::upload('galPic', "upload", $allowedArr, false);

					if ($media && $media->IsImage())
					{
						$fileName = $media->getServerAbsoluteUrl(); //$media->getFiledirpath().$media->getFilename();
						list($w, $h) = getimagesize($fileName);

						$params['gw'] = $this->getRequestParameter("gw");
						$params['gh'] = $this->getRequestParameter("gh");
						$params['gtw'] = $this->getRequestParameter("gtw");
						$params['gth'] = $this->getRequestParameter("gth");
						$params['gcw'] = $this->getRequestParameter("gcw");
						$params['gch'] = $this->getRequestParameter("gch");
						$cropData = array(0,0);
						if ($params['gcw'] || $params['gch'])
						{
							if ($params['gcw'] && $params['gch'])
								$cropData = array($params['gcw'], $params['gch']);
							else if ($params['gcw'])
								$cropData = array($params['gcw'],0);
							else
								$cropData = array(0,$params['gch']);
						}
						if ($params['gw'] || $params['gh'])
						{
							if (($params['gw']>0 && $w > $params['gw']) || ($params['gh']>0 && $h > $params['gh']))
								$media->resizeImage(null, $params['gh'], $params['gw'], null, $cropData);
							else
								$media->resizeImage(null, null, 800, null, $cropData);
						}
						else
						{
							$media->resizeImage(null, null, 800, null, array(800,600));
						}

						// thumbs
						if ($params['gtw'] || $params['gth'])
						{
							$media->resizeImage("thumbs", $params['gth'], $params['gtw']);
						}
						else
						{
							if ($h > $w)
							{
								$media->resizeImage("thumbs", 80, null, null, array(120, 80));
							}
							else
							{
								$media->resizeImage("thumbs", null, 120, null, array(120, 80));
							}
						}

/*						if ($h > $w)
						{
							$media->resizeImage(null, 600);
							$media->resizeImage(1, 80, null, null, array(120, 80));
						}
						else
						{
							$media->resizeImage(null, null, 800);
							$media->resizeImage(1, null, 120, null, array(120, 80));
						}*/
					}
				}
				$this->description = $media->getDescription();
				$this->newId = $media->getId();
			}
		}
		catch (Exception $e)
		{
//			$this->message = $e->getMessage();
			$this->message = UtilsHelper::Localize("media.".$e->getMessage());
		}
	}

	public function executeIndex()
	{
		$this->redirect('/panel/admin/index');
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
/*		if ($id = $this->getRequestParameter('id'))
		{
			$this->obj = Document::getDocumentInstance($id);
		}

		$this->err = $this->getRequestParameter('err');
		$this->tags = Document::getAvailableTagsOf($this->getRequestParameter('module'), 'Media');
		*/
		$this->setLayout(false);
		return PanelService::objectEdit('media', 'Media', $this);
	}

/*	public function executeSaveMedia()
	{
		try
		{
			$request = $this->getRequest();
			$media = Media::upload('attrFilename');
			if ($fileName =	$request->getFileName('attrFilename')) // new check if there is uploading NEW image
			{
				if ($media && $media->IsImage())
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
			}
			else
			{
				if (!$this->getRequestParameter('id'))
				{
					//UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
					UtilsHelper::setBackendMsg($e->getMessage(), "error");
				}
				//PanelService::redirect();
				//exit();
			}
		}
		catch (Exception $e)
		{
//			if ($this->getRequestParameter('id'))
//			{
//				//return $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/admin/?refresh=modules_'.$this->getRequestParameter('module')."&err=".$e->getMessage()."&model=Media&id=".$this->getRequestParameter('id'));
//			}
//			else
//			{
//				//return $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/admin/?refresh=modules_'.$this->getRequestParameter('module')."&err=".$e->getMessage()."&model=Media&parent=".$this->getRequestParameter('parent'));
//			}
			//UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
			UtilsHelper::setBackendMsg(UtilsHelper::Localize('media.'.$e->getMessage()), "error");
		}
		//return $this->redirect('http://'.$_SERVER['HTTP_HOST'].'/admin/?refresh=modules_'.$this->getRequestParameter('module'));
//		PanelService::redirect();
//		exit();
	}
*/

	public function executeSaveMedia()
	{
		$hasError = false;
		try
		{
			$request = $this->getRequest();
			$id = $this->getRequestParameter("id");
			if ($this->getRequestParameter("submitEdit"))
			{
				$fileName = $request->getFilePath('attrFilename');
				if (!$id && !$fileName)
				{
					UtilsHelper::setBackendMsg("Error: Please upload an image (JPG, GIF or JPG)!", "error");
					return;
				}
				if ($fileName)
				{
					$allowedArr = array("image/gif", "image/png", "image/jpg", "image/jpeg", "image/pjpeg");
					$media = Media::upload('attrFilename', 'upload', $allowedArr);
					$media->resizeImage("thumbs", null, 100);
				}
			}
		}
		catch (Exception $e)
		{
			$hasError = true;
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}
		if (!$hasError)
		{
			PanelService::redirect();
			exit();
		}
	}

}