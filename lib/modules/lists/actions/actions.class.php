<?php
/**
 * @package    cms
 * @subpackage core lists
 * @author     Jordan Hristov / Ilya Popivanov
 */

class listsCoreActions extends sfActions
{
  
	public function executeGetLinkedListItems()
	{
		$this->setLayout(false);
		if(is_numeric($id = $this->getRequestParameter('id'))) $list = Lists::getChildListForItem($id);
		if($list) $items = Lists::getListitemsByListId($list->getListId());
		
		foreach ($items as $item)
		{
			$options .= "<option value='".$item->getId()."'>".$item->getLabel()."</option>";
		}
		return $this->renderText($options);
	}

}
