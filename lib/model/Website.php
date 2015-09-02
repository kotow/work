<?php

/**
 * Subclass for representing a row from the 'm_website' table.
 *
 * 
 *
 * @package lib.model
 */ 
class Website extends BaseWebsite
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

	public static function getBrowser()
	{
		$browsers = "mozilla msie gecko firefox ";
		$browsers.= "konqueror safari netscape navigator ";
		$browsers.= "opera mosaic lynx amaya omniweb";

		$browsers = explode(" ", $browsers);
		$nua = strToLower( $_SERVER['HTTP_USER_AGENT']);
		$res = array();
		$l = strlen($nua);

		for ($i=0; $i<count($browsers); $i++)
		{
			$browser = $browsers[$i];
			$n = stristr($nua, $browser);
			if(strlen($n)>0)
			{
				$res["version"] = "";
				$res["browser"] = $browser;
				$j=strpos($nua, $res["browser"])+$n+strlen($res["browser"])+1;
				for (; $j<=$l; $j++)
				{
					$s = substr ($nua, $j, 1);
					if(is_numeric($res["version"].$s) )
					$res["version"] .= $s;
					break;
				}
			}
		}
		return $res;
	}

}