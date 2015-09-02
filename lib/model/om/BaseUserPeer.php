<?php


abstract class BaseUserPeer {

	
	const DATABASE_NAME = 'tm_marks';

	
	const TABLE_NAME = 'm_user';

	
	const CLASS_DEFAULT = 'lib.model.User';

	
	const NUM_COLUMNS = 24;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'm_user.ID';

	
	const LABEL = 'm_user.LABEL';

	
	const LOGIN = 'm_user.LOGIN';

	
	const BACKEND = 'm_user.BACKEND';

	
	const TYPE = 'm_user.TYPE';

	
	const SHA1_PASSWORD = 'm_user.SHA1_PASSWORD';

	
	const SALT = 'm_user.SALT';

	
	const FIRST_NAME = 'm_user.FIRST_NAME';

	
	const LAST_NAME = 'm_user.LAST_NAME';

	
	const EMAIL = 'm_user.EMAIL';

	
	const PHONE = 'm_user.PHONE';

	
	const CITY = 'm_user.CITY';

	
	const ADDRESS = 'm_user.ADDRESS';

	
	const ZIP = 'm_user.ZIP';

	
	const STATE = 'm_user.STATE';

	
	const ADDRESS2 = 'm_user.ADDRESS2';

	
	const MOBILE_PHONE = 'm_user.MOBILE_PHONE';

	
	const WORK_PHONE = 'm_user.WORK_PHONE';

	
	const CONTACT_NAME = 'm_user.CONTACT_NAME';

	
	const CONTACT_NUMBER = 'm_user.CONTACT_NUMBER';

	
	const ACTIVATION_CODE = 'm_user.ACTIVATION_CODE';

	
	const CREATED_AT = 'm_user.CREATED_AT';

	
	const UPDATED_AT = 'm_user.UPDATED_AT';

	
	const PUBLICATION_STATUS = 'm_user.PUBLICATION_STATUS';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Label', 'Login', 'Backend', 'Type', 'Sha1Password', 'Salt', 'FirstName', 'LastName', 'Email', 'Phone', 'City', 'Address', 'Zip', 'State', 'Address2', 'MobilePhone', 'WorkPhone', 'ContactName', 'ContactNumber', 'ActivationCode', 'CreatedAt', 'UpdatedAt', 'PublicationStatus', ),
		BasePeer::TYPE_COLNAME => array (UserPeer::ID, UserPeer::LABEL, UserPeer::LOGIN, UserPeer::BACKEND, UserPeer::TYPE, UserPeer::SHA1_PASSWORD, UserPeer::SALT, UserPeer::FIRST_NAME, UserPeer::LAST_NAME, UserPeer::EMAIL, UserPeer::PHONE, UserPeer::CITY, UserPeer::ADDRESS, UserPeer::ZIP, UserPeer::STATE, UserPeer::ADDRESS2, UserPeer::MOBILE_PHONE, UserPeer::WORK_PHONE, UserPeer::CONTACT_NAME, UserPeer::CONTACT_NUMBER, UserPeer::ACTIVATION_CODE, UserPeer::CREATED_AT, UserPeer::UPDATED_AT, UserPeer::PUBLICATION_STATUS, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'label', 'login', 'backend', 'type', 'sha1_password', 'salt', 'first_name', 'last_name', 'email', 'phone', 'city', 'address', 'zip', 'state', 'address2', 'mobile_phone', 'work_phone', 'contact_name', 'contact_number', 'activation_code', 'created_at', 'updated_at', 'publication_status', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Label' => 1, 'Login' => 2, 'Backend' => 3, 'Type' => 4, 'Sha1Password' => 5, 'Salt' => 6, 'FirstName' => 7, 'LastName' => 8, 'Email' => 9, 'Phone' => 10, 'City' => 11, 'Address' => 12, 'Zip' => 13, 'State' => 14, 'Address2' => 15, 'MobilePhone' => 16, 'WorkPhone' => 17, 'ContactName' => 18, 'ContactNumber' => 19, 'ActivationCode' => 20, 'CreatedAt' => 21, 'UpdatedAt' => 22, 'PublicationStatus' => 23, ),
		BasePeer::TYPE_COLNAME => array (UserPeer::ID => 0, UserPeer::LABEL => 1, UserPeer::LOGIN => 2, UserPeer::BACKEND => 3, UserPeer::TYPE => 4, UserPeer::SHA1_PASSWORD => 5, UserPeer::SALT => 6, UserPeer::FIRST_NAME => 7, UserPeer::LAST_NAME => 8, UserPeer::EMAIL => 9, UserPeer::PHONE => 10, UserPeer::CITY => 11, UserPeer::ADDRESS => 12, UserPeer::ZIP => 13, UserPeer::STATE => 14, UserPeer::ADDRESS2 => 15, UserPeer::MOBILE_PHONE => 16, UserPeer::WORK_PHONE => 17, UserPeer::CONTACT_NAME => 18, UserPeer::CONTACT_NUMBER => 19, UserPeer::ACTIVATION_CODE => 20, UserPeer::CREATED_AT => 21, UserPeer::UPDATED_AT => 22, UserPeer::PUBLICATION_STATUS => 23, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'label' => 1, 'login' => 2, 'backend' => 3, 'type' => 4, 'sha1_password' => 5, 'salt' => 6, 'first_name' => 7, 'last_name' => 8, 'email' => 9, 'phone' => 10, 'city' => 11, 'address' => 12, 'zip' => 13, 'state' => 14, 'address2' => 15, 'mobile_phone' => 16, 'work_phone' => 17, 'contact_name' => 18, 'contact_number' => 19, 'activation_code' => 20, 'created_at' => 21, 'updated_at' => 22, 'publication_status' => 23, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/UserMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.UserMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = UserPeer::getTableMap();
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
		return str_replace(UserPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(UserPeer::ID);

		$criteria->addSelectColumn(UserPeer::LABEL);

		$criteria->addSelectColumn(UserPeer::LOGIN);

		$criteria->addSelectColumn(UserPeer::BACKEND);

		$criteria->addSelectColumn(UserPeer::TYPE);

		$criteria->addSelectColumn(UserPeer::SHA1_PASSWORD);

		$criteria->addSelectColumn(UserPeer::SALT);

		$criteria->addSelectColumn(UserPeer::FIRST_NAME);

		$criteria->addSelectColumn(UserPeer::LAST_NAME);

		$criteria->addSelectColumn(UserPeer::EMAIL);

		$criteria->addSelectColumn(UserPeer::PHONE);

		$criteria->addSelectColumn(UserPeer::CITY);

		$criteria->addSelectColumn(UserPeer::ADDRESS);

		$criteria->addSelectColumn(UserPeer::ZIP);

		$criteria->addSelectColumn(UserPeer::STATE);

		$criteria->addSelectColumn(UserPeer::ADDRESS2);

		$criteria->addSelectColumn(UserPeer::MOBILE_PHONE);

		$criteria->addSelectColumn(UserPeer::WORK_PHONE);

		$criteria->addSelectColumn(UserPeer::CONTACT_NAME);

		$criteria->addSelectColumn(UserPeer::CONTACT_NUMBER);

		$criteria->addSelectColumn(UserPeer::ACTIVATION_CODE);

		$criteria->addSelectColumn(UserPeer::CREATED_AT);

		$criteria->addSelectColumn(UserPeer::UPDATED_AT);

		$criteria->addSelectColumn(UserPeer::PUBLICATION_STATUS);

	}

	const COUNT = 'COUNT(m_user.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT m_user.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(UserPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(UserPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = UserPeer::doSelectRS($criteria, $con);
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
		$objects = UserPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return UserPeer::populateObjects(UserPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			UserPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = UserPeer::getOMClass();
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
		return UserPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(UserPeer::ID);
			$selectCriteria->add(UserPeer::ID, $criteria->remove(UserPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(UserPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof User) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(UserPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(User $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(UserPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(UserPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(UserPeer::DATABASE_NAME, UserPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = UserPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $pk);


		$v = UserPeer::doSelect($criteria, $con);

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
			$criteria->add(UserPeer::ID, $pks, Criteria::IN);
			$objs = UserPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseUserPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/UserMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.UserMapBuilder');
}
