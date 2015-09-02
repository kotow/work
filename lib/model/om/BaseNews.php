<?php


abstract class BaseNews extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $short_description;


	
	protected $image;


	
	protected $download;


	
	protected $content;


	
	protected $start_date;


	
	protected $end_date;


	
	protected $rds;


	
	protected $keywords;


	
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

	
	public function getShortDescription()
	{

		return $this->short_description;
	}

	
	public function getImage()
	{

		return $this->image;
	}

	
	public function getDownload()
	{

		return $this->download;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getStartDate($format = 'Y-m-d H:i:s')
	{

		if ($this->start_date === null || $this->start_date === '') {
			return null;
		} elseif (!is_int($this->start_date)) {
						$ts = strtotime($this->start_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [start_date] as date/time value: " . var_export($this->start_date, true));
			}
		} else {
			$ts = $this->start_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getEndDate($format = 'Y-m-d H:i:s')
	{

		if ($this->end_date === null || $this->end_date === '') {
			return null;
		} elseif (!is_int($this->end_date)) {
						$ts = strtotime($this->end_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [end_date] as date/time value: " . var_export($this->end_date, true));
			}
		} else {
			$ts = $this->end_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getRds()
	{

		return $this->rds;
	}

	
	public function getKeywords()
	{

		return $this->keywords;
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
			$this->modifiedColumns[] = NewsPeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = NewsPeer::LABEL;
		}

	} 
	
	public function setShortDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->short_description !== $v) {
			$this->short_description = $v;
			$this->modifiedColumns[] = NewsPeer::SHORT_DESCRIPTION;
		}

	} 
	
	public function setImage($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->image !== $v) {
			$this->image = $v;
			$this->modifiedColumns[] = NewsPeer::IMAGE;
		}

	} 
	
	public function setDownload($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->download !== $v) {
			$this->download = $v;
			$this->modifiedColumns[] = NewsPeer::DOWNLOAD;
		}

	} 
	
	public function setContent($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = NewsPeer::CONTENT;
		}

	} 
	
	public function setStartDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [start_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->start_date !== $ts) {
			$this->start_date = $ts;
			$this->modifiedColumns[] = NewsPeer::START_DATE;
		}

	} 
	
	public function setEndDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [end_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->end_date !== $ts) {
			$this->end_date = $ts;
			$this->modifiedColumns[] = NewsPeer::END_DATE;
		}

	} 
	
	public function setRds($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->rds !== $v) {
			$this->rds = $v;
			$this->modifiedColumns[] = NewsPeer::RDS;
		}

	} 
	
	public function setKeywords($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->keywords !== $v) {
			$this->keywords = $v;
			$this->modifiedColumns[] = NewsPeer::KEYWORDS;
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
			$this->modifiedColumns[] = NewsPeer::CREATED_AT;
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
			$this->modifiedColumns[] = NewsPeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = NewsPeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->short_description = $rs->getString($startcol + 2);

			$this->image = $rs->getInt($startcol + 3);

			$this->download = $rs->getInt($startcol + 4);

			$this->content = $rs->getString($startcol + 5);

			$this->start_date = $rs->getTimestamp($startcol + 6, null);

			$this->end_date = $rs->getTimestamp($startcol + 7, null);

			$this->rds = $rs->getInt($startcol + 8);

			$this->keywords = $rs->getString($startcol + 9);

			$this->created_at = $rs->getTimestamp($startcol + 10, null);

			$this->updated_at = $rs->getTimestamp($startcol + 11, null);

			$this->publication_status = $rs->getString($startcol + 12);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 13; 
		} catch (Exception $e) {
			throw new PropelException("Error populating News object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(NewsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			NewsPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(NewsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(NewsPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(NewsPeer::DATABASE_NAME);
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
					$pk = NewsPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += NewsPeer::doUpdate($this, $con);
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


			if (($retval = NewsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NewsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getShortDescription();
				break;
			case 3:
				return $this->getImage();
				break;
			case 4:
				return $this->getDownload();
				break;
			case 5:
				return $this->getContent();
				break;
			case 6:
				return $this->getStartDate();
				break;
			case 7:
				return $this->getEndDate();
				break;
			case 8:
				return $this->getRds();
				break;
			case 9:
				return $this->getKeywords();
				break;
			case 10:
				return $this->getCreatedAt();
				break;
			case 11:
				return $this->getUpdatedAt();
				break;
			case 12:
				return $this->getPublicationStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NewsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getShortDescription(),
			$keys[3] => $this->getImage(),
			$keys[4] => $this->getDownload(),
			$keys[5] => $this->getContent(),
			$keys[6] => $this->getStartDate(),
			$keys[7] => $this->getEndDate(),
			$keys[8] => $this->getRds(),
			$keys[9] => $this->getKeywords(),
			$keys[10] => $this->getCreatedAt(),
			$keys[11] => $this->getUpdatedAt(),
			$keys[12] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NewsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setShortDescription($value);
				break;
			case 3:
				$this->setImage($value);
				break;
			case 4:
				$this->setDownload($value);
				break;
			case 5:
				$this->setContent($value);
				break;
			case 6:
				$this->setStartDate($value);
				break;
			case 7:
				$this->setEndDate($value);
				break;
			case 8:
				$this->setRds($value);
				break;
			case 9:
				$this->setKeywords($value);
				break;
			case 10:
				$this->setCreatedAt($value);
				break;
			case 11:
				$this->setUpdatedAt($value);
				break;
			case 12:
				$this->setPublicationStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NewsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setShortDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setImage($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDownload($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setContent($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setStartDate($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setEndDate($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setRds($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setKeywords($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedAt($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUpdatedAt($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPublicationStatus($arr[$keys[12]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(NewsPeer::DATABASE_NAME);

		if ($this->isColumnModified(NewsPeer::ID)) $criteria->add(NewsPeer::ID, $this->id);
		if ($this->isColumnModified(NewsPeer::LABEL)) $criteria->add(NewsPeer::LABEL, $this->label);
		if ($this->isColumnModified(NewsPeer::SHORT_DESCRIPTION)) $criteria->add(NewsPeer::SHORT_DESCRIPTION, $this->short_description);
		if ($this->isColumnModified(NewsPeer::IMAGE)) $criteria->add(NewsPeer::IMAGE, $this->image);
		if ($this->isColumnModified(NewsPeer::DOWNLOAD)) $criteria->add(NewsPeer::DOWNLOAD, $this->download);
		if ($this->isColumnModified(NewsPeer::CONTENT)) $criteria->add(NewsPeer::CONTENT, $this->content);
		if ($this->isColumnModified(NewsPeer::START_DATE)) $criteria->add(NewsPeer::START_DATE, $this->start_date);
		if ($this->isColumnModified(NewsPeer::END_DATE)) $criteria->add(NewsPeer::END_DATE, $this->end_date);
		if ($this->isColumnModified(NewsPeer::RDS)) $criteria->add(NewsPeer::RDS, $this->rds);
		if ($this->isColumnModified(NewsPeer::KEYWORDS)) $criteria->add(NewsPeer::KEYWORDS, $this->keywords);
		if ($this->isColumnModified(NewsPeer::CREATED_AT)) $criteria->add(NewsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(NewsPeer::UPDATED_AT)) $criteria->add(NewsPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(NewsPeer::PUBLICATION_STATUS)) $criteria->add(NewsPeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(NewsPeer::DATABASE_NAME);

		$criteria->add(NewsPeer::ID, $this->id);

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

		$copyObj->setShortDescription($this->short_description);

		$copyObj->setImage($this->image);

		$copyObj->setDownload($this->download);

		$copyObj->setContent($this->content);

		$copyObj->setStartDate($this->start_date);

		$copyObj->setEndDate($this->end_date);

		$copyObj->setRds($this->rds);

		$copyObj->setKeywords($this->keywords);

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
			self::$peer = new NewsPeer();
		}
		return self::$peer;
	}

} 