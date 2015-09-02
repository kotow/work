<?php



class TagMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TagMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_tag');
		$tMap->setPhpName('Tag');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('TAG_ID', 'TagId', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MODULE', 'Module', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DOCUMENT_MODEL', 'DocumentModel', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXCLUSIVE', 'Exclusive', 'boolean', CreoleTypes::BOOLEAN, false, null);

	} 
} 