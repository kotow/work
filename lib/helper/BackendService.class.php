<?php

class BackendService
{

	public static function loadChildrenRelations()
	{
		if(!sfConfig::get("sf_use_relations_cache")) return false;
		$path = sfConfig::get('sf_root_dir')."/cache/objcache/childrenRelations.php";
		if(is_readable($path))
		{
			$pathTime = filemtime($path);
			if (!array_key_exists('childrenRelations', $_SESSION) || !is_array($_SESSION['childrenRelations']) ||
			(array_key_exists('RelationsTime', $_SESSION) && $_SESSION["RelationsTime"] < $pathTime))
			{
				include $path;
				if(!is_readable($path) || !isset($_Rel))
				{
					return false;
				}
				$_SESSION['childrenRelations'] = $_Rel; unset($_Rel);
				$_SESSION['RelationsTime'] = $pathTime;
			}
			return true;
		}
		else
		{
			$_SESSION['childrenRelations'] = null;
			$_SESSION['RelationsTime'] = null;
		}
		return false;
	}

/*	public static function loadChildrenRelations($id)
	{
		if(!sfConfig::get("sf_use_relations_cache"))
		{
//			if ($_SERVER['REMOTE_ADDR']=='213.226.13.26') echo "sf_use_relations_cache: return false";
			return false;
		}
//		$path = sfConfig::get('sf_root_dir')."/cache/objcache/childrenRelations.php";
		$path = Document::getCachePath($id)."children".$id.".php";
		if(is_readable($path))
		{
			$pathTime = filemtime($path);
			if (!array_key_exists('childrenRelations', $_SESSION) || !is_array($_SESSION['childrenRelations']) ||
				(array_key_exists('RelationsTime', $_SESSION) &&
				(!array_key_exists($id, $_SESSION['RelationsTime']) ||
					(array_key_exists($id, $_SESSION['RelationsTime']) && $_SESSION["RelationsTime"][$id] < $pathTime))) )
			{
				include $path;
				if(isset($_Rel))
				{
					$_SESSION['childrenRelations'][$id] = $_Rel; //unset($_Rel);
					$_SESSION['RelationsTime'][$id] = $pathTime;
					return true;
				}
			}
			if (array_key_exists($id, $_SESSION['RelationsTime']) && $_SESSION["RelationsTime"][$id] == $pathTime)
			{
				return true;
			}
			return false;
		}
		$_SESSION['childrenRelations'][$id] = null;
		$_SESSION['RelationsTime'][$id] = null;
		return false;
	}*/

	public static function loadTagsRelations()
	{
		if(!sfConfig::get("sf_use_relations_cache")) return false;
		$path = sfConfig::get('sf_root_dir')."/cache/objcache/tagsRelations.php";
		
		//echo "LOADING FROM TAG RELATIONS";
		if(is_readable($path))
		{
			$pathTime = filemtime($path);
			if (!array_key_exists('tagsRelations', $_SESSION) || ($_SESSION["tagsRelationsTime"] < $pathTime))
			{
				include $path;
				if(!isset($_TagRel))
				{
					return false;
				}
				$_SESSION['tagsRelations'] = $_TagRel; unset($_TagRel);
				$_SESSION['tagsRelationsTime'] = $pathTime;
			}
			return true;
		}
		else
		{
			$_SESSION['tagsRelations'] = null;
			$_SESSION['tagsRelationsTime'] = null;
		}
		return false;
	}

	public static function loadUrlRelations()
	{
		if(!sfConfig::get("sf_use_relations_cache")) return false;
		$path = sfConfig::get('sf_root_dir')."/cache/objcache/urlRelations.php";
		if(is_readable($path))
		{
			$pathTime = filemtime($path);
			if (!array_key_exists('urlRelations', $_SESSION) || ($_SESSION["urlRelationsTime"] < $pathTime))
			{
				include $path;
				if(!isset($_UrlRel))
				{
					return false;
				}
				$_SESSION['urlRelations'] = $_UrlRel; unset($_UrlRel);
				$_SESSION['urlRelationsTime'] = $pathTime;
			}
			return true;
		}
		else
		{
			$_SESSION['urlRelations'] = null;
			$_SESSION['urlRelationsTime'] = null;
		}
		return false;
	}

