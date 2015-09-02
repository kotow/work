<?php
/**
 * @package    cms
 * @subpackage core search
 * @author     Jordan Hristov / Ilya Popivanov
 */

class searchCoreActions extends sfActions
{

	public function executeSearchForm()
	{
		$this->setLayout(false);
		$page = Document::getDocumentByExclusiveTag("website_page_search");
		if ($page)
		{
			$this->searchUrl = $page->getHref(false);
		}
	}

	public function executeSearch()
	{
		try
		{
			$this->setLayout(false);

			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll();
			$searchOf= array();

			foreach ($params as $key => $param)
			{
				$parts = explode("-", $key);
				if($parts[0] == "field" && !empty($param))
				{
					str_replace(
					array('+','-','&&','||','!','(',')','{','}','[',']','^','"','~','*','?',':','\\','.','/'), 
					array('\+','\-','\&&','\||','\!','\(','\)','\{','\}','\[','\]','\^','\"','\~','\*','\?','\:','\\\\','\.','\/'),
					$param
					);
					$searchOf[$parts[1]] = trim($param);
					}
			}

			/////////////////////// QUERY BUILDING //////////////////////////
			$q = new Zend_Search_Lucene_Search_Query_Boolean();
			$queryTerms = explode(" ", strtolower($query));

			$i = 0;
			$query = "";
			foreach ($searchOf as $field => $term)
			{
				if($i > 0) $query .= ' AND ';

				$query .= $field.':';

				if(/*$field == "OfficeOfOrigin" ||*/$field == "NiceClasses" || $field == "ViennaClasses")
				{
					$query .= '(';
					$parts = explode(",", $term);
					foreach ($parts as  $el)
					{
						for ($e = 1 ; $e < 21 ; $e++)
						{
							$query .= $field.$e.':"'.trim($el).'" OR ';
						}
					}
					$query = substr($query, 0, -4).")";
				}
				elseif($field == "DesignatedContractingParty")
				{
					$query .= '(';
					$parts = explode(",", $term);
					foreach ($parts as  $el)
					{
						for ($e = 1 ; $e < 21 ; $e++)
						{
							$query .= $field.$e.':"'.trim($el).'" OR ';
						}
					}
					$query = substr($query, 0, -4).")";
				}
				elseif($field == "Label")
				{
					if(strpos($term,"*") !== false || strpos($term,"?") !== false)
						$query .= trim($term);
					else
						$query .= trim($term).'~0.7';
				}
				else
				{
					if(strpos($term,"*") !== false || strpos($term,"?") !== false)
						$query .= trim($term);
					else
						$query .= trim($term);
				}

				$i++;
			}

			//echo "QUERY: ".$query;
			$q = Zend_Search_Lucene_Search_QueryParser::parse($query);

			//////////////////////// SEARCH EXECUTION ////////////////////
			$searchIndex = Zend_Search_Lucene::open(sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search/');
			//Zend_Search_Lucene::setResultSetLimit(100);
			$searchResults  = $searchIndex->find($q);
			//$this->count = count($searchResults);
			//$this->results = $searchResults;
			$this->pager = UtilsHelper::pager("Trademark", $searchResults, 100);
			$this->count = $this->pager->getNbResults();
			$this->paging = $this->pager->paging();
		}
		catch (Exception $e)
		{
			$this->error = $e->getMessage();
		}

	}

}