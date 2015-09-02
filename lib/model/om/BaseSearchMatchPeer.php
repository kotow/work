<?php


abstract class BaseSearchMatchPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_search_match';

	
	const CLASS_DEFAULT = 'lib.model.SearchMatch';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_search_match.ID';

	
	const LABEL = 'm_search_match.LABEL';

	
	const IMPORT_SESSION = 'm_search_match.IMPORT_SESSION';

	
	const SEARCH = 'm_search_match.SEARCH';

	
	const TRADEMARK = 'm_search_match.TRADEMARK';

	
	const MATCHES = 'm_search_match.MATCHES';

	
	const CREATED_AT = 'm_search_match.CREATED_AT';

	
	const UPDATED_AT = 'm_search_match.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_search_match.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'ImportSession', 'Search', 'Trademark', 'Matches', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (SearchMatchPeer::ID, SearchMatchPeer::LABEL, SearchMatchPeer::IMPORT_SESSION, SearchMatchPeer::SEARCH, SearchMatchPeer::TRADEMARK, SearchMatchPeer::MATCHES, SearchMatchPeer::CREATED_AT, SearchMatchPeer::UPDATED_AT, SearchMatchPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'import_session', 'search', 'trademark', 'matches', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'ImportSession' => 2, 'Search' => 3, 'Trademark' => 4, 'Matches' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, 'PublicationStatus' => 8, ),
		BasePeer::TYPE_COLNAME => array (SearchMatchPeer::ID => 0, SearchMatchPeer::LABEL => 1, SearchMatchPeer::IMPORT_SESSION => 2, SearchMatchPeer::SEARCH => 3, SearchMatchPeer::TRADEMARK => 4, SearchMatchPeer::MATCHES => 5, SearchMatchPeer::CREATED_AT => 6, SearchMatchPeer::UPDATED_AT => 7, SearchMatchPeer::PUBLICATION_STATUS => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'import_session' => 2, 'search' => 3, 'trademark' => 4, 'matches' => 5, 'created_at' => 6, 'updated_at' => 7, 'publication_status' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/SearchMatchMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.SearchMatchMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = SearchMatchPeer::getTableMap();
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
		return str_replace(SearchMatchPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(SearchMatchPeer::ID);

		$criteria->addSelectColumn(SearchMatchPeer::LABEL);

		$criteria->addSelectColumn(SearchMatchPeer::IMPORT_SESSION);

		$criteria->addSelectColumn(SearchMatchPeer::SEARCH);

		$criteria->addSelectColumn(SearchMatchPeer::TRADEMARK);

		$criteria->addSelectColumn(SearchMatchPeer::MATCHES);

		$criteria->addSelectColumn(SearchMatchPeer::CREATED_AT);

		$criteria->addSelectColumn(SearchMatchPeer::UPDATED_AT);

		$criteria->addSelectColumn(SearchMatchPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_search_match.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_search_match.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(SearchMatchPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(SearchMatchPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = SearchMatchPeer::doSelectRS($criteria, $con);
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
		$objects = SearchMatchPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return SearchMatchPeer::populateObjects(SearchMatchPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			SearchMatchPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = SearchMatchPeer::getOMClass();
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
		return SearchMatchPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(SearchMatchPeer::ID);
			$selectCriteria->add(SearchMatchPeer::ID, $criteria->remove(SearchMatchPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(SearchMatchPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(SearchMatchPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof SearchMatch) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(SearchMatchPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(SearchMatch $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(SearchMatchPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(SearchMatchPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(SearchMatchPeer::DATABASE_NAME, SearchMatchPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = SearchMatchPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(SearchMatchPeer::DATABASE_NAME);

		$criteria->add(SearchMatchPeer::ID, $pk);


		$v = SearchMatchPeer::doSelect($criteria, $con);

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
			$criteria->add(SearchMatchPeer::ID, $pks, Criteria::IN);
			$objs = SearchMatchPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseSearchMatchPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/SearchMatchMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.SearchMatchMapBuilder');
}
