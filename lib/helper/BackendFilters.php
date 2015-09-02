<?php

class BackendFilters
{
	public static function getInactiveSubscribers(&$c, &$pager)
	{
		$pager = "Subscriber";
		$c->add(SubscriberPeer::PUBLICATION_STATUS , 'WAITING', Criteria::EQUAL);
		$c->addAscendingOrderByColumn(SubscriberPeer::LABEL);
	}
	
	/*================================ SEARCH ============================================*/
	public static function news_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		
		$owner = $user->getSubscriber();
		$ownerId = $owner->getId();
		
		/*if($stype == "extended")
		{
			$queryTerms = explode(" ", $keys);
			
			foreach ($queryTerms as $t)
			{
				if(strlen($t) > 3 && count($terms) < 3)
				{
					$q[] = "Label:".UtilsHelper::cyrillicConvert($t)."*";
				}
			}
			$query = implode(" ", $q);
			$query = Zend_Search_Lucene_Search_QueryParser::parse($query, 'utf-8');
			$searchIndex = Zend_Search_Lucene::open(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search/news');
			
			$searchResults  = $searchIndex->find($query);
			$res = array();
			
			foreach ($searchResults as $hit)
			{
				$obj = Document::getDocumentInstance($hit->document_id);
				if($obj) $res[] = $obj;
			}
			
			$pager = new sfPropelPager("NewsI18n", 50);
			$pager->setResults($res);
		}
		else*/
		{
			$pager = "NewsI18n";
			$c->add(NewsI18nPeer::LABEL, $keys, Criteria::LIKE);
			/*if($owner->getType() != "admin")
			{
				$c->addJoin(RelationPeer::ID2, NewsI18nPeer::ID, Criteria::LEFT_JOIN );
				$c->addJoin(RelationPeer::ID1, DocumentPeer::ID, Criteria::LEFT_JOIN );
				$c->add(DocumentPeer::DOCUMENT_AUTHOR, $ownerId);
			}*/
		}
	}

	
	public static function user_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		
		/*if($stype == "extended")
		{
			$queryTerms = explode(" ", $keys);
			
			foreach ($queryTerms as $t)
			{
				if(strlen($t) > 3 && count($terms) < 3)
				{
					$q[] = "Label:".UtilsHelper::cyrillicConvert($t)."*";
				}
			}
			$query = implode(" ", $q);
			$query = Zend_Search_Lucene_Search_QueryParser::parse($query, 'utf-8');
			$searchIndex = Zend_Search_Lucene::open(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search/users');
			
			$searchResults  = $searchIndex->find($query);
			$res = array();
			
			foreach ($searchResults as $hit)
			{
				$obj = Document::getDocumentInstance($hit->document_id);
				if($obj) $res[] = $obj;
			}
			
			$pager = new sfPropelPager("User", 50);
			$pager->setResults($res);
		}
		else*/
		{
			$pager = "User";
			$c1 = $c->getNewCriterion(UserPeer::EMAIL, $keys, Criteria::LIKE);
			$c2 = $c->getNewCriterion(UserPeer::LABEL, $keys, Criteria::LIKE);
			$c1->addOr($c2);
			$c->add($c1);
		}
	}
	
	public static function newsletter_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		
		$pager = "Subscriber";
		$c1 = $c->getNewCriterion(SubscriberPeer::EMAIL, $keys, Criteria::LIKE);
		$c2 = $c->getNewCriterion(SubscriberPeer::LABEL, $keys, Criteria::LIKE);
		$c1->addOr($c2);
		$c->add($c1);
	}
	
	
	public static function company_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		
		$pager = "Company";
		$c1 = $c->getNewCriterion(CompanyPeer::LABEL, $keys, Criteria::LIKE);
		$c2 = $c->getNewCriterion(CompanyPeer::ID, substr($keys, 1 , -1), Criteria::EQUAL );
		$c1->addOr($c2);
		$c->add($c1);
	}
	
	public static function properties_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		$pager = "Property";
		$c->add(PropertyPeer::LABEL, $keys, Criteria::LIKE);
	}
	public static function media_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		$pager = "Media";
		$c->add(MediaPeer::LABEL, $keys, Criteria::LIKE);
	}
	
	public static function website_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		$pager = "Page";
		
		$c->add(PagePeer::LABEL, $keys, Criteria::LIKE);
		$res = PagePeer::doSelect($c);
		
		$c = new Criteria();
		$c->add(PageI18nPeer::LABEL, $keys, Criteria::LIKE);
		$res2 = PageI18nPeer::doSelect($c);
		
		$c = new Criteria();
		$c->add(TopicPeer::LABEL, $keys, Criteria::LIKE);
		$res3 = TopicPeer::doSelect($c);
		
		$c = new Criteria();
		$c->add(TopicI18nPeer::LABEL, $keys, Criteria::LIKE);
		$res4 = TopicI18nPeer::doSelect($c);
		
		$c = array_merge($res, array_merge($res2, array_merge($res3 , $res4)));
	}
	
	public static function lists_search(&$c, &$pager)
	{
		self::getSearchParams($context, $user, $request, $keys, $stype);
		$pager = "Lists";

		$c->add(ListsPeer::LABEL, $keys, Criteria::LIKE);
		$res = ListsPeer::doSelect($c);
		
		$c = new Criteria();
		$c->add(ListitemI18nPeer::LABEL, keys, Criteria::LIKE);
		$res2 = ListitemI18nPeer::doSelect($c);
		
		$c = new Criteria();
		$c->add(ListitemPeer::LABEL, $keys, Criteria::LIKE);
		$res3 = ListitemPeer::doSelect($c);
		
		$c = array_merge($res, array_merge($res2, $res3));
	}
	
	
	/*================================ TOOLS ============================================*/
	
	public static  function getSearchParams(&$context, &$user, &$request, &$keys, &$stype)
	{
		$context = sfContext::getInstance();
		$user = $context->getUser();
		$request = $context->getRequest();
		$stype = $request->getParameter('stype');
		$keys = str_replace(array(chr(255), chr(254), chr(253)), array(".", "?", "/"), $request->getParameter('keys'));
	
		if(!$keys)
		{
			$keys = $user->getAttribute('search_keys');
		}
		else
		{
			$user->setAttribute('search_keys', $keys);
		}
		
		if(!$stype)
		{
			$stype = $user->getAttribute('search_type');
		}
		else
		{
			$user->setAttribute('search_type', $stype);
		}
		
		if($keys)
		{
			if($stype != "extended")
			{
				$keys = "%".$keys."%";
			}
		}
		else
		{
			$keys = null;
		}
	}
}