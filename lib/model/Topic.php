<?php

/**
 * Subclass for representing a row from the 'm_website_topic' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Topic extends BaseTopic
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

	public function getIndexPage()
	{
		try
		{
			$c = new Criteria();
			$c->add(TagPeer::TAG_ID, 'website_page_index');
			$tag = TagPeer::doSelectOne($c);

			$c = new Criteria();
			$c->add(RelationPeer::ID1, $this->getId());
			$c->addJoin(RelationPeer::ID2, TagrelationPeer::ID);
			$c->add(TagrelationPeer::TAG_ID, $tag->getId());
			$relation = RelationPeer::doSelectOne($c);
			if ($relation)
			{
				$indexPage = Document::getDocumentInstance($relation->getId2());
				return $indexPage;
			}
			else
			{
				return null;
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}
	
}