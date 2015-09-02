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
		$this->redirect('/panel/admin/index');
	}

	public function executeEditNews()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('news', 'News', $this);
	}

/*	public function executeEditNewsI18n()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('news', 'NewsI18n', $this);
	}

	public function executeSaveNewsI18n()
	{
		try
		{
			$hasError = false;
			PanelService::objectSave($obj, $parent);

			$obj->setStartDate(substr($obj->setStartDate(),0,11).date("H.i.s"));
			$obj->save(null, $parent, $parameters["attrCulture"]);

			//UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			$hasError = true;
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}
		if (!$hasError)
		{
			PanelService::panelRedirect();
			exit();
		}
	}*/

}