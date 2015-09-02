<?php

/**
 * Slider actions.
 *
 * @package		XXXXXX
 * @subpackage	slider
 */

class sliderActions extends sfActions
{							

	public function loadPages()
	{
		$allPages = array('' => '----- select a page -----');
		$c = new Criteria();
		$c->addAscendingOrderByColumn(PagePeer::LABEL);
		$pages = PagePeer::doSelect($c);
		foreach ($pages as $p)
		{
			$allPages[$p->getId()] = $p->getLabel();
		}
		$this->allPages = $allPages;
	}

	public function executeEditSlide()
	{
		$this->setLayout(false);
//		$this->loadPages();
		return PanelService::objectEdit('slider', 'Slide', $this);
	}

	public function executeEditSlider()
	{
		$this->setLayout(false);
		return PanelService::objectEdit('slider', 'Slider', $this);
	}

/*	public function executeEditSlideI18n()
	{
		$this->setLayout(false);
		$this->loadPages();
		return PanelService::objectEdit('slider', 'SlideI18n', $this);
	}*/

}