<?php
/*
Available options:
hasTags				-
mainMasterId		- mainTag's element master ID
mainMasterClass		- mainTag's element master class
mainMasterStyle		- mainTag's element master style
mainClass			- mainTag's elements class
mainSubClass		- mainTag's sub elements class
firstItemClass
lastItemClass
itemClass
currentItemClass
mainTag
subTag
aClass
currentAClass
separator
depth
hideSecure
hideLabel
inPath
getIndex
*/
class MenuHelper
{

	public static function get_menu_by_tag($tagname, $options = array())
	{
 		$menu = Document::getDocumentByExclusiveTag($tagname);
		if (!$menu)
		{
			return null;
		}
		/*$path = sfConfig::get('sf_root_dir')."/cache/menus/".$tagname.UtilsHelper::cleanStr($_SERVER['REQUEST_URI']);
		if (is_readable($path))
		{
			return file_get_contents($path);
		}*/
		$content = self::buildMenu($menu, array(), null, $options);
		//FileHelper::writeFile($path, $content);
		return $content;
	}

	public static function getSiteMap($root = null, &$sitemap, $depth = 1000, $level = 1, $path = null, $getIndex = false, $getInvisible = false)
	{
		if ($level > $depth) return array();

		$nolabel = UtilsHelper::Localize("website.frontend.nolabel");
		if (!$root)
		{
			$root = Rootfolder::getRootfolderByModule("website");
			if (!$root) return;
		}
		if (is_object($root))
		{
			$root = $root->getId();
		}
		$pathSet = false;

		if (Document::hasChildren($root))
		{
//			$oldRelationsFlag = sfConfig::get('sf_cache_relations');
//			sfConfig::set('sf_cache_relations', false);

			try
			{
				$children = Document::getChildrenOf($root, null, true, false);
				foreach ($children as $child)
				{
					// skip  Urlrewrite objects
					if ( (get_class($child) == "Urlrewrite") || (get_class($child) == "Media") ) continue;

					$href = "";
					$label = $nolabel;
					$childId = $child->getId();
					$class = get_class($child);

					$showItem = true;
					if (Document::getStatus($child) != UtilsHelper::STATUS_ACTIVE) continue;
					{
						if (!$getIndex && Document::hasTag($child, "website_page_index"))
						{
							continue;
						}

						if (!$getInvisible)
						{
							if ( ($class == 'Page' && Document::hasTag($child, "website_page_nonvisible")) ||
								($class == 'Topic' && Document::hasTag($child, "website_topic_nonvisible")) )
							{
								$id = $childId;
								$showItem = false;
								//continue;
							}
						}

						if ($showItem)
						{
							if ($class == "Page")
							{
								$type = $child->getPageType();
								$secure = $child->getIsSecure();
								//$label = $child->getLabel();
								$label = $child->getNavigationTitle();
								$href = $child->getHref();
								$id = $childId;
							}
							elseif ($class == "Topic")
							{
								$label .= $child->getLabel(); // " (".$child->getLabel().")";
								$indexPage = $child->getIndexPage();
								$id = 0;
								if ($indexPage)
								{
									//$id = $indexPage->getId();
									$id = $childId;
									$href = $indexPage->getHref();
									$label = $indexPage->getLabel();
									$type = $indexPage->getPageType();
//									if ($type == "REFERENCE")
//									{
//										//echo "--- Topic: ".$id." ---\n";
//										$pg = Document::getDocumentByCulture($indexPage->getPageId(), null, true); // get PageI18n object
//										if($pg)
//										{
//											$id = $pg->getId();
//											$href = $pg->getHref();
//											$secure = $pg->getIsSecure();
//										}
//									}
								}
							}
							else
							{
								$id = $childId;
								$label = $child->getLabel();
							}
						}
						if ($id && !$pathSet)
						{
							$path[] = $id;
							$pathSet = true;
						}
						else
						{
							$c = count($path);
							$path[$c-1] = $id;
						}
						
						$sitemap[$root][$childId]['path'] = $path;
						$sitemap[$root][$childId]['id'] = $id;
						$sitemap[$root][$childId]['href'] = $href;
						$sitemap[$root][$childId]['label'] = $label;
						if (array_key_exists('secure', $sitemap[$root][$childId]))
							$sitemap[$root][$childId]['secure'] = $secure;
						$sitemap[$root][$childId]['level'] = $level;
						$sitemap[$root][$childId]['model'] = $class;
						$sitemap[$root][$childId]['show'] = $showItem;
					}

					self::getSiteMap($child->getId(), $sitemap, $depth, $level+1, $path, $getIndex, $getInvisible);
				}
			}
			catch (Exception $e)
			{
				return null;
			}
//			sfConfig::set('sf_cache_relations', $oldRelationsFlag);
		}
		return $sitemap;
	}

