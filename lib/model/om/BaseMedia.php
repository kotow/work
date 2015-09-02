<?php


abstract class BaseMedia extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $description;


	
	protected $filename;


	
	protected $filedirpath;


	
	protected $filetype;


	
	protected $filesize;


	
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

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getFilename()
	{

		return $this->filename;
	}

	
	public function getFiledirpath()
	{

		return $this->filedirpath;
	}

	
	public function getFiletype()
	{

		return $this->filetype;
	}

	
	public function getFilesize()
	{

		return $this->filesize;
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
			$this->modifiedColumns[] = MediaPeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = MediaPeer::LABEL;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = MediaPeer::DESCRIPTION;
		}

	} 
	
	public function setFilename($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filename !== $v) {
			$this->filename = $v;
			$this->modifiedColumns[] = MediaPeer::FILENAME;
		}

	} 
	
	public function setFiledirpath($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filedirpath !== $v) {
			$this->filedirpath = $v;
			$this->modifiedColumns[] = MediaPeer::FILEDIRPATH;
		}

	} 
	
	public function setFiletype($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->filetype !== $v) {
			$this->filetype = $v;
			$this->modifiedColumns[] = MediaPeer::FILETYPE;
		}

	} 
	
	public function setFilesize($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->filesize !== $v) {
			$this->filesize = $v;
			$this->modifiedColumns[] = MediaPeer::FILESIZE;
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
			$this->modifiedColumns[] = MediaPeer::CREATED_AT;
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
			$this->modifiedColumns[] = MediaPeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = MediaPeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->description = $rs->getString($startcol + 2);

			$this->filename = $rs->getString($startcol + 3);

			$this->filedirpath = $rs->getString($startcol + 4);

			$this->filetype = $rs->getString($startcol + 5);

			$this->filesize = $rs->getInt($startcol + 6);

			$this->created_at = $rs->getTimestamp($startcol + 7, null);

			$this->updated_at = $rs->getTimestamp($startcol + 8, null);

			$this->publication_status = $rs->getString($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Media object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MediaPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			MediaPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(MediaPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(MediaPeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(MediaPeer::DATABASE_NAME);
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
					$pk = MediaPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += MediaPeer::doUpdate($this, $con);
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


			if (($retval = MediaPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MediaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDescription();
				break;
			case 3:
				return $this->getFilename();
				break;
			case 4:
				return $this->getFiledirpath();
				break;
			case 5:
				return $this->getFiletype();
				break;
			case 6:
				return $this->getFilesize();
				break;
			case 7:
				return $this->getCreatedAt();
				break;
			case 8:
				return $this->getUpdatedAt();
				break;
			case 9:
				return $this->getPublicationStatus();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MediaPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getDescription(),
			$keys[3] => $this->getFilename(),
			$keys[4] => $this->getFiledirpath(),
			$keys[5] => $this->getFiletype(),
			$keys[6] => $this->getFilesize(),
			$keys[7] => $this->getCreatedAt(),
			$keys[8] => $this->getUpdatedAt(),
			$keys[9] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = MediaPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDescription($value);
				break;
			case 3:
				$this->setFilename($value);
				break;
			case 4:
				$this->setFiledirpath($value);
				break;
			case 5:
				$this->setFiletype($value);
				break;
			case 6:
				$this->setFilesize($value);
				break;
			case 7:
				$this->setCreatedAt($value);
				break;
			case 8:
				$this->setUpdatedAt($value);
				break;
			case 9:
				$this->setPublicationStatus($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = MediaPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFilename($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFiledirpath($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setFiletype($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setFilesize($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUpdatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPublicationStatus($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(MediaPeer::DATABASE_NAME);

		if ($this->isColumnModified(MediaPeer::ID)) $criteria->add(MediaPeer::ID, $this->id);
		if ($this->isColumnModified(MediaPeer::LABEL)) $criteria->add(MediaPeer::LABEL, $this->label);
		if ($this->isColumnModified(MediaPeer::DESCRIPTION)) $criteria->add(MediaPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(MediaPeer::FILENAME)) $criteria->add(MediaPeer::FILENAME, $this->filename);
		if ($this->isColumnModified(MediaPeer::FILEDIRPATH)) $criteria->add(MediaPeer::FILEDIRPATH, $this->filedirpath);
		if ($this->isColumnModified(MediaPeer::FILETYPE)) $criteria->add(MediaPeer::FILETYPE, $this->filetype);
		if ($this->isColumnModified(MediaPeer::FILESIZE)) $criteria->add(MediaPeer::FILESIZE, $this->filesize);
		if ($this->isColumnModified(MediaPeer::CREATED_AT)) $criteria->add(MediaPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(MediaPeer::UPDATED_AT)) $criteria->add(MediaPeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(MediaPeer::PUBLICATION_STATUS)) $criteria->add(MediaPeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(MediaPeer::DATABASE_NAME);

		$criteria->add(MediaPeer::ID, $this->id);

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

		$copyObj->setDescription($this->description);

		$copyObj->setFilename($this->filename);

		$copyObj->setFiledirpath($this->filedirpath);

		$copyObj->setFiletype($this->filetype);

		$copyObj->setFilesize($this->filesize);

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
			self::$peer = new MediaPeer();
		}
		return self::$peer;
	}

} 