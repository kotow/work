<?php



class TrademarkMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.TrademarkMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_trademark');
		$tMap->setPhpName('Trademark');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('APPLICATION_NUMBER', 'ApplicationNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REGISTER_NUMBER', 'RegisterNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('REGISTRATION_DATE', 'RegistrationDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('FROM_SYSTEM', 'FromSystem', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('KIND', 'Kind', 'string', CreoleTypes::VARCHAR, false, 31);

		$tMap->addColumn('APPLICATION_DATE', 'ApplicationDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('STATUS', 'Status', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXPIRES_ON', 'ExpiresOn', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATIONS', 'Publications', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('VIENNA_CLASSES', 'ViennaClasses', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('COLORS', 'Colors', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('NICE_CLASSES', 'NiceClasses', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('RIGHTS_OWNER', 'RightsOwner', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('RIGHTS_OWNER_ID', 'RightsOwnerId', 'string', CreoleTypes::VARCHAR, false, 63);

		$tMap->addColumn('RIGHTS_OWNER_ADDRESS', 'RightsOwnerAddress', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('RIGHTS_REPRESENTATIVE', 'RightsRepresentative', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('RIGHTS_REPRESENTATIVE_ID', 'RightsRepresentativeId', 'string', CreoleTypes::VARCHAR, false, 63);

		$tMap->addColumn('RIGHTS_REPRESENTATIVE_ADDRESS', 'RightsRepresentativeAddress', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('OFFICE_OF_ORIGIN', 'OfficeOfOrigin', 'string', CreoleTypes::VARCHAR, false, 10);

		$tMap->addColumn('DESIGNATED_CONTRACTING_PARTY', 'DesignatedContractingParty', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('IMAGE', 'Image', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CONTESTATION', 'Contestation', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 