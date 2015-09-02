<?php



class SearchMatchMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SearchMatchMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_search_match');
		$tMap->setPhpName('SearchMatch');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('IMPORT_SESSION', 'ImportSession', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('SEARCH', 'Search', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TRADEMARK', 'Trademark', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MATCHES', 'Matches', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 