	public static function makePhpArray($root, $moduleName, $displayedObjects, $level = 0, $tree = "left")
	{
		$arrChildren = array();
		if (Document::hasChildren($root))
		{
			$context = sfContext::getInstance();
			$user = $context->getUser();
			$user->setAttribute('search_keys', false);

			$owner = $user->getSubscriber();
			$ownerId = $owner->getId();

			foreach ($displayedObjects as $do)
			{

				/*$c = new Criteria();
				$c->add(RelationPeer::ID1, $root);
				$c->add(RelationPeer::DOCUMENT_MODEL2,  $do);
				if($owner->getType() != "admin" && in_array($moduleName, array("user","news")))
				{
				$c->addJoin(RelationPeer::ID2, DocumentPeer::ID, Criteria::LEFT_JOIN );
				$c->add(DocumentPeer::DOCUMENT_AUTHOR, $ownerId);
				}
				$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);
				$rels = RelationPeer::doSelect($c, null);

				foreach ($rels as $rel)*/
				//////// SPECIFIC/////
				/*if($moduleName == "user" && $do == 'Folder')
				{
				$children = Document::getChildrenOf($root, $do, true, false, FolderPeer::LABEL);
				}
				elseif($moduleName == "user" && $do == 'User')
				{
				$children = Document::getChildrenOf($root, $do, true, false, UserPeer::LABEL);
				}
				else*/
				///////////////////////
				{
					$children = Document::getChildrenOf($root, $do);
				}

				foreach ($children as $child)
				{
					$childClass = get_class($child);

					if (in_array($childClass, $displayedObjects) || count($displayedObjects) == 0)
					{
						$childItem = array();
						$childId = $child->getId();

						$childItem['id'] = $childId;
						$childItem['parent'] = $root;
						$childItem['model'] = $childClass;
						$childItem['class'] = $moduleName."_".strtolower($childClass);
						$childItem['label'] = $child->getLabel();
						$childItem['level'] = $level+1;
						$childItem['status'] = Document::getGenericDocument($child)->getPublicationStatus();
						if ($childClass == 'Media')
						{
							$childItem['image'] = $child->isImage();
						}

						$arrChildren[] = $childItem;
						$childrenArr = self::makePhpArray($childId, $moduleName, $displayedObjects, $level+1, $tree);
						$arrChildren = array_merge($arrChildren, $childrenArr);
					}
				}
			}
		}
		return $arrChildren;
	}

