<?php



class UserMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.UserMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('m_user');
		$tMap->setPhpName('User');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LABEL', 'Label', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LOGIN', 'Login', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('BACKEND', 'Backend', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('SHA1_PASSWORD', 'Sha1Password', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addColumn('SALT', 'Salt', 'string', CreoleTypes::VARCHAR, false, 32);

		$tMap->addColumn('FIRST_NAME', 'FirstName', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('LAST_NAME', 'LastName', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('CITY', 'City', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ADDRESS', 'Address', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ZIP', 'Zip', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('STATE', 'State', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ADDRESS2', 'Address2', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('MOBILE_PHONE', 'MobilePhone', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('WORK_PHONE', 'WorkPhone', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTACT_NAME', 'ContactName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTACT_NUMBER', 'ContactNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ACTIVATION_CODE', 'ActivationCode', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('UPDATED_AT', 'UpdatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLICATION_STATUS', 'PublicationStatus', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 