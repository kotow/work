<?php

class PanelService
{

	public static function redirect($moduleName = null)
	{
		$context = sfContext::getInstance();
		$request = $context->getRequest();

		if ($http_ref = $request->getParameter('http_ref'))
		{
			header("location: ".$http_ref);
			exit();
		}

		$addPage = '';
		if ($page = $request->getParameter('page'))
			$addPage = '&page='.$page;
		if (!$moduleName)
			$moduleName = $request->getParameter('moduleName');
		if ($parentModule = $request->getParameter('parentModule'))
		{
			$moduleName = $parentModule;
		}

		if (!$request->getParameter("backendMsg"))
		{
			if ($parent = $request->getParameter('parent'))
			{
				header("location: /panel/?m=".$moduleName."&p=".$parent.$addPage);
			}
			else if ($id = $request->getParameter('id'))
			{
				if (is_numeric($id) && $p = Document::getParentOf($id, null, false))
				{
					header("location: /panel/?m=".$moduleName."&p=".$p.$addPage);
				}
				else
				{
					header("location: /panel/?m=".$moduleName.$addPage);
				}
			}
			else
			{
				header("location: /panel/?m=".$moduleName.$addPage);
			}
		}
		else
		{
			if ($id = $request->getParameter('id'))
				header("location: /panel/?m=".$moduleName."&id=".$id.$addPage);
			else if ($new = $request->getParameter('n'))
				header("location: /panel/?m=".$moduleName."&n=".$new.$addPage);
		}
	}

