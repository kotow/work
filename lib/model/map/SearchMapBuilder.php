<?php



class SearchMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.SearchMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_search');
		$tMap->setPhpName('Search');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('APPLICATION_NUMBER', 'ApplicationNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REGISTER_NUMBER', 'RegisterNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REGISTRATION_DATE', 'RegistrationDate', 'string', CreoleTypes::VARCHAR, false, 12);

		$tMap->addColumn('APPLICATION_DATE', 'ApplicationDate', 'string', CreoleTypes::VARCHAR, false, 12);

		$tMap->addColumn('EXPIRES_ON', 'ExpiresOn', 'string', CreoleTypes::VARCHAR, false, 12);

		$tMap->addColumn('VIENNA_CLASSES', 'ViennaClasses', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('NICE_CLASSES', 'NiceClasses', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('RIGHTS_OWNER', 'RightsOwner', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('RIGHTS_REPRESENTATIVE', 'RightsRepresentative', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('OFFICE_OF_ORIGIN', 'OfficeOfOrigin', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('DESIGNATED_CONTRACTING_PARTY', 'DesignatedContractingParty', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 