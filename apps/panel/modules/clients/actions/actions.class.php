<?php

/**
 * Clients actions.
 *
 * @package		XXXXXX
 * @subpackage	clients
 */

class clientsActions extends sfActions
{							

	public function executeIndex()
	{
		$this->redirect('/panel/admin/index');
	}

	public function executeEditClient()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('clients', 'Client', $this);
	}

}