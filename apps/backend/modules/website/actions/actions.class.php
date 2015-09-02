<?php
/**
 * @package    cms
 * @subpackage website
 * @author     Jordan Hristov / Ilya Popivanov
 */

class websiteActions extends sfActions
{
	public function executeIndex()
	{
		$this->redirect('admin/index');
	}

	public function executeGetDocumentModules()
	{
		$content = '<option value="">Select module...</option>';
		$modules = $this->getFrontendModules();
		foreach ($modules as $module)
		{
			$content .= '<option value="/website/getDocumentsForModule/modulename/'.strtolower($module).'">'.$module.'</option>';
		}
		return $this->renderText($content);
	}

	public function executeGetBlockParameters()
	{
		$moduleName = $this->getRequestParameter('modulename');
		$blockId = $this->getRequestParameter('blockId');
		$configFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'blockParams.xml';
		if (!file_exists($configFile))
		{
			return $this->renderText('');
		}
		$tags = XMLParser::getXMLdataValues($configFile);
		$foundBlock = false;
		$index = 0;
		$paramName = null;
		foreach ($tags as $tag)
		{
			if (($tag['tag'] == 'BLOCK') && ($tag['attributes']['ID'] == $blockId) && ($tag['type'] == 'open'))
			{
				$content = '<h3>Block parameters:</h3>';
				$foundBlock = true;
				continue;
			}
			if ($foundBlock)
			{
				if (($tag['tag'] == 'PARAMETER') && ($tag['type'] == 'open'))
				{
					$paramName = $tag['attributes']['ID'];
					$content .= '<div class="frmRow"><label for="blockParam'.$index.'">'.$tag['attributes']['LABEL'].':</label>';
					$content .= '<select id="blockParam'.$index.'" name="blockParam'.$index.'">';
				}
				if (($tag['tag'] == 'VALUE') && ($tag['type'] == 'complete'))
				{
					$content .= '<option value="/'.$paramName.'/'.$tag['attributes']['ID'].'">'.$tag['attributes']['LABEL'].'</option>';
				}
				if (($tag['tag'] == 'PARAMETER') && ($tag['type'] == 'close'))
				{
					$content .= '</select></div>';
				}
				if (($tag['tag'] == 'BLOCK') && ($tag['type'] == 'close'))
				{
					$foundBlock = false;
					continue;
				}
			}
		}
		return $this->renderText($content);
	}

	public function executeGetDocumentsForModule()
	{
		$content = BackendService::getMceTree($this->getRequestParameter('modulename'));
		return $this->renderText($content);
	}

	private function getFrontendModules()
	{
		$modules = array();
		$modules[''] = "Select module...";
		$libDirs = array();
		$libDirs[0] = 'lib';
		$libDirs[1] = 'apps'.DIRECTORY_SEPARATOR.'frontend';

		foreach ($libDirs as $libDir)
		{
			$dirName = SF_ROOT_DIR.DIRECTORY_SEPARATOR.$libDir.DIRECTORY_SEPARATOR.'modules';
			if ($dirHandle = opendir($dirName))
			{
				while (false !== ($moduleDir = readdir($dirHandle)))
				{
					if (substr($moduleDir, 0, 1) != '.')
					{
						// add only NOT EMPTY modules
						$configFile = $dirName.DIRECTORY_SEPARATOR.$moduleDir.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'blocks.xml';
						$found = false;
						if (file_exists($configFile))
						{
							$tags = XMLParser::getXMLdataValues($configFile);
							foreach ($tags as $tag)
							{
								if (($tag['tag'] == 'BLOCK') && ($tag['type'] == 'complete'))
								{
									$found = true;
								}
							}
							
							if($found)
							{
								$modules[$moduleDir] = ucfirst($moduleDir);
							}
							else
							{
								if($libDir == 'apps'.DIRECTORY_SEPARATOR.'frontend' && array_key_exists($moduleDir, $modules)) unset($modules[$moduleDir]);
							}
						}
					}
				}
				closedir($dirHandle);
			}
		}
		return $modules;
	}

	public function executeEditPageContent()
	{
		$this->page = Document::getDocumentInstance($this->getRequestParameter('id'));
		$this->content = '<iframe src="http://'.$_SERVER['HTTP_HOST'].'/website/display/pageref/'.$this->getRequestParameter('id').'" width=100% height=100% scrolling=yes frameborder=0></iframe>';
	}

	public function executeInsertBlock()
	{
		if ($this->getRequestParameter('pageId'))
		{
			$this->page = Document::getDocumentInstance($this->getRequestParameter('pageId'));
			$this->modules = $this->getFrontendModules();
		}
		else
		{
			$this->error = "Your browser doesn't support cookies or restart your browser!";
		}
	}

