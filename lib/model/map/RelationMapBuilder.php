<?php



class RelationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.RelationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_relation');
		$tMap->setPhpName('Relation');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID1', 'Id1', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addPrimaryKey('ID2', 'Id2', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DOCUMENT_MODEL1', 'DocumentModel1', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DOCUMENT_MODEL2', 'DocumentModel2', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SORT_ORDER', 'SortOrder', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 