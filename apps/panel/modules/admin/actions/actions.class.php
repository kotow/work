<?php
/**
 * admin actions.
 *
 * @package    cms
 * @subpackage admin
 */

class adminActions extends sfActions
{
	private $showModule = null;

	public function executeIndex()
	{
		$this->setLayout("panel");
		$this->subscriber = $this->getUser()->getSubscriber();
		if (!$this->subscriber || $this->subscriber->getBackend() != 1)
		{
			$this->forward("user", "login");
		}

		$moduleName = $this->getRequestParameter("moduleName");
		// fake modules: Labels, Settings
		if ($moduleName != 'labels' && $moduleName != 'settings')
		{
			$submitOK = false;
			if ($this->getRequestParameter("submitEdit"))
			{
				$submitOK = $this->checkSubmit();
			}
			if ($submitOK)
			{
				$documentName = $this->getRequestParameter("documentName");
				// call REAL save method
				if (!in_array('executeSave'.$documentName, get_class_methods($moduleName.'Actions')))
				{
					//echo "getPresentationFor('admin', 'save')";
					$this->content = $this->getPresentationFor("admin", "save");
				}
				else
				{
					//echo "getPresentationFor($moduleName, 'save$documentName')";
					$this->content = $this->getPresentationFor($moduleName, "save".$documentName);
				}
				// and redirect after success (if no error/message set)
				if (!$this->getRequestParameter("backendMsg"))
				{
					PanelService::redirect();
					exit();
				}
			}
		}

		$this->mainMenu = $this->getPresentationFor('admin', 'mainMenu');
		$this->breadcrumb = $this->getPresentationFor('admin', 'parentsTree');
		$this->footer = $this->getPresentationFor('admin', 'footer');
		$module = $this->getRequestParameter("m");
		$id = $this->getRequestParameter("id");
		$new = $this->getRequestParameter("n");
		if ($id && $module)
		{
			if ($module == 'labels')
			{
				$this->content = $this->getPresentationFor("labels", "editLabel");
				if ($this->getRequestParameter("submitEdit") && !$this->getRequestParameter("backendMsg"))
				{
					PanelService::redirect();
					exit();
				}
			}
			elseif ($module == 'settings')
			{
				$this->content = $this->getPresentationFor("settings", "editSettings");
				if ($this->getRequestParameter("submitEdit") && !$this->getRequestParameter("backendMsg"))
				{
					PanelService::redirect();
					exit();
				}
			}
			else
			{
				$document = Document::getDocumentInstance($id);
				if ($document)
				{
					$class = get_class($document);
					if ($class == 'Folder')
					{
						$request = $this->getRequest();
						$request->setParameter("parentModule", $module);
						$this->content = $this->getPresentationFor("admin", "edit".$class);
					}
					else
					{
						$this->content = $this->getPresentationFor($module, "edit".$class);
					}
				}
			}
		}
		elseif ($module && $new)
		{
			if ($new == 'Folder')
			{
				$request = $this->getRequest();
				$request->setParameter("parentModule", $module);
				$this->content = $this->getPresentationFor('admin', "edit".$new);
			}
			else
				$this->content = $this->getPresentationFor($module, "edit".$new);
		}
		elseif ($module)
		{
			$this->content = $this->getPresentationFor('admin', 'mainListPanel');
		}
		else
		{
			$this->content = $this->getPresentationFor('admin', 'dashboard');
		}
	}

	public function executeMainMenu()
	{
		$this->subscriber = $this->getUser()->getSubscriber();
		if (!is_null($this->subscriber))
		{
			include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.SF_APP.'_rights.php');
			$this->userRights = $allRights[$this->subscriber->getType()];
		}

