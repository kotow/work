<?php

/**
 * Subclass for representing a row from the 'm_user' table.
 *
 * 
 *
 * @package lib.model
 */ 
class User extends BaseUser
{
	
	public function __toString()
	{
		return $this->getFirstName().' '.$this->getLastName();
	}

	public function getPassword()
	{
		return '';
	}
	
	public function setPassword($password)
	{
		$salt = md5(rand(100000, 999999).$this->getLogin().$this->getEmail());
		$this->setSalt($salt);
		$this->setSha1Password(sha1($salt.$password));
	}

	public function save($con = null, $parent = null)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();
			
			if(trim($this->__toString()) != "")
			{
				$this->setLabel($this->__toString());
			}
			
			switch ($this->getType())
			{
				case "admin":
				//case "site_admin":
					$this->setBackend(1);
					break;
				default:
					$this->setBackend(0);
			}
			
			if($this->getLogin() == "") $this->setLogin($this->getEmail());
			
			if (!$this->getId())
			{
				$this->setId(Document::getGenericDocument($this)->getId());
			}

			/*if (!$this->getPublicationStatus())
			{
				$this->setPublicationStatus(UtilsHelper::STATUS_ACTIVE);
			}*/

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