<?php


abstract class BaseUser extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $login;


	
	protected $backend;


	
	protected $type;


	
	protected $sha1_password;


	
	protected $salt;


	
	protected $first_name;


	
	protected $last_name;


	
	protected $email;


	
	protected $phone;


	
	protected $city;


	
	protected $address;


	
	protected $zip;


	
	protected $state;


	
	protected $address2;


	
	protected $mobile_phone;


	
	protected $work_phone;


	
	protected $contact_name;


	
	protected $contact_number;


	
	protected $activation_code;


	
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

	
	public function getLogin()
	{

		return $this->login;
	}

	
	public function getBackend()
	{

		return $this->backend;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getSha1Password()
	{

		return $this->sha1_password;
	}

	
	public function getSalt()
	{

		return $this->salt;
	}

	
	public function getFirstName()
	{

		return $this->first_name;
	}

	
	public function getLastName()
	{

		return $this->last_name;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getPhone()
	{

		return $this->phone;
	}

	
	public function getCity()
	{

		return $this->city;
	}

	
	public function getAddress()
	{

		return $this->address;
	}

	
	public function getZip()
	{

		return $this->zip;
	}

	
	public function getState()
	{

		return $this->state;
	}

	
	public function getAddress2()
	{

		return $this->address2;
	}

	
	public function getMobilePhone()
	{

		return $this->mobile_phone;
	}

	
	public function getWorkPhone()
	{

		return $this->work_phone;
	}

	
	public function getContactName()
	{

		return $this->contact_name;
	}

	
	public function getContactNumber()
	{

		return $this->contact_number;
	}

	
	public function getActivationCode()
	{

		return $this->activation_code;
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
			$this->modifiedColumns[] = UserPeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = UserPeer::LABEL;
		}

	} 
	
	public function setLogin($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->login !== $v) {
			$this->login = $v;
			$this->modifiedColumns[] = UserPeer::LOGIN;
		}

	} 
	
	public function setBackend($v)
	{

		if ($this->backend !== $v) {
			$this->backend = $v;
			$this->modifiedColumns[] = UserPeer::BACKEND;
		}

	} 
	
	public function setType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = UserPeer::TYPE;
		}

	} 
	
	public function setSha1Password($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sha1_password !== $v) {
			$this->sha1_password = $v;
			$this->modifiedColumns[] = UserPeer::SHA1_PASSWORD;
		}

	} 
	
	public function setSalt($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->salt !== $v) {
			$this->salt = $v;
			$this->modifiedColumns[] = UserPeer::SALT;
		}

	} 
	
	public function setFirstName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->first_name !== $v) {
			$this->first_name = $v;
			$this->modifiedColumns[] = UserPeer::FIRST_NAME;
		}

	} 
	
	public function setLastName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->last_name !== $v) {
			$this->last_name = $v;
			$this->modifiedColumns[] = UserPeer::LAST_NAME;
		}

	} 
	
	public function setEmail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = UserPeer::EMAIL;
		}

	} 
	
	public function setPhone($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone !== $v) {
			$this->phone = $v;
			$this->modifiedColumns[] = UserPeer::PHONE;
		}

	} 
	
	public function setCity($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->city !== $v) {
			$this->city = $v;
			$this->modifiedColumns[] = UserPeer::CITY;
		}

	} 
	
	public function setAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->address !== $v) {
			$this->address = $v;
			$this->modifiedColumns[] = UserPeer::ADDRESS;
		}

	} 
	
	public function setZip($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->zip !== $v) {
			$this->zip = $v;
			$this->modifiedColumns[] = UserPeer::ZIP;
		}

	} 
	
	public function setState($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->state !== $v) {
			$this->state = $v;
			$this->modifiedColumns[] = UserPeer::STATE;
		}

	} 
	
	public function setAddress2($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->address2 !== $v) {
			$this->address2 = $v;
			$this->modifiedColumns[] = UserPeer::ADDRESS2;
		}

	} 
	
	public function setMobilePhone($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mobile_phone !== $v) {
			$this->mobile_phone = $v;
			$this->modifiedColumns[] = UserPeer::MOBILE_PHONE;
		}

	} 
	
	public function setWorkPhone($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->work_phone !== $v) {
			$this->work_phone = $v;
			$this->modifiedColumns[] = UserPeer::WORK_PHONE;
		}

	} 
	
	public function setContactName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->contact_name !== $v) {
			$this->contact_name = $v;
			$this->modifiedColumns[] = UserPeer::CONTACT_NAME;
		}

	} 
	
	public function setContactNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->contact_number !== $v) {
			$this->contact_number = $v;
			$this->modifiedColumns[] = UserPeer::CONTACT_NUMBER;
		}

	} 
	
	public function setActivationCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->activation_code !== $v) {
			$this->activation_code = $v;
			$this->modifiedColumns[] = UserPeer::ACTIVATION_CODE;
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
			$this->modifiedColumns[] = UserPeer::CREATED_AT;
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
			$this->modifiedColumns[] = UserPeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = UserPeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->login = $rs->getString($startcol + 2);

			$this->backend = $rs->getBoolean($startcol + 3);

			$this->type = $rs->getString($startcol + 4);

			$this->sha1_password = $rs->getString($startcol + 5);

			$this->salt = $rs->getString($startcol + 6);

			$this->first_name = $rs->getString($startcol + 7);

			$this->last_name = $rs->getString($startcol + 8);

			$this->email = $rs->getString($startcol + 9);

			$this->phone = $rs->getString($startcol + 10);

			$this->city = $rs->getString($startcol + 11);

			$this->address = $rs->getString($startcol + 12);

			$this->zip = $rs->getString($startcol + 13);

			$this->state = $rs->getString($startcol + 14);

			$this->address2 = $rs->getString($startcol + 15);

			$this->mobile_phone = $rs->getString($startcol + 16);

			$this->work_phone = $rs->getString($startcol + 17);

			$this->contact_name = $rs->getString($startcol + 18);

			$this->contact_number = $rs->getString($startcol + 19);

			$this->activation_code = $rs->getString($startcol + 20);

			$this->created_at = $rs->getTimestamp($startcol + 21, null);

			$this->updated_at = $rs->getTimestamp($startcol + 22, null);

			$this->publication_status = $rs->getString($startcol + 23);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 24; 
		} catch (Exception $e) {
			throw new PropelException("Error populating User object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			UserPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(UserPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(UserPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(UserPeer::DATABASE_NAME);
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
					$pk = UserPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += UserPeer::doUpdate($this, $con);
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


			if (($retval = UserPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getLogin();
				break;
			case 3:
				return $this->getBackend();
				break;
			case 4:
				return $this->getType();
				break;
			case 5:
				return $this->getSha1Password();
				break;
			case 6:
				return $this->getSalt();
				break;
			case 7:
				return $this->getFirstName();
				break;
			case 8:
				return $this->getLastName();
				break;
			case 9:
				return $this->getEmail();
				break;
			case 10:
				return $this->getPhone();
				break;
			case 11:
				return $this->getCity();
				break;
			case 12:
				return $this->getAddress();
				break;
			case 13:
				return $this->getZip();
				break;
			case 14:
				return $this->getState();
				break;
			case 15:
				return $this->getAddress2();
				break;
			case 16:
				return $this->getMobilePhone();
				break;
			case 17:
				return $this->getWorkPhone();
				break;
			case 18:
				return $this->getContactName();
				break;
			case 19:
				return $this->getContactNumber();
				break;
			case 20:
				return $this->getActivationCode();
				break;
			case 21:
				return $this->getCreatedAt();
				break;
			case 22:
				return $this->getUpdatedAt();
				break;
			case 23:
				return $this->getPublicationStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getLogin(),
			$keys[3] => $this->getBackend(),
			$keys[4] => $this->getType(),
			$keys[5] => $this->getSha1Password(),
			$keys[6] => $this->getSalt(),
			$keys[7] => $this->getFirstName(),
			$keys[8] => $this->getLastName(),
			$keys[9] => $this->getEmail(),
			$keys[10] => $this->getPhone(),
			$keys[11] => $this->getCity(),
			$keys[12] => $this->getAddress(),
			$keys[13] => $this->getZip(),
			$keys[14] => $this->getState(),
			$keys[15] => $this->getAddress2(),
			$keys[16] => $this->getMobilePhone(),
			$keys[17] => $this->getWorkPhone(),
			$keys[18] => $this->getContactName(),
			$keys[19] => $this->getContactNumber(),
			$keys[20] => $this->getActivationCode(),
			$keys[21] => $this->getCreatedAt(),
			$keys[22] => $this->getUpdatedAt(),
			$keys[23] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = UserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setLogin($value);
				break;
			case 3:
				$this->setBackend($value);
				break;
			case 4:
				$this->setType($value);
				break;
			case 5:
				$this->setSha1Password($value);
				break;
			case 6:
				$this->setSalt($value);
				break;
			case 7:
				$this->setFirstName($value);
				break;
			case 8:
				$this->setLastName($value);
				break;
			case 9:
				$this->setEmail($value);
				break;
			case 10:
				$this->setPhone($value);
				break;
			case 11:
				$this->setCity($value);
				break;
			case 12:
				$this->setAddress($value);
				break;
			case 13:
				$this->setZip($value);
				break;
			case 14:
				$this->setState($value);
				break;
			case 15:
				$this->setAddress2($value);
				break;
			case 16:
				$this->setMobilePhone($value);
				break;
			case 17:
				$this->setWorkPhone($value);
				break;
			case 18:
				$this->setContactName($value);
				break;
			case 19:
				$this->setContactNumber($value);
				break;
			case 20:
				$this->setActivationCode($value);
				break;
			case 21:
				$this->setCreatedAt($value);
				break;
			case 22:
				$this->setUpdatedAt($value);
				break;
			case 23:
				$this->setPublicationStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = UserPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setLogin($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setBackend($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSha1Password($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSalt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setFirstName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLastName($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setEmail($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPhone($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setCity($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setAddress($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setZip($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setState($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setAddress2($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setMobilePhone($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setWorkPhone($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setContactName($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setContactNumber($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setActivationCode($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setCreatedAt($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setUpdatedAt($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setPublicationStatus($arr[$keys[23]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		if ($this->isColumnModified(UserPeer::ID)) $criteria->add(UserPeer::ID, $this->id);
		if ($this->isColumnModified(UserPeer::LABEL)) $criteria->add(UserPeer::LABEL, $this->label);
		if ($this->isColumnModified(UserPeer::LOGIN)) $criteria->add(UserPeer::LOGIN, $this->login);
		if ($this->isColumnModified(UserPeer::BACKEND)) $criteria->add(UserPeer::BACKEND, $this->backend);
		if ($this->isColumnModified(UserPeer::TYPE)) $criteria->add(UserPeer::TYPE, $this->type);
		if ($this->isColumnModified(UserPeer::SHA1_PASSWORD)) $criteria->add(UserPeer::SHA1_PASSWORD, $this->sha1_password);
		if ($this->isColumnModified(UserPeer::SALT)) $criteria->add(UserPeer::SALT, $this->salt);
		if ($this->isColumnModified(UserPeer::FIRST_NAME)) $criteria->add(UserPeer::FIRST_NAME, $this->first_name);
		if ($this->isColumnModified(UserPeer::LAST_NAME)) $criteria->add(UserPeer::LAST_NAME, $this->last_name);
		if ($this->isColumnModified(UserPeer::EMAIL)) $criteria->add(UserPeer::EMAIL, $this->email);
		if ($this->isColumnModified(UserPeer::PHONE)) $criteria->add(UserPeer::PHONE, $this->phone);
		if ($this->isColumnModified(UserPeer::CITY)) $criteria->add(UserPeer::CITY, $this->city);
		if ($this->isColumnModified(UserPeer::ADDRESS)) $criteria->add(UserPeer::ADDRESS, $this->address);
		if ($this->isColumnModified(UserPeer::ZIP)) $criteria->add(UserPeer::ZIP, $this->zip);
		if ($this->isColumnModified(UserPeer::STATE)) $criteria->add(UserPeer::STATE, $this->state);
		if ($this->isColumnModified(UserPeer::ADDRESS2)) $criteria->add(UserPeer::ADDRESS2, $this->address2);
		if ($this->isColumnModified(UserPeer::MOBILE_PHONE)) $criteria->add(UserPeer::MOBILE_PHONE, $this->mobile_phone);
		if ($this->isColumnModified(UserPeer::WORK_PHONE)) $criteria->add(UserPeer::WORK_PHONE, $this->work_phone);
		if ($this->isColumnModified(UserPeer::CONTACT_NAME)) $criteria->add(UserPeer::CONTACT_NAME, $this->contact_name);
		if ($this->isColumnModified(UserPeer::CONTACT_NUMBER)) $criteria->add(UserPeer::CONTACT_NUMBER, $this->contact_number);
		if ($this->isColumnModified(UserPeer::ACTIVATION_CODE)) $criteria->add(UserPeer::ACTIVATION_CODE, $this->activation_code);
		if ($this->isColumnModified(UserPeer::CREATED_AT)) $criteria->add(UserPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(UserPeer::UPDATED_AT)) $criteria->add(UserPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(UserPeer::PUBLICATION_STATUS)) $criteria->add(UserPeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(UserPeer::DATABASE_NAME);

		$criteria->add(UserPeer::ID, $this->id);

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

		$copyObj->setLogin($this->login);

		$copyObj->setBackend($this->backend);

		$copyObj->setType($this->type);

		$copyObj->setSha1Password($this->sha1_password);

		$copyObj->setSalt($this->salt);

		$copyObj->setFirstName($this->first_name);

		$copyObj->setLastName($this->last_name);

		$copyObj->setEmail($this->email);

		$copyObj->setPhone($this->phone);

		$copyObj->setCity($this->city);

		$copyObj->setAddress($this->address);

		$copyObj->setZip($this->zip);

		$copyObj->setState($this->state);

		$copyObj->setAddress2($this->address2);

		$copyObj->setMobilePhone($this->mobile_phone);

		$copyObj->setWorkPhone($this->work_phone);

		$copyObj->setContactName($this->contact_name);

		$copyObj->setContactNumber($this->contact_number);

		$copyObj->setActivationCode($this->activation_code);

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
			self::$peer = new UserPeer();
		}
		return self::$peer;
	}

} 