	public static function buildMenu($root, $menuItems = array(), $rootId = null, $options = array(), $siteMap = null)
	{
		$defOptionsArr = array(
			"hasTags" => false,
			"mainMasterClass" => false,
			"mainMasterStyle" => false,
			"mainMasterId" => false,
			"mainClass" => false,
			"mainSubClass" => false,
			"firstItemClass" => false,
			"lastItemClass" => false,
			"itemClass" => false,
			"currentItemClass" => false,
			"mainTag" => false,
			"subTag" => false,
			"aClass" => false,
			"currentAClass" => false,
			"separator" => false,
			"depth" => false,
			"hideSecure" => false,
			"hideLabel" => false,
			"inPath" => false,
			"getIndex" => false,
			"splitElements" => 0
		);

		$class = null;
		foreach($defOptionsArr as $okey => $oval)
		{
			if(!array_key_exists($okey, $options)) $options[$okey] = false;
		}
		if ($options['inPath'] && !$siteMap)
		{
			self::getSiteMap(null, $siteMap, 1000, 1, null, false, true);
		}
		$sfcontext = sfContext::getInstance();
		if (!$rootId)
		{
			if(is_object($root))
			{
				$root = $root->getId();
			}

			$rootId = $root;
			$depth = isset($options['depth']) ? $options['depth'] : 1000;
			$menuItems = self::getSiteMap($rootId, $menuItems, $depth, 1, null , $options['getIndex']);
			if (isset($options["mainMasterClass"]))
				$class = $options["mainMasterClass"];
//			if ($options["mainMasterId"])
//				$masterId = $options["mainMasterId"];
//			if ($options["mainMasterStyle"])
//				$masterStyle = $options["mainMasterStyle"];
			$options['depth'] = $depth;
		}

		if (!isset($class) && isset($options["mainSubClass"]))
			$class = $options["mainSubClass"];
		if (isset($options["mainClass"]))
			$class .= ' '.$options["mainClass"];
		if (isset($options["splitElements"]) && is_numeric($options["splitElements"]))
		{
			$splitElements = intval($options["splitElements"]);
		}
		else
			$splitElements = 0;

		$tag = $options["mainTag"] ? $options["mainTag"] : "ul";
		$subTag = ($options["subTag"] && ($tag != "ul" || $tag != "ol")) ? $options["subTag"] : "li";

		$add = '';
		if ($class)
			$add .= ' class="'.$class.'"';
		if (isset($options["mainMasterId"]))
			$add .= ' id="'.$options["mainMasterId"].'"';
		if (isset($options["mainMasterStyle"]))
			$add .= ' style="'.$options["mainMasterStyle"].'"';
		if ($tag != 'none')
			$content = "<$tag".$add.">\n";

		$i = 1; $j = $i;
		if (array_key_exists($rootId, $menuItems))
		{
			$nbr = count($menuItems[$rootId]);

			// prepare "inPath" checker
			if ( $options['inPath'] && ($options['currentItemClass'] || $options['currentAClass']) )
			{
				$pageref = $sfcontext->getRequest()->getParameter("pageref");
				if ($par = Document::getParentOf($pageref))
				{
					$parId = $par->getId();
					if ($up = Document::getParentOf($parId))
					{
						$upId = $up->getId();
					}
				}
			}

			foreach ($menuItems[$rootId] as $k => $item)
			{
				if (!$item['show']) continue; // skip hidden items
				$newOptions = array();
				foreach ($options as $key => $option)
				{
					$newOptions[$key] = str_replace("%INDEX%", $i, $option);
				}

				if ($newOptions['hideLabel'])
				{
					$label = "";
				}
				else
				{
					$label = $item['label'];
				}
				
				if ($item['model'] != "Website" && $item['model'] != "Menu")
				{
					if ($newOptions['separator'] && $i > 1)
					{
						$content .= $newOptions['separator'];
					}

					if ($newOptions["hideSecure"] == true)
					{
						if (!isset($authentificated))
						{
							$user = $sfcontext->getUser();
							$authentificated = $user->isAuthenticated();
						}
						if ($item["secure"] == 1 && $authentificated == false) continue;
					}

					$itemClass = '';
					if ($newOptions['currentItemClass'])
					{
						if (isset($newOptions['inPath']))
						{
							$existInPath = in_array($item['id'], $siteMap[$upId][$parId]['path']);
						}

						if (!isset($existInPath))
							$existInPath = false;
						if ($pageref == $item['id'] || $existInPath)
						{
							$itemClass = $newOptions['currentItemClass'];
						}
					}
					if ($newOptions["itemClass"])
					{
						$itemClass = $newOptions["itemClass"];
					}

					if ($i == 1 && $newOptions['firstItemClass'])
						$itemClass .= " ".$newOptions['firstItemClass'];
					if ($i == $nbr && $newOptions['lastItemClass'])
						$itemClass .= " ".$newOptions['lastItemClass'];

					if ($itemClass)
						$itemClass = " class='".trim($itemClass)."'";

					$existInPath = false; $aClass = ' class="';
					if ($newOptions['currentAClass'])
					{
						if ($newOptions['inPath'])
						{
							$existInPath = in_array($item['id'], $siteMap[$upId][$parId]['path']);
						}

						if (!isset($existInPath))
							$existInPath = false;

						if ($pageref == $item['id'] || $existInPath)
						{
							$aClass .= $newOptions['currentAClass'];
						}
					}
					if ($newOptions['aClass'])
						$aClass .= ' '.$newOptions['aClass'];
					$aClass .= '" ';

					if (empty($item["href"]))
					{
						if ($tag != 'none')
							$content .= "<$subTag".$itemClass."><a href=\"javascript:void(0)\" ".$aClass.">".$label."</a>\n";
						else
							$content .= "<a href=\"javascript:void(0)\" ".$aClass.">".$label."</a>\n";
					}
					else
					{
						if ($tag != 'none')
							$content .= "<$subTag".$itemClass."><a href=\"".$item['href']."\"".$aClass." title=\"".$item['label']."\">".$label."</a>\n";
						else
							$content .= "<a href=\"".$item['href']."\"".$aClass." title=\"".$item['label']."\">".$label."</a>\n";
					}
				}
				if (array_key_exists($k, $menuItems) && $menuItems[$k] && ($item['level'] < $newOptions['depth']))
				{
					$content .= self::buildMenu(null, $menuItems, $k, $options);
				}
				if ($item['model'] != "Website" && $item['model'] != "Menu")
				{
					if ($tag != 'none')
						$content .= "</$subTag>\n";
				}

				$i++; $j++;
				if ($splitElements && ($j > $splitElements))
				{
					if ($tag != 'none')
					{
						$content .= "</$tag>\n";
						$add = '';
						if ($class)
							$add .= " class='$class'";
						$content .= "<$tag".$add.">\n";
					}
					$j = 1;
				}
			}
		}
		if ($tag != 'none')
			$content .= "</$tag>\n";
		return $content;
	}

}
?>