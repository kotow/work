<?php
/**
 * @package    cms
 * @subpackage admin
 * @author     Jordan Hristov / Ilya Popivanov
 */

class adminActions extends sfActions
{

	private $showModule = null;

	public function executeEditUser()
	{
		BackendService::objectEdit('admin', 'User', $this);
	}

	public function executeSave()
	{
		try
		{
			$parameters = $this->getRequest()->getParameterHolder()->getAll();
			$parameters['documentName'] == "Folder" ? $moduleName = "Admin" : $moduleName = $parameters['moduleName'];
			$documentName = $parameters["documentName"];
			$parent = Document::getDocumentInstance($parameters['parent']);
			if (is_numeric($parameters['id']))
			{
				$obj = Document::getDocumentInstance($parameters['id']);
				$parent = Document::getParentOf($parameters['id']);
			}
			else
			{
				$obj = new $documentName();
			}

			include_once(sfConfig::get('sf_root_dir')."/config/Schema.class.php");
			$m = "get".$documentName."Properties";
			$properties = Schema::$m();

			//exit(var_dump($properties));
			$imageFields = explode(",", $parameters['imageFields']);
			/*foreach ($parameters as $property)
			{
				$function = 'set'.$property;
				$obj->$function();
			}*/

			foreach ($parameters as $key => $value)
			{

				if (!(strpos($key, 'attr') === false) && ($key != "attrRewriteUrl"))
				{
					$key = str_replace('attr', '', $key);

					if($properties && $key != "Password" && !in_array($key, $properties)) continue;
					if($key == "Password" && empty($value)) continue;

					$function = 'set'.$key;
					if (is_array($value))
					{
						$date = $value['year'].'-'.$value['month'].'-'.$value['day']; // 2009-02-09 16:10:20
						if ($value['hour'] && $value['minute'])
						{
							$time = $value['hour'].':'.$value['minute'];
							$value = $date.' '.$time;
						}
						else
						{
							$value = $date;
						}
					}
					if (in_array($key, $imageFields))
					{
						$getFunction = 'get'.$key;

						$imgId = $obj->$getFunction();
						if ($imgId != $value)
						{
							$img = Document::getDocumentInstance($imgId);
							if ($img)
							{
								$imgExt = $img->getExtention();
								@unlink(sfConfig::get('sf_root_dir')."/www/media/upload/thumbs/".$parameters["moduleName"]."/".$imgId."-".$key.".".$imgExt);
							}
						}
					}
					if ($key == "Keywords")
					{
						if($value)
						{
							$value = str_replace(',', '][', $value);
							$value = '['.substr($value, 0, -1);
						}
					}

					$obj->$function($value);
				}

				if (in_array($key, $imageFields) && (!empty($value)))
				{
					$image = Document::getDocumentInstance($value);
					if ($image)
					{
						if (empty($parameters[$key.'_thumbheight']))
						{
							$parameters[$key.'_thumbheight'] = null;
						}
						if (empty($parameters[$key.'_thumbwidth']))
						{
							$parameters[$key.'_thumbwidth'] = null;
						}
						$image->resizeImage($parameters["moduleName"], $parameters[$key.'_thumbheight'], $parameters[$key.'_thumbwidth'], $key);
					}
				}
			}

			if(class_exists($documentName."I18n") && $documentName != "Listitem")
			{
				if(!$culture = $parameters["attrCulture"])
				{
					$culture = Document::getDocumentByExclusiveTag("default_culture");
					if($culture)
						$culture = $culture->getValue();
					else
						throw new Exception("No default culture defined");
				}

				$obj->save(null, $parent, $culture);

				if(!$parameters["id"])
				{
					if(class_exists($documentName."I18n"))
					{
						BackendService::objectSave($objI8n, $obj, $documentName."I18n");
						if($documentName == "Page") $objI8n->setRewriteUrl($parameters["attrRewriteUrl"]);
						$objI8n->setCulture($culture);
						$objI8n->save(null, $obj, $culture);
					}

					$request = $this->getRequest();
					$request->setParameter("id", $obj->getId());
				}
			}
			else
			{
				$obj->save(null, $parent);
			}

			$tags = Document::getAvailableTagsOf($moduleName, $parameters['documentName']);
			foreach ($tags as $tag)
			{
				if ($parameters['tag_id_'.$tag->getId()])
				{
					Document::addTag($obj, $tag->getTagId());
				}
				else
				{
					Document::removeTag($obj, $tag->getTagId());
				}
			}

			Tagrelation::updateTagRelationCache();
			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}
		$this->forward(strtolower($moduleName), "edit".$parameters['documentName']);
		exit();
	}

