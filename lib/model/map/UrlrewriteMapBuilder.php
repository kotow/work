<?php



class UrlrewriteMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UrlrewriteMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_urlrewrite');
		$tMap->setPhpName('Urlrewrite');

		$tMap->setUseIdGenerator(false);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PAGE_ID', 'PageId', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 