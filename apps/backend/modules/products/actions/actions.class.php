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
		BackendService::objectEdit('products', 'Category', $this);
	}

	public function executeEditCategoryI18n()
	{
		BackendService::objectEdit('products', 'CategoryI18n', $this);
	}

	public function executeEditProduct()
	{
		BackendService::objectEdit('products', 'Product', $this);
	}

	public function executeEditProductI18n()
	{
		BackendService::objectEdit('products', 'ProductI18n', $this);
	}
}