	public static function getUserRights($user, $class, $moduleName)
	{
		$userRights = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/panel/config/rights.xml");
		if ($user)
		{
			$type = $user->getType();
		}

		$commands = array(); $ind = 0;
		$moduleFound = $proceed = false;
		foreach ($userRights as $obj)
		{
			// find USER type
			if (($obj['tag'] == 'USER') && ($obj['type'] == 'open') && ($obj["attributes"]["LABEL"] == $type))
			{
				$proceed = true;
				//				echo "User '$type' found!<br/>";
			}
			else if ($proceed && ($obj['tag'] == 'USER') && ($obj['type'] == 'close'))
			{
				break; //$proceed = false;
			}
			else if ($proceed)
			{
				// find MODULE
				if (($obj['tag'] == 'MODULE') && ($obj['type'] == 'open') && ($obj["attributes"]["NAME"] == $moduleName))
				{
					$moduleFound = true;
					//					echo "Module '$moduleName' found!<br/>".intval($moduleFound);
				}
				else if ($moduleFound && ($obj['tag'] == 'MODULE') && ($obj['type'] == 'close'))
				{
					break; //$moduleFound = false;
				}
				else if ($moduleFound && ($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
				{
//					echo "*";
					$val = $obj['value'];
					$allowed = array();
					//if (strpos($val, "I18n") == false)
					{
						$tmp = explode(',', $obj["attributes"]["COMMANDS"]);
						foreach ($tmp as $v)
						{
							//if (strpos($v, "I18n") == false)
							$allowed[] = $v;
						}
						$commands[$obj['value']] = implode(',', $allowed);
					}
				}
			}
		}
		return $commands;
	}

	public static function getMainList(&$documentId, $moduleName, $page = 1)
	{
		$moduleName = strtolower($moduleName);
		try
		{
			if ($moduleName == "settings")
			{
				$settingsArr = array();
				if (is_readable(sfConfig::get('sf_root_dir')."/config/settings.xml"))
				{
					$objects = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/config/settings.xml");
				}

				foreach ($objects as $obj)
				{
					if (($obj['tag'] == 'ELEMENT') && ($obj['type'] == 'open'))
					{
						$objName = $obj['attributes']['LABEL'];
						$objDescription = $obj['attributes']['DESCRIPTION'];
					}
					if (($obj['tag'] == 'ITEM') && ($obj['type'] == 'complete'))
					{
						//$val = $obj['attributes']['VALUE'];
						$settingName = $objName; //$settingName = strtolower($objName);
						$settingsArr[$settingName] = $objDescription;
					}
				}
				$pager = new sfPropelPager("Relation", 20);
				$pager->setResults($settingsArr);
				$pager->setPage($page);
				$pager->init();
				foreach ($pager->getResults() as $name => $label)
				{
					$res['children'][$name] = $label;
				}
				$res['paging'] = $pager->paging(true);
				return $res;
			}

			if ($moduleName == "labels")
			{
				$localesArr = array();
				if (is_readable(sfConfig::get('sf_root_dir')."/config/locales.xml"))
				{
					$objects = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/config/locales.xml");
					foreach ($objects as $obj)
					{
						if (($obj['tag'] == 'LOCALE') && ($obj['type'] == 'open'))
						{
							$objName = $obj['attributes']['LABEL'];
							if ($obj['attributes']['DESCRIPTION'])
							{
								$objDescription = $obj['attributes']['DESCRIPTION'];
							}
							else
							{
								$objDescription = '['.$obj['attributes']['LABEL'].']';
							}
						}

						if (($obj['tag'] == 'ITEM') && ($obj['type'] == 'complete'))
						{
							//$val = $obj['attributes']['VALUE'];
							$localeName = $objName; //$localeName = strtolower($objName);
							$localesArr[$localeName] = $objDescription;
						}
					}
				}
				$pager = new sfPropelPager("Relation", 20);
				$pager->setResults($localesArr);
				$pager->setPage($page);
				$pager->init();
				foreach ($pager->getResults() as $name => $label)
				{
					$res['children'][$name] = $label;
				}
				$res['paging'] = $pager->paging(true);
				return $res;
			}

			$mainList = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/panel/modules/".$moduleName."/config/mainList.xml");
			$displayedObjects = array();
			$rootId = null;

			foreach ($mainList as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
				{
					$displayedObjects[] = $obj['value'];
				}
				// check overwrite RootID
				if (($obj['tag'] == 'OBJECTS') && ($obj['type'] == 'open'))
				{
					if (array_key_exists("attributes", $obj) && array_key_exists("PARENT", $obj['attributes']))
					{
						$rootName = $obj['attributes']['PARENT'];
						$rootDocument = Rootfolder::getRootfolderByModule($rootName);
						if ($rootDocument)
						{
							$rootId = $rootDocument->getId();
						}
					}

					if (array_key_exists("attributes", $obj) && array_key_exists("TAG", $obj['attributes']))
					{
						$tag = $obj['attributes']['TAG'];
						$rootDocument = Document::getDocumentByExclusiveTag($tag);
						if ($rootDocument)
						{
							$rootId = $rootDocument->getId();
						}
					}
				}
			}

			$children = array();
			$res = array('children' => array(), 'paging' => '');
			$c = new Criteria();
			if (!$documentId)
			{
				if ($rootId)
				{
					$documentId = $rootId;
				}
				else
				{
					$document = Rootfolder::getRootfolderByModule($moduleName);
					if ($document) $documentId = $document->getId();
				}
			}
//echo "rootId = $rootId; moduleName = $moduleName;";

			if ($documentId)
			{
				$pager = new sfPropelPager("Relation", 20);
				$c->add(RelationPeer::ID1, $documentId);
				$c->add(RelationPeer::DOCUMENT_MODEL2, $displayedObjects, Criteria::IN);
				$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);

				$pager->setCriteria($c);
				$pager->setPage($page);
				$pager->init();

				foreach ($pager->getResults() as $relation)
				{
					$id = $relation->getId2();
					$res['children'][] = Document::getDocumentInstance($id);
				}
			}
			$res['paging'] = $pager->paging(true);

			return $res;
		}
		catch(Exception $e)
		{
			throw $e;
		}
	}

	public static function get_all_content_blocks($content)
	{
		$blocks = XMLParser::getXMLdata($content);
		$out = array();
		foreach ($blocks[0] as $obj)
		{
			if (($obj['tag'] == 'BLOCK') && ($obj['type'] == 'complete'))
			{
				$name = $obj['attributes']['ID'];
				$out[$name]['target'] = $obj['attributes']['TARGET'];
				$out[$name]['content'] = $obj["value"];
				$out[$name]['action'] = $obj['attributes']['ACTION'];
			}
		}
		return $out;
	}

	public static function get_content_blocks($content)
	{
		$blocks = XMLParser::getXMLdata($content);
		$out = array();
		foreach ($blocks[0] as $obj)
		{
			if (($obj['tag'] == 'BLOCK') && ($obj['type'] == 'complete'))
			{
				if (substr($obj['attributes']['ID'], 0, 8) != 'richtext')
				{
					$name = $obj['attributes']['ID'];
					$out[$name]['target'] = $obj['attributes']['TARGET'];
					$out[$name]['content'] = $obj["value"];
					$out[$name]['action'] = $obj['attributes']['ACTION'];
				}
			}
		}
		return $out;
	}

	public static function objectSave(&$obj, &$parent, $documentName = null)
	{
		try
		{
			$parameters = sfContext::getInstance()->getRequest()->getParameterHolder()->getAll();
			if (!$documentName)
			{
				$documentName = $parameters["documentName"];
			}
			if (!$parent)
				$parent = Document::getDocumentInstance($parameters['parent']);
			if (!$parent)
			{
				if (isset($parameters["parentModule"]))
				{
					$parent = Rootfolder::getRootfolderByModule($parameters["parentModule"]);
				}
				else
				{
					$parent = Rootfolder::getRootfolderByModule($moduleName);
				}
			}
			if (!is_object($obj))
			{
				if (is_numeric($parameters['id']) && !$parent)
				{
					$obj = Document::getDocumentInstance($parameters['id']);
					$parent = Document::getParentOf($parameters['id']);
					$documentName = $parameters["documentName"];
				}
/*				elseif ($parent && strstr($documentName, "I18n"))
				{
					$obj = Document::getChildrenOf($parent->getId(), $documentName);
					if ($obj)
					$obj = $obj[0];
					else
					$obj = new $documentName();
				}*/
				else
				{
					$obj = new $documentName();
				}
			}

			include_once(sfConfig::get('sf_root_dir')."/config/Schema.class.php");
			$m = "get".$documentName."Properties";
			$properties = Schema::$m();

			$contentArr = array();
			foreach ($parameters as $key => $value)
			{
				// parse Content attribute/s for Page
				if ( ($documentName == "Page") && (substr($key, 0, 11) == 'attrContent') && ($key > 'attrContent') && in_array('Content', $properties) )
				{
					$ind = intval(substr($key, 11));
					// check if creating NEW Page
					if ($ind == 0)
						$ind = 1;
					$contentArr[$parameters['contentID'.$ind]] = '<block id="'.$parameters['contentID'.$ind].'" target="'.$parameters['contentTarget'.$ind].'" action="richtext"><![CDATA['.$value.']]></block>';
				}
				else if (!(strpos($key, 'attr') === false) && ($key != "attrRewriteUrl"))
				{
					if ($value == '') $value = null;
					$key = str_replace('attr', '', $key);

					if ($properties && $key != "Password" && !in_array($key, $properties)) continue;
					if ($key == "Password" && empty($value)) continue;

					$function = 'set'.$key;
					if (is_array($value))
					{
						// date field
						if (array_key_exists('year', $value) || array_key_exists('month', $value) || array_key_exists('day', $value))
						{
							//$value = implode('-', $value);
							//							$date = $value['year'].'-'.str_pad($value['month'], 2, "0", STR_PAD_LEFT).'-'.str_pad($value['day'], 2, "0", STR_PAD_LEFT); // 2009-02-09 16:10:20
							$date = implode('-', $value);
							if ($value['hour'] && $value['minute'])
							{
								// if 'include_custom' is used
								if (empty($value['year']) || empty($value['month']) || empty($value['day']) || empty($value['hour']) || empty($value['minute']))
								{
									$value = null;
								}
								else
								{
									$time = $value['hour'].':'.$value['minute'];
									$value = $date.' '.$time;
								}
							}
							else
							{
								// if 'include_custom' is used
								if (empty($value['year']) && empty($value['month']) && empty($value['day']))
								{
									$value = null;
								}
								else
								{
									$value = $date;
								}
							}
						}
						else
						{
							$value = implode(";", $value);
						}
					}

					if ($key == "Related")
					{
						if ($value)
						{
							$value = '['.str_replace(';', '][', $value).']';
							$value = str_replace('[]', '', $value);
						}
					}
					if ($key == "Keywords")
					{
						if ($value)
						{
							$value = '['.str_replace(',', '][', $value).']';
							$value = str_replace('[]', '', $value);
						}
					}
					$obj->$function($value);
				}
			}

			// Page content save
			if (($documentName == 'Page') && (count($contentArr) > 0))
			{
				// add original NON-RICHTEXT content blocks
				$orgContent = $obj->getContent();
				$blocks = self::get_content_blocks($orgContent);
				foreach ($blocks as $name => $block)
				{
					$contentArr[$name] = '<block id="'.$name.'" target="'.$block['target'].'" action="'.$block['action'].'"><![CDATA['.$block['content'].']]></block>';
				}

				$allBlocks = PanelService::get_all_content_blocks($orgContent);
				$content = '';
				foreach ($allBlocks as $blockName => $blockData)
				{
					$content .= $contentArr[$blockName];
				}
				$content = '<?xml version="1.0" encoding="UTF-8"?><blocks>'.$content.'</blocks>';
				$obj->setContent($content);
			}

/*			if (class_exists($documentName."I18n") && $documentName != "Listitem")
			{
				if (!$culture = $parameters["attrCulture"])
				{
					$culture = sfContext::getInstance()->getUser()->getCulture();
				}
				$obj->save(null, $parent, $culture);
				if(class_exists($documentName."I18n"))
				{
					$objI8n = Document::getDocumentByCulture($obj, null, true);
					self::objectSave($objI8n, $obj, $documentName."I18n");
					if ($documentName == "Page")
						$objI8n->setRewriteUrl($parameters["attrRewriteUrl"]);
					$objI8n->setCulture($culture);
					$objI8n->save(null, $obj, $culture);
				}
			}
			else*/
			{
				if ($documentName == "Page")
					$obj->setRewriteUrl($parameters["attrRewriteUrl"]);
				$obj->save(null, $parent);
			}

			if ($tags = Document::getAvailableTagsOf($parameters['moduleName'], $documentName))
			{
				foreach ($tags as $tag)
				{
					if ( $parameters['tag_id_'.$tag->getId()] )
					{
						Document::addTag($obj, $tag->getTagId());
					}
					else
					{
						Document::removeTag($obj, $tag->getTagId());
					}
				}
				Tagrelation::updateTagRelationCache();
			}
			//UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public static function objectEdit($moduleName, $documentName, &$act, $id = null)
	{
		if ($act->getRequestParameter('id') && is_null($id))
		{
			$id = $act->getRequestParameter('id');
		}
		$act->obj = null;
		if ($id)
		{
			$act->obj = Document::getDocumentInstance($id);
		}
		$act->tags = Document::getAvailableTagsOf($moduleName, $documentName);
		$act->moduleName = $moduleName;
		$act->documentName = $documentName;

		$act->formAction = "";
		return "Success";
	}

}