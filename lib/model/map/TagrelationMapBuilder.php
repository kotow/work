<?php



class TagrelationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TagrelationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_tag_relation');
		$tMap->setPhpName('Tagrelation');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addPrimaryKey('TAG_ID', 'TagId', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 