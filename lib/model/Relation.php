<?php

/**
 * Subclass for representing a row from the 'm_relation' table.
 *
 *
 *
 * @package lib.model
 */
class Relation extends BaseRelation
{

	public static function checkRelationCache($kind = 'wait')
	{
		$checkFile = sfConfig::get('sf_root_dir')."/cache/objcache/_Relations.lck";
		$pathTime = @filemtime($checkFile);

		if($pathTime+60 < time()) @unlink($checkFile);

		if ($kind == 'wait')
		{
			while (is_readable($checkFile))
			{
				if($pathTime+60 < time()) @unlink($checkFile);
			}
		}
		elseif ($kind == 'lock')
		{
			while (is_readable($checkFile))
			{
				if($pathTime+60 < time()) @unlink($checkFile);
			}
			FileHelper::writeFile($checkFile, 'LOCK!');
		}
		else //if ($kind == 'unlock')
		{
			@unlink($checkFile);
		}
	}

	public static function updateRelationCache($parentId = null, $manualLock = false)
	{
		//$m = memory_get_usage();
		if (!$manualLock)
		{
			self::checkRelationCache('wait');
			self::checkRelationCache('lock');
		}

		try
		{
			$relationsFile = sfConfig::get('sf_root_dir')."/cache/objcache/childrenRelations.php";
			$found = false;

			if ($parentId && is_readable($relationsFile))
			{
				$handle = fopen($relationsFile, "r+");
				if ($handle)
				{
					$content = fread($handle, filesize($relationsFile));

					$rels = explode("\$_Rel[".$parentId."]", $content);
					$cnt = count($rels);
					if ($cnt>1)
					{
						$prevContent = $rels[0];
						$p = strpos($rels[$cnt-1], ";");
						$nextContent = substr($rels[$cnt-1], $p+2);
						$found = true;
					}
				}
			}

			if (!$found)
			{
				// if not found - create relations for ALL documents
				$prevContent = "<?php \n";
				$nextContent = "\n?>";
				$parentId = null;
			}

			$c = new Criteria();
			if ($parentId)
			{
				$c->add(RelationPeer::ID1, $parentId);
			}

			$c->addAscendingOrderByColumn('id1');
			$c->addAscendingOrderByColumn('document_model2');
			$c->addAscendingOrderByColumn('sort_order');
			$rs = RelationPeer::doSelectRs($c);

			$i = 0;
			$content = $prevContent; // "<?php \n";
			$oldIDModel = '';
			$currIDModel = '';
			$idStr = '';

			while($rs->next())
			{
				$id1 = $rs->getInt(1);
				$id2 = $rs->getInt(2);
				$model1 = $rs->getString(3);
				$model2 = $rs->getString(4);
				$sort = $rs->getString(5);

				$currIDModel = $id1.':'.$model2;
				if ($i == 0)
				{
					$oldIDModel = $currIDModel;
				}

				$i++;

				if ($currIDModel == $oldIDModel)
				{
					$idStr .= ",".$id2;
				}
				else
				{
					$idStr = substr($idStr, 1);
					$content .= "\$_Rel[".$oldId1."][\"".$oldModel2."\"] = explode(\",\", \"".$idStr."\");\n";
					$idStr = ",".$id2;
				}
				$oldIDModel = $currIDModel;
				$oldId1 = $id1;
				$oldModel2 = $model2;
			}

			if ($idStr)
			{
				$idStr = substr($idStr, 1);
				$content .= "\$_Rel[".$oldId1."][\"".$oldModel2."\"] = explode(\",\", \"".$idStr."\");\n";
			}

			$content .= $nextContent; /* "\n?>"; */
			FileHelper::writeFile($relationsFile, $content);

			$_SESSION['childrenRelations'] = null;
			BackendService::loadChildrenRelations();
		}
		catch (Exception $e)
		{
			;
		}

		if (!$manualLock)
		{
			self::checkRelationCache('unlock');
		}
		//$m2 = memory_get_usage();
		//FileHelper::Log(round(($m2-$m)/1024/1024,2)." Mo");
	}

