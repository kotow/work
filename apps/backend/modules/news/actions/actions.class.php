<?php
/**
 * news actions.
 *
 * @package    cms
 * @subpackage news
 */

class newsActions extends sfActions
{

	public function executeIndex()
	{
		$this->redirect('admin/index');
	}

	public function executeEditNews()
	{
		BackendService::objectEdit('news', 'News', $this);
	}

	public function executeEditNewsI18n()
	{
		BackendService::objectEdit('news', 'NewsI18n', $this);
	}

	public function executeSaveNewsI18n()
	{
		try
		{
			BackendService::objectSave($obj, $parent);

			$end_date = $obj->getEndDate();
			$obj->setEndDate(substr($end_date,0,11).'23:59:59');
			$obj->save(null, $parent, $parameters["attrCulture"]);

			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		$this->forward(strtolower($this->getRequestParameter('moduleName')), "edit".$this->getRequestParameter('documentName'));
		exit();
	}

}