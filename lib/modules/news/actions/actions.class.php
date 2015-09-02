<?php
/**
 * @package    cms
 * @subpackage core news
 * @author     Jordan Hristov / Ilya Popivanov
 */

class newsCoreActions extends sfActions
{

	public function executeLatest()
	{
		$this->setLayout(false);
		$c = new Criteria();
		
//		$c->addJoin(NewsPeer::ID, DocumentPeer::ID, Criteria::LEFT_JOIN );
//		$c->addJoin(NewsPeer::ID, RelationPeer::ID1 );
//		$c->addJoin(NewsI18nPeer::ID, RelationPeer::ID2 );
		$c->add(NewsPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
		$c->addDescendingOrderByColumn(NewsPeer::START_DATE);
		$this->pager = UtilsHelper::pager("News", $c, 3);
		$this->paging = $this->pager->paging(true);
	}
	
	public function executeList()
	{
		$this->setLayout(false);
		$c = new Criteria();
		
//		$c->addJoin(NewsPeer::ID, DocumentPeer::ID, Criteria::LEFT_JOIN );
//		$c->addJoin(NewsPeer::ID, RelationPeer::ID1 );
//		$c->addJoin(NewsI18nPeer::ID, RelationPeer::ID2 );
		$c->add(NewsPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
		$c->addDescendingOrderByColumn(NewsPeer::START_DATE);
		$this->pager = UtilsHelper::pager("News", $c, 15);
		$this->paging = $this->pager->paging(true);
	}

	public function executeDetail()
	{
		$this->setLayout(false);
		if ($id = $this->getRequestParameter('News_id'))
		{
			if ($this->news = Document::getDocumentInstance($id))
			{
				//$reads = $this->news->getRds()+1;
				//$this->news->setRds($reads);
				//$this->news->save();
				$this->images = Document::getChildrenOf($id, 'Media', false);
			}
		}
	}

	public function executeMenu()
	{
		$this->setLayout(false);
		$con = Propel::getConnection();
		$year = date("Y");
		$years = array();
		$sql = "SELECT DISTINCT MONTH(start_date) AS month FROM m_news WHERE start_date LIKE '".$year."%'";
		$stmt = $con->createStatement();
		$rs = $stmt->executeQuery($sql);
		while ($rs->next())
		{
			$months[]= $rs->get("month");
		}

		$con = Propel::getConnection();
		$year = date("Y");
		$sql = "SELECT DISTINCT YEAR(start_date) AS year FROM m_news";
		$stmt = $con->createStatement();
		$rs = $stmt->executeQuery($sql);
		while ($rs->next())
		{
			$years[$rs->get("year")]= $rs->get("year");
		}

		unset($years[$year]);

		if(!empty($years)) $this->pastYears = $years;

		$this->monthsArr = array(
			1=>"january",
			2=>"february",
			3=>"march",
			4=>"april",
			5=>"may",
			6=>"june",
			7=>"july",
			8=>"august",
			9=>"september",
			10=>"october",
			11=>"november",
			12=>"december",
		);
		//UtilsHelper::Date()
		$this->months = $months;
		$this->getRequestParameter("month")? $this->currentMonth = $this->getRequestParameter("month"): $this->currentMonth = date("n");
		$this->currentYear = $year;
	}

}