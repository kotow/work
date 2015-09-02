<?php
/**
 * lists actions.
 *
 * @package    cms
 * @subpackage lists
 */

class listsActions extends sfActions
{
	public function executeIndex()
	{
		$this->redirect('admin/index');
	}

	public function executeEditLists()
	{
		$this->setLayout(false);
		PanelService::objectEdit('lists', 'Lists', $this);
		if ($user = $this->getUser()->getSubscriber())
		{
			$this->userType = $user->getType();
		}
	}

	public function executeEditListitem()
	{
		$this->setLayout(false);
		PanelService::objectEdit('lists', 'Listitem', $this);
//		if ($user = $this->getUser()->getSubscriber())
//		{
//			$this->userType = $user->getType();
//		}
/*		if ($this->obj)
		{
			if ($parent = Document::getParentOf($this->obj->getId()))
			{
				$this->listType = $parent->getListType();
			}
		}*/
	}

/*	public function executeEditListitemI18n()
	{
		$this->setLayout(false);
		PanelService::objectEdit('lists', 'ListitemI18n', $this);
		if($user = $this->getUser()->getSubscriber())
			$this->userType = $user->getType();
		if ($this->obj)
		{
			if($parentI18 = Document::getParentOf($this->obj->getId()))
			{
				if($parent = Document::getParentOf($parentI18))
				{
					$this->listType = $parent->getListType();
				}
			}
		}
	}*/

}