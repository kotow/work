<?php
/**
 * news actions.
 *
 * @package    cms
 * @subpackage search
 */

class searchActions extends sfActions
{

	public function executeIndex()
	{
		$this->redirect('/panel/admin/index');
	}

	public function executeEditBrand()
	{
		$this->setLayout(false);

		$ownersArr = array('' => '--- изберете ---');
		$root = Rootfolder::getRootfolderByModule('clients');
		$owners = Document::getChildrenOf($root->getId(), 'Client');
		foreach ($owners as $ow)
		{
			$ownersArr[$ow->getId()] = $ow->getLabel();
		}
		$this->ownersArr = $ownersArr;
		$this->kindsArr = UtilsHelper::loadTrademarkTypes();
		return PanelService::objectEdit('search', 'Brand', $this);
	}

	public function executeEditSearch()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('search', 'Search', $this);
	}

}