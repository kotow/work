<?php


abstract class BaseNewsletterPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_newsletter';

	
	const CLASS_DEFAULT = 'lib.model.Newsletter';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_newsletter.ID';

	
	const LABEL = 'm_newsletter.LABEL';

	
	const CONTENT = 'm_newsletter.CONTENT';

	
	const PERIOD = 'm_newsletter.PERIOD';

	
	const EMAIL = 'm_newsletter.EMAIL';

	
	const CREATED_AT = 'm_newsletter.CREATED_AT';

	
	const UPDATED_AT = 'm_newsletter.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_newsletter.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'Content', 'Period', 'Email', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (NewsletterPeer::ID, NewsletterPeer::LABEL, NewsletterPeer::CONTENT, NewsletterPeer::PERIOD, NewsletterPeer::EMAIL, NewsletterPeer::CREATED_AT, NewsletterPeer::UPDATED_AT, NewsletterPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'content', 'period', 'email', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'Content' => 2, 'Period' => 3, 'Email' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, 'PublicationStatus' => 7, ),
		BasePeer::TYPE_COLNAME => array (NewsletterPeer::ID => 0, NewsletterPeer::LABEL => 1, NewsletterPeer::CONTENT => 2, NewsletterPeer::PERIOD => 3, NewsletterPeer::EMAIL => 4, NewsletterPeer::CREATED_AT => 5, NewsletterPeer::UPDATED_AT => 6, NewsletterPeer::PUBLICATION_STATUS => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'content' => 2, 'period' => 3, 'email' => 4, 'created_at' => 5, 'updated_at' => 6, 'publication_status' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/NewsletterMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.NewsletterMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = NewsletterPeer::getTableMap();
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
		return str_replace(NewsletterPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(NewsletterPeer::ID);

		$criteria->addSelectColumn(NewsletterPeer::LABEL);

		$criteria->addSelectColumn(NewsletterPeer::CONTENT);

		$criteria->addSelectColumn(NewsletterPeer::PERIOD);

		$criteria->addSelectColumn(NewsletterPeer::EMAIL);

		$criteria->addSelectColumn(NewsletterPeer::CREATED_AT);

		$criteria->addSelectColumn(NewsletterPeer::UPDATED_AT);

		$criteria->addSelectColumn(NewsletterPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_newsletter.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_newsletter.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsletterPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsletterPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = NewsletterPeer::doSelectRS($criteria, $con);
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
		$objects = NewsletterPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return NewsletterPeer::populateObjects(NewsletterPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			NewsletterPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = NewsletterPeer::getOMClass();
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
		return NewsletterPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(NewsletterPeer::ID);
			$selectCriteria->add(NewsletterPeer::ID, $criteria->remove(NewsletterPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(NewsletterPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(NewsletterPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Newsletter) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(NewsletterPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Newsletter $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(NewsletterPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(NewsletterPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(NewsletterPeer::DATABASE_NAME, NewsletterPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = NewsletterPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(NewsletterPeer::DATABASE_NAME);

		$criteria->add(NewsletterPeer::ID, $pk);


		$v = NewsletterPeer::doSelect($criteria, $con);

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
			$criteria->add(NewsletterPeer::ID, $pks, Criteria::IN);
			$objs = NewsletterPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseNewsletterPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/NewsletterMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.NewsletterMapBuilder');
}
