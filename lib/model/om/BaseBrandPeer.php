<?php


abstract class BaseBrandPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_brand';

	
	const CLASS_DEFAULT = 'lib.model.Brand';

	
	const NUM_COLUMNS = 25;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_brand.ID';

	
	const LABEL = 'm_brand.LABEL';

	
	const CLIENT_ID = 'm_brand.CLIENT_ID';

	
	const APPLICATION_NUMBER = 'm_brand.APPLICATION_NUMBER';

	
	const APPLICATION_DATE = 'm_brand.APPLICATION_DATE';

	
	const STATUS = 'm_brand.STATUS';

	
	const REGISTER_NUMBER = 'm_brand.REGISTER_NUMBER';

	
	const REGISTRATION_DATE = 'm_brand.REGISTRATION_DATE';

	
	const KIND = 'm_brand.KIND';

	
	const EXPIRES_ON = 'm_brand.EXPIRES_ON';

	
	const VIENNA_CLASSES = 'm_brand.VIENNA_CLASSES';

	
	const COLORS = 'm_brand.COLORS';

	
	const NICE_CLASSES = 'm_brand.NICE_CLASSES';

	
	const RIGHTS_OWNER = 'm_brand.RIGHTS_OWNER';

	
	const RIGHTS_OWNER_ID = 'm_brand.RIGHTS_OWNER_ID';

	
	const RIGHTS_OWNER_ADDRESS = 'm_brand.RIGHTS_OWNER_ADDRESS';

	
	const RIGHTS_REPRESENTATIVE = 'm_brand.RIGHTS_REPRESENTATIVE';

	
	const RIGHTS_REPRESENTATIVE_ID = 'm_brand.RIGHTS_REPRESENTATIVE_ID';

	
	const RIGHTS_REPRESENTATIVE_ADDRESS = 'm_brand.RIGHTS_REPRESENTATIVE_ADDRESS';

	
	const OFFICE_OF_ORIGIN = 'm_brand.OFFICE_OF_ORIGIN';

	
	const DESIGNATED_CONTRACTING_PARTY = 'm_brand.DESIGNATED_CONTRACTING_PARTY';

	
	const IMAGE = 'm_brand.IMAGE';

	
	const CREATED_AT = 'm_brand.CREATED_AT';

	
	const UPDATED_AT = 'm_brand.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_brand.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'ClientId', 'ApplicationNumber', 'ApplicationDate', 'Status', 'RegisterNumber', 'RegistrationDate', 'Kind', 'ExpiresOn', 'ViennaClasses', 'Colors', 'NiceClasses', 'RightsOwner', 'RightsOwnerId', 'RightsOwnerAddress', 'RightsRepresentative', 'RightsRepresentativeId', 'RightsRepresentativeAddress', 'OfficeOfOrigin', 'DesignatedContractingParty', 'Image', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (BrandPeer::ID, BrandPeer::LABEL, BrandPeer::CLIENT_ID, BrandPeer::APPLICATION_NUMBER, BrandPeer::APPLICATION_DATE, BrandPeer::STATUS, BrandPeer::REGISTER_NUMBER, BrandPeer::REGISTRATION_DATE, BrandPeer::KIND, BrandPeer::EXPIRES_ON, BrandPeer::VIENNA_CLASSES, BrandPeer::COLORS, BrandPeer::NICE_CLASSES, BrandPeer::RIGHTS_OWNER, BrandPeer::RIGHTS_OWNER_ID, BrandPeer::RIGHTS_OWNER_ADDRESS, BrandPeer::RIGHTS_REPRESENTATIVE, BrandPeer::RIGHTS_REPRESENTATIVE_ID, BrandPeer::RIGHTS_REPRESENTATIVE_ADDRESS, BrandPeer::OFFICE_OF_ORIGIN, BrandPeer::DESIGNATED_CONTRACTING_PARTY, BrandPeer::IMAGE, BrandPeer::CREATED_AT, BrandPeer::UPDATED_AT, BrandPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'client_id', 'application_number', 'application_date', 'status', 'register_number', 'registration_date', 'kind', 'expires_on', 'vienna_classes', 'colors', 'nice_classes', 'rights_owner', 'rights_owner_id', 'rights_owner_address', 'rights_representative', 'rights_representative_id', 'rights_representative_address', 'office_of_origin', 'designated_contracting_party', 'image', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'ClientId' => 2, 'ApplicationNumber' => 3, 'ApplicationDate' => 4, 'Status' => 5, 'RegisterNumber' => 6, 'RegistrationDate' => 7, 'Kind' => 8, 'ExpiresOn' => 9, 'ViennaClasses' => 10, 'Colors' => 11, 'NiceClasses' => 12, 'RightsOwner' => 13, 'RightsOwnerId' => 14, 'RightsOwnerAddress' => 15, 'RightsRepresentative' => 16, 'RightsRepresentativeId' => 17, 'RightsRepresentativeAddress' => 18, 'OfficeOfOrigin' => 19, 'DesignatedContractingParty' => 20, 'Image' => 21, 'CreatedAt' => 22, 'UpdatedAt' => 23, 'PublicationStatus' => 24, ),
		BasePeer::TYPE_COLNAME => array (BrandPeer::ID => 0, BrandPeer::LABEL => 1, BrandPeer::CLIENT_ID => 2, BrandPeer::APPLICATION_NUMBER => 3, BrandPeer::APPLICATION_DATE => 4, BrandPeer::STATUS => 5, BrandPeer::REGISTER_NUMBER => 6, BrandPeer::REGISTRATION_DATE => 7, BrandPeer::KIND => 8, BrandPeer::EXPIRES_ON => 9, BrandPeer::VIENNA_CLASSES => 10, BrandPeer::COLORS => 11, BrandPeer::NICE_CLASSES => 12, BrandPeer::RIGHTS_OWNER => 13, BrandPeer::RIGHTS_OWNER_ID => 14, BrandPeer::RIGHTS_OWNER_ADDRESS => 15, BrandPeer::RIGHTS_REPRESENTATIVE => 16, BrandPeer::RIGHTS_REPRESENTATIVE_ID => 17, BrandPeer::RIGHTS_REPRESENTATIVE_ADDRESS => 18, BrandPeer::OFFICE_OF_ORIGIN => 19, BrandPeer::DESIGNATED_CONTRACTING_PARTY => 20, BrandPeer::IMAGE => 21, BrandPeer::CREATED_AT => 22, BrandPeer::UPDATED_AT => 23, BrandPeer::PUBLICATION_STATUS => 24, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'client_id' => 2, 'application_number' => 3, 'application_date' => 4, 'status' => 5, 'register_number' => 6, 'registration_date' => 7, 'kind' => 8, 'expires_on' => 9, 'vienna_classes' => 10, 'colors' => 11, 'nice_classes' => 12, 'rights_owner' => 13, 'rights_owner_id' => 14, 'rights_owner_address' => 15, 'rights_representative' => 16, 'rights_representative_id' => 17, 'rights_representative_address' => 18, 'office_of_origin' => 19, 'designated_contracting_party' => 20, 'image' => 21, 'created_at' => 22, 'updated_at' => 23, 'publication_status' => 24, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/BrandMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.BrandMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = BrandPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(BrandPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(BrandPeer::ID);

		$criteria->addSelectColumn(BrandPeer::LABEL);

		$criteria->addSelectColumn(BrandPeer::CLIENT_ID);

		$criteria->addSelectColumn(BrandPeer::APPLICATION_NUMBER);

		$criteria->addSelectColumn(BrandPeer::APPLICATION_DATE);

		$criteria->addSelectColumn(BrandPeer::STATUS);

		$criteria->addSelectColumn(BrandPeer::REGISTER_NUMBER);

		$criteria->addSelectColumn(BrandPeer::REGISTRATION_DATE);

		$criteria->addSelectColumn(BrandPeer::KIND);

		$criteria->addSelectColumn(BrandPeer::EXPIRES_ON);

		$criteria->addSelectColumn(BrandPeer::VIENNA_CLASSES);

		$criteria->addSelectColumn(BrandPeer::COLORS);

		$criteria->addSelectColumn(BrandPeer::NICE_CLASSES);

		$criteria->addSelectColumn(BrandPeer::RIGHTS_OWNER);

		$criteria->addSelectColumn(BrandPeer::RIGHTS_OWNER_ID);

		$criteria->addSelectColumn(BrandPeer::RIGHTS_OWNER_ADDRESS);

		$criteria->addSelectColumn(BrandPeer::RIGHTS_REPRESENTATIVE);

		$criteria->addSelectColumn(BrandPeer::RIGHTS_REPRESENTATIVE_ID);

		$criteria->addSelectColumn(BrandPeer::RIGHTS_REPRESENTATIVE_ADDRESS);

		$criteria->addSelectColumn(BrandPeer::OFFICE_OF_ORIGIN);

		$criteria->addSelectColumn(BrandPeer::DESIGNATED_CONTRACTING_PARTY);

		$criteria->addSelectColumn(BrandPeer::IMAGE);

		$criteria->addSelectColumn(BrandPeer::CREATED_AT);

		$criteria->addSelectColumn(BrandPeer::UPDATED_AT);

		$criteria->addSelectColumn(BrandPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_brand.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_brand.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(BrandPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(BrandPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = BrandPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = BrandPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return BrandPeer::populateObjects(BrandPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			BrandPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = BrandPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return BrandPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(BrandPeer::ID);
			$selectCriteria->add(BrandPeer::ID, $criteria->remove(BrandPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(BrandPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(BrandPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Brand) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(BrandPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(Brand $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(BrandPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(BrandPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(BrandPeer::DATABASE_NAME, BrandPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = BrandPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(BrandPeer::DATABASE_NAME);

		$criteria->add(BrandPeer::ID, $pk);


		$v = BrandPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(BrandPeer::ID, $pks, Criteria::IN);
			$objs = BrandPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseBrandPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/BrandMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.BrandMapBuilder');
}
