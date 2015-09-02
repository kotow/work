<?php



class PageMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.PageMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('tm_marks');

		$tMap = $this->dbMap->addTable('m_website_page');
		$tMap->setPhpName('Page');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('PAGE_TYPE', 'PageType', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('NAVIGATION_TITLE', 'NavigationTitle', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('META_DESCRIPTION', 'MetaDescription', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('META_KEYWORDS', 'MetaKeywords', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('IMAGE', 'Image', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TEMPLATE', 'Template', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PAGE_ID', 'PageId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('IS_SECURE', 'IsSecure', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 