	public static function saveRelation($parents, $document, $updateCache = true)
	{
		if ($parents)
		{
			try
			{
				$con = Propel::getConnection();
				$con->begin();

				$docId = $document->getId();
				if (!is_array($parents))
				{
					$parents = array($parents);
				}

				foreach ($parents as $parent)
				{
					$saveNew = true;
					if ($parent)
					{
						$parentId = $parent->getId();

						$oldParentId = Document::getParentOf($docId, null, false);

						if ($oldParentId)
						{
							$relation = RelationPeer::retrieveByPk($oldParentId, $docId);
							if ($oldParentId != $parentId)
							{
								$relation->delete();
							}
							else
							{
								$saveNew = false;
							}
						}

						if ($saveNew)
						{
							$relation = new Relation;
							$relation->setId1($parentId);
							$relation->setId2($docId);
							$relation->setDocumentModel1(get_class($parent));
							$relation->setDocumentModel2(get_class($document));
							$relation->setSortOrder($relation->getNextSortOrder($parent, $document));
						}

						$relation->save();
					}
				}

				$con->commit();

				if (sfConfig::get('sf_cache_relations') && $updateCache && $parentId)
				{
					self::updateRelationCache($parentId);
				}
				return true;
			}
			catch (Exception $e)
			{
				$con->rollback();
				throw $e;
			}
		}
	}

	public function delete($con = null, $updateCache = true)
	{
		$id = $this->getId1();
		parent::delete();
		if (sfConfig::get('sf_cache_relations') && $updateCache)
		{
			self::updateRelationCache($id);
		}
	}

	private function getNextSortOrder($parent, $document)
	{
		try
		{
			$c = new Criteria();
			$c->add(RelationPeer::ID1, $parent->getId());
			$c->addSelectColumn('MAX('.RelationPeer::SORT_ORDER.')');
			$rs = RelationPeer::doSelectRS($c);
			$rs->next();
			$maxOrder = $rs->getInt(1);
			$maxOrder++;

			return $maxOrder;
		}
		catch (Exception $e)
		{
			throw $e;
		}
	}

	public static function orderDocument($documentId, $up = true)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();

			$c = new Criteria();
			$c->add(RelationPeer::ID2, $documentId);
			$relation = RelationPeer::doSelectOne($c);

			$c = new Criteria();
			$c->add(RelationPeer::ID1, $relation->getId1());
			if ($up)
			{
				$c->addDescendingOrderByColumn(RelationPeer::SORT_ORDER);
				$criterion = $c->getNewCriterion(
					RelationPeer::SORT_ORDER,
					$relation->getSortOrder(),
					Criteria::LESS_THAN
				);
			}
			else
			{
				$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);
				$criterion = $c->getNewCriterion(
					RelationPeer::SORT_ORDER,
					$relation->getSortOrder(),
					Criteria::GREATER_THAN
				);
			}
			$c->add($criterion);
			$previousRelation = RelationPeer::doSelectOne($c);
			if ($previousRelation)
			{
				$previousSortOrder = $previousRelation->getSortOrder();

				$previousRelation->setSortOrder($relation->getSortOrder());
				$previousRelation->save();
				$relation->setSortOrder($previousSortOrder);
				$relation->save();

				if (sfConfig::get('sf_cache_relations'))
				{
					if ($relation)
					{
						self::updateRelationCache($relation->getId1());
					}
				}
			}

			if (SF_APP == "backend" && sfConfig::get('sf_cache_trees'))
			{
				$user = sfContext::getInstance()->getUser();
				$moduleName = $user->getAttribute("currentModule");
				
				$document = Document::getDocumentInstance($documentId);
				if ($up)
				{
					BackendService::updateTree($moduleName, $document, "UP");
					//BackendService::updateTree($moduleName, $document, "UP", "right");
					//BackendService::updateTree($moduleName, $document, "UP", "mce");

				}
				else
				{
					BackendService::updateTree($moduleName, $document, "DOWN");
					//BackendService::updateTree($moduleName, $document, "DOWN", "right");
					//BackendService::updateTree($moduleName, $document, "DOWN", "mce");
				}
			}
			$con->commit();
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

}