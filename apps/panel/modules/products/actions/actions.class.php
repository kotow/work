<?php

/**
 * Products  actions.
 *
 * @package		XXXXXX
 * @subpackage	products
 */

class productsActions extends sfActions
{

	public function executeEditCategory()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('products', 'Category', $this);
	}

/*	public function executeEditCategoryI18n()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('products', 'CategoryI18n', $this);
	}*/

	public function executeEditProduct()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('products', 'Product', $this);
	}

/*	public function executeEditProductI18n()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('products', 'ProductI18n', $this);
	}*/
	
/*	public function executeSaveCategory()
	{
		try
		{
			PanelService::objectSave($obj, $parent);
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error saving Category: ". $e->getMessage(), "error");
		}
		
//		exec('rm -fr '.SF_ROOT_DIR.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'menus/*');
		//PanelService::redirect();
		//exit();
	}*/

}