	/* =========================================================================================================================================================== */
	public function executeIndex()
	{
		$this->setLayout("backend");
		$subscriber = $this->getUser()->getSubscriber();

		if (!$subscriber || $subscriber->getBackend() != 1)
		{
			$this->forward("user", "login");
		}
		$this->refresh = $this->getRequestParameter("refresh");
		$this->model = $this->getRequestParameter("model");
		$this->id = $this->getRequestParameter("id");
		$this->parent = $this->getRequestParameter("parent");
		$this->err = $this->getRequestParameter("err");

		$this->mainMenu = $this->getPresentationFor('admin', 'backendMainMenu');
		$this->contextMenus = $this->getPresentationFor('admin', 'contextMenus');
		$this->currentModule = $this->getUser()->getAttribute('currentModule');

				$filters = XMLParser::getXMLdataValues(sfConfig::get('sf_root_dir')."/apps/backend/config/backendFilters.xml");

		$i = 0;
		$y = 0;
		$moduleFilters = array();
		foreach ($filters as $filter)
		{
			if (($filter['tag'] == 'MODULE') && ($filter['type'] == 'open'))
			{
				$i++;
				$y = 0;
				$f = array();
				$name = null;
				$name = $filter['attributes']['NAME'];
			}

			if (($filter['tag'] == 'FILTER') && ($filter['type'] == 'complete'))
			{
				$y++;
				$f[$y]['name'] =  $filter['attributes']['NAME'];
				$f[$y]['pop'] =  $filter['attributes']['POP'];
				$f[$y]['value'] =  str_replace("\"", "'",  $filter['value']);
			}

			if (($filter['tag'] == 'MODULE') && ($filter['type'] == 'close'))
			{
				$moduleFilters[$i]['moduleName'] = $name;
				$moduleFilters[$i]['filters'] = $f;
			}
		}

		$this->moduleFilters = $moduleFilters;
	}

	public function executeBackendMainMenu()
	{
		include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'rights.php');

		$sfuser = $this->getUser();
		$user = $sfuser->getSubscriber();

