<?php

/**
 * Subclass for representing a row from the 'm_list_item' table.
 * @package lib.model
 */ 
class Listitem extends BaseListitem
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

			// get Lists object
			if (!$parent)
				$parent = Document::getParentOf($this->getId());
			// update list cache
			if (get_class($parent) == "Lists")
				Lists::updateListCache($parent->getListId());

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

			// update list cache
			if (get_class($parent) == "Lists")
				Lists::updateListCache($parent->getListId());

			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

}