	public static function makePhpCache($contentArr, $moduleName, $tree, $saveToFile = true)
	{
		$content = "<?php\n\n".
		"\$contentArray = array(\n";
		foreach($contentArr as $contentItem)
		{
			$content .= "\t".$contentItem['id']."\t\t=> array(";
			foreach ($contentItem as $k => $v)
			{
				if (is_int($v))
				$content .= " '".$k."' => ".$v.",";
				else
				$content .= " '".$k."' => '".addslashes($v)."',";
			}
			$content = substr($content, 0, -1)."),\n";
		}
		$content = substr($content, 0, -2)."\n);\n\n?>";

		if ($saveToFile)
		{
			$moduleName = ucfirst($moduleName);
			/*if($tree == "right")
			{
			$writeResult = FileHelper::writeFile(sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_rightTree.php", $content);
			}
			else*/
			if($tree == "mce")
			{
				$writeResult = FileHelper::writeFile(sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_mceTree.php", $content);
			}
			else
			{
				$writeResult = FileHelper::writeFile(sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_Tree.php", $content);
			}

			if ($writeResult)
			{
				return self::makeHtmlCache($moduleName, $tree);
			}
			else
			{
				return "Error caching tree";
			}
		}
		return $content;
	}

	public static function getLeftTree($moduleName, $action = false, $updatedId = null)
	{
		$lmn = strtolower($moduleName);
		/*$htmlCacheFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_leftTree.html";

		if (is_readable($htmlCacheFile))
		{
			$content = file_get_contents($htmlCacheFile);
			return $content;
		}

		$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_Tree.php";
		if (is_readable($phpFile))
		{
			return self::makeHtmlCache($moduleName, "left");
		}*/

		$lmn2 = $lmn;
		if ($lmn2 == "tag")
		{
			$lmn2 = "admin";
		}
		$leftTree = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/modules/".$lmn2."/config/leftTree.xml");
		$displayedObjects = array();
		$rootId = null;

		foreach ($leftTree as $obj)
		{
			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
			{
				$displayedObjects[] = $obj['value'];
			}

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

		$document = Rootfolder::getRootfolderByModule($moduleName);
		if (!$rootId)
		{
			$rootId = $document->getId();
		}
		$contentArr = self::makePhpArray($rootId, $lmn, $displayedObjects);

		// make Root element
		$rootItem = array(); $docId = $document->getId();
		$rootItem[$docId]['id'] = $document->getId();
		$rootItem[$docId]['model'] = 'rootfolder';
		$rootItem[$docId]['treeParent'] = $rootId;
		$rootItem[$docId]['class'] = $lmn.'_rootfolder';
		$rootItem[$docId]['level'] = 0;
		$rootItem[$docId]['label'] = addslashes($document->getLabel());
		$contentArr = array_merge($rootItem, $contentArr);

		return self::makePhpCache($contentArr, $moduleName, "left");
	}

	public static function makeHtmlCache($moduleName, $tree)
	{
		$moduleName = ucfirst($moduleName);
		/*if($tree == "right")
		{
		$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_rightTree.php";
		}
		else*/
		if($tree == "mce")
		{
			$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_mceTree.php";
		}
		else
		{
			$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_Tree.php";
		}

		include $phpFile;

		$content = "";
		$lastLevel = 0;
		$closingTag = array(); $closingTag[-1] = "*";
		$tabs = array(); $tabs[-1] = "*";

		// find MAX level
		$maxLevel = 0;
		foreach ($contentArray as $item)
		{
			if ($item['level'] > $maxLevel)
			{
				$maxLevel = $item['level'];
			}
		}
		// create "Tabs" and "ClosingTabs" arrays
		$tabs[0] = ""; $tab = "";
		for ($i=1; $i <= $maxLevel; $i++)
		{
			$tab .= "\t\t";
			$tabs[$i] = $tab;
			$closingTag[$i] .= $tabs[$i]."</ul>\n".$tabs[$i-1]."\t</li>\n";
		}
		//------------------------------------------------------------------
		foreach ($contentArray as $item)
		{
			$itemLevel = $item['level'];

			if ($lastLevel < $itemLevel)
			{
				$content .= $tabs[$itemLevel]."<ul id='ul_".$childId."'>\n";
			}
			elseif ($lastLevel != 0)
			{
				$content .= $tabs[$lastLevel]."\t</li>\n";
			}

			if ($lastLevel > $itemLevel)
			{
				for ($i = $lastLevel; $i>$itemLevel; $i--)
				{
					$content .= $closingTag[$i]."\n";
				}
			}

			$childId = $item['id'];
			$childModel = $item['model'];
			$childLabel = $item['label'];
			$childClass = $item['class'];

			$isImage = '';
			$onclick = '';

			/*if ($tree == "right")
			{
			if ($childModel == 'Media')
			{
			$isImage = 'image="'.$item['image'].'"';

			if($item['image'] == 1)
			{
			$onclick = 'onclick="selectMedia('.$childId.', 1)"';
			}
			else
			{
			$onclick = 'onclick="selectMedia('.$childId.')"';
			}
			}
			elseif($childModel != 'Folder' && $childModel != 'rootfolder')
			{
			$isImage = '';
			$onclick = 'onclick="selectMedia('.$childId.')"';
			}


			$content .=
			$tabs[$itemLevel]."\t<li>\n".
			$tabs[$itemLevel]."\t\t".'<span id="'.$childId.'" '.$isImage.' style="background: url(/images/icons/'.strtolower($childModel).'.png) 0 0 no-repeat" '.$onclick.'>'."\n".
			$tabs[$itemLevel]."\t\t\t".$childLabel."\n".
			$tabs[$itemLevel]."\t\t</span>\n";
			}
			else*/
			if ($tree == "mce")
			{
				if ($childModel == 'Media')
				{
					$isImage = 'image="'.$item['image'].'"';
				}
				else
				{
					$isImage = 'image="0"';
				}
				$content .=
				$tabs[$itemLevel]."\t<li>\n".
				$tabs[$itemLevel]."\t\t".'<span class="'.$childClass.'" onclick="previewTemplate(this)" name="'.strtolower($moduleName).'_'.$childModel.'" id="'.$childId.'" '.$isImage.' style="padding-left:20px; background: url(/images/icons/'.strtolower($childModel).'.png) 0 0 no-repeat" >'."\n".
				$tabs[$itemLevel]."\t\t\t".$childLabel."\n".
				$tabs[$itemLevel]."\t\t</span>\n";
			}
			else
			{
				$content .=
				$tabs[$itemLevel]."\t<li id='li_".$childId."' >\n".
				$tabs[$itemLevel]."\t\t".'<span id="'.$childId.'" class="draggable '.$childClass.'" style="background: url(/images/icons/'.strtolower($childModel).'.png) 0 0 no-repeat" onclick="parseMainList(this)">'."\n".
				$tabs[$itemLevel]."\t\t\t".$childLabel."\n".
				$tabs[$itemLevel]."\t\t</span>\n";
			}

			$lastLevel = $itemLevel;
		}

		$content .= $tabs[$lastLevel]."</li>\n";
		if ($lastLevel > 0)
		{
			$closingTags = "";
			for ($i = $lastLevel; $i > 0; $i--)
			{
				$closingTags .= $closingTag[$i];
			}
		}
		$content .= $closingTags."\n"; //."</li>\n";

		return $content;
		/*if (FileHelper::writeFile(sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_".$tree."Tree.html", $content))
		{
		return $content;
		}
		else
		{
		return "Error caching left tree";
		}*/
	}

	public static function updateTree($moduleName, $document, $action = "UPDATE", $tree = "left")
	{
		if ($moduleName == 'admin')
		{
			$moduleName = 'tag';
		}

		$moduleName = ucfirst($moduleName);

		/*if($tree == "right")
		{
		$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_rightTree.php";
		}
		else*/
		if($tree == "mce")
		{
			$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_mceTree.php";
			// TEMPORARY FIX
			if($tree == "mce" && $action == "DELETE") unlink($phpFile);
		}
		else
		{
			$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_Tree.php";
		}

		// if Tree cache file doesn't exists -> exit!
		if (!is_readable($phpFile))
		{
			return;
		}

		include $phpFile;
		$docId = $document->getId();

		if ($action == "DOWN" && $contentArray[$docId])
		{
			$docStart = $docEnd = $nextStart = $nextEnd = -1;
			$docLevel = $contentArray[$docId]['level'];
			// Finding where DOC block starts
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($k == $docId)
				{
					$docStart = $i;
					break;
				}
				$i++;
			}
			// Finding where NEXT block starts
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if (($nextStart < 0) && ($contentArray[$k]['level'] == $docLevel))
				{
					if ($i > $docStart)
					{
						$nextStart = $i;
						break;
					}
				}
				$i++;
			}
			// Finding where DOC block ends
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($docEnd >= 0)
				{
					if ($contentArray[$k]['level'] > $docLevel)
					$docEnd = $i;
					else
					break;
				}
				if ($i == $docStart)
				{
					$docEnd = $i;
				}
				$i++;
			}
			// Finding where NEXT block ends
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($nextEnd >= 0)
				{
					if ($contentArray[$k]['level'] > $docLevel)
					$nextEnd = $i;
					else
					break;
				}
				if ($i == $nextStart)
				{
					$nextEnd = $i;
				}
				$i++;
			}
			//===============================================================
			if ($nextEnd >= 0)
			{
				$docArr = array_slice($contentArray, $docStart, $docEnd - $docStart + 1);
				$nextArr = array_slice($contentArray, $nextStart, $nextEnd - $nextStart + 1);

				$start = array_slice($contentArray, 0, $docStart);
				$last = array_slice($contentArray, $nextEnd);

				$contentArray = array_merge($start, array_merge($nextArr, array_merge($docArr, $last)));
			}
		}
		elseif ($action == "UP" && in_array($docId, $contentArray))
		{
			$docStart = $docEnd = $prevStart = $prevEnd = -1;
			$docLevel = $contentArray[$docId]['level'];
			// Finding where DOC block starts
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($k == $docId)
				{
					$docStart = $i;
					break;
				}
				$i++;
			}
			// Finding where PREV block starts
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($contentArray[$k]['level'] == $docLevel)
				{
					if ($i < $docStart)
					$prevStart = $i;
				}
				$i++;
			}
			// Finding where DOC block ends
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($docEnd >= 0)
				{
					if ($contentArray[$k]['level'] > $docLevel)
					$docEnd = $i;
					else
					break;
				}
				if ($i == $docStart)
				{
					$docEnd = $i;
				}
				$i++;
			}
			// Finding where PREV block ends
			$i = 0;
			foreach ($contentArray as $k => $v)
			{
				if ($prevEnd >= 0)
				{
					if ($contentArray[$k]['level'] > $docLevel)
					$prevEnd = $i;
					else
					break;
				}
				if ($i == $prevStart)
				{
					$prevEnd = $i;
				}
				$i++;
			}
			//===============================================================
			if ($prevStart >= 0)
			{
				$docArr = array_slice($contentArray, $docStart, $docEnd - $docStart + 1);
				$prevArr = array_slice($contentArray, $prevStart, $prevEnd - $prevStart + 1);

				$start = array_slice($contentArray, 0, $prevStart);
				$last = array_slice($contentArray, $docEnd);

				$contentArray = array_merge($start, array_merge($docArr, array_merge($prevArr, $last)));
			}
		}
		elseif ($action == "DELETE")
		{
			// if document not in the Tree -> exit!
			if (!in_array($docId, $contentArray))
			{
				return;
			}
			$newArray = array();
			$level = $contentArray[$docId]['level'];
			$deleteRest = false;
			foreach ($contentArray as $k => $v)
			{
				if ($k == $docId)
				{
					//unset($contentArray[$k]);
					$deleteRest = true;
				}
				elseif ($deleteRest && ($contentArray[$k]['level'] <= $level))
				{
					$deleteRest = false;
				}
				if (!$deleteRest)
				{
					$newArray[$k] = $contentArray[$k];
				}
			}
			$contentArray = $newArray;
		}
		else
		{

			if (array_key_exists($docId, $contentArray)) // update!!!
			{
				$contentArray[$docId]['label'] = addslashes($document->getLabel());
				$contentArray[$docId]['status'] = Document::getGenericDocument($document)->getPublicationStatus();
			}
			else // insert!
			{
				$parent = Document::getParentOf($docId, null, true, false);
				if($parent) $parentId = $parent->getId();

				// if document not in the Tree -> exit!
				$oldContentArray = $contentArray;
				$first = array_shift($oldContentArray);
				if (array_key_exists('treeParent', $first) && ($first['treeParent'] == $first['id']) && (!$contentArray[$parentId]))
				{
					return;
				}
				else
				{
					if (!$contentArray[$parentId])
					{
						$parentId = $first['id'];
					}
				}

				$lmn = strtolower($moduleName);
				$lmn2 = $lmn;
				if ($lmn2 == "tag")
				{
					$lmn2 = "admin";
				}
				$leftTree = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/modules/".$lmn2."/config/".$tree."Tree.xml");
				$displayedObjects = array();
				foreach ($leftTree as $obj)
				{
					if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
					{
						$displayedObjects[] = $obj['value'];
					}
				}

				if (!in_array(get_class($document), $displayedObjects))
				{
					return null;
				}

				$docModel = get_class($document);

				$newItem = array();
				$newItem[$docId]['id'] = $docId;
				$newItem[$docId]['parent'] = $parentId;
				$newItem[$docId]['model'] = $docModel;
				$newItem[$docId]['class'] = $lmn.'_'.strtolower($newItem[$docId]['model']);
				$newItem[$docId]['label'] = addslashes($document->getLabel());
				$newItem[$docId]['level'] = $contentArray[$parentId]['level'] + 1;

				if($docModel == "Media")
				{
					$newItem[$docId]['image'] = $document->isImage();
				}

				$newItem[$docId]['status'] = Document::getGenericDocument($document)->getPublicationStatus();

				$position = 0; $level = -1;
				foreach ($contentArray as $k => $v)
				{
					if ($level >= 0)
					{
						if ($contentArray[$k]['level'] > $level)
						{
							//
						}
						else
						{
							break;
						}
					}
					if ($k == $parentId)
					{
						// get level of the Parent object
						$level = $contentArray[$k]['level'];
					}
					$position++;
				}

				$leftArr = array_slice($contentArray, 0, $position);
				$rightArr = array_slice($contentArray, $position);
				$contentArray = array_merge($leftArr, array_merge($newItem, $rightArr));
			}
		}

		/*if($tree == "right")
		{
		self::makePhpCache($contentArray, $moduleName, "right");
		}
		else*/
		if($tree == "mce")
		{
			self::makePhpCache($contentArray, $moduleName, "mce");
		}
		else
		{
			self::makePhpCache($contentArray, $moduleName, "left");
		}
	}

	public static function getMainList($documentId, $moduleName, $page = 1, $filter = null)
	{
		try
		{
			if ($moduleName == "Tag")
			{
				$moduleName = "Admin";
			}

			$mainList = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/modules/".strtolower($moduleName)."/config/mainList.xml");
			$displayedObjects = array();

			foreach ($mainList as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
				{
					$displayedObjects[] = $obj['value'];
				}
			}

			$c = new Criteria();

			if(empty($filter))
			{
				if($documentId > 0)
				{
					$context = sfContext::getInstance();
					$user = $context->getUser();
					$user->setAttribute('search_keys', false);

					$owner = $user->getSubscriber();
					$ownerId = $owner->getId();

					/*if($owner->getType() != "admin")
					{
						$c->addJoin(RelationPeer::ID2, DocumentPeer::ID, Criteria::LEFT_JOIN );
						$c->add(DocumentPeer::DOCUMENT_AUTHOR, $ownerId);
					}*/

					$pager = new sfPropelPager("Relation", 50);
					$c->add(RelationPeer::ID1, $documentId);
					$c->add(RelationPeer::DOCUMENT_MODEL2, $displayedObjects, Criteria::IN);

					$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);

				}
				else
				{
					$results['children'] = null;
					$results['pager'] = null;
					return $results;
				}
			}
			else
			{
				BackendFilters::$filter($c, $pager);
				if(!is_object($pager))
				{
					$pager = new sfPropelPager($pager, 50);
				}
			}

			if(get_class($c) == "Criteria")
			{
				$pager->setCriteria($c);
			}
			else
			{
				$pager->setResults($c);
			}

			$pager->setPage($page);
			$pager->init();

			if(empty($filter))
			{
				foreach ($pager->getResults() as $relation)
				{
					$id = $relation->getId2();
					$children[] = Document::getDocumentInstance($id);
				}
			}
			else
			{
				$children = $pager->getResults();
			}

			$results['children'] = $children;
			$results['pager'] = $pager;

			return $results;
		}
		catch(Exception $e)
		{
			exit($e->getMessage());
		}
	}

	public static function getUserRightsPanel($user, $class, $moduleName)
	{
		$userRights = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/panel/config/rights.xml");
//		var_dump($userRights);
		if ($user)
			$type = $user->getType();
		
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
					$val = $obj['value']; $allowed = array();
					if (strpos($val, "I18n") == false)
					{
						$tmp = explode(',', $obj["attributes"]["COMMANDS"]);
						foreach ($tmp as $v)
						{
							if (strpos($v, "I18n") == false)
								$allowed[] = $v;
						}
						$commands[$obj['value']] = implode(',', $allowed);
					}
				}
			}