		if(!is_null($user))
		{
			$this->userRights = $allRights[$user->getType()];
		}
	}

	public function executeContextMenus()
	{
		include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'rights.php');

		$sfuser = $this->getUser();
		$user = $sfuser->getSubscriber();

		if(!is_null($user))
		{
			$this->userRights = $allRights[$user->getType()];
		}
	}

	public function executeParentsTree()
	{
		$this->tree = Document::getParentsTree($this->getRequestParameter('id'));
		$this->moduleName = $this->getRequestParameter('modulename');
	}

	public function executeLeftTree()
	{
		$this->tree = BackendService::getLeftTree($this->getRequestParameter('modulename'));
		$this->getUser()->setAttribute('currentModule', $this->getRequestParameter('modulename'));
	}

	public function executeMainList()
	{

		$this->page = $this->getRequestParameter('page');
		$this->filter = $this->getRequestParameter('filter');

		if($this->filter)
		{
			$this->parent = '1';
		}
		else
		{
			$this->parent = $this->getRequestParameter('parent');
		}

		$results = BackendService::getMainList($this->parent, $this->getRequestParameter('modulename'), $this->page, $this->filter);
		$this->children = $results['children'];
		$this->pager = $results['pager'];
	}

	public function executeGetLastChildId()
	{
		$children = Document::getChildrenOf($this->getRequestParameter('parentId'), null, false, false);

		if($pos = $this->getRequestParameter('position'))
		{
			$cnt = count($children);
			$last = $children[$cnt-$pos];
		}
		else
		{
			$last = array_pop($children);
		}
		exit("".$last);
	}

	public function executeGetParentId()
	{
		$parent = Document::getParentOf($this->getRequestParameter('id'), null, false);
		exit("".$parent);
	}

	public function executeLanguageBar()
	{
		$this->children = BackendService::getLanguageBar($this->getRequestParameter('parent'), $this->getRequestParameter('modulename'));
	}

	public function executeRightTree()
	{
		$this->resources = BackendService::getResources($this->getRequestParameter('modulename'));
	}

	public function executeGetRightTree()
	{
		$this->tree = BackendService::getRightTree($this->getRequestParameter('modulename'));
	}

	// ==============================================================================================================================
	public function executeEditFolder()
	{
		BackendService::objectEdit('admin', 'Folder', $this);
	}

	public function executeEditTag()
	{
		BackendService::objectEdit('admin', 'Tag', $this);
	}

	public function executeSaveTag()
	{
		try
		{
			$parameters = $this->getRequest()->getParameterHolder()->getAll();

			if ($parameters['id'])
			{
				$obj = Document::getDocumentInstance($parameters['id']);
				$parent = Document::getParentOf($parameters['id']);
			}
			else
			{
				$obj = new Tag();
				$parent = Document::getDocumentInstance($parameters['parent']);
			}

			foreach ($parameters as $key => $value)
			{
				if (!(strpos($key, 'attr') === false))
				{
					$function = 'set'.str_replace('attr', '', $key);
					$obj->$function($value);
				}
			}
			if(!$parameters['attrExclusive']) $obj->setExclusive(0);

			$obj->save(null, $parent);

			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		$this->forward("admin", "editTag");
		exit();
	}

	// ==============================================================================================================================
	public function executeDelete()
	{
		if($user = $this->getUser()->getSubscriber())
			$userType = $user->getType();

		if ($selectedDocuments = $this->getRequestParameter("selectedDocuments"))
		{
			sfConfig::set('sf_cache_relations', false);
			$selectedDocuments = explode(",", $selectedDocuments);
			foreach ($selectedDocuments as $docId)
			{
				$document = Document::getDocumentInstance($docId);
				if ($document)
				{
					if($userType != "admin" )
					{
						$class = get_class($document);
						if($class == "Lists" && $document->getListType() == "system")
						{
							$alert = "no_delete";
							continue;
						}
						else if($class == "Listitem")
						{
							if($parent = Document::getParentOf($document->getId()))
							{
								if($parent->getListType() == "system")
								{
									$alert = "no_delete";
									continue;
								}
							}
						}
					}

					$document->delete();
				}
			}

			sfConfig::set('sf_cache_relations', true);
			Relation::updateRelationCache($this->getRequestParameter("p"));
		}
		else
		{
			$document = Document::getDocumentInstance($this->getRequestParameter('id'));
			if ($document)
			{
				$class = get_class($document);
				if($userType != "admin" )
				{
					if($class == "Lists" && $document->getListType() == "system")
					{
						$alert = "no_delete";
					}
					else if($class == "Listitem")
					{
						if($parent = Document::getParentOf($document->getId()))
						{
							if($parent->getListType() == "system") $alert = "no_delete";
						}
					}
				}

				if($alert != "no_delete") $document->delete();

			}
		}
		exit($alert);
	}

	public function executeOrderDocument()
	{
		try
		{
			$documentId = $this->getRequestParameter('id');
			$up = $this->getRequestParameter('up');

			if ($up == "true")
			{
				Relation::orderDocument($documentId);
			}
			else
			{
				Relation::orderDocument($documentId, false);
			}
		}
		catch (Exception $e)
		{
			FileHelper::Log('ERROR SORT: '.$e->getMessage(), UtilsHelper::MSG_ERROR);
		}
	}

	public function executeValidateRegexp()
	{
		$myValidator = new sfRegexValidator();
		$myValidator->initialize($this->getContext(), array(
		'match'		=>		"Yes",
		'pattern'	=>		urldecode($this->getRequestParameter('pattern'))
		));
		if (!$myValidator->execute(urldecode($this->getRequestParameter('value')), $error))
		{
			exit('invalid data');
		}
		exit("ok");
	}

	public function executeValidateString()
	{
		$myValidator = new sfStringValidator();
		$myValidator->initialize($this->getContext(), array(
		));
		if (!$myValidator->execute(urldecode($this->getRequestParameter('value')), $error))
		{
			exit('invalid data');
		}
		exit("ok");
	}

	public function executeValidateInteger()
	{
		$myValidator = new sfNumberValidator();
		$myValidator->initialize($this->getContext(), array(
		'type' 	=>	"int"
		));
		if (!$myValidator->execute(urldecode($this->getRequestParameter('value')), $error))
		{
			exit('you must enter a number');
		}
		exit("ok");
	}

	public function executeValidateFloat()
	{
		$myValidator = new sfNumberValidator();
		$myValidator->initialize($this->getContext(), array(
		'type' 	=>	"float"
		));
		if (!$myValidator->execute(urldecode($this->getRequestParameter('value')), $error))
		{
			exit('you must enter a decimal number');
		}
		exit("ok");
	}

	public function executeValidateUrl()
	{
		$myValidator = new sfUrlValidator();
		$myValidator->initialize($this->getContext(), array(
		));
		if (!$myValidator->execute(urldecode($this->getRequestParameter('value')), $error))
		{
			exit('you must enter a valid url');
		}
		exit("ok");
	}

	public function executeValidateEmail()
	{
		$myValidator = new sfEmailValidator();
		$myValidator->initialize($this->getContext(), array(
		));
		if (!$myValidator->execute(urldecode($this->getRequestParameter('value')), $error))
		{
			exit('you must enter a valid email');
		}
		exit("ok");
	}

	public function executeSetPublicationStatus()
	{
		$items = explode(",", $this->getRequestParameter('items'));
		$status = $this->getRequestParameter('status');

		try
		{
			foreach ($items as $item)
			{
				$genericDocument = Document::getGenericDocument($item);
				$item = Document::getDocumentInstance($item);
				if ($genericDocument)
				{
					$genericDocument->setPublicationStatus($status);
					$genericDocument->save();
					Document::cacheObj($item, null, true);
				}
			}
		}
		catch(Exception $e)
		{
			exit("A probleme occured: ".$e->getMessage());
		}
		exit("OK");
	}
}