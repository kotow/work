<?php


abstract class BaseImportSessionPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_import_session';

	
	const CLASS_DEFAULT = 'lib.model.ImportSession';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_import_session.ID';

	
	const LABEL = 'm_import_session.LABEL';

	
	const IMPORT_ID = 'm_import_session.IMPORT_ID';

	
	const START_ID = 'm_import_session.START_ID';

	
	const TM_COUNT = 'm_import_session.TM_COUNT';

	
	const CREATED_AT = 'm_import_session.CREATED_AT';

	
	const UPDATED_AT = 'm_import_session.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_import_session.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'ImportId', 'StartId', 'TmCount', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (ImportSessionPeer::ID, ImportSessionPeer::LABEL, ImportSessionPeer::IMPORT_ID, ImportSessionPeer::START_ID, ImportSessionPeer::TM_COUNT, ImportSessionPeer::CREATED_AT, ImportSessionPeer::UPDATED_AT, ImportSessionPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'import_id', 'start_id', 'tm_count', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'ImportId' => 2, 'StartId' => 3, 'TmCount' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, 'PublicationStatus' => 7, ),
		BasePeer::TYPE_COLNAME => array (ImportSessionPeer::ID => 0, ImportSessionPeer::LABEL => 1, ImportSessionPeer::IMPORT_ID => 2, ImportSessionPeer::START_ID => 3, ImportSessionPeer::TM_COUNT => 4, ImportSessionPeer::CREATED_AT => 5, ImportSessionPeer::UPDATED_AT => 6, ImportSessionPeer::PUBLICATION_STATUS => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'import_id' => 2, 'start_id' => 3, 'tm_count' => 4, 'created_at' => 5, 'updated_at' => 6, 'publication_status' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ImportSessionMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ImportSessionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ImportSessionPeer::getTableMap();
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
		return str_replace(ImportSessionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ImportSessionPeer::ID);

		$criteria->addSelectColumn(ImportSessionPeer::LABEL);

		$criteria->addSelectColumn(ImportSessionPeer::IMPORT_ID);

		$criteria->addSelectColumn(ImportSessionPeer::START_ID);

		$criteria->addSelectColumn(ImportSessionPeer::TM_COUNT);

		$criteria->addSelectColumn(ImportSessionPeer::CREATED_AT);

		$criteria->addSelectColumn(ImportSessionPeer::UPDATED_AT);

		$criteria->addSelectColumn(ImportSessionPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_import_session.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_import_session.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ImportSessionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ImportSessionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ImportSessionPeer::doSelectRS($criteria, $con);
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
		$objects = ImportSessionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ImportSessionPeer::populateObjects(ImportSessionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ImportSessionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ImportSessionPeer::getOMClass();
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
		return ImportSessionPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(ImportSessionPeer::ID);
			$selectCriteria->add(ImportSessionPeer::ID, $criteria->remove(ImportSessionPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ImportSessionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ImportSessionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ImportSession) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ImportSessionPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ImportSession $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ImportSessionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ImportSessionPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ImportSessionPeer::DATABASE_NAME, ImportSessionPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ImportSessionPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ImportSessionPeer::DATABASE_NAME);

		$criteria->add(ImportSessionPeer::ID, $pk);


		$v = ImportSessionPeer::doSelect($criteria, $con);

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
			$criteria->add(ImportSessionPeer::ID, $pks, Criteria::IN);
			$objs = ImportSessionPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseImportSessionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ImportSessionMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ImportSessionMapBuilder');
}