	public function executeDeleteBlock()
	{
		$this->page = Document::getDocumentInstance($this->getRequestParameter('pageId'));
		$blockId = str_replace('_', '/', $this->getRequestParameter('blockId'));

		//refresh the content for free blocks
		$blobData = $this->page->getContent();
		if (!empty($blobData))
		{
			$blockContents = $blobData;
			$blockContentsTags = XMLParser::getXMLdataValues($blockContents, false, false);
		}
		$blobData = '<?xml version="1.0" encoding="UTF-8"?>';
		$blobData .= '<blocks>';
		$index = 0;
		foreach ($blockContentsTags as $block)
		{
			if (($block["tag"] == "BLOCK") && $block['attributes']["ID"] != $blockId)
			{
				$blobData .= '<block id="'.$block['attributes']["ACTION"].$index++.
				'" target="'.$block['attributes']["TARGET"].
				'" action="'.$block['attributes']["ACTION"];
				if (isset($block['attributes']["PARAMETERS"]))
				{
					$blobData .= '" parameters="'.$block['attributes']["PARAMETERS"];
				}
				$blobData .= '">';
				$blobData .= '<![CDATA['.$block["value"].']]>';
				$blobData .= '</block>';
			}
		}
		$blobData .= '</blocks>';
		$this->page->setContent($blobData);
		$this->page->save();
		return $this->renderText('OK');
	}

	public function executeGetBlocksForModule()
	{

		$content = '<option value="">Select block...</option>';
		$moduleName = $this->getRequestParameter('modulename');
		$blocks = array();

		// check if exists FRONTEND/modules blocks
		$configFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'blocks.xml';
		if (!file_exists($configFile))
		{
			// check if exists LIB/modules blocks
			$configFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'blocks.xml';
			if (!file_exists($configFile))
			{
				return $this->renderText('');
			}
		}

		$tags = XMLParser::getXMLdataValues($configFile);
		foreach ($tags as $tag)
		{
			if (($tag['tag'] == 'BLOCK') && ($tag['type'] == 'complete'))
			{
				$content .= '<option value="'.$tag['attributes']['ID'].';'.$tag['attributes']['PARAMETER'].'">'.$tag['attributes']['LABEL'].'</option>';
			}
		}
			return $this->renderText($content);
	}

	public function executeSaveBlock()
	{
		$parameters = $this->getRequest()->getParameterHolder()->getAll();

		$this->page = Document::getDocumentInstance($this->getRequestParameter('id'));
		$destination = $this->getRequestParameter('parentBlock');

		// Block Id - the new block is inserted after it
		$blockId = str_replace('_', '/', $this->getRequestParameter('blockId'));

		// Refresh the content for free blocks
		$blobData = $this->page->getContent();
		if (!empty($blobData))
		{
			$blockContents = $blobData;
			$blockContentsTags = XMLParser::getXMLdataValues($blockContents, false, false);
		}

		$index = 0;
		$blobData = '<?xml version="1.0" encoding="UTF-8"?>'.
		'<blocks>';

		$max_num = 0;
		if ($this->getRequestParameter('block') == "richtext;")
		{
			foreach ($blockContentsTags as $block)
			{
				if (($block["tag"] == "BLOCK") && ($block['attributes']["ACTION"] == "richtext"))
				{
					$num = substr($block['attributes']["ID"], 8);
					if($max_num < $num)
					{
						$max_num = $num;
					}
				}
			}
			$max_num++;
		}

		// Copy content of existing BLOCKs
		foreach ($blockContentsTags as $block)
		{
			if ($block["tag"] == "BLOCK")
			{
				if ($block['attributes']["ACTION"] == "richtext")
				{
					$blobData .= '<block id="'.$block['attributes']["ID"];
				}
				else
				{
					$blobData .= '<block id="'.$block['attributes']["ACTION"].$index++;
				}

				$blobData .= '" target="'.$block['attributes']["TARGET"].
					'" action="'.$block['attributes']["ACTION"];
				if (isset($block['attributes']["PARAMETERS"]))
				{
					$blobData .= '" parameters="'.$block['attributes']["PARAMETERS"];
				}

				$blobData .= '">';
				$blobData .= '<![CDATA['.$block["value"].']]>';
				$blobData .= '</block>';

				// Insert NEW block AFTER parent block
				if ($block['attributes']["ID"] == $blockId)
				{
					if ($this->getRequestParameter('block') == "richtext;")
					{
						$blobData .= '<block id="richtext'.$max_num.'" target="'.$destination.'" action="richtext"><![CDATA[]]></block>';
					}
					else
					{
						$params = explode(';', $this->getRequestParameter('block'));
						$action = $params[0];
						$blobData .= '<block id="'.$action.$index++.
							'" target="'.$destination.
							'" action="'.$action;
						if (isset($params[1]))
						{
							$blobData .= '" parameters="'.$params[1];
						}
						$blobData .= '"><![CDATA[]]></block>';
					}
				}
			}
		}

		// Insert FIRST block in a content!
		if (substr($blockId, 0, 9) == 'new/Block')
		{
			if ($this->getRequestParameter('block') == "richtext;")
			{
				$blobData .= '<block id="richtext'.$max_num.'" target="'.$destination.'" action="richtext"><![CDATA[]]></block>';
			}
			else
			{
				$params = explode(';', $this->getRequestParameter('block'));
				$action = $params[0];
				$blobData .= '<block id="'.$action.$index.
					'" target="'.$destination.
					'" action="'.$action;
				if (isset($params[1]))
				{
					$blobData .= '" parameters="'.$params[1];
				}
				$blobData .= '"><![CDATA[]]></block>';
			}
		}

		$blobData .= '</blocks>';
		$this->page->setContent($blobData);
		$this->page->save();
		return $this->redirect($this->getRequest()->getReferer());
	}

