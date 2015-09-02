<?php


abstract class BaseBrand extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $client_id;


	
	protected $application_number;


	
	protected $application_date;


	
	protected $status;


	
	protected $register_number;


	
	protected $registration_date;


	
	protected $kind;


	
	protected $expires_on;


	
	protected $vienna_classes;


	
	protected $colors;


	
	protected $nice_classes;


	
	protected $rights_owner;


	
	protected $rights_owner_id;


	
	protected $rights_owner_address;


	
	protected $rights_representative;


	
	protected $rights_representative_id;


	
	protected $rights_representative_address;


	
	protected $office_of_origin;


	
	protected $designated_contracting_party;


	
	protected $image;


	
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

	
	public function getClientId()
	{

		return $this->client_id;
	}

	
	public function getApplicationNumber()
	{

		return $this->application_number;
	}

	
	public function getApplicationDate($format = 'Y-m-d H:i:s')
	{

		if ($this->application_date === null || $this->application_date === '') {
			return null;
		} elseif (!is_int($this->application_date)) {
						$ts = strtotime($this->application_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [application_date] as date/time value: " . var_export($this->application_date, true));
			}
		} else {
			$ts = $this->application_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getStatus()
	{

		return $this->status;
	}

	
	public function getRegisterNumber()
	{

		return $this->register_number;
	}

	
	public function getRegistrationDate($format = 'Y-m-d H:i:s')
	{

		if ($this->registration_date === null || $this->registration_date === '') {
			return null;
		} elseif (!is_int($this->registration_date)) {
						$ts = strtotime($this->registration_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [registration_date] as date/time value: " . var_export($this->registration_date, true));
			}
		} else {
			$ts = $this->registration_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getKind()
	{

		return $this->kind;
	}

	
	public function getExpiresOn($format = 'Y-m-d H:i:s')
	{

		if ($this->expires_on === null || $this->expires_on === '') {
			return null;
		} elseif (!is_int($this->expires_on)) {
						$ts = strtotime($this->expires_on);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [expires_on] as date/time value: " . var_export($this->expires_on, true));
			}
		} else {
			$ts = $this->expires_on;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getViennaClasses()
	{

		return $this->vienna_classes;
	}

	
	public function getColors()
	{

		return $this->colors;
	}

	
	public function getNiceClasses()
	{

		return $this->nice_classes;
	}

	
	public function getRightsOwner()
	{

		return $this->rights_owner;
	}

	
	public function getRightsOwnerId()
	{

		return $this->rights_owner_id;
	}

	
	public function getRightsOwnerAddress()
	{

		return $this->rights_owner_address;
	}

	
	public function getRightsRepresentative()
	{

		return $this->rights_representative;
	}

	
	public function getRightsRepresentativeId()
	{

		return $this->rights_representative_id;
	}

	
	public function getRightsRepresentativeAddress()
	{

		return $this->rights_representative_address;
	}

	
	public function getOfficeOfOrigin()
	{

		return $this->office_of_origin;
	}

	
	public function getDesignatedContractingParty()
	{

		return $this->designated_contracting_party;
	}

	
	public function getImage()
	{

		return $this->image;
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
			$this->modifiedColumns[] = BrandPeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = BrandPeer::LABEL;
		}

	} 
	
	public function setClientId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->client_id !== $v) {
			$this->client_id = $v;
			$this->modifiedColumns[] = BrandPeer::CLIENT_ID;
		}

	} 
	
	public function setApplicationNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->application_number !== $v) {
			$this->application_number = $v;
			$this->modifiedColumns[] = BrandPeer::APPLICATION_NUMBER;
		}

	} 
	
	public function setApplicationDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [application_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->application_date !== $ts) {
			$this->application_date = $ts;
			$this->modifiedColumns[] = BrandPeer::APPLICATION_DATE;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = BrandPeer::STATUS;
		}

	} 
	
	public function setRegisterNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->register_number !== $v) {
			$this->register_number = $v;
			$this->modifiedColumns[] = BrandPeer::REGISTER_NUMBER;
		}

	} 
	
	public function setRegistrationDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [registration_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->registration_date !== $ts) {
			$this->registration_date = $ts;
			$this->modifiedColumns[] = BrandPeer::REGISTRATION_DATE;
		}

	} 
	
	public function setKind($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->kind !== $v) {
			$this->kind = $v;
			$this->modifiedColumns[] = BrandPeer::KIND;
		}

	} 
	
	public function setExpiresOn($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [expires_on] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->expires_on !== $ts) {
			$this->expires_on = $ts;
			$this->modifiedColumns[] = BrandPeer::EXPIRES_ON;
		}

	} 
	
	public function setViennaClasses($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->vienna_classes !== $v) {
			$this->vienna_classes = $v;
			$this->modifiedColumns[] = BrandPeer::VIENNA_CLASSES;
		}

	} 
	
	public function setColors($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->colors !== $v) {
			$this->colors = $v;
			$this->modifiedColumns[] = BrandPeer::COLORS;
		}

	} 
	
	public function setNiceClasses($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nice_classes !== $v) {
			$this->nice_classes = $v;
			$this->modifiedColumns[] = BrandPeer::NICE_CLASSES;
		}

	} 
	
	public function setRightsOwner($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner !== $v) {
			$this->rights_owner = $v;
			$this->modifiedColumns[] = BrandPeer::RIGHTS_OWNER;
		}

	} 
	
	public function setRightsOwnerId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner_id !== $v) {
			$this->rights_owner_id = $v;
			$this->modifiedColumns[] = BrandPeer::RIGHTS_OWNER_ID;
		}

	} 
	
	public function setRightsOwnerAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner_address !== $v) {
			$this->rights_owner_address = $v;
			$this->modifiedColumns[] = BrandPeer::RIGHTS_OWNER_ADDRESS;
		}

	} 
	
	public function setRightsRepresentative($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative !== $v) {
			$this->rights_representative = $v;
			$this->modifiedColumns[] = BrandPeer::RIGHTS_REPRESENTATIVE;
		}

	} 
	
	public function setRightsRepresentativeId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative_id !== $v) {
			$this->rights_representative_id = $v;
			$this->modifiedColumns[] = BrandPeer::RIGHTS_REPRESENTATIVE_ID;
		}

	} 
	
	public function setRightsRepresentativeAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative_address !== $v) {
			$this->rights_representative_address = $v;
			$this->modifiedColumns[] = BrandPeer::RIGHTS_REPRESENTATIVE_ADDRESS;
		}

	} 
	
	public function setOfficeOfOrigin($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->office_of_origin !== $v) {
			$this->office_of_origin = $v;
			$this->modifiedColumns[] = BrandPeer::OFFICE_OF_ORIGIN;
		}

	} 
	
	public function setDesignatedContractingParty($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->designated_contracting_party !== $v) {
			$this->designated_contracting_party = $v;
			$this->modifiedColumns[] = BrandPeer::DESIGNATED_CONTRACTING_PARTY;
		}

	} 
	
	public function setImage($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->image !== $v) {
			$this->image = $v;
			$this->modifiedColumns[] = BrandPeer::IMAGE;
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
			$this->modifiedColumns[] = BrandPeer::CREATED_AT;
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
			$this->modifiedColumns[] = BrandPeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = BrandPeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->client_id = $rs->getInt($startcol + 2);

			$this->application_number = $rs->getString($startcol + 3);

			$this->application_date = $rs->getTimestamp($startcol + 4, null);

			$this->status = $rs->getString($startcol + 5);

			$this->register_number = $rs->getString($startcol + 6);

			$this->registration_date = $rs->getTimestamp($startcol + 7, null);

			$this->kind = $rs->getString($startcol + 8);

			$this->expires_on = $rs->getTimestamp($startcol + 9, null);

			$this->vienna_classes = $rs->getString($startcol + 10);

			$this->colors = $rs->getString($startcol + 11);

			$this->nice_classes = $rs->getString($startcol + 12);

			$this->rights_owner = $rs->getString($startcol + 13);

			$this->rights_owner_id = $rs->getString($startcol + 14);

			$this->rights_owner_address = $rs->getString($startcol + 15);

			$this->rights_representative = $rs->getString($startcol + 16);

			$this->rights_representative_id = $rs->getString($startcol + 17);

			$this->rights_representative_address = $rs->getString($startcol + 18);

			$this->office_of_origin = $rs->getString($startcol + 19);

			$this->designated_contracting_party = $rs->getString($startcol + 20);

			$this->image = $rs->getInt($startcol + 21);

			$this->created_at = $rs->getTimestamp($startcol + 22, null);

			$this->updated_at = $rs->getTimestamp($startcol + 23, null);

			$this->publication_status = $rs->getString($startcol + 24);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 25; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Brand object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(BrandPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			BrandPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(BrandPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(BrandPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(BrandPeer::DATABASE_NAME);
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
					$pk = BrandPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += BrandPeer::doUpdate($this, $con);
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


			if (($retval = BrandPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = BrandPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getClientId();
				break;
			case 3:
				return $this->getApplicationNumber();
				break;
			case 4:
				return $this->getApplicationDate();
				break;
			case 5:
				return $this->getStatus();
				break;
			case 6:
				return $this->getRegisterNumber();
				break;
			case 7:
				return $this->getRegistrationDate();
				break;
			case 8:
				return $this->getKind();
				break;
			case 9:
				return $this->getExpiresOn();
				break;
			case 10:
				return $this->getViennaClasses();
				break;
			case 11:
				return $this->getColors();
				break;
			case 12:
				return $this->getNiceClasses();
				break;
			case 13:
				return $this->getRightsOwner();
				break;
			case 14:
				return $this->getRightsOwnerId();
				break;
			case 15:
				return $this->getRightsOwnerAddress();
				break;
			case 16:
				return $this->getRightsRepresentative();
				break;
			case 17:
				return $this->getRightsRepresentativeId();
				break;
			case 18:
				return $this->getRightsRepresentativeAddress();
				break;
			case 19:
				return $this->getOfficeOfOrigin();
				break;
			case 20:
				return $this->getDesignatedContractingParty();
				break;
			case 21:
				return $this->getImage();
				break;
			case 22:
				return $this->getCreatedAt();
				break;
			case 23:
				return $this->getUpdatedAt();
				break;
			case 24:
				return $this->getPublicationStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = BrandPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getClientId(),
			$keys[3] => $this->getApplicationNumber(),
			$keys[4] => $this->getApplicationDate(),
			$keys[5] => $this->getStatus(),
			$keys[6] => $this->getRegisterNumber(),
			$keys[7] => $this->getRegistrationDate(),
			$keys[8] => $this->getKind(),
			$keys[9] => $this->getExpiresOn(),
			$keys[10] => $this->getViennaClasses(),
			$keys[11] => $this->getColors(),
			$keys[12] => $this->getNiceClasses(),
			$keys[13] => $this->getRightsOwner(),
			$keys[14] => $this->getRightsOwnerId(),
			$keys[15] => $this->getRightsOwnerAddress(),
			$keys[16] => $this->getRightsRepresentative(),
			$keys[17] => $this->getRightsRepresentativeId(),
			$keys[18] => $this->getRightsRepresentativeAddress(),
			$keys[19] => $this->getOfficeOfOrigin(),
			$keys[20] => $this->getDesignatedContractingParty(),
			$keys[21] => $this->getImage(),
			$keys[22] => $this->getCreatedAt(),
			$keys[23] => $this->getUpdatedAt(),
			$keys[24] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = BrandPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setClientId($value);
				break;
			case 3:
				$this->setApplicationNumber($value);
				break;
			case 4:
				$this->setApplicationDate($value);
				break;
			case 5:
				$this->setStatus($value);
				break;
			case 6:
				$this->setRegisterNumber($value);
				break;
			case 7:
				$this->setRegistrationDate($value);
				break;
			case 8:
				$this->setKind($value);
				break;
			case 9:
				$this->setExpiresOn($value);
				break;
			case 10:
				$this->setViennaClasses($value);
				break;
			case 11:
				$this->setColors($value);
				break;
			case 12:
				$this->setNiceClasses($value);
				break;
			case 13:
				$this->setRightsOwner($value);
				break;
			case 14:
				$this->setRightsOwnerId($value);
				break;
			case 15:
				$this->setRightsOwnerAddress($value);
				break;
			case 16:
				$this->setRightsRepresentative($value);
				break;
			case 17:
				$this->setRightsRepresentativeId($value);
				break;
			case 18:
				$this->setRightsRepresentativeAddress($value);
				break;
			case 19:
				$this->setOfficeOfOrigin($value);
				break;
			case 20:
				$this->setDesignatedContractingParty($value);
				break;
			case 21:
				$this->setImage($value);
				break;
			case 22:
				$this->setCreatedAt($value);
				break;
			case 23:
				$this->setUpdatedAt($value);
				break;
			case 24:
				$this->setPublicationStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = BrandPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setClientId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setApplicationNumber($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setApplicationDate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setStatus($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setRegisterNumber($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRegistrationDate($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setKind($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setExpiresOn($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setViennaClasses($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setColors($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setNiceClasses($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setRightsOwner($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setRightsOwnerId($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setRightsOwnerAddress($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setRightsRepresentative($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setRightsRepresentativeId($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setRightsRepresentativeAddress($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setOfficeOfOrigin($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setDesignatedContractingParty($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setImage($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setCreatedAt($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setUpdatedAt($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setPublicationStatus($arr[$keys[24]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(BrandPeer::DATABASE_NAME);

		if ($this->isColumnModified(BrandPeer::ID)) $criteria->add(BrandPeer::ID, $this->id);
		if ($this->isColumnModified(BrandPeer::LABEL)) $criteria->add(BrandPeer::LABEL, $this->label);
		if ($this->isColumnModified(BrandPeer::CLIENT_ID)) $criteria->add(BrandPeer::CLIENT_ID, $this->client_id);
		if ($this->isColumnModified(BrandPeer::APPLICATION_NUMBER)) $criteria->add(BrandPeer::APPLICATION_NUMBER, $this->application_number);
		if ($this->isColumnModified(BrandPeer::APPLICATION_DATE)) $criteria->add(BrandPeer::APPLICATION_DATE, $this->application_date);
		if ($this->isColumnModified(BrandPeer::STATUS)) $criteria->add(BrandPeer::STATUS, $this->status);
		if ($this->isColumnModified(BrandPeer::REGISTER_NUMBER)) $criteria->add(BrandPeer::REGISTER_NUMBER, $this->register_number);
		if ($this->isColumnModified(BrandPeer::REGISTRATION_DATE)) $criteria->add(BrandPeer::REGISTRATION_DATE, $this->registration_date);
		if ($this->isColumnModified(BrandPeer::KIND)) $criteria->add(BrandPeer::KIND, $this->kind);
		if ($this->isColumnModified(BrandPeer::EXPIRES_ON)) $criteria->add(BrandPeer::EXPIRES_ON, $this->expires_on);
		if ($this->isColumnModified(BrandPeer::VIENNA_CLASSES)) $criteria->add(BrandPeer::VIENNA_CLASSES, $this->vienna_classes);
		if ($this->isColumnModified(BrandPeer::COLORS)) $criteria->add(BrandPeer::COLORS, $this->colors);
		if ($this->isColumnModified(BrandPeer::NICE_CLASSES)) $criteria->add(BrandPeer::NICE_CLASSES, $this->nice_classes);
		if ($this->isColumnModified(BrandPeer::RIGHTS_OWNER)) $criteria->add(BrandPeer::RIGHTS_OWNER, $this->rights_owner);
		if ($this->isColumnModified(BrandPeer::RIGHTS_OWNER_ID)) $criteria->add(BrandPeer::RIGHTS_OWNER_ID, $this->rights_owner_id);
		if ($this->isColumnModified(BrandPeer::RIGHTS_OWNER_ADDRESS)) $criteria->add(BrandPeer::RIGHTS_OWNER_ADDRESS, $this->rights_owner_address);
		if ($this->isColumnModified(BrandPeer::RIGHTS_REPRESENTATIVE)) $criteria->add(BrandPeer::RIGHTS_REPRESENTATIVE, $this->rights_representative);
		if ($this->isColumnModified(BrandPeer::RIGHTS_REPRESENTATIVE_ID)) $criteria->add(BrandPeer::RIGHTS_REPRESENTATIVE_ID, $this->rights_representative_id);
		if ($this->isColumnModified(BrandPeer::RIGHTS_REPRESENTATIVE_ADDRESS)) $criteria->add(BrandPeer::RIGHTS_REPRESENTATIVE_ADDRESS, $this->rights_representative_address);
		if ($this->isColumnModified(BrandPeer::OFFICE_OF_ORIGIN)) $criteria->add(BrandPeer::OFFICE_OF_ORIGIN, $this->office_of_origin);
		if ($this->isColumnModified(BrandPeer::DESIGNATED_CONTRACTING_PARTY)) $criteria->add(BrandPeer::DESIGNATED_CONTRACTING_PARTY, $this->designated_contracting_party);
		if ($this->isColumnModified(BrandPeer::IMAGE)) $criteria->add(BrandPeer::IMAGE, $this->image);
		if ($this->isColumnModified(BrandPeer::CREATED_AT)) $criteria->add(BrandPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(BrandPeer::UPDATED_AT)) $criteria->add(BrandPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(BrandPeer::PUBLICATION_STATUS)) $criteria->add(BrandPeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(BrandPeer::DATABASE_NAME);

		$criteria->add(BrandPeer::ID, $this->id);

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

		$copyObj->setClientId($this->client_id);

		$copyObj->setApplicationNumber($this->application_number);

		$copyObj->setApplicationDate($this->application_date);

		$copyObj->setStatus($this->status);

		$copyObj->setRegisterNumber($this->register_number);

		$copyObj->setRegistrationDate($this->registration_date);

		$copyObj->setKind($this->kind);

		$copyObj->setExpiresOn($this->expires_on);

		$copyObj->setViennaClasses($this->vienna_classes);

		$copyObj->setColors($this->colors);

		$copyObj->setNiceClasses($this->nice_classes);

		$copyObj->setRightsOwner($this->rights_owner);

		$copyObj->setRightsOwnerId($this->rights_owner_id);

		$copyObj->setRightsOwnerAddress($this->rights_owner_address);

		$copyObj->setRightsRepresentative($this->rights_representative);

		$copyObj->setRightsRepresentativeId($this->rights_representative_id);

		$copyObj->setRightsRepresentativeAddress($this->rights_representative_address);

		$copyObj->setOfficeOfOrigin($this->office_of_origin);

		$copyObj->setDesignatedContractingParty($this->designated_contracting_party);

		$copyObj->setImage($this->image);

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
			self::$peer = new BrandPeer();
		}
		return self::$peer;
	}

} 