<?php



class TopicMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TopicMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_website_topic');
		$tMap->setPhpName('Topic');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('NAVIGATION_TITLE', 'NavigationTitle', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 