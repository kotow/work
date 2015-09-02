<?php


abstract class BaseTrademarkPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_trademark';

	
	const CLASS_DEFAULT = 'lib.model.Trademark';

	
	const NUM_COLUMNS = 27;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_trademark.ID';

	
	const LABEL = 'm_trademark.LABEL';

	
	const APPLICATION_NUMBER = 'm_trademark.APPLICATION_NUMBER';

	
	const REGISTER_NUMBER = 'm_trademark.REGISTER_NUMBER';

	
	const REGISTRATION_DATE = 'm_trademark.REGISTRATION_DATE';

	
	const FROM_SYSTEM = 'm_trademark.FROM_SYSTEM';

	
	const KIND = 'm_trademark.KIND';

	
	const APPLICATION_DATE = 'm_trademark.APPLICATION_DATE';

	
	const STATUS = 'm_trademark.STATUS';

	
	const EXPIRES_ON = 'm_trademark.EXPIRES_ON';

	
	const PUBLICATIONS = 'm_trademark.PUBLICATIONS';

	
	const VIENNA_CLASSES = 'm_trademark.VIENNA_CLASSES';

	
	const COLORS = 'm_trademark.COLORS';

	
	const NICE_CLASSES = 'm_trademark.NICE_CLASSES';

	
	const RIGHTS_OWNER = 'm_trademark.RIGHTS_OWNER';

	
	const RIGHTS_OWNER_ID = 'm_trademark.RIGHTS_OWNER_ID';

	
	const RIGHTS_OWNER_ADDRESS = 'm_trademark.RIGHTS_OWNER_ADDRESS';

	
	const RIGHTS_REPRESENTATIVE = 'm_trademark.RIGHTS_REPRESENTATIVE';

	
	const RIGHTS_REPRESENTATIVE_ID = 'm_trademark.RIGHTS_REPRESENTATIVE_ID';

	
	const RIGHTS_REPRESENTATIVE_ADDRESS = 'm_trademark.RIGHTS_REPRESENTATIVE_ADDRESS';

	
	const OFFICE_OF_ORIGIN = 'm_trademark.OFFICE_OF_ORIGIN';

	
	const DESIGNATED_CONTRACTING_PARTY = 'm_trademark.DESIGNATED_CONTRACTING_PARTY';

	
	const IMAGE = 'm_trademark.IMAGE';

	
	const CONTESTATION = 'm_trademark.CONTESTATION';

	
	const CREATED_AT = 'm_trademark.CREATED_AT';

	
	const UPDATED_AT = 'm_trademark.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_trademark.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'FromSystem', 'Kind', 'ApplicationDate', 'Status', 'ExpiresOn', 'Publications', 'ViennaClasses', 'Colors', 'NiceClasses', 'RightsOwner', 'RightsOwnerId', 'RightsOwnerAddress', 'RightsRepresentative', 'RightsRepresentativeId', 'RightsRepresentativeAddress', 'OfficeOfOrigin', 'DesignatedContractingParty', 'Image', 'Contestation', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (TrademarkPeer::ID, TrademarkPeer::LABEL, TrademarkPeer::APPLICATION_NUMBER, TrademarkPeer::REGISTER_NUMBER, TrademarkPeer::REGISTRATION_DATE, TrademarkPeer::FROM_SYSTEM, TrademarkPeer::KIND, TrademarkPeer::APPLICATION_DATE, TrademarkPeer::STATUS, TrademarkPeer::EXPIRES_ON, TrademarkPeer::PUBLICATIONS, TrademarkPeer::VIENNA_CLASSES, TrademarkPeer::COLORS, TrademarkPeer::NICE_CLASSES, TrademarkPeer::RIGHTS_OWNER, TrademarkPeer::RIGHTS_OWNER_ID, TrademarkPeer::RIGHTS_OWNER_ADDRESS, TrademarkPeer::RIGHTS_REPRESENTATIVE, TrademarkPeer::RIGHTS_REPRESENTATIVE_ID, TrademarkPeer::RIGHTS_REPRESENTATIVE_ADDRESS, TrademarkPeer::OFFICE_OF_ORIGIN, TrademarkPeer::DESIGNATED_CONTRACTING_PARTY, TrademarkPeer::IMAGE, TrademarkPeer::CONTESTATION, TrademarkPeer::CREATED_AT, TrademarkPeer::UPDATED_AT, TrademarkPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'application_number', 'register_number', 'registration_date', 'from_system', 'kind', 'application_date', 'status', 'expires_on', 'publications', 'vienna_classes', 'colors', 'nice_classes', 'rights_owner', 'rights_owner_id', 'rights_owner_address', 'rights_representative', 'rights_representative_id', 'rights_representative_address', 'office_of_origin', 'designated_contracting_party', 'image', 'contestation', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'ApplicationNumber' => 2, 'RegisterNumber' => 3, 'RegistrationDate' => 4, 'FromSystem' => 5, 'Kind' => 6, 'ApplicationDate' => 7, 'Status' => 8, 'ExpiresOn' => 9, 'Publications' => 10, 'ViennaClasses' => 11, 'Colors' => 12, 'NiceClasses' => 13, 'RightsOwner' => 14, 'RightsOwnerId' => 15, 'RightsOwnerAddress' => 16, 'RightsRepresentative' => 17, 'RightsRepresentativeId' => 18, 'RightsRepresentativeAddress' => 19, 'OfficeOfOrigin' => 20, 'DesignatedContractingParty' => 21, 'Image' => 22, 'Contestation' => 23, 'CreatedAt' => 24, 'UpdatedAt' => 25, 'PublicationStatus' => 26, ),
		BasePeer::TYPE_COLNAME => array (TrademarkPeer::ID => 0, TrademarkPeer::LABEL => 1, TrademarkPeer::APPLICATION_NUMBER => 2, TrademarkPeer::REGISTER_NUMBER => 3, TrademarkPeer::REGISTRATION_DATE => 4, TrademarkPeer::FROM_SYSTEM => 5, TrademarkPeer::KIND => 6, TrademarkPeer::APPLICATION_DATE => 7, TrademarkPeer::STATUS => 8, TrademarkPeer::EXPIRES_ON => 9, TrademarkPeer::PUBLICATIONS => 10, TrademarkPeer::VIENNA_CLASSES => 11, TrademarkPeer::COLORS => 12, TrademarkPeer::NICE_CLASSES => 13, TrademarkPeer::RIGHTS_OWNER => 14, TrademarkPeer::RIGHTS_OWNER_ID => 15, TrademarkPeer::RIGHTS_OWNER_ADDRESS => 16, TrademarkPeer::RIGHTS_REPRESENTATIVE => 17, TrademarkPeer::RIGHTS_REPRESENTATIVE_ID => 18, TrademarkPeer::RIGHTS_REPRESENTATIVE_ADDRESS => 19, TrademarkPeer::OFFICE_OF_ORIGIN => 20, TrademarkPeer::DESIGNATED_CONTRACTING_PARTY => 21, TrademarkPeer::IMAGE => 22, TrademarkPeer::CONTESTATION => 23, TrademarkPeer::CREATED_AT => 24, TrademarkPeer::UPDATED_AT => 25, TrademarkPeer::PUBLICATION_STATUS => 26, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'application_number' => 2, 'register_number' => 3, 'registration_date' => 4, 'from_system' => 5, 'kind' => 6, 'application_date' => 7, 'status' => 8, 'expires_on' => 9, 'publications' => 10, 'vienna_classes' => 11, 'colors' => 12, 'nice_classes' => 13, 'rights_owner' => 14, 'rights_owner_id' => 15, 'rights_owner_address' => 16, 'rights_representative' => 17, 'rights_representative_id' => 18, 'rights_representative_address' => 19, 'office_of_origin' => 20, 'designated_contracting_party' => 21, 'image' => 22, 'contestation' => 23, 'created_at' => 24, 'updated_at' => 25, 'publication_status' => 26, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/TrademarkMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.TrademarkMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = TrademarkPeer::getTableMap();
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
		return str_replace(TrademarkPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(TrademarkPeer::ID);

		$criteria->addSelectColumn(TrademarkPeer::LABEL);

		$criteria->addSelectColumn(TrademarkPeer::APPLICATION_NUMBER);

		$criteria->addSelectColumn(TrademarkPeer::REGISTER_NUMBER);

		$criteria->addSelectColumn(TrademarkPeer::REGISTRATION_DATE);

		$criteria->addSelectColumn(TrademarkPeer::FROM_SYSTEM);

		$criteria->addSelectColumn(TrademarkPeer::KIND);

		$criteria->addSelectColumn(TrademarkPeer::APPLICATION_DATE);

		$criteria->addSelectColumn(TrademarkPeer::STATUS);

		$criteria->addSelectColumn(TrademarkPeer::EXPIRES_ON);

		$criteria->addSelectColumn(TrademarkPeer::PUBLICATIONS);

		$criteria->addSelectColumn(TrademarkPeer::VIENNA_CLASSES);

		$criteria->addSelectColumn(TrademarkPeer::COLORS);

		$criteria->addSelectColumn(TrademarkPeer::NICE_CLASSES);

		$criteria->addSelectColumn(TrademarkPeer::RIGHTS_OWNER);

		$criteria->addSelectColumn(TrademarkPeer::RIGHTS_OWNER_ID);

		$criteria->addSelectColumn(TrademarkPeer::RIGHTS_OWNER_ADDRESS);

		$criteria->addSelectColumn(TrademarkPeer::RIGHTS_REPRESENTATIVE);

		$criteria->addSelectColumn(TrademarkPeer::RIGHTS_REPRESENTATIVE_ID);

		$criteria->addSelectColumn(TrademarkPeer::RIGHTS_REPRESENTATIVE_ADDRESS);

		$criteria->addSelectColumn(TrademarkPeer::OFFICE_OF_ORIGIN);

		$criteria->addSelectColumn(TrademarkPeer::DESIGNATED_CONTRACTING_PARTY);

		$criteria->addSelectColumn(TrademarkPeer::IMAGE);

		$criteria->addSelectColumn(TrademarkPeer::CONTESTATION);

		$criteria->addSelectColumn(TrademarkPeer::CREATED_AT);

		$criteria->addSelectColumn(TrademarkPeer::UPDATED_AT);

		$criteria->addSelectColumn(TrademarkPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_trademark.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_trademark.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(TrademarkPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(TrademarkPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = TrademarkPeer::doSelectRS($criteria, $con);
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
		$objects = TrademarkPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return TrademarkPeer::populateObjects(TrademarkPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			TrademarkPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = TrademarkPeer::getOMClass();
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
		return TrademarkPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(TrademarkPeer::ID);
			$selectCriteria->add(TrademarkPeer::ID, $criteria->remove(TrademarkPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(TrademarkPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(TrademarkPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Trademark) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(TrademarkPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Trademark $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(TrademarkPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(TrademarkPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(TrademarkPeer::DATABASE_NAME, TrademarkPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = TrademarkPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(TrademarkPeer::DATABASE_NAME);

		$criteria->add(TrademarkPeer::ID, $pk);


		$v = TrademarkPeer::doSelect($criteria, $con);

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
			$criteria->add(TrademarkPeer::ID, $pks, Criteria::IN);
			$objs = TrademarkPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseTrademarkPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/TrademarkMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.TrademarkMapBuilder');
}
