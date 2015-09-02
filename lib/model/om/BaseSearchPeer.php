<?php


abstract class BaseSearchPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_search';

	
	const CLASS_DEFAULT = 'lib.model.Search';

	
	const NUM_COLUMNS = 16;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_search.ID';

	
	const LABEL = 'm_search.LABEL';

	
	const APPLICATION_NUMBER = 'm_search.APPLICATION_NUMBER';

	
	const REGISTER_NUMBER = 'm_search.REGISTER_NUMBER';

	
	const REGISTRATION_DATE = 'm_search.REGISTRATION_DATE';

	
	const APPLICATION_DATE = 'm_search.APPLICATION_DATE';

	
	const EXPIRES_ON = 'm_search.EXPIRES_ON';

	
	const VIENNA_CLASSES = 'm_search.VIENNA_CLASSES';

	
	const NICE_CLASSES = 'm_search.NICE_CLASSES';

	
	const RIGHTS_OWNER = 'm_search.RIGHTS_OWNER';

	
	const RIGHTS_REPRESENTATIVE = 'm_search.RIGHTS_REPRESENTATIVE';

	
	const OFFICE_OF_ORIGIN = 'm_search.OFFICE_OF_ORIGIN';

	
	const DESIGNATED_CONTRACTING_PARTY = 'm_search.DESIGNATED_CONTRACTING_PARTY';

	
	const CREATED_AT = 'm_search.CREATED_AT';

	
	const UPDATED_AT = 'm_search.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_search.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'ApplicationNumber', 'RegisterNumber', 'RegistrationDate', 'ApplicationDate', 'ExpiresOn', 'ViennaClasses', 'NiceClasses', 'RightsOwner', 'RightsRepresentative', 'OfficeOfOrigin', 'DesignatedContractingParty', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (SearchPeer::ID, SearchPeer::LABEL, SearchPeer::APPLICATION_NUMBER, SearchPeer::REGISTER_NUMBER, SearchPeer::REGISTRATION_DATE, SearchPeer::APPLICATION_DATE, SearchPeer::EXPIRES_ON, SearchPeer::VIENNA_CLASSES, SearchPeer::NICE_CLASSES, SearchPeer::RIGHTS_OWNER, SearchPeer::RIGHTS_REPRESENTATIVE, SearchPeer::OFFICE_OF_ORIGIN, SearchPeer::DESIGNATED_CONTRACTING_PARTY, SearchPeer::CREATED_AT, SearchPeer::UPDATED_AT, SearchPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'application_number', 'register_number', 'registration_date', 'application_date', 'expires_on', 'vienna_classes', 'nice_classes', 'rights_owner', 'rights_representative', 'office_of_origin', 'designated_contracting_party', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'ApplicationNumber' => 2, 'RegisterNumber' => 3, 'RegistrationDate' => 4, 'ApplicationDate' => 5, 'ExpiresOn' => 6, 'ViennaClasses' => 7, 'NiceClasses' => 8, 'RightsOwner' => 9, 'RightsRepresentative' => 10, 'OfficeOfOrigin' => 11, 'DesignatedContractingParty' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, 'PublicationStatus' => 15, ),
		BasePeer::TYPE_COLNAME => array (SearchPeer::ID => 0, SearchPeer::LABEL => 1, SearchPeer::APPLICATION_NUMBER => 2, SearchPeer::REGISTER_NUMBER => 3, SearchPeer::REGISTRATION_DATE => 4, SearchPeer::APPLICATION_DATE => 5, SearchPeer::EXPIRES_ON => 6, SearchPeer::VIENNA_CLASSES => 7, SearchPeer::NICE_CLASSES => 8, SearchPeer::RIGHTS_OWNER => 9, SearchPeer::RIGHTS_REPRESENTATIVE => 10, SearchPeer::OFFICE_OF_ORIGIN => 11, SearchPeer::DESIGNATED_CONTRACTING_PARTY => 12, SearchPeer::CREATED_AT => 13, SearchPeer::UPDATED_AT => 14, SearchPeer::PUBLICATION_STATUS => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'application_number' => 2, 'register_number' => 3, 'registration_date' => 4, 'application_date' => 5, 'expires_on' => 6, 'vienna_classes' => 7, 'nice_classes' => 8, 'rights_owner' => 9, 'rights_representative' => 10, 'office_of_origin' => 11, 'designated_contracting_party' => 12, 'created_at' => 13, 'updated_at' => 14, 'publication_status' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SearchMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SearchMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SearchPeer::getTableMap();
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
		return str_replace(SearchPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SearchPeer::ID);

		$criteria->addSelectColumn(SearchPeer::LABEL);

		$criteria->addSelectColumn(SearchPeer::APPLICATION_NUMBER);

		$criteria->addSelectColumn(SearchPeer::REGISTER_NUMBER);

		$criteria->addSelectColumn(SearchPeer::REGISTRATION_DATE);

		$criteria->addSelectColumn(SearchPeer::APPLICATION_DATE);

		$criteria->addSelectColumn(SearchPeer::EXPIRES_ON);

		$criteria->addSelectColumn(SearchPeer::VIENNA_CLASSES);

		$criteria->addSelectColumn(SearchPeer::NICE_CLASSES);

		$criteria->addSelectColumn(SearchPeer::RIGHTS_OWNER);

		$criteria->addSelectColumn(SearchPeer::RIGHTS_REPRESENTATIVE);

		$criteria->addSelectColumn(SearchPeer::OFFICE_OF_ORIGIN);

		$criteria->addSelectColumn(SearchPeer::DESIGNATED_CONTRACTING_PARTY);

		$criteria->addSelectColumn(SearchPeer::CREATED_AT);

		$criteria->addSelectColumn(SearchPeer::UPDATED_AT);

		$criteria->addSelectColumn(SearchPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_search.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_search.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SearchPeer::doSelectRS($criteria, $con);
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
		$objects = SearchPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SearchPeer::populateObjects(SearchPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SearchPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SearchPeer::getOMClass();
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
		return SearchPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(SearchPeer::ID);
			$selectCriteria->add(SearchPeer::ID, $criteria->remove(SearchPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(SearchPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SearchPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Search) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SearchPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Search $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SearchPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SearchPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(SearchPeer::DATABASE_NAME, SearchPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SearchPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(SearchPeer::DATABASE_NAME);

		$criteria->add(SearchPeer::ID, $pk);


		$v = SearchPeer::doSelect($criteria, $con);

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
			$criteria->add(SearchPeer::ID, $pks, Criteria::IN);
			$objs = SearchPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSearchPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SearchMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SearchMapBuilder');
}
