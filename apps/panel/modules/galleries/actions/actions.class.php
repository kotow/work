<?php

/**
 * Galleries  actions.
 *
 * @package		cms
 * @subpackage	galleries
 */

class galleriesActions extends sfActions
{
	public function executeIndex()
	{
		$this->redirect('/panel/admin/index');
	}

	public function executeEditGallery()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('galleries', 'Gallery', $this);
	}

}