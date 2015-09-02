<?php


abstract class BaseRelation extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id1;


	
	protected $id2;


	
	protected $document_model1;


	
	protected $document_model2;


	
	protected $sort_order;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId1()
	{

		return $this->id1;
	}

	
	public function getId2()
	{

		return $this->id2;
	}

	
	public function getDocumentModel1()
	{

		return $this->document_model1;
	}

	
	public function getDocumentModel2()
	{

		return $this->document_model2;
	}

	
	public function getSortOrder()
	{

		return $this->sort_order;
	}

	
	public function setId1($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id1 !== $v) {
			$this->id1 = $v;
			$this->modifiedColumns[] = RelationPeer::ID1;
		}

	} 
	
	public function setId2($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id2 !== $v) {
			$this->id2 = $v;
			$this->modifiedColumns[] = RelationPeer::ID2;
		}

	} 
	
	public function setDocumentModel1($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->document_model1 !== $v) {
			$this->document_model1 = $v;
			$this->modifiedColumns[] = RelationPeer::DOCUMENT_MODEL1;
		}

	} 
	
	public function setDocumentModel2($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->document_model2 !== $v) {
			$this->document_model2 = $v;
			$this->modifiedColumns[] = RelationPeer::DOCUMENT_MODEL2;
		}

	} 
	
	public function setSortOrder($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sort_order !== $v) {
			$this->sort_order = $v;
			$this->modifiedColumns[] = RelationPeer::SORT_ORDER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id1 = $rs->getInt($startcol + 0);

			$this->id2 = $rs->getInt($startcol + 1);

			$this->document_model1 = $rs->getString($startcol + 2);

			$this->document_model2 = $rs->getString($startcol + 3);

			$this->sort_order = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Relation object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RelationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			RelationPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(RelationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = RelationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += RelationPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = RelationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RelationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId1();
				break;
			case 1:
				return $this->getId2();
				break;
			case 2:
				return $this->getDocumentModel1();
				break;
			case 3:
				return $this->getDocumentModel2();
				break;
			case 4:
				return $this->getSortOrder();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RelationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId1(),
			$keys[1] => $this->getId2(),
			$keys[2] => $this->getDocumentModel1(),
			$keys[3] => $this->getDocumentModel2(),
			$keys[4] => $this->getSortOrder(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = RelationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId1($value);
				break;
			case 1:
				$this->setId2($value);
				break;
			case 2:
				$this->setDocumentModel1($value);
				break;
			case 3:
				$this->setDocumentModel2($value);
				break;
			case 4:
				$this->setSortOrder($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = RelationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId1($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setId2($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDocumentModel1($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDocumentModel2($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSortOrder($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(RelationPeer::DATABASE_NAME);

		if ($this->isColumnModified(RelationPeer::ID1)) $criteria->add(RelationPeer::ID1, $this->id1);
		if ($this->isColumnModified(RelationPeer::ID2)) $criteria->add(RelationPeer::ID2, $this->id2);
		if ($this->isColumnModified(RelationPeer::DOCUMENT_MODEL1)) $criteria->add(RelationPeer::DOCUMENT_MODEL1, $this->document_model1);
		if ($this->isColumnModified(RelationPeer::DOCUMENT_MODEL2)) $criteria->add(RelationPeer::DOCUMENT_MODEL2, $this->document_model2);
		if ($this->isColumnModified(RelationPeer::SORT_ORDER)) $criteria->add(RelationPeer::SORT_ORDER, $this->sort_order);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(RelationPeer::DATABASE_NAME);

		$criteria->add(RelationPeer::ID1, $this->id1);
		$criteria->add(RelationPeer::ID2, $this->id2);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId1();

		$pks[1] = $this->getId2();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId1($keys[0]);

		$this->setId2($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDocumentModel1($this->document_model1);

		$copyObj->setDocumentModel2($this->document_model2);

		$copyObj->setSortOrder($this->sort_order);


		$copyObj->setNew(true);

		$copyObj->setId1(NULL); 
		$copyObj->setId2(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new RelationPeer();
		}
		return self::$peer;
	}

} 