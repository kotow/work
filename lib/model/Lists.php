<?php

/**
 * Subclass for representing a row from the 'm_lists' table.
 * @package lib.model
 */ 
class Lists extends BaseLists
{

	public function save($con = null, $parent = null)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();
			
			if (!$this->getId())
			{
				$this->setId(Document::getGenericDocument($this)->getId());
			}
			
			parent::save($con);

			// create relationship
			if (!$parent && !Document::getParentOf($this->getId()))
			{
				$parent = Rootfolder::getRootfolder($this);
			}
			Relation::saveRelation($parent, $this);

			$con->commit();
			Document::cacheObj($this, get_class($this));

			// update list cache
			Lists::deleteListCache($this->getListId());
			Lists::updateListCache($this->getListId());
			
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
		try
		{
			$con = Propel::getConnection();
			$con->begin();

			//deletes generic document
			$genericDocument = Document::getGenericDocument($this);
			$genericDocument->delete();

			parent::delete();

			$con->commit();
			Document::deleteObjCache($this);

			// remove list cache
			Lists::deleteListCache($this->getListId());

			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

// ================================================== EXPORT FUNCTIONS =============================================

	public function getListitems()
	{
		try
		{
			return Document::getChildrenOf($this->getId(), "Listitem", true);
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	public static function getListByListId($listid)
	{
		try
		{
			$c = new Criteria();
			$c->add(ListsPeer::LIST_ID , $listid);
			$list = ListsPeer::doSelectOne($c);

			return $list;
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	public static function getListitemsByListId($listid)
	{
		$items = false;
		if ($list = self::getListByListId($listid))
		{
			$items = $list->getListitems();
		}
		return $items;
	}

	public static function getListitemsForSelect($listid, $selectArray = array(), $getId = false)
	{
		$path = sfConfig::get('sf_root_dir')."/cache/listscache/".$listid.".php";
		if (is_readable($path))
		{
			include($path);
			$selectArray = $selectArray + $listItemsForSelect;
		}
		else
		{
			if ($items = self::getListitemsByListId($listid))
			{
				foreach ($items as $item)
				{
					$id = $item->getId();
					/*if (get_class($item) == "ListitemI18n")
					{
						$parent = Document::getParentOf($id, "Listitem");
						if($parent)
						{
							$id = $parent->getId();
						}
					}*/
					if (($item->getValue() == "") || ($item->getValue() == null) || ($getId == true))
					{
						$selectArray[$id] = $item->getLabel();
					}
					else
					{
						$selectArray[$item->getValue()] = $item->getLabel();
					}
				}
			}
		}
		return $selectArray;
	}

/*	public static function getChildListsForSelect($listid)
	{
		$childLists = array();
		if($items = self::getListitemsByListId($listid))
		{
			foreach ($items as $item)
			{
				if (Document::hasChildren($item->getId()))
				{
					$childList = array_shift(Document::getChildrenOf($item->getId(), "Lists"));
					$childLists[$item->getId()] = $childList->getListId();
				}
			}
		}
		return $childLists;
	}

	public static function getChildListForItem($itemId)
	{

		if (Document::hasChildren($itemId))
		{
			$childList = Document::getFirstChildOf($itemId, "Lists");
		}
		return $childList;
	}*/

	public static function deleteListCache($listId)
	{
		// remove list cache
		$listPath = sfConfig::get('sf_root_dir')."/cache/listscache/".$listId.".php";
		@unlink($listPath);
	}
	
	public static function updateListCache($listId = null)
	{
		if ($listId)
		{
			$list = Lists::getListByListId($listId);
			$lists = array($list);
		}
		else
		{
			if ($listsRootFolder = Rootfolder::getRootfolderByModule("lists"))
				$lists = Document::getChildrenOf($listsRootFolder->getId(), "Lists");
		}

		foreach ($lists as $list)
		{
			$listId = $list->getListId();
			$listPath = sfConfig::get('sf_root_dir')."/cache/listscache/".$listId.".php";
			@unlink($listPath);

			$content = "<?php \n";
			$content .= "\$listItemsForSelect = array(\n";
			$items = Lists::getListitemsForSelect($listId, array(), false);
			foreach ($items as $key => $item)
			{
				$content .= "\"".str_replace("\"", "\\\"", $key)."\" => \"".str_replace("\"", "\\\"", $item)."\",\n";
			}
			$content .= ");\n?>";
			FileHelper::writeFile($listPath, $content);
		}
	}

}