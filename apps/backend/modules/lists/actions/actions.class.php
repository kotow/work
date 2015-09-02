<?php
/**
 * @package    cms
 * @subpackage lists
 * @author     Jordan Hristov / Ilya Popivanov
 */

class listsActions extends sfActions
{
	public function executeIndex()
	{
		$this->redirect('admin/index');
	}

	public function executeEditLists()
	{
		BackendService::objectEdit('lists', 'Lists', $this);
		if($user = $this->getUser()->getSubscriber())
			$this->userType = $user->getType();
	}

	public function executeEditListitem()
	{
		BackendService::objectEdit('lists', 'Listitem', $this);
		if($user = $this->getUser()->getSubscriber())
			$this->userType = $user->getType();
		
		if($this->obj)
		{
			if($parent = Document::getParentOf($this->obj->getId()))
			{
				$this->listType = $parent->getListType();
				if($parent->getListId() == "property_type") $this->showtags = true;
				if($parent->getListId() == "brokers") $this->showvalue = true;
			}
		}
	}

	public function executeEditListitemI18n()
	{
		BackendService::objectEdit('lists', 'ListitemI18n', $this);
		if($user = $this->getUser()->getSubscriber())
			$this->userType = $user->getType();
			
		if($this->obj)
		{
			if($parentI18 = Document::getParentOf($this->obj->getId()))
			{
				if($parent = Document::getParentOf($parentI18))
				{
					$this->listType = $parent->getListType();
					//if($parent->getListId() == "brokers") $this->showvalue = true;
				}
			}
		}
	}

}