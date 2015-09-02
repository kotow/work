<?php
/**
 * Subclass for representing a row from the 'm_news' table.
 * @package lib.model
 */

class News extends BaseNews
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
			Document::getGenericDocument($this)->delete();
			parent::delete();
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

}