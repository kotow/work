<?php

/**
 * Subclass for representing a row from the 'm_tag' table.
 * @package lib.model
 */

class Tag extends BaseTag
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
			if (sfConfig::get('sf_cache_relations'))
			{
				Tagrelation::updateTagRelationCache();
			}
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

			//deletes any tags for this document
			$c = new Criteria();
			$c->add(TagrelationPeer::TAG_ID, $this->getId());
			$tagRelations = TagrelationPeer::doSelect($c);
			foreach ($tagRelations as $tag)
			{
				$tag->delete();
			}

			parent::delete();

			$con->commit();
			if (sfConfig::get('sf_cache_relations'))
			{
				Tagrelation::updateTagRelationCache();
			}
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