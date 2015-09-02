<?php

/**
 * Subclass for representing a row from the 'm_newsletter' table.
 *
 *
 *
 * @package lib.model
 */
class Newsletter extends BaseNewsletter
{
	public function save($con = null, $parent = null)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();

			if (!$this->getId())
			{
				$genDoc = Document::getGenericDocument($this);
				$genDoc->setPublicationStatus("WAITING");
				$genDoc->save();
				
				$this->setId($genDoc->getId());
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

			//deletes generic document
			$genericDocument = Document::getGenericDocument($this);
			$genericDocument->delete();

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