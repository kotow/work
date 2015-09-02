<?php

/**
 * Subclass for representing a row from the 'm_tag_relation' table.
 *
 *
 *
 * @package lib.model
 */
class Tagrelation extends BaseTagrelation
{
	public static function checkTagRelationCache($kind = 'wait')
	{
		$checkFile = sfConfig::get('sf_root_dir')."/cache/objcache/_TagRelations.lck";
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

	public static function updateTagRelationCache($manualLock = false)
	{
		if (!$manualLock)
		{
			self::checkTagRelationCache('lock');
		}

		try
		{
			$tagRelationsFile = sfConfig::get('sf_root_dir')."/cache/objcache/tagsRelations.php";

			$c = new Criteria();
			$allTags = TagPeer::doSelect($c);

			$content = "<?php \n";
			foreach($allTags as $singleTag)
			{
				$c = new Criteria();
				$c->add(TagrelationPeer::TAG_ID, $singleTag->getId());
				$tagRelations = TagrelationPeer::doSelect($c);

				if($tagRelations)
				{
					$elementsArr = "array(";
					foreach($tagRelations as $tagRelation)
					{
						$elementsArr .= $tagRelation->getId().",";
					}
					$content .= "\$_TagRel['".$singleTag->getTagId()."'] = ". substr($elementsArr, 0 , -1).");\n";
				}

			}
			$content .= "\n?>";

			if (FileHelper::writeFile($tagRelationsFile, $content))
			{
				BackendService::loadTagsRelations();
			}
			else
			{
				echo FileHelper::Log("Unable to write tag cache in: ".$tagRelationsFile, UtilsHelper::MSG_ERROR );
			}
		}
		catch(Exception $e)
		{
			echo FileHelper::Log("Unable to refresh tag cache: ".$e->getMessage(), UtilsHelper::MSG_ERROR );
		}

		if (!$manualLock)
		{
			self::checkTagRelationCache('unlock');
		}
	}

}