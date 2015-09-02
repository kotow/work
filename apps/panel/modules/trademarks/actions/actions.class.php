<?php
/**
 * news actions.
 *
 * @package    cms
 * @subpackage trademarks
 */

class trademarksActions extends sfActions
{

	public function executeIndex()
	{
		$this->redirect('/panel/admin/index');
	}

	public function executeEditTrademark()
	{
		$this->setLayout(false);
		$this->systemsArr = array(
			1 => 'BPO - Bulgaria',
			2 => 'OAMI - Europe',
			3 => 'WIPO - world',
		);
		$this->kindsArr = array(
			1 => 'Text',
			2 => 'Image',
			3 => 'Mixed',
		);
		$this->statusArr = array(
			1 => 'Pending',
			2 => 'Registered',
			3 => 'Rejected',
		);
		return PanelService::objectEdit('trademarks', 'Trademark', $this);
	}

}