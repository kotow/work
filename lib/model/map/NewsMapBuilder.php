<?php



class NewsMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.NewsMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_news');
		$tMap->setPhpName('News');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SHORT_DESCRIPTION', 'ShortDescription', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('IMAGE', 'Image', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DOWNLOAD', 'Download', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('START_DATE', 'StartDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('END_DATE', 'EndDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('RDS', 'Rds', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('KEYWORDS', 'Keywords', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 