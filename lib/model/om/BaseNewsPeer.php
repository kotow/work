<?php


abstract class BaseNewsPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_news';

	
	const CLASS_DEFAULT = 'lib.model.News';

	
	const NUM_COLUMNS = 13;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_news.ID';

	
	const LABEL = 'm_news.LABEL';

	
	const SHORT_DESCRIPTION = 'm_news.SHORT_DESCRIPTION';

	
	const IMAGE = 'm_news.IMAGE';

	
	const DOWNLOAD = 'm_news.DOWNLOAD';

	
	const CONTENT = 'm_news.CONTENT';

	
	const START_DATE = 'm_news.START_DATE';

	
	const END_DATE = 'm_news.END_DATE';

	
	const RDS = 'm_news.RDS';

	
	const KEYWORDS = 'm_news.KEYWORDS';

	
	const CREATED_AT = 'm_news.CREATED_AT';

	
	const UPDATED_AT = 'm_news.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_news.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'ShortDescription', 'Image', 'Download', 'Content', 'StartDate', 'EndDate', 'Rds', 'Keywords', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (NewsPeer::ID, NewsPeer::LABEL, NewsPeer::SHORT_DESCRIPTION, NewsPeer::IMAGE, NewsPeer::DOWNLOAD, NewsPeer::CONTENT, NewsPeer::START_DATE, NewsPeer::END_DATE, NewsPeer::RDS, NewsPeer::KEYWORDS, NewsPeer::CREATED_AT, NewsPeer::UPDATED_AT, NewsPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'short_description', 'image', 'download', 'content', 'start_date', 'end_date', 'rds', 'keywords', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'ShortDescription' => 2, 'Image' => 3, 'Download' => 4, 'Content' => 5, 'StartDate' => 6, 'EndDate' => 7, 'Rds' => 8, 'Keywords' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, 'PublicationStatus' => 12, ),
		BasePeer::TYPE_COLNAME => array (NewsPeer::ID => 0, NewsPeer::LABEL => 1, NewsPeer::SHORT_DESCRIPTION => 2, NewsPeer::IMAGE => 3, NewsPeer::DOWNLOAD => 4, NewsPeer::CONTENT => 5, NewsPeer::START_DATE => 6, NewsPeer::END_DATE => 7, NewsPeer::RDS => 8, NewsPeer::KEYWORDS => 9, NewsPeer::CREATED_AT => 10, NewsPeer::UPDATED_AT => 11, NewsPeer::PUBLICATION_STATUS => 12, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'short_description' => 2, 'image' => 3, 'download' => 4, 'content' => 5, 'start_date' => 6, 'end_date' => 7, 'rds' => 8, 'keywords' => 9, 'created_at' => 10, 'updated_at' => 11, 'publication_status' => 12, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/NewsMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.NewsMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = NewsPeer::getTableMap();
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
		return str_replace(NewsPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(NewsPeer::ID);

		$criteria->addSelectColumn(NewsPeer::LABEL);

		$criteria->addSelectColumn(NewsPeer::SHORT_DESCRIPTION);

		$criteria->addSelectColumn(NewsPeer::IMAGE);

		$criteria->addSelectColumn(NewsPeer::DOWNLOAD);

		$criteria->addSelectColumn(NewsPeer::CONTENT);

		$criteria->addSelectColumn(NewsPeer::START_DATE);

		$criteria->addSelectColumn(NewsPeer::END_DATE);

		$criteria->addSelectColumn(NewsPeer::RDS);

		$criteria->addSelectColumn(NewsPeer::KEYWORDS);

		$criteria->addSelectColumn(NewsPeer::CREATED_AT);

		$criteria->addSelectColumn(NewsPeer::UPDATED_AT);

		$criteria->addSelectColumn(NewsPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_news.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_news.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = NewsPeer::doSelectRS($criteria, $con);
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
		$objects = NewsPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return NewsPeer::populateObjects(NewsPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			NewsPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = NewsPeer::getOMClass();
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
		return NewsPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(NewsPeer::ID);
			$selectCriteria->add(NewsPeer::ID, $criteria->remove(NewsPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(NewsPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(NewsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof News) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(NewsPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(News $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(NewsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(NewsPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(NewsPeer::DATABASE_NAME, NewsPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = NewsPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(NewsPeer::DATABASE_NAME);

		$criteria->add(NewsPeer::ID, $pk);


		$v = NewsPeer::doSelect($criteria, $con);

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
			$criteria->add(NewsPeer::ID, $pks, Criteria::IN);
			$objs = NewsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseNewsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/NewsMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.NewsMapBuilder');
}
