<?php
/**
 * @package    cms
 * @subpackage galleries
 * @author     Jordan Hristov / Ilya Popivanov
 */

class galleriesCoreActions extends sfActions
{

	public function executeList($getFirstgalleries = false)
	{
		$this->setLayout(false);
		$c = new Criteria();
		$c->addJoin(GalleryPeer::ID, RelationPeer::ID2, Criteria::LEFT_JOIN );
		$c->add(GalleryPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
		$c->addAscendingOrderByColumn(RelationPeer::SORT_ORDER);
		$this->pager = UtilsHelper::pager("Gallery", $c, 10);
		$this->paging = $this->pager->paging(true);
	}

	public function executeDetail()
	{
		if ($id = $this->getRequestParameter('Gallery_id'))
		{
			$this->setLayout(false);
			if($this->gallery = Document::getDocumentInstance($id))
			{
				$reads = $this->gallery->getRds()+1;
				$this->gallery->setRds($reads);
				$this->gallery->save();
				$this->images = Document::getChildrenOf($id, 'Media', false);
			}
		}
	}

}