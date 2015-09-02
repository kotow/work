<?php

/**
 * Tag  actions.
 *
 * @package		XXXXXX
 * @subpackage	tag
 */

class tagActions extends sfActions
{
	public function executeEditTag()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('tag', 'Tag', $this);
	}
	
	public function executeSaveTag()
	{
		try
		{
			$parameters = $this->getRequest()->getParameterHolder()->getAll();

			if ($parameters['id'])
			{
				$obj = Document::getDocumentInstance($parameters['id']);
				$parent = Document::getParentOf($parameters['id']);
			}
			else
			{
				$obj = new Tag();
				$parent = Document::getDocumentInstance($parameters['parent']);
			}

			foreach ($parameters as $key => $value)
			{
				if (!(strpos($key, 'attr') === false))
				{
					$function = 'set'.str_replace('attr', '', $key);
					$obj->$function($value);
				}
			}
			if(!$parameters['attrExclusive']) $obj->setExclusive(0);

			$obj->save(null, $parent);

			UtilsHelper::setBackendMsg("Saved");
		}
		catch (Exception $e)
		{
			UtilsHelper::setBackendMsg("Error while saving: ". $e->getMessage(), "error");
		}

		PanelService::redirect('tag');
		exit();
	}

}