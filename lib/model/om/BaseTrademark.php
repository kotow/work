<?php


abstract class BaseTrademark extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $application_number;


	
	protected $register_number;


	
	protected $registration_date;


	
	protected $from_system;


	
	protected $kind;


	
	protected $application_date;


	
	protected $status;


	
	protected $expires_on;


	
	protected $publications;


	
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


	
	protected $contestation;


	
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

	
	public function getFromSystem()
	{

		return $this->from_system;
	}

	
	public function getKind()
	{

		return $this->kind;
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

	
	public function getPublications()
	{

		return $this->publications;
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

	
	public function getContestation($format = 'Y-m-d H:i:s')
	{

		if ($this->contestation === null || $this->contestation === '') {
			return null;
		} elseif (!is_int($this->contestation)) {
						$ts = strtotime($this->contestation);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [contestation] as date/time value: " . var_export($this->contestation, true));
			}
		} else {
			$ts = $this->contestation;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
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
			$this->modifiedColumns[] = TrademarkPeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = TrademarkPeer::LABEL;
		}

	} 
	
	public function setApplicationNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->application_number !== $v) {
			$this->application_number = $v;
			$this->modifiedColumns[] = TrademarkPeer::APPLICATION_NUMBER;
		}

	} 
	
	public function setRegisterNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->register_number !== $v) {
			$this->register_number = $v;
			$this->modifiedColumns[] = TrademarkPeer::REGISTER_NUMBER;
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
			$this->modifiedColumns[] = TrademarkPeer::REGISTRATION_DATE;
		}

	} 
	
	public function setFromSystem($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->from_system !== $v) {
			$this->from_system = $v;
			$this->modifiedColumns[] = TrademarkPeer::FROM_SYSTEM;
		}

	} 
	
	public function setKind($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->kind !== $v) {
			$this->kind = $v;
			$this->modifiedColumns[] = TrademarkPeer::KIND;
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
			$this->modifiedColumns[] = TrademarkPeer::APPLICATION_DATE;
		}

	} 
	
	public function setStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->status !== $v) {
			$this->status = $v;
			$this->modifiedColumns[] = TrademarkPeer::STATUS;
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
			$this->modifiedColumns[] = TrademarkPeer::EXPIRES_ON;
		}

	} 
	
	public function setPublications($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publications !== $v) {
			$this->publications = $v;
			$this->modifiedColumns[] = TrademarkPeer::PUBLICATIONS;
		}

	} 
	
	public function setViennaClasses($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->vienna_classes !== $v) {
			$this->vienna_classes = $v;
			$this->modifiedColumns[] = TrademarkPeer::VIENNA_CLASSES;
		}

	} 
	
	public function setColors($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->colors !== $v) {
			$this->colors = $v;
			$this->modifiedColumns[] = TrademarkPeer::COLORS;
		}

	} 
	
	public function setNiceClasses($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nice_classes !== $v) {
			$this->nice_classes = $v;
			$this->modifiedColumns[] = TrademarkPeer::NICE_CLASSES;
		}

	} 
	
	public function setRightsOwner($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner !== $v) {
			$this->rights_owner = $v;
			$this->modifiedColumns[] = TrademarkPeer::RIGHTS_OWNER;
		}

	} 
	
	public function setRightsOwnerId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner_id !== $v) {
			$this->rights_owner_id = $v;
			$this->modifiedColumns[] = TrademarkPeer::RIGHTS_OWNER_ID;
		}

	} 
	
	public function setRightsOwnerAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_owner_address !== $v) {
			$this->rights_owner_address = $v;
			$this->modifiedColumns[] = TrademarkPeer::RIGHTS_OWNER_ADDRESS;
		}

	} 
	
	public function setRightsRepresentative($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative !== $v) {
			$this->rights_representative = $v;
			$this->modifiedColumns[] = TrademarkPeer::RIGHTS_REPRESENTATIVE;
		}

	} 
	
	public function setRightsRepresentativeId($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative_id !== $v) {
			$this->rights_representative_id = $v;
			$this->modifiedColumns[] = TrademarkPeer::RIGHTS_REPRESENTATIVE_ID;
		}

	} 
	
	public function setRightsRepresentativeAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->rights_representative_address !== $v) {
			$this->rights_representative_address = $v;
			$this->modifiedColumns[] = TrademarkPeer::RIGHTS_REPRESENTATIVE_ADDRESS;
		}

	} 
	
	public function setOfficeOfOrigin($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->office_of_origin !== $v) {
			$this->office_of_origin = $v;
			$this->modifiedColumns[] = TrademarkPeer::OFFICE_OF_ORIGIN;
		}

	} 
	
	public function setDesignatedContractingParty($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->designated_contracting_party !== $v) {
			$this->designated_contracting_party = $v;
			$this->modifiedColumns[] = TrademarkPeer::DESIGNATED_CONTRACTING_PARTY;
		}

	} 
	
	public function setImage($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->image !== $v) {
			$this->image = $v;
			$this->modifiedColumns[] = TrademarkPeer::IMAGE;
		}

	} 
	
	public function setContestation($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [contestation] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->contestation !== $ts) {
			$this->contestation = $ts;
			$this->modifiedColumns[] = TrademarkPeer::CONTESTATION;
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
			$this->modifiedColumns[] = TrademarkPeer::CREATED_AT;
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
			$this->modifiedColumns[] = TrademarkPeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = TrademarkPeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->application_number = $rs->getString($startcol + 2);

			$this->register_number = $rs->getString($startcol + 3);

			$this->registration_date = $rs->getTimestamp($startcol + 4, null);

			$this->from_system = $rs->getInt($startcol + 5);

			$this->kind = $rs->getString($startcol + 6);

			$this->application_date = $rs->getTimestamp($startcol + 7, null);

			$this->status = $rs->getString($startcol + 8);

			$this->expires_on = $rs->getTimestamp($startcol + 9, null);

			$this->publications = $rs->getString($startcol + 10);

			$this->vienna_classes = $rs->getString($startcol + 11);

			$this->colors = $rs->getString($startcol + 12);

			$this->nice_classes = $rs->getString($startcol + 13);

			$this->rights_owner = $rs->getString($startcol + 14);

			$this->rights_owner_id = $rs->getString($startcol + 15);

			$this->rights_owner_address = $rs->getString($startcol + 16);

			$this->rights_representative = $rs->getString($startcol + 17);

			$this->rights_representative_id = $rs->getString($startcol + 18);

			$this->rights_representative_address = $rs->getString($startcol + 19);

			$this->office_of_origin = $rs->getString($startcol + 20);

			$this->designated_contracting_party = $rs->getString($startcol + 21);

			$this->image = $rs->getInt($startcol + 22);

			$this->contestation = $rs->getTimestamp($startcol + 23, null);

			$this->created_at = $rs->getTimestamp($startcol + 24, null);

			$this->updated_at = $rs->getTimestamp($startcol + 25, null);

			$this->publication_status = $rs->getString($startcol + 26);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 27; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Trademark object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TrademarkPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TrademarkPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(TrademarkPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(TrademarkPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TrademarkPeer::DATABASE_NAME);
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
					$pk = TrademarkPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += TrademarkPeer::doUpdate($this, $con);
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


			if (($retval = TrademarkPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TrademarkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getFromSystem();
				break;
			case 6:
				return $this->getKind();
				break;
			case 7:
				return $this->getApplicationDate();
				break;
			case 8:
				return $this->getStatus();
				break;
			case 9:
				return $this->getExpiresOn();
				break;
			case 10:
				return $this->getPublications();
				break;
			case 11:
				return $this->getViennaClasses();
				break;
			case 12:
				return $this->getColors();
				break;
			case 13:
				return $this->getNiceClasses();
				break;
			case 14:
				return $this->getRightsOwner();
				break;
			case 15:
				return $this->getRightsOwnerId();
				break;
			case 16:
				return $this->getRightsOwnerAddress();
				break;
			case 17:
				return $this->getRightsRepresentative();
				break;
			case 18:
				return $this->getRightsRepresentativeId();
				break;
			case 19:
				return $this->getRightsRepresentativeAddress();
				break;
			case 20:
				return $this->getOfficeOfOrigin();
				break;
			case 21:
				return $this->getDesignatedContractingParty();
				break;
			case 22:
				return $this->getImage();
				break;
			case 23:
				return $this->getContestation();
				break;
			case 24:
				return $this->getCreatedAt();
				break;
			case 25:
				return $this->getUpdatedAt();
				break;
			case 26:
				return $this->getPublicationStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TrademarkPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getApplicationNumber(),
			$keys[3] => $this->getRegisterNumber(),
			$keys[4] => $this->getRegistrationDate(),
			$keys[5] => $this->getFromSystem(),
			$keys[6] => $this->getKind(),
			$keys[7] => $this->getApplicationDate(),
			$keys[8] => $this->getStatus(),
			$keys[9] => $this->getExpiresOn(),
			$keys[10] => $this->getPublications(),
			$keys[11] => $this->getViennaClasses(),
			$keys[12] => $this->getColors(),
			$keys[13] => $this->getNiceClasses(),
			$keys[14] => $this->getRightsOwner(),
			$keys[15] => $this->getRightsOwnerId(),
			$keys[16] => $this->getRightsOwnerAddress(),
			$keys[17] => $this->getRightsRepresentative(),
			$keys[18] => $this->getRightsRepresentativeId(),
			$keys[19] => $this->getRightsRepresentativeAddress(),
			$keys[20] => $this->getOfficeOfOrigin(),
			$keys[21] => $this->getDesignatedContractingParty(),
			$keys[22] => $this->getImage(),
			$keys[23] => $this->getContestation(),
			$keys[24] => $this->getCreatedAt(),
			$keys[25] => $this->getUpdatedAt(),
			$keys[26] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TrademarkPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setFromSystem($value);
				break;
			case 6:
				$this->setKind($value);
				break;
			case 7:
				$this->setApplicationDate($value);
				break;
			case 8:
				$this->setStatus($value);
				break;
			case 9:
				$this->setExpiresOn($value);
				break;
			case 10:
				$this->setPublications($value);
				break;
			case 11:
				$this->setViennaClasses($value);
				break;
			case 12:
				$this->setColors($value);
				break;
			case 13:
				$this->setNiceClasses($value);
				break;
			case 14:
				$this->setRightsOwner($value);
				break;
			case 15:
				$this->setRightsOwnerId($value);
				break;
			case 16:
				$this->setRightsOwnerAddress($value);
				break;
			case 17:
				$this->setRightsRepresentative($value);
				break;
			case 18:
				$this->setRightsRepresentativeId($value);
				break;
			case 19:
				$this->setRightsRepresentativeAddress($value);
				break;
			case 20:
				$this->setOfficeOfOrigin($value);
				break;
			case 21:
				$this->setDesignatedContractingParty($value);
				break;
			case 22:
				$this->setImage($value);
				break;
			case 23:
				$this->setContestation($value);
				break;
			case 24:
				$this->setCreatedAt($value);
				break;
			case 25:
				$this->setUpdatedAt($value);
				break;
			case 26:
				$this->setPublicationStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TrademarkPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setApplicationNumber($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setRegisterNumber($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRegistrationDate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFromSystem($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setKind($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setApplicationDate($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setStatus($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setExpiresOn($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setPublications($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setViennaClasses($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setColors($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setNiceClasses($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setRightsOwner($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setRightsOwnerId($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setRightsOwnerAddress($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setRightsRepresentative($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setRightsRepresentativeId($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setRightsRepresentativeAddress($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setOfficeOfOrigin($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setDesignatedContractingParty($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setImage($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setContestation($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setCreatedAt($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setUpdatedAt($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setPublicationStatus($arr[$keys[26]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TrademarkPeer::DATABASE_NAME);

		if ($this->isColumnModified(TrademarkPeer::ID)) $criteria->add(TrademarkPeer::ID, $this->id);
		if ($this->isColumnModified(TrademarkPeer::LABEL)) $criteria->add(TrademarkPeer::LABEL, $this->label);
		if ($this->isColumnModified(TrademarkPeer::APPLICATION_NUMBER)) $criteria->add(TrademarkPeer::APPLICATION_NUMBER, $this->application_number);
		if ($this->isColumnModified(TrademarkPeer::REGISTER_NUMBER)) $criteria->add(TrademarkPeer::REGISTER_NUMBER, $this->register_number);
		if ($this->isColumnModified(TrademarkPeer::REGISTRATION_DATE)) $criteria->add(TrademarkPeer::REGISTRATION_DATE, $this->registration_date);
		if ($this->isColumnModified(TrademarkPeer::FROM_SYSTEM)) $criteria->add(TrademarkPeer::FROM_SYSTEM, $this->from_system);
		if ($this->isColumnModified(TrademarkPeer::KIND)) $criteria->add(TrademarkPeer::KIND, $this->kind);
		if ($this->isColumnModified(TrademarkPeer::APPLICATION_DATE)) $criteria->add(TrademarkPeer::APPLICATION_DATE, $this->application_date);
		if ($this->isColumnModified(TrademarkPeer::STATUS)) $criteria->add(TrademarkPeer::STATUS, $this->status);
		if ($this->isColumnModified(TrademarkPeer::EXPIRES_ON)) $criteria->add(TrademarkPeer::EXPIRES_ON, $this->expires_on);
		if ($this->isColumnModified(TrademarkPeer::PUBLICATIONS)) $criteria->add(TrademarkPeer::PUBLICATIONS, $this->publications);
		if ($this->isColumnModified(TrademarkPeer::VIENNA_CLASSES)) $criteria->add(TrademarkPeer::VIENNA_CLASSES, $this->vienna_classes);
		if ($this->isColumnModified(TrademarkPeer::COLORS)) $criteria->add(TrademarkPeer::COLORS, $this->colors);
		if ($this->isColumnModified(TrademarkPeer::NICE_CLASSES)) $criteria->add(TrademarkPeer::NICE_CLASSES, $this->nice_classes);
		if ($this->isColumnModified(TrademarkPeer::RIGHTS_OWNER)) $criteria->add(TrademarkPeer::RIGHTS_OWNER, $this->rights_owner);
		if ($this->isColumnModified(TrademarkPeer::RIGHTS_OWNER_ID)) $criteria->add(TrademarkPeer::RIGHTS_OWNER_ID, $this->rights_owner_id);
		if ($this->isColumnModified(TrademarkPeer::RIGHTS_OWNER_ADDRESS)) $criteria->add(TrademarkPeer::RIGHTS_OWNER_ADDRESS, $this->rights_owner_address);
		if ($this->isColumnModified(TrademarkPeer::RIGHTS_REPRESENTATIVE)) $criteria->add(TrademarkPeer::RIGHTS_REPRESENTATIVE, $this->rights_representative);
		if ($this->isColumnModified(TrademarkPeer::RIGHTS_REPRESENTATIVE_ID)) $criteria->add(TrademarkPeer::RIGHTS_REPRESENTATIVE_ID, $this->rights_representative_id);
		if ($this->isColumnModified(TrademarkPeer::RIGHTS_REPRESENTATIVE_ADDRESS)) $criteria->add(TrademarkPeer::RIGHTS_REPRESENTATIVE_ADDRESS, $this->rights_representative_address);
		if ($this->isColumnModified(TrademarkPeer::OFFICE_OF_ORIGIN)) $criteria->add(TrademarkPeer::OFFICE_OF_ORIGIN, $this->office_of_origin);
		if ($this->isColumnModified(TrademarkPeer::DESIGNATED_CONTRACTING_PARTY)) $criteria->add(TrademarkPeer::DESIGNATED_CONTRACTING_PARTY, $this->designated_contracting_party);
		if ($this->isColumnModified(TrademarkPeer::IMAGE)) $criteria->add(TrademarkPeer::IMAGE, $this->image);
		if ($this->isColumnModified(TrademarkPeer::CONTESTATION)) $criteria->add(TrademarkPeer::CONTESTATION, $this->contestation);
		if ($this->isColumnModified(TrademarkPeer::CREATED_AT)) $criteria->add(TrademarkPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(TrademarkPeer::UPDATED_AT)) $criteria->add(TrademarkPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(TrademarkPeer::PUBLICATION_STATUS)) $criteria->add(TrademarkPeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TrademarkPeer::DATABASE_NAME);

		$criteria->add(TrademarkPeer::ID, $this->id);

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

		$copyObj->setFromSystem($this->from_system);

		$copyObj->setKind($this->kind);

		$copyObj->setApplicationDate($this->application_date);

		$copyObj->setStatus($this->status);

		$copyObj->setExpiresOn($this->expires_on);

		$copyObj->setPublications($this->publications);

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

		$copyObj->setContestation($this->contestation);

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
			self::$peer = new TrademarkPeer();
		}
		return self::$peer;
	}

} 