	public function executeSavePageContent()
	{
		$this->page = Document::getDocumentInstance($this->getRequestParameter('id'));
		
		$content = '<?xml version="1.0" encoding="UTF-8"?>';
		$content .= '<blocks>';

		$data = $this->page->getContent();

		if (!empty($data))
		{
			$blockContentsTags = XMLParser::getXMLdataValues($data, false, false);
		}

		foreach ($blockContentsTags as $block)
		{
			if ($block["tag"] == "BLOCK")
			{
				$content .= '<block id="'.$block['attributes']["ID"].
					'" target="'.$block['attributes']["TARGET"].
					'" action="'.$block['attributes']["ACTION"].'"';
				if (isset($block['attributes']["PARAMETERS"]))
				{
					$content .= ' parameters="'.$block['attributes']["PARAMETERS"].'"';
				}
				$content .= '>';
				if ($this->getRequestParameter($block['attributes']["ID"]))
				{
					$blockContent = $this->getRequestParameter($block['attributes']["ID"]);

					if( substr($block['attributes']["ID"], 0, 8) == "richtext" )
					{
						$imgTags = explode('<img', $blockContent);
						$imageFound = false;
						$thumbDir = "richtext/".$this->getRequestParameter('id')."/".substr($block['attributes']["ID"], 8);
						$usedImg = array();

						for ($i = 0; $i < count($imgTags); $i++)
						{
							$imgParams = explode('/>', $imgTags[$i]);
							$id = 0;
							$thumb = "richtext";

							foreach ($imgParams as $paramStr)
							{
								$width = null;
								$height = null;
								$id = false;

								if(strstr($paramStr, "width"))
								{
									$width = strstr($paramStr, "width");
									$width = substr($width, 7);
									$pos = strpos($width, '"');
									$width = substr($width, 0, $pos);
								}

								if(strstr($paramStr, "height"))
								{
									$height = strstr($paramStr, "height");
									$height = substr($height, 8);
									$pos = strpos($height, '"');
									$height = substr($height, 0, $pos);
								}

								if(strstr($paramStr, "id"))
								{
									$id = strstr($paramStr, "id");
									$id = substr($id, 4);
									$pos = strpos($id, '"');
									$id = substr($id, 0, $pos);
								}
								
								if($id)
								{
									$prefix = time();

									if(strstr($paramStr, "src"))
									{
										$src = strstr($paramStr, "src");
										$src = substr($src, 5);
										$pos = strpos($src, '"');
										$src = substr($src, 0, $pos);
										$parts = explode("/", $src);

										if($parts[6])
										{
											$prefix = $parts[6];
										}
									}
									
									$img = Document::getDocumentInstance($id);

									if($img && get_class($img) == "Media" && $img->isImage())
									{
										if(empty($height) && empty($width))
										{
											list($width, $height) = getimagesize($img->getServerAbsoluteUrl());
										}
										$img->resizeImage($thumbDir, $height, $width, $prefix);
										
										$imageFound = true;
										$usedImg[] =  SF_ROOT_DIR."/www/media/upload/thumbs/".$thumbDir."/".$id."-".$prefix.".".$img->getExtention();
									}
								}

								$id++;
							}
							$thumb = str_replace("/", "-", $thumbDir);

							$replaceStr = 'src="/media/display/thumb/'.$thumb.'/freeimg/'.$prefix.'/id/';
							$find = array(
									'src="/media/display/id/',
									'src="/media/display/thumb/thumbs/id/'
									);
							$replace = array($replaceStr, $replaceStr);
							$blockParts[] = str_replace($find, $replace, $imgTags[$i]);
						}

						if ($imageFound)
						{
							$blockContent = implode("<img ", $blockParts);
						}
						$blockContent = preg_replace('@(<[ \\n\\r\\t]*script(>|[^>]*>))@i', '', $blockContent);
						$blockContent = preg_replace('@(<[ \\n\\r\\t]*/[ \\n\\r\\t]*script(>|[^>]*>))@i', '', $blockContent);

						$files = FileHelper::getSubElements(SF_ROOT_DIR."/www/media/upload/thumbs/".$thumbDir, "file");
						foreach ($files as $file)
						{
							if(!in_array($file, $usedImg))
							{
								// delete RICHTEXT media
								unlink($file);
								
								// delete ORIGINAL media
								$parts = explode(DIRECTORY_SEPARATOR, $file);
								$delFile = array_pop($parts);
								$delIdArr = explode("-", $delFile);
								$delId = $delIdArr[0];
								$imageToDelete = Document::getDocumentInstance($delId);
								if($imageToDelete)
									$imageToDelete->delete();
							}
						}
					}

					$content .= '<![CDATA['.$blockContent.']]>';
				}
				else
				{
					$blockContent = $block["value"];
					$blockContent = preg_replace('@(<[ \\n\\r\\t]*script(>|[^>]*>))@i', '', $blockContent);
					$blockContent = preg_replace('@(<[ \\n\\r\\t]*/[ \\n\\r\\t]*script(>|[^>]*>))@i', '', $blockContent);

					$content .= '<![CDATA['.$blockContent.']]>';
				}
				$content .= '</block>';
			}
		}
		$content .= '</blocks>';

		$this->page->setContent($content);
		$this->page->save();

		return $this->redirect($this->getRequest()->getReferer());
	}

