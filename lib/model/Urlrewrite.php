<?php

/**
 * Subclass for representing a row from the 'm_urlrewrite' table.
 *
 *
 *
 * @package lib.model
 */
class Urlrewrite extends BaseUrlrewrite
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
			if (sfConfig::get('sf_cache_relations'))
			{
				Relation::saveRelation($parent, $this);
				self::updateUrlRelationCache();
			}

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
			if (sfConfig::get('sf_cache_relations'))
			{
				self::updateUrlRelationCache();
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

	public static function checkUrlRelationCache($kind = 'wait')
	{
		$checkFile = sfConfig::get('sf_root_dir')."/cache/objcache/_UrlRelations.lck";
		if ($kind == 'wait')
		{
			while (is_readable($checkFile))
			{
				;
			}
		}
		elseif ($kind == 'lock')
		{
			while (is_readable($checkFile))
			{
				;
			}
			FileHelper::writeFile($checkFile, 'LOCK!');
		}
		else //if ($kind == 'unlock')
		{
			@unlink($checkFile);
		}
	}

	public static function updateUrlRelationCache($manualLock = false)
	{
		if (!$manualLock)
		{
			self::checkUrlRelationCache('lock');
		}

		try
		{
			$urlRelationsFile = sfConfig::get('sf_root_dir')."/cache/objcache/urlRelations.php";

			$c = new Criteria();
			$rewriteUrls = UrlrewritePeer::doSelect($c);

			$content = "<?php \n";

			foreach($rewriteUrls as $singleUrl)
			{
				$content .= "\$_UrlRel['".$singleUrl->getlabel()."'] = ".$singleUrl->getPageId().";\n";
			}

			$content .= "\n?>";

			if (FileHelper::writeFile($urlRelationsFile, $content))
			{
				BackendService::loadUrlRelations();
			}
			else
			{
				FileHelper::Log("Unable to write url cache in: ".$urlRelations, UtilsHelper::MSG_ERROR );
			}
		}
		catch(Exception $e)
		{
			FileHelper::Log("Unable to refresh url cache: ".$e->getMessage(), UtilsHelper::MSG_ERROR );
		}

		if (!$manualLock)
		{
			self::checkUrlRelationCache('unlock');
		}
	}

	public static function checkRewriteUrl($value, $objId)
	{
		try
		{
			$c = new Criteria();
			$c->add(UrlrewritePeer::LABEL, $value);
			$c->add(UrlrewritePeer::PAGE_ID, $objId, Criteria::NOT_EQUAL);
			$rewriteArr = UrlrewritePeer::doSelect($c);
			if ( ($cnt = count($rewriteArr)) > 0 )
			{
				$c = new Criteria();
				$c->add(UrlrewritePeer::LABEL, $value."_", Criteria::LIKE);
				$c->add(UrlrewritePeer::PAGE_ID, $objId, Criteria::NOT_EQUAL);
				$rewriteArr = UrlrewritePeer::doSelect($c);
				$cnt = $cnt + count($rewriteArr);
				$value = $value.$cnt;
			}
		}
		catch (Exception $e)
		{
			exit("checkRewriteUrl -> ERROR: ".$e->getMessage());
		}
		return $value;
	}

}
