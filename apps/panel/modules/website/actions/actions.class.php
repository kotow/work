<?php
/**
 * website actions.
 *
 * @package    cms
 * @subpackage website
 */

class websiteActions extends sfActions
{
	public function executeIndex()
	{
		$this->redirect('/panel');
	}

	public function executeEditWebsite()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('website', 'Website', $this);
	}

	public function executeEditMenu()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('website', 'Menu', $this);
	}

	public function executeEditTopic()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('website', 'Topic', $this);
	}

/*	public function executeEditTopicI18n()
	{
		$this->setLayout(false);
		PanelService::objectEdit('website', 'TopicI18n', $this);
	}*/

	public function loadPages()
	{
		$allPages = array('' => '----- select a page -----');
		$c = new Criteria();
		$c->addAscendingOrderByColumn(PagePeer::LABEL);
		$pages = PagePeer::doSelect($c);
		foreach ($pages as $p)
		{
			$allPages[$p->getId()] = $p->getLabel();
		}
		$this->allPages = $allPages;
	}

	public function executeEditPage()
	{
		$this->setLayout(false);

		$this->loadPages();
		$res = PanelService::objectEdit('website', 'Page', $this);
		if ($this->obj)
			$this->template = $this->getPageTemplates(true);
		else
			$this->template = $this->getPageTemplates();
		return $res;
	}

/*	public function executeEditPageI18n()
	{
		$this->setLayout(false);
		
		$this->loadPages();
		PanelService::objectEdit('website', 'PageI18n', $this);
		if ($this->obj)
			$this->template = $this->getPageTemplates(true);
		else
			$this->template = $this->getPageTemplates();
	}*/

	public function executeSavePage()
	{
		try
		{
			PanelService::objectSave($obj, $parent);
			Urlrewrite::updateUrlRelationCache();
			//UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error saving Page: ". $e->getMessage(), "error");
		}
		
//		exec('rm -fr '.SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'menus/*');
//		PanelService::redirect();
//		exit();
	}

/*	public function executeSavePageI18n()
	{
		try
		{
			$pageType = $this->getRequestParameter("attrPageType");
			if (!$pageType)
			{
				$request = $this->getRequest();
				$request->setParameter('attrPageType', 'CONTENT');
			}

			PanelService::objectSave($obj, $parent);

			$obj->setRewriteUrl($this->getRequestParameter("attrRewriteUrl"));
			if (!$this->getRequestParameter("attrIsSecure"))
			{
				$obj->setIsSecure(NULL);
			}
			$obj->save(null, $parent, $this->getRequestParameter("attrCulture"));
			Urlrewrite::updateUrlRelationCache();

			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		PanelService::redirect();
		exit();
	}*/

	public function getPageTemplates($all = false)
	{
		$templates = array('' => '----- select page template -----');
		if ($dirHandle = opendir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'))
		{
			while (false !== ($file = readdir($dirHandle)))
			{
				if (strpos($file,'.xml') === strlen($file) - 4)
				{
					$tplName = substr($file, 0, strlen($file) - 4);
					//if ((!$all && ($tplName == "home")) || (!$all && ($tplName == "default"))) continue;
					$templates[$tplName] = $tplName;
				}
			}
			closedir($dirHandle);
		}
/*		if ($dirHandle = opendir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'))
		{
			while (false !== ($file = readdir($dirHandle)))
			{
				if (strpos($file,'.xml') === strlen($file) - 4)
				{
					$tplName = substr($file, 0, strlen($file) - 4);
					if($tplName != "promos") continue;
					$templates[$tplName] = $tplName;
				}
			}
			closedir($dirHandle);
		}*/
		return $templates;
	}

}