<?php


abstract class BaseSearch extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $application_number;


	
	protected $register_number;


	
	protected $registration_date;


	
	protected $application_date;


	
	protected $expires_on;


	
	protected $vienna_classes;


	
	protected $nice_classes;


	
	protected $rights_owner;


	
	protected $rights_representative;


	
	protected $office_of_origin;


	
	protected $designated_contracting_party;


	
	protected $created_at;


	
	protected $updated_at;


	
	protected $publication_status;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getLabel()
	{

		return $this->label;
	}

	
	public function getApplicationNumber()
	{

		return $this->application_number;
	}

	
	public function getRegisterNumber()
	{

		return $this->register_number;
	}

	
	public function getRegistrationDate()
	{

		return $this->registration_date;
	}

	
	public function getApplicationDate()
	{

		return $this->application_date;
	}

	
	public function getExpiresOn()
	{

		return $this->expires_on;
	}

	
	public function getViennaClasses()
	{

		return $this->vienna_classes;
	}

	
	public function getNiceClasses()
	{

		return $this->nice_classes;
	}

	
	public function getRightsOwner()
	{

		return $this->rights_owner;
	}

	
	public function getRightsRepresentative()
	{

		return $this->rights_representative;
	}

	
	public function getOfficeOfOrigin()
	{

		return $this->office_of_origin;
	}

	
	public function getDesignatedContractingParty()
	{

		return $this->designated_contracting_party;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->updated_at === null || $this->updated_at === '') {
			return null;
		} elseif (!is_int($this->updated_at)) {
						$ts = strtotime($this->updated_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [updated_at] as date/time value: " . var_export($this->updated_at, true));
			}
		} else {
			$ts = $this->updated_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getPublicationStatus()
	{

		return $this->publication_status;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = SearchPeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = SearchPeer::LABEL;
		}

	} 
	
	public function setApplicationNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->application_number !== $v) {
			$this->application_number = $v;
			$this->modifiedColumns[] = SearchPeer::APPLICATION_NUMBER;
		}

	} 
	
	public function setRegisterNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->register_number !== $v) {
			$this->register_number = $v;
			$this->modifiedColumns[] = SearchPeer::REGISTER_NUMBER;
		}

	} 
	
	public function setRegistrationDate($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->registration_date !== $v) {
			$this->registration_date = $v;
			$this->modifiedColumns[] = SearchPeer::REGISTRATION_DATE;
		}

	} 
	
	public function setApplicationDate($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->application_date !== $v) {
			$this->application_date = $v;
			$this->modifiedColumns[] = SearchPeer::APPLICATION_DATE;
		}

	} 
	
	public function setExpiresOn($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->expires_on !== $v) {
			$this->expires_on = $v;
			$this->modifiedColumns[] = SearchPeer::EXPIRES_ON;
		}

	} 
	
	public function setViennaClasses($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->vienna_classes !== $v) {
			$this->vienna_classes = $v;
			$this->modifiedColumns[] = SearchPeer::VIENNA_CLASSES;
		}

	} 
	
	public function setNiceClasses($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nice_classes !== $v) {
			$this->nice_classes = $v;
			$this->modifiedColumns[] = SearchPeer::NICE_CLASSES;
		}

	} 
	
	public function setRightsOwner($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner !== $v) {
			$this->rights_owner = $v;
			$this->modifiedColumns[] = SearchPeer::RIGHTS_OWNER;
		}

	} 
	
	public function setRightsRepresentative($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative !== $v) {
			$this->rights_representative = $v;
			$this->modifiedColumns[] = SearchPeer::RIGHTS_REPRESENTATIVE;
		}

	} 
	
	public function setOfficeOfOrigin($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->office_of_origin !== $v) {
			$this->office_of_origin = $v;
			$this->modifiedColumns[] = SearchPeer::OFFICE_OF_ORIGIN;
		}

	} 
	
	public function setDesignatedContractingParty($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->designated_contracting_party !== $v) {
			$this->designated_contracting_party = $v;
			$this->modifiedColumns[] = SearchPeer::DESIGNATED_CONTRACTING_PARTY;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = SearchPeer::CREATED_AT;
		}

	} 
	
	public function setUpdatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [updated_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->updated_at !== $ts) {
			$this->updated_at = $ts;
			$this->modifiedColumns[] = SearchPeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = SearchPeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->application_number = $rs->getString($startcol + 2);

			$this->register_number = $rs->getString($startcol + 3);

			$this->registration_date = $rs->getString($startcol + 4);

			$this->application_date = $rs->getString($startcol + 5);

			$this->expires_on = $rs->getString($startcol + 6);

			$this->vienna_classes = $rs->getString($startcol + 7);

			$this->nice_classes = $rs->getString($startcol + 8);

			$this->rights_owner = $rs->getString($startcol + 9);

			$this->rights_representative = $rs->getString($startcol + 10);

			$this->office_of_origin = $rs->getString($startcol + 11);

			$this->designated_contracting_party = $rs->getString($startcol + 12);

			$this->created_at = $rs->getTimestamp($startcol + 13, null);

			$this->updated_at = $rs->getTimestamp($startcol + 14, null);

			$this->publication_status = $rs->getString($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Search object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SearchPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			SearchPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(SearchPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(SearchPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(SearchPeer::DATABASE_NAME);
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
					$pk = SearchPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += SearchPeer::doUpdate($this, $con);
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


			if (($retval = SearchPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SearchPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getLabel();
				break;
			case 2:
				return $this->getApplicationNumber();
				break;
			case 3:
				return $this->getRegisterNumber();
				break;
			case 4:
				return $this->getRegistrationDate();
				break;
			case 5:
				return $this->getApplicationDate();
				break;
			case 6:
				return $this->getExpiresOn();
				break;
			case 7:
				return $this->getViennaClasses();
				break;
			case 8:
				return $this->getNiceClasses();
				break;
			case 9:
				return $this->getRightsOwner();
				break;
			case 10:
				return $this->getRightsRepresentative();
				break;
			case 11:
				return $this->getOfficeOfOrigin();
				break;
			case 12:
				return $this->getDesignatedContractingParty();
				break;
			case 13:
				return $this->getCreatedAt();
				break;
			case 14:
				return $this->getUpdatedAt();
				break;
			case 15:
				return $this->getPublicationStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SearchPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getApplicationNumber(),
			$keys[3] => $this->getRegisterNumber(),
			$keys[4] => $this->getRegistrationDate(),
			$keys[5] => $this->getApplicationDate(),
			$keys[6] => $this->getExpiresOn(),
			$keys[7] => $this->getViennaClasses(),
			$keys[8] => $this->getNiceClasses(),
			$keys[9] => $this->getRightsOwner(),
			$keys[10] => $this->getRightsRepresentative(),
			$keys[11] => $this->getOfficeOfOrigin(),
			$keys[12] => $this->getDesignatedContractingParty(),
			$keys[13] => $this->getCreatedAt(),
			$keys[14] => $this->getUpdatedAt(),
			$keys[15] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = SearchPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setLabel($value);
				break;
			case 2:
				$this->setApplicationNumber($value);
				break;
			case 3:
				$this->setRegisterNumber($value);
				break;
			case 4:
				$this->setRegistrationDate($value);
				break;
			case 5:
				$this->setApplicationDate($value);
				break;
			case 6:
				$this->setExpiresOn($value);
				break;
			case 7:
				$this->setViennaClasses($value);
				break;
			case 8:
				$this->setNiceClasses($value);
				break;
			case 9:
				$this->setRightsOwner($value);
				break;
			case 10:
				$this->setRightsRepresentative($value);
				break;
			case 11:
				$this->setOfficeOfOrigin($value);
				break;
			case 12:
				$this->setDesignatedContractingParty($value);
				break;
			case 13:
				$this->setCreatedAt($value);
				break;
			case 14:
				$this->setUpdatedAt($value);
				break;
			case 15:
				$this->setPublicationStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = SearchPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setApplicationNumber($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRegisterNumber($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRegistrationDate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setApplicationDate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setExpiresOn($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setViennaClasses($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setNiceClasses($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setRightsOwner($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setRightsRepresentative($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setOfficeOfOrigin($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setDesignatedContractingParty($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUpdatedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setPublicationStatus($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(SearchPeer::DATABASE_NAME);

		if ($this->isColumnModified(SearchPeer::ID)) $criteria->add(SearchPeer::ID, $this->id);
		if ($this->isColumnModified(SearchPeer::LABEL)) $criteria->add(SearchPeer::LABEL, $this->label);
		if ($this->isColumnModified(SearchPeer::APPLICATION_NUMBER)) $criteria->add(SearchPeer::APPLICATION_NUMBER, $this->application_number);
		if ($this->isColumnModified(SearchPeer::REGISTER_NUMBER)) $criteria->add(SearchPeer::REGISTER_NUMBER, $this->register_number);
		if ($this->isColumnModified(SearchPeer::REGISTRATION_DATE)) $criteria->add(SearchPeer::REGISTRATION_DATE, $this->registration_date);
		if ($this->isColumnModified(SearchPeer::APPLICATION_DATE)) $criteria->add(SearchPeer::APPLICATION_DATE, $this->application_date);
		if ($this->isColumnModified(SearchPeer::EXPIRES_ON)) $criteria->add(SearchPeer::EXPIRES_ON, $this->expires_on);
		if ($this->isColumnModified(SearchPeer::VIENNA_CLASSES)) $criteria->add(SearchPeer::VIENNA_CLASSES, $this->vienna_classes);
		if ($this->isColumnModified(SearchPeer::NICE_CLASSES)) $criteria->add(SearchPeer::NICE_CLASSES, $this->nice_classes);
		if ($this->isColumnModified(SearchPeer::RIGHTS_OWNER)) $criteria->add(SearchPeer::RIGHTS_OWNER, $this->rights_owner);
		if ($this->isColumnModified(SearchPeer::RIGHTS_REPRESENTATIVE)) $criteria->add(SearchPeer::RIGHTS_REPRESENTATIVE, $this->rights_representative);
		if ($this->isColumnModified(SearchPeer::OFFICE_OF_ORIGIN)) $criteria->add(SearchPeer::OFFICE_OF_ORIGIN, $this->office_of_origin);
		if ($this->isColumnModified(SearchPeer::DESIGNATED_CONTRACTING_PARTY)) $criteria->add(SearchPeer::DESIGNATED_CONTRACTING_PARTY, $this->designated_contracting_party);
		if ($this->isColumnModified(SearchPeer::CREATED_AT)) $criteria->add(SearchPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(SearchPeer::UPDATED_AT)) $criteria->add(SearchPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(SearchPeer::PUBLICATION_STATUS)) $criteria->add(SearchPeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(SearchPeer::DATABASE_NAME);

		$criteria->add(SearchPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setLabel($this->label);

		$copyObj->setApplicationNumber($this->application_number);

		$copyObj->setRegisterNumber($this->register_number);

		$copyObj->setRegistrationDate($this->registration_date);

		$copyObj->setApplicationDate($this->application_date);

		$copyObj->setExpiresOn($this->expires_on);

		$copyObj->setViennaClasses($this->vienna_classes);

		$copyObj->setNiceClasses($this->nice_classes);

		$copyObj->setRightsOwner($this->rights_owner);

		$copyObj->setRightsRepresentative($this->rights_representative);

		$copyObj->setOfficeOfOrigin($this->office_of_origin);

		$copyObj->setDesignatedContractingParty($this->designated_contracting_party);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUpdatedAt($this->updated_at);

		$copyObj->setPublicationStatus($this->publication_status);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
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
			self::$peer = new SearchPeer();
		}
		return self::$peer;
	}

} 