		/*$this->mainMenu = array(
			'website' => array( 'title' => "Website", 'href' => "/panel/?m=website" ),
			'user' => array( 'title' => "Admin users", 'href' => "/panel/?m=user" ),
			'media' => array( 'title' => "Media", 'href' => "/panel/?m=media" ),
			'news' => array( 'title' => "News", 'href' => "/panel/?m=news" ),
			'mailer' => array( 'title' => "Mailer", 'href' => "/panel/?m=newsletter" ),
			'labels' => array( 'title' => "Labels", 'href' => "/panel/?m=labels" ),
			'settings' => array( 'title' => "Settings", 'href' => "/panel/?m=settings" ),
			'stats'  => array( 'title' => "Stats", 'href' => "/panel/?m=stats" ),
		);*/
	}

	public function executeMainListPanel()
	{
		try
		{
			$module = $this->getRequestParameter("m");
			$this->module = $module;
			$this->page = $this->getRequestParameter('page');

			$parent = $this->getRequestParameter('p');
			$res = PanelService::getMainList($parent, $this->getRequestParameter('m'), $this->page);

			if ($module == 'labels' || $module == 'settings')
			{
				$class = 'Rootfolder';
			}
			else
			{
				$document = Document::getDocumentInstance($parent);
				$class = get_class($document);
			}

			// get user's rigts
			$user = $this->getUser()->getSubscriber();
			include (SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.SF_APP.'_rights.php');
			$this->user_rights = $allRights[$user->getType()];
			$rights = PanelService::getUserRights($user, $class, $this->getRequestParameter('m'));
			$this->module_rights = $rights;
			if (isset($rights[$class]))
				$this->rights = explode(",", $rights[$class]);
			else
				$this->rights = array();
			$this->children = $res['children'];
			$this->paging = $res['paging'];
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg($e->getMessage(), "error");
		}
		if ($module == 'labels' || $module == 'settings')
		{
			// main list for XML data editing
			return 'Xml';
		}
	}

	public function objectValidate($validateArr)
	{
		$result = true; $errors = array();

		$request = $this->getRequest();
		$params = $request->getParameterHolder()->getAll();
		foreach ($validateArr as $field => $data)
		{
			if (array_key_exists($field, $params))
			{
				$value = $params[$field];
				if (empty($value))
				{
					$name = $data['label'] ? $data['label'] : $data['name'];
					$errors[] = 'Field <b>'.$name.'</b> is empty!';
					$request->setError($field, 1);
					$result = false;
				}
				else
				{
					if (array_key_exists('validate', $data))
					{
						$validator = ucfirst($data['validate']);
						$validatorClass ="sf".$validator."Validator";
						if (class_exists($validatorClass))
						{
							$myValidator = new $validatorClass();
							$myValidator->initialize($this->getContext(), array());
							if ($validator == "Email" || $validator == "Url")
								$value = urldecode($value);
							if (!$myValidator->execute($value, $error))
							{
								$name = $data['label'] ? $data['label'] : $data['name'];
								$errors[] = 'Field <b>'.$name.'</b> is a not valid '.$validator.'!';
								$request->setError($field, 1);
								$result = false;
							}
						}
					}
				}
			}
			else
			{
				$name = $data['label'] ? $data['label'] : $data['name'];
				$errors[] = 'Field <b>'.$name.'</b> is empty!';
				$request->setError($field, 1);
				$result = false;
			}
		}
		if (count($errors)> 0)
		{
			UtilsHelper::setBackendMsg(implode('</br>', $errors), 'error');
		}
		return $result;
	}

	public function checkSubmit()
	{
		$parameters = $this->getRequest()->getParameterHolder()->getAll();
		$moduleName = $parameters["moduleName"];
		$documentName = $parameters["documentName"];
//		if (class_exists($documentName."I18n"))
//			$documentName = $documentName."I18n";

		$formFile = sfConfig::get('sf_root_dir')."/config/form.xml";
		if (is_readable($formFile))
		{
			$objects = XMLParser::getXMLdataValues($formFile);
			$found = false; $validateArr = array();
			foreach ($objects as $obj)
			{
				if (($obj['tag'] == 'OBJECT') && ($obj['type'] == 'open'))
				{
					if (($obj['attributes']['NAME'] == $documentName) && ($obj['attributes']['MODULE'] == $moduleName))
					{
						$found = true;
					}
				}

				if ($found && ($obj['tag'] == 'COLUMN') && ($obj['type'] == 'complete'))
				{
					$name = 'attr'.UtilsHelper::convertFieldName($obj['attributes']['NAME']);
					if (array_key_exists('REQUIRED', $obj['attributes']))
					{
						$validateArr[$name]['required'] = 1;
						$validateArr[$name]['name'] = ucfirst($obj['attributes']['NAME']);
						$validateArr[$name]['label'] = $obj['attributes']['LABEL'];
					}
					if (array_key_exists('VALIDATE', $obj['attributes']))
					{
						$validateArr[$name]['validate'] = $obj['attributes']['VALIDATE'];
						$validateArr[$name]['name'] = ucfirst($obj['attributes']['NAME']);
						$validateArr[$name]['label'] = $obj['attributes']['LABEL'];
					}
				}

				if ($found && ($obj['tag'] == 'OBJECT') && ($obj['type'] == 'close'))
				{
					break;
				}
			}
			if (empty($validateArr))
			{
				// no Required or Validated fields found
				return true; // return OK
			}
			else
			{
				// object has Required or Validated fields
				return $this->objectValidate($validateArr);
			}
		}
		return false;
	}

	public function executeFooter()
	{
	}

	public function executeDashboard()
	{
		$user = $this->getUser()->getSubscriber();
		include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'panel_rights.php');
		$userRights = $allRights[$user->getType()];

		$modules = array();
		if (array_key_exists('website', $userRights))
		{
			$modules['Website'] = array(
				'class' => 'website',
				'list' => '/panel/?m=website',
				'add' => array('Page', '/panel/?m=website&n=Page&parent=36'),
			);
		}
		if (array_key_exists('users', $userRights))
		{
			$modules['Users'] = array(
				'class' => 'users',
				'list' => '/panel/?m=user',
				'add' => array('User', '/panel/?m=user&n=User'),
			);
		}
		if (array_key_exists('media', $userRights))
		{
			$modules['Media'] = array(
				'class' => 'media',
				'list' => '/panel/?m=media',
			);
		}
		if (array_key_exists('keywords', $userRights))
		{
			$modules['Keywords'] = array(
				'class' => 'keywords',
				'list' => '/panel/?m=keywords',
				'add' => array('Keywords', '/panel/?m=keywords&n=Keyword'),
			);
		}
		if (array_key_exists('news', $userRights))
		{
			$modules['News'] = array(
				'class' => 'news',
				'list' => '/panel/?m=news',
				'add' => array('News', '/panel/?m=news&n=News'),
			);
		}
		if (array_key_exists('newsletter', $userRights))
		{
			$modules['Newsletter'] = array(
				'class' => 'newsletter',
				'list' => '/panel/?m=newsletter',
				'add' => array('Subscriber', '/panel/?m=newsletter&n=Subscriber'),
			);
		}
		if (array_key_exists('products', $userRights))
		{
			$modules['Products'] = array(
				'class' => 'products',
				'list' => '/panel/?m=products',
				'add' => array('Subscriber', '/panel/?m=products&n=Product'),
			);
		}
		if (array_key_exists('galleries', $userRights))
		{
			$modules['Galleries'] = array(
				'class' => 'gallery',
				'list' => '/panel/?m=galleries',
				'add' => array('Gallery', '/panel/?m=galleries&n=Gallery'),
			);
		}
		if (array_key_exists('slider', $userRights))
		{
			$modules['Slider'] = array(
				'class' => 'slider',
				'list' => '/panel/?m=slider',
				'add' => array('Slider', '/panel/?m=slider&n=Slider'),
			);
		}
		if (array_key_exists('search', $userRights))
		{
			$modules['Search'] = array(
				'class' => 'search',
				'list' => '/panel/?m=search',
				'add' => array('Brand', '/panel/?m=search&n=Brand'),
			);
		}
		if (array_key_exists('trademarks', $userRights))
		{
			$modules['Trademarks'] = array(
				'class' => 'trademarks',
				'list' => '/panel/?m=trademarks',
				'add' => array('Trademark', '/panel/?m=trademarks&n=Trademark'),
			);
		}
		if (array_key_exists('labels', $userRights))
		{
			$modules['Labels'] = array(
				'class' => 'labels',
				'list' => '/panel/?m=labels',
			);
		}
		if (array_key_exists('settings', $userRights))
		{
			$modules['Settings'] = array(
				'class' => 'settings',
				'list' => '/panel/?m=settings',
			);
		}

		$this->modules = $modules;
	}

	public function executeEditUser()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('admin', 'User', $this);
	}

	public function executeSave()
	{
		$hasError = false;
		try
		{
			$parameters = $this->getRequest()->getParameterHolder()->getAll();
			$moduleName = $parameters['moduleName'];
			$documentName = $parameters["documentName"];
			$parent = Document::getDocumentInstance($parameters['parent']);

			if (!$parent)
			{
				if (isset($parameters["parentModule"]))
				{
					$parent = Rootfolder::getRootfolderByModule($parameters["parentModule"]);
				}
				else
				{
					$parent = Rootfolder::getRootfolderByModule($moduleName);
				}
			}
			if (is_numeric($parameters['id']))
			{
				$obj = Document::getDocumentInstance($parameters['id']);
				$parent = Document::getParentOf($parameters['id']);
			}
/*			elseif($parent && strstr($documentName, "I18n"))
			{
				$obj = Document::getChildrenOf($parent->getId(), $documentName);
				if($obj)
					$obj = $obj[0];
				else
					$obj = new $documentName();
			}*/
			else
			{
				$obj = new $documentName();
			}

			include_once(sfConfig::get('sf_root_dir')."/config/Schema.class.php");
			$m = "get".$documentName."Properties";
			$properties = Schema::$m();
			if (isset($parameters['imageFields']))
			{
				$imageFields = explode(",", $parameters['imageFields']);
			}
			else
			{
				$imageFields = array();
			}

			$contentArr = array();
			foreach ($parameters as $key => $value)
			{
				// parse Content attribute/s for Page
				if ($documentName == "Page" && substr($key, 0, 11) == 'attrContent' && in_array('Content', $properties))
				{
					$ind = intval(substr($key, 11));
					// check if creating NEW Page
					if ($ind == 0)
						$ind = 1;
					$contentArr[$parameters['contentID'.$ind]] = '<block id="'.$parameters['contentID'.$ind].'" target="'.$parameters['contentTarget'.$ind].'" action="richtext"><![CDATA['.$value.']]></block>';
				}
				else if (!(strpos($key, 'attr') === false) && ($key != "attrRewriteUrl"))
				{
					$key = str_replace('attr', '', $key);
					if ($properties && $key != "Password" && !in_array($key, $properties)) continue;
					if ($key == "Password" && empty($value)) continue;
					$function = 'set'.$key;
					if (is_array($value))
					{
						if(array_key_exists('year',$value) && array_key_exists('month',$value))
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
						else
						{
							$value = implode(";", $value);
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
					if ($key == "Related")
					{
//						if ($value)
//						{
//							$value = '['.str_replace(';', '][', $value).']';
//						}
					}
					if ($key == "Keywords")
					{
//						if ($value)
//						{
//							$value = str_replace(',', '][', $value);
//							$value = '['.substr($value, 0, -1);
//						}
					}
					$obj->$function($value);
				}
			}

			// Page content save
			if ( ($documentName == 'Page') && (count($contentArr) > 0) )
			{
				// add original NON-RICHTEXT content blocks
				$orgContent = $obj->getContent();
				$blocks = PanelService::get_content_blocks($orgContent);
				foreach ($blocks as $name => $block)
				{
					$contentArr[$name] = '<block id="'.$name.'" target="'.$block['target'].'" action="'.$block['action'].'"><![CDATA['.$block['content'].']]></block>';
				}

				$allBlocks = PanelService::get_all_content_blocks($orgContent);
				$content = '';
				foreach ($allBlocks as $blockName => $blockData)
				{
					$content .= $contentArr[$blockName];
				}
				$content = '<?xml version="1.0" encoding="UTF-8"?><blocks>'.$content.'</blocks>';
				$obj->setContent($content);
			}

/*			if (class_exists($documentName."I18n") && $documentName != "Listitem")
			{
				if(!$culture = $parameters["attrCulture"])
				{
					$culture = sfContext::getInstance()->getUser()->getCulture();
				}
				$obj->save(null, $parent, $culture);
				if(class_exists($documentName."I18n"))
				{
					PanelService::objectSave($objI8n, $obj, $documentName."I18n");
					if($documentName == "Page")
						$objI8n->setRewriteUrl($parameters["attrRewriteUrl"]);
					$objI8n->setCulture($culture);
					$objI8n->save(null, $obj, $culture);
				}
			}
			else*/
			{
				if ($documentName == "Page")
					$obj->setRewriteUrl($parameters["attrRewriteUrl"]);
				$obj->save(null, $parent);
			}

			if ($tags = Document::getAvailableTagsOf($moduleName, $parameters['documentName']))
			{
				foreach ($tags as $tag)
				{
					if ($parameters['tag_id_'.$tag->getId()])
					{
						Document::addTag($obj, $tag->getTagId(), false);
					}
					else
					{
						Document::removeTag($obj, $tag->getTagId(), false);
					}
				}
				Tagrelation::updateTagRelationCache();
			}
			//UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			$hasError = true;
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}
		if (!$hasError)
		{
			PanelService::redirect();
			exit();
		}
	}

/*	public function executeContextMenus()
	{
		$user = $this->getUser()->getSubscriber();
		if (!is_null($user))
		{
			include(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'rights.php');
			$this->userRights = $allRights[$user->getType()];
		}
	}*/

	public function executeParentsTree()
	{
		$this->moduleName = $module = $this->getRequestParameter("m");

		if ($p = $this->getRequestParameter('p'))
			$document = Document::getDocumentInstance($p);
		if (isset($document) && $document)
			$class = get_class($document);
		else
			$class = 'Rootfolder';
		$user = $this->getUser()->getSubscriber();
		$rights = PanelService::getUserRights($user, $class, $module);
		$this->module_rights = $rights;

		if ($module == "labels")
		{
			$this->tree = array('labels', $this->getRequestParameter("id"));
			return "Success";
		}
		if ($module == "settings")
		{
			$this->tree = array('settings', $this->getRequestParameter("id"));
			return "Success";
		}

		$id = $this->getRequestParameter('id');
		if (!$id)
		{
			$id = $this->getRequestParameter('p');
		}
		if (!$id)
		{
			$id = $this->getRequestParameter('parent');
		}
		if (!$id)
		{
			$root = Rootfolder::getRootfolderByModule($module);
			if ($root) $id = $root->getId();
		}

		if ($id)
			$this->tree = Document::getParentsTree($id);
	}

/*	public function executeLeftTree()
	{
		$this->tree = PanelService::getLeftTree($this->getRequestParameter('modulename'));
		$this->getUser()->setAttribute('currentModule', $this->getRequestParameter('modulename'));
	}*/

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

/*	public function executeLanguageBar()
	{
		$this->children = PanelService::getLanguageBar($this->getRequestParameter('parent'), $this->getRequestParameter('modulename'));
	}*/

/*	public function executeRightTree()
	{
		$this->resources = PanelService::getResources($this->getRequestParameter('modulename'));
	}

	public function executeGetRightTree()
	{
		$this->tree = PanelService::getRightTree($this->getRequestParameter('modulename'));
	}*/

	// ==============================================================================================================================
	public function executeEditFolder()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('admin', 'Folder', $this);
	}

	public function executeEditTag()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('admin', 'Tag', $this);
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
			//UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		PanelService::redirect('admin');
		exit();
	}

	// ==============================================================================================================================
	public function executeDelete()
	{
		if ($user = $this->getUser()->getSubscriber())
			$userType = $user->getType();

		if ($selectedDocuments = $this->getRequestParameter("selectedDocuments"))
		{

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
		}
		else
		{
			$document = Document::getDocumentInstance($this->getRequestParameter('id'));
			if ($document)
			{
				if ($userType != "admin" )
				{
					$class = get_class($document);
					if($class == "Lists" && $document->getListType() == "system")
					{
						$alert = "no_delete";
					}
					else if($class == "Listitem")
					{
						if($parent = Document::getParentOf($document->getId()))
						{
							if($parent->getListType() == "system")
								$alert = "no_delete";
						}
					}
				}
				if ($alert != "no_delete") $document->delete();
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
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
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
		if ($status == 'online')
			$status = UtilsHelper::STATUS_ACTIVE;
		if ($status == 'offline')
			$status = UtilsHelper::STATUS_DEACTIVATED;

		try
		{
			foreach ($items as $item)
			{
				$document = Document::getDocumentInstance($item);
				if (method_exists($document, 'setPublicationStatus'))
				{
					$document->setPublicationStatus($status);
					$document->save();
					Document::cacheObj($document, null, true);
				}
			}
		}
		catch(Exception $e)
		{
			exit("A probleme occured: ".$e->getMessage());
		}
		exit("OK");
	}

/*	public function executeChangeCulture()
	{
		$culture = $this->getRequestParameter('culture');
		$this->getUser()->setCulture($culture);
		exit("OK");
	}*/

	public function executeChangeOrder()
	{
		exec('rm -fr '.SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'menus/*');

		$items = $this->getRequestParameter('item');
		$c = new Criteria();
		$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);
		$c->add(RelationPeer::ID2, $items, Criteria::IN);
		$arr = RelationPeer::doSelect($c);
		$order = array();
		foreach ($arr as $ind => $obj)
		{
			$parentId = $obj->getId1();
			$order[ $items[$ind] ] = $obj->getSortOrder();
		}
		foreach ($arr as &$obj)
		{
			$obj->setSortOrder($order[$obj->getId2()]);
			$obj->save();
		}
		if ($parentId)
			Relation::updateRelationCache($parentId);
		exit("OK");
	}

	public function executeMoveDocument()
	{
		try
		{
			$documentId = $this->getRequestParameter('id');
			$up = $this->getRequestParameter('up');
			if ($up)
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
		exit("OK");
	}

	public static function get_richtext($content)
	{
		$richtext = XMLParser::getXMLdata($content);
		$out = array();
		foreach ($richtext[0] as $obj)
		{
			if (($obj['tag'] == 'BLOCK') && ($obj['type'] == 'complete'))
			{
				if (substr($obj['attributes']['ID'], 0, 8) == 'richtext')
				{
					$name = substr($obj['attributes']['ID'], 8);
					$out[$name]['target'] = $obj['attributes']['TARGET'];
					$out[$name]['content'] = $obj["value"];
				}
			}
		}
		return $out;
	}

	public function executeGetRichtextFields()
	{
		$this->setLayout(false);

		$template = $this->getRequestParameter('template');
		$templateFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.'.xml';
		if (!is_file($templateFile))
		{
			$templateFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.'.xml';
		}
		$tags = XMLParser::getXMLdataValues($templateFile);

		// CREATING PREDEFINED RICHTEXT FIELDS
		$richtextCnt = 0;
		$richtextBoxes = array();
		foreach ($tags as $tag)
		{
			if (($tag['tag'] == 'DESTINATION') && ($tag['type'] == 'complete') && ($tag['attributes']['TYPE'] == 'richtext'))
			{
				$richtextCnt++;
				$richtextBoxes[$richtextCnt] = $tag['attributes']['ID'];
			}
		}
		$obj = Document::getDocumentInstance($this->getRequestParameter('id'));
		if ($obj)
		{
			$this->richtext = self::get_richtext($obj->getContent());
		}
		$this->obj = $obj;
		$this->boxes = $richtextBoxes;
	}

}