	public function executeEditWebsite()
	{
		BackendService::objectEdit('website', 'Website', $this);
	}

	public function executeEditMenu()
	{
		BackendService::objectEdit('website', 'Menu', $this);
	}

	public function executeEditTopic()
	{
		BackendService::objectEdit('website', 'Topic', $this);
	}

	public function executeEditTopicI18n()
	{
		BackendService::objectEdit('website', 'TopicI18n', $this);
	}

	public function executeEditPage()
	{
		BackendService::objectEdit('website', 'Page', $this);
		$this->template = $this->getPageTemplates();
		if(!$this->obj)
		{
			return "I18nSuccess";
		}
	}

	public function executeEditPageI18n()
	{
		BackendService::objectEdit('website', 'PageI18n', $this);
		$this->template = $this->getPageTemplates();
	}

	public function executeSavePage()
	{
		try
		{
			BackendService::objectSave($obj, $parent);
			Urlrewrite::updateUrlRelationCache();
			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		$this->forward(strtolower($this->getRequestParameter('moduleName')), "edit".$this->getRequestParameter('documentName'));
		exit();
	}

	public function executeSavePageI18n()
	{
		try
		{
			$pageType = $this->getRequestParameter("attrPageType");
			if (!$pageType)
			{
				$request = $this->getRequest();
				$request->setParameter('attrPageType', 'CONTENT');
			}
			
			BackendService::objectSave($obj, $parent);

			$obj->setRewriteUrl($this->getRequestParameter("attrRewriteUrl"));
			if (!$this->getRequestParameter("attrIsSecure"))
			{
				$obj->setIsSecure(NULL);
			}
			
			$obj->save(null, $parent, $this->getRequestParameter("attrCulture"));
			Urlrewrite::updateUrlRelationCache();

			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		$this->forward(strtolower($this->getRequestParameter('moduleName')), "edit".$this->getRequestParameter('documentName'));
		exit();
	}

	public function getPageTemplates()
	{
		$templates = array();
		if ($dirHandle = opendir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'))
		{
			while (false !== ($file = readdir($dirHandle)))
			{
				if (strpos($file,'.xml') === strlen($file) - 4)
				{
					$tplName = substr($file, 0, strlen($file) - 4);
					$templates[$tplName] = $tplName;
				}
			}
			closedir($dirHandle);
		}
		if ($dirHandle = opendir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'))
		{
			while (false !== ($file = readdir($dirHandle)))
			{
				if (strpos($file,'.xml') === strlen($file) - 4)
				{
					$tplName = substr($file, 0, strlen($file) - 4);
					$templates[$tplName] = $tplName;
				}
			}
			closedir($dirHandle);
		}
		return $templates;
	}

}