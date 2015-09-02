<?php
/**
 * @package    cms
 * @subpackage keywords
 * @author     Jordan Hristov / Ilya Popivanov
 */

class keywordsActions extends sfActions
{

	public function executeAddKeyword()
	{
		$val = $this->getRequestParameter('keyword');
		$c = new Criteria();
		$c->add(KeywordPeer::LABEL, $val."%", Criteria::LIKE );
		$keyword = KeywordPeer::doSelectOne($c);
		if(!$keyword)
		{
			$keyword = new Keyword();
			$keyword->setLabel($val);
			$keyword->save();
			
			exit($keyword->getId().",".$keyword->getLabel());
		}
		exit();
	}
	
	public function executeGetKeywords()
	{
		$val = $this->getRequestParameter('keyword');
		if(strlen($val) > 2)
		{
			$c = new Criteria();
			$c->add(KeywordPeer::LABEL, $val."%", Criteria::LIKE );
			$c->addJoin(KeywordPeer::ID, DocumentPeer::ID);
			$c->add(DocumentPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
			$c->setLimit(10);
			$keywords = KeywordPeer::doSelect($c);
			foreach ($keywords as $keyword)
			{
				$keys .= $keyword->getId().",".$keyword->getLabel().";";
			}
		}
		exit($keys);
	}
	
	public function executeEditKeyword()
	{
		BackendService::objectEdit('keywords', 'Keyword', $this);
	}

}