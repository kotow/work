<?php

/**
 * Subclass for representing a row from the 'm_rootfolder' table.
 * @package lib.model
 */

class Rootfolder extends BaseRootfolder
{	
	public function save($con = null)
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

	public static function getRootfolder($document)
	{
		$docClass = get_class($document);
		$docModule = '';
		$formFile = sfConfig::get('sf_root_dir')."/config/form.xml";
		if (is_readable($formFile))
		{
			$objects = XMLParser::getXMLdataValues($formFile);
			foreach ($objects as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'open'))
				{
					if ($obj['attributes']['NAME'] == $docClass)
					{
						$docModule = $obj['attributes']['MODULE'];
					}
				}
			}
		}
		if ($docModule)
		{
			return self::getRootfolderByModule($docModule);
		}
		else
		{
			return null;
		}
	}

	public static function getRootfolderByModule($module)
	{
		$found = false;

		$searchModule = $module;
		if (strtolower($searchModule) == 'tag')
		{
			$searchModule = 'admin';
		}
		$formFile = sfConfig::get('sf_root_dir')."/config/form.xml";
		if (is_readable($formFile))
		{
			$objects = XMLParser::getXMLdataValues($formFile);
			foreach ($objects as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'open'))
				{
					if (strtoupper($obj['attributes']['MODULE']) == strtoupper($searchModule))
					{
						$found = true; break;
					}
				}
			}
		}
		if (!$found)
		{
			//echo "getRootfolderByModule($module): not_found!";
			return null;
		}

		try
		{
			$c = new Criteria();
			$c->add(RootfolderPeer::LABEL, $module);
			$c->addOr(RootfolderPeer::LABEL, ucfirst($module));
			$rootFolder = RootfolderPeer::doSelectOne($c);

			if (!$rootFolder)
			{
				$rootFolder = new Rootfolder();
				$rootFolder->setLabel(ucfirst($module));
				$rootFolder->save();
			}
			return $rootFolder;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

}