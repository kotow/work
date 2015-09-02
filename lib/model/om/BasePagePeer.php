<?php


abstract class BasePagePeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_website_page';

	
	const CLASS_DEFAULT = 'lib.model.Page';

	
	const NUM_COLUMNS = 16;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_website_page.ID';

	
	const LABEL = 'm_website_page.LABEL';

	
	const PAGE_TYPE = 'm_website_page.PAGE_TYPE';

	
	const NAVIGATION_TITLE = 'm_website_page.NAVIGATION_TITLE';

	
	const META_DESCRIPTION = 'm_website_page.META_DESCRIPTION';

	
	const META_KEYWORDS = 'm_website_page.META_KEYWORDS';

	
	const IMAGE = 'm_website_page.IMAGE';

	
	const TEMPLATE = 'm_website_page.TEMPLATE';

	
	const CONTENT = 'm_website_page.CONTENT';

	
	const PAGE_ID = 'm_website_page.PAGE_ID';

	
	const URL = 'm_website_page.URL';

	
	const DESCRIPTION = 'm_website_page.DESCRIPTION';

	
	const IS_SECURE = 'm_website_page.IS_SECURE';

	
	const CREATED_AT = 'm_website_page.CREATED_AT';

	
	const UPDATED_AT = 'm_website_page.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_website_page.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'PageType', 'NavigationTitle', 'MetaDescription', 'MetaKeywords', 'Image', 'Template', 'Content', 'PageId', 'Url', 'Description', 'IsSecure', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (PagePeer::ID, PagePeer::LABEL, PagePeer::PAGE_TYPE, PagePeer::NAVIGATION_TITLE, PagePeer::META_DESCRIPTION, PagePeer::META_KEYWORDS, PagePeer::IMAGE, PagePeer::TEMPLATE, PagePeer::CONTENT, PagePeer::PAGE_ID, PagePeer::URL, PagePeer::DESCRIPTION, PagePeer::IS_SECURE, PagePeer::CREATED_AT, PagePeer::UPDATED_AT, PagePeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'page_type', 'navigation_title', 'meta_description', 'meta_keywords', 'image', 'template', 'content', 'page_id', 'url', 'description', 'is_secure', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'PageType' => 2, 'NavigationTitle' => 3, 'MetaDescription' => 4, 'MetaKeywords' => 5, 'Image' => 6, 'Template' => 7, 'Content' => 8, 'PageId' => 9, 'Url' => 10, 'Description' => 11, 'IsSecure' => 12, 'CreatedAt' => 13, 'UpdatedAt' => 14, 'PublicationStatus' => 15, ),
		BasePeer::TYPE_COLNAME => array (PagePeer::ID => 0, PagePeer::LABEL => 1, PagePeer::PAGE_TYPE => 2, PagePeer::NAVIGATION_TITLE => 3, PagePeer::META_DESCRIPTION => 4, PagePeer::META_KEYWORDS => 5, PagePeer::IMAGE => 6, PagePeer::TEMPLATE => 7, PagePeer::CONTENT => 8, PagePeer::PAGE_ID => 9, PagePeer::URL => 10, PagePeer::DESCRIPTION => 11, PagePeer::IS_SECURE => 12, PagePeer::CREATED_AT => 13, PagePeer::UPDATED_AT => 14, PagePeer::PUBLICATION_STATUS => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'page_type' => 2, 'navigation_title' => 3, 'meta_description' => 4, 'meta_keywords' => 5, 'image' => 6, 'template' => 7, 'content' => 8, 'page_id' => 9, 'url' => 10, 'description' => 11, 'is_secure' => 12, 'created_at' => 13, 'updated_at' => 14, 'publication_status' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/PageMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.PageMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = PagePeer::getTableMap();
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
		return str_replace(PagePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(PagePeer::ID);

		$criteria->addSelectColumn(PagePeer::LABEL);

		$criteria->addSelectColumn(PagePeer::PAGE_TYPE);

		$criteria->addSelectColumn(PagePeer::NAVIGATION_TITLE);

		$criteria->addSelectColumn(PagePeer::META_DESCRIPTION);

		$criteria->addSelectColumn(PagePeer::META_KEYWORDS);

		$criteria->addSelectColumn(PagePeer::IMAGE);

		$criteria->addSelectColumn(PagePeer::TEMPLATE);

		$criteria->addSelectColumn(PagePeer::CONTENT);

		$criteria->addSelectColumn(PagePeer::PAGE_ID);

		$criteria->addSelectColumn(PagePeer::URL);

		$criteria->addSelectColumn(PagePeer::DESCRIPTION);

		$criteria->addSelectColumn(PagePeer::IS_SECURE);

		$criteria->addSelectColumn(PagePeer::CREATED_AT);

		$criteria->addSelectColumn(PagePeer::UPDATED_AT);

		$criteria->addSelectColumn(PagePeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_website_page.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_website_page.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(PagePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(PagePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = PagePeer::doSelectRS($criteria, $con);
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
		$objects = PagePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return PagePeer::populateObjects(PagePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			PagePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = PagePeer::getOMClass();
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
		return PagePeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(PagePeer::ID);
			$selectCriteria->add(PagePeer::ID, $criteria->remove(PagePeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(PagePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(PagePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof Page) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(PagePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(Page $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(PagePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(PagePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(PagePeer::DATABASE_NAME, PagePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = PagePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(PagePeer::DATABASE_NAME);

		$criteria->add(PagePeer::ID, $pk);


		$v = PagePeer::doSelect($criteria, $con);

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
			$criteria->add(PagePeer::ID, $pks, Criteria::IN);
			$objs = PagePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasePagePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/PageMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.PageMapBuilder');
}