//			echo $ind++."<br/>";
		}
//		var_dump($commands);
		return $commands;
	}
	public static function getMainListPanel($documentId, $moduleName, $page = 1)
	{
		$moduleName = strtolower($moduleName);
		try
		{
			if ($moduleName == "tag")
			{
				$moduleName = "admin";
			}

			$mainList = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/panel/modules/".$moduleName."/config/mainList.xml");
			$displayedObjects = array();

			foreach ($mainList as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
				{
					$displayedObjects[] = $obj['value'];
				}
			}

			$children = array();
			$res = array('children','paging');
			$c = new Criteria();
			if(!$documentId)
			{
				$document = Rootfolder::getRootfolderByModule($moduleName);
				if($document) $documentId = $document->getId();
			}
			if($documentId)
			{
				$pager = new sfPropelPager("Relation", 20);
				$c->add(RelationPeer::ID1, $documentId);
				$c->add(RelationPeer::DOCUMENT_MODEL2, $displayedObjects, Criteria::IN);

				if($moduleName == 'houses' || $moduleName == 'jobs')
				{
					$c->addDescendingOrderByColumn(RelationPeer::ID2);
				}
				else
				{
					$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);
				}

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

	/*
	* getRightTree
	* @param $moduleName;
	*/

	public static function getRightTree($moduleName)
	{
/*
		$lmn = strtolower($moduleName);
		$umn = ucfirst($moduleName);

		$htmlCacheFile = sfConfig::get('sf_root_dir')."/cache/backend/".$umn."_rightTree.html";

		if (is_readable($htmlCacheFile))
		{
			$content = file_get_contents($htmlCacheFile);
			return $content;
		}

		$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$umn."_rightTree.php";
		if (is_readable($phpFile))
		{
			return self::makeHtmlCache($moduleName, "right");
		}

		$rightTree = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/modules/".$lmn."/config/rightTree.xml");

		$displayedObjects = array();

		foreach ($rightTree as $obj)
		{
			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
			{
				$displayedObjects[] = $obj['value'];
			}
		}

		$document = Rootfolder::getRootfolderByModule($umn);
		$docId = $document->getId();
		$contentArr = self::makePhpArray($docId, $lmn, $displayedObjects);

		// make Root element
		$rootItem = array();
		$rootItem[$docId]['id'] = $document->getId();
		$rootItem[$docId]['model'] = 'rootfolder';
		$rootItem[$docId]['class'] = $lmn.'_rootfolder';
		$rootItem[$docId]['level'] = 0;
		$rootItem[$docId]['label'] = addslashes($document->getLabel());
		$contentArr = array_merge($rootItem, $contentArr);

		return self::makePhpCache($contentArr, $umn, "right");*/
	}

	public static function getLanguageBar($parent, $moduleName = '')
	{
		$parentDoc = Document::getDocumentInstance($parent);
		$children = Document::getChildrenOf($parent, get_class($parentDoc)."I18n");

		$childrenArray = array();
		$iconExtension = '.gif';

		// if we load an other module tree (config in <mymodule>/config/leftTree.xml param "parent" on tag <objects>)
		/*$leftTree = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/modules/".strtolower($moduleName)."/config/leftTree.xml");
		if ($leftTree[0]['attributes']['PARENT'])
		{
			return null;
		}*/

		$i = 0;
		foreach ($children as $child)
		{
			$childClass = get_class($child);
			$childrenArray[$i]['id'] = $child->getId();

			$culture = $child->getCulture();

			$con = Propel::getConnection();
			$con->begin();
			$c = new Criteria();
			$c->addAnd(ListitemPeer::VALUE, $culture, Criteria::EQUAL);
			$cultureObj = ListitemPeer::doSelectOne($c);

			$childrenArray[$i]['culture'] = $cultureObj;
			$childrenArray[$i]['type'] = $childClass;
			$childrenArray[$i]['class'] = strtolower($moduleName).'_'.strtolower($childClass);
			$childrenArray[$i]['style'] = "background: url(/images/icons/".$culture.$iconExtension.") 0 0 no-repeat;";
			$i++;
		}

		return $childrenArray;
	}

	public static function getResources($moduleName)
	{
		$configFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.strtolower($moduleName).DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'resources.xml';
		$content = '<option value="">Select module...</option>';
		if (!file_exists($configFile))
		{
			return $content;
		}

		$tags = XMLParser::getXMLdataValues($configFile);
		foreach ($tags as $tag)
		{
			if ($tag['tag'] == 'RESOURCE')
			{
				$content .= '<option value="'.$tag['attributes']['ID'].'">'.$tag['attributes']['ID'].'</option>';
			}
		}

		return $content;
	}

	/////////////////////////////////////////////////////////////
	public static function getMceTree($moduleName)
	{
		$lmn = strtolower($moduleName);
		$moduleName = ucfirst($lmn);

		$htmlCacheFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_mceTree.html";

		if (is_readable($htmlCacheFile))
		{
			$content = file_get_contents($htmlCacheFile);
			return $content;
		}

		$phpFile = sfConfig::get('sf_root_dir')."/cache/backend/".$moduleName."_mceTree.php";
		if (is_readable($phpFile))
		{
			return self::makeHtmlCache($moduleName, "mce");
		}

		$rightTree = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/modules/".$lmn."/config/mceTree.xml");

		$displayedObjects = array();

		foreach ($rightTree as $obj)
		{
			if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'complete'))
			{
				$displayedObjects[] = $obj['value'];
			}
		}

		$document = Rootfolder::getRootfolderByModule($moduleName);
		$docId = $document->getId();
		$contentArr = self::makePhpArray($docId, $lmn, $displayedObjects);

		// make Root element
		$rootItem = array();
		$rootItem[$docId]['id'] = $document->getId();
		$rootItem[$docId]['model'] = 'rootfolder';
		$rootItem[$docId]['class'] = $lmn.'_rootfolder';
		$rootItem[$docId]['level'] = 0;
		$rootItem[$docId]['label'] = addslashes($document->getLabel());
		$contentArr = array_merge($rootItem, $contentArr);

		return self::makePhpCache($contentArr, $moduleName, "mce");
	}

	/* ================================================================================================================================================== */

	public static function objectSave(&$obj, &$parent, $documentName = null)
	{
		try
		{
			$parameters = sfContext::getInstance()->getRequest()->getParameterHolder()->getAll();

			if(!$documentName)
			{
				$documentName = $parameters["documentName"];
			}

			if(!$parent) $parent = Document::getDocumentInstance($parameters['parent']);
			if(!is_object($obj))
			{
				if (is_numeric($parameters['id']) && !$parent)
				{
					$obj = Document::getDocumentInstance($parameters['id']);
					$parent = Document::getParentOf($parameters['id']);
					$documentName = $parameters["documentName"];
				}
				else
				{
					$obj = new $documentName();
				}
			}

			include_once(sfConfig::get('sf_root_dir')."/config/Schema.class.php");

			$m = "get".$documentName."Properties";
			$properties = Schema::$m();

			//$imageFields = explode(",", $parameters['imageFields']);

			foreach ($parameters as $key => $value)
			{
				if (!(strpos($key, 'attr') === false) && ($key != "attrRewriteUrl"))
				{
					$key = str_replace('attr', '', $key);

					if($properties && $key != "Password" && !in_array($key, $properties)) continue;
					if($key == "Password" && empty($value)) continue;

					$function = 'set'.$key;
					if (is_array($value))
					{
						//$value = implode('-', $value);
						$date = $value['year'].'-'.$value['month'].'-'.$value['day']; // 2009-02-09 16:10:20
						if ($value['hour'] && $value['minute'])
						{
							$time = $value['hour'].':'.$value['minute'];
							$value = $date.' '.$time;
						}
						else
						{
							$value = $date;
						}
					}

					/*if (in_array($key, $imageFields))
					{
					$getFunction = 'get'.$key;

					$imgId = $obj->$getFunction();
					if ($imgId != $value)
					{
					$img = Document::getDocumentInstance($imgId);
					if ($img)
					{
					$imgExt = $img->getExtention();
					@unlink(sfConfig::get('sf_root_dir')."/www/media/upload/thumbs/".$parameters["moduleName"]."/".$imgId."-".$key.".".$imgExt);
					}
					}
					}*/

					if ($key == "Keywords")
					{
						if($value)
						{
							$value = str_replace(',', '][', $value);
							$value = '['.substr($value, 0, -1);
						}

					}
					$obj->$function($value);
				}

				/*if (in_array($key, $imageFields) && (!empty($value)))
				{
					$image = Document::getDocumentInstance($value);
					if ($image)
					{
						if (empty($parameters[$key.'_thumbheight']))
						{
							$parameters[$key.'_thumbheight'] = null;
						}
						if (empty($parameters[$key.'_thumbwidth']))
						{
							$parameters[$key.'_thumbwidth'] = null;
						}
						$image->resizeImage($parameters["moduleName"], $parameters[$key.'_thumbheight'], $parameters[$key.'_thumbwidth'], $key);
					}
				}*/
			}

			if (class_exists($documentName."I18n") && $documentName != "Listitem")
			{
				if (!$culture = $parameters["attrCulture"])
				{
					if(SF_APP == "panel")
						$culture = sfContext::getInstance()->getUser()->getCulture();
					else
						$culture = Document::getDocumentByExclusiveTag("default_culture");
					if($culture)
						$culture = $culture->getValue();
					else
						throw new Exception("No default culture defined");
				}
				
				$obj->save(null, $parent, $culture);
				
				if(!$parameters["id"] || SF_APP == 'panel')
				{
					if(class_exists($documentName."I18n"))
					{
						if(SF_APP == "panel")
						{
							$objI8n = Document::getDocumentByCulture($obj, null, true);
						}
						self::objectSave($objI8n, $obj, $documentName."I18n");
						if($documentName == "Page") $objI8n->setRewriteUrl($parameters["attrRewriteUrl"]);
						$objI8n->setCulture($culture);
						$objI8n->save(null, $obj, $culture);
					}
					
					if(SF_APP != "panel")
					{
						$request = sfContext::getInstance()->getRequest();
						$request->setParameter("id", $obj->getId());
					}
				}
			}
			else 
			{
				$obj->save(null, $parent);
			}
			
			$tags = Document::getAvailableTagsOf($parameters['moduleName'], $documentName);
			foreach ($tags as $tag)
			{
				if ($parameters['tag_id_'.$tag->getId()])
				{
					Document::addTag($obj, $tag->getTagId());
				}
				else
				{
					Document::removeTag($obj, $tag->getTagId());
				}
			}
			
			Tagrelation::updateTagRelationCache();
			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			throw $e;
		}

		if(SF_APP == "panel")
		{
			self::panelRedirect();
		}
	}

	public static function objectEdit($moduleName, $documentName, &$act, $id = null)
	{
		$act->setLayout("iframe");
		if ($act->getRequestParameter('id') && is_null($id))
		{
			$id = $act->getRequestParameter('id');
		}

		if($id)
		{
			$act->obj = Document::getDocumentInstance($id);
		}

		$act->tags = Document::getAvailableTagsOf($act->getRequestParameter('module'), $documentName);
		if($documentName == "Folder" || $documentName == "Tag")
		{
			$act->moduleName = $act->getUser()->getAttribute('currentModule');
		}
		else
		{
			$act->moduleName = $moduleName;
		}
		$act->documentName = $documentName;
//		$act->editAction = $moduleName."/edit".$documentName.'/id/'.$id;
		if (!in_array('executeSave'.$documentName, get_class_methods($moduleName.'Actions')))
		{
			$act->formAction =  "/admin/admin/save";
		}
		else
		{
			$act->formAction = "/admin/".$moduleName."/save".$documentName;
		}
	}

	/* ================================================================================================================================================== */

}