<?php


abstract class BasePage extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $label;


	
	protected $page_type;


	
	protected $navigation_title;


	
	protected $meta_description;


	
	protected $meta_keywords;


	
	protected $image;


	
	protected $template;


	
	protected $content;


	
	protected $page_id;


	
	protected $url;


	
	protected $description;


	
	protected $is_secure;


	
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

	
	public function getPageType()
	{

		return $this->page_type;
	}

	
	public function getNavigationTitle()
	{

		return $this->navigation_title;
	}

	
	public function getMetaDescription()
	{

		return $this->meta_description;
	}

	
	public function getMetaKeywords()
	{

		return $this->meta_keywords;
	}

	
	public function getImage()
	{

		return $this->image;
	}

	
	public function getTemplate()
	{

		return $this->template;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getPageId()
	{

		return $this->page_id;
	}

	
	public function getUrl()
	{

		return $this->url;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getIsSecure()
	{

		return $this->is_secure;
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
			$this->modifiedColumns[] = PagePeer::ID;
		}

	} 
	
	public function setLabel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = PagePeer::LABEL;
		}

	} 
	
	public function setPageType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->page_type !== $v) {
			$this->page_type = $v;
			$this->modifiedColumns[] = PagePeer::PAGE_TYPE;
		}

	} 
	
	public function setNavigationTitle($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->navigation_title !== $v) {
			$this->navigation_title = $v;
			$this->modifiedColumns[] = PagePeer::NAVIGATION_TITLE;
		}

	} 
	
	public function setMetaDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->meta_description !== $v) {
			$this->meta_description = $v;
			$this->modifiedColumns[] = PagePeer::META_DESCRIPTION;
		}

	} 
	
	public function setMetaKeywords($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->meta_keywords !== $v) {
			$this->meta_keywords = $v;
			$this->modifiedColumns[] = PagePeer::META_KEYWORDS;
		}

	} 
	
	public function setImage($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->image !== $v) {
			$this->image = $v;
			$this->modifiedColumns[] = PagePeer::IMAGE;
		}

	} 
	
	public function setTemplate($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->template !== $v) {
			$this->template = $v;
			$this->modifiedColumns[] = PagePeer::TEMPLATE;
		}

	} 
	
	public function setContent($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = PagePeer::CONTENT;
		}

	} 
	
	public function setPageId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->page_id !== $v) {
			$this->page_id = $v;
			$this->modifiedColumns[] = PagePeer::PAGE_ID;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = PagePeer::URL;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = PagePeer::DESCRIPTION;
		}

	} 
	
	public function setIsSecure($v)
	{

		if ($this->is_secure !== $v) {
			$this->is_secure = $v;
			$this->modifiedColumns[] = PagePeer::IS_SECURE;
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
			$this->modifiedColumns[] = PagePeer::CREATED_AT;
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
			$this->modifiedColumns[] = PagePeer::UPDATED_AT;
		}

	} 
	
	public function setPublicationStatus($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->publication_status !== $v) {
			$this->publication_status = $v;
			$this->modifiedColumns[] = PagePeer::PUBLICATION_STATUS;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->label = $rs->getString($startcol + 1);

			$this->page_type = $rs->getString($startcol + 2);

			$this->navigation_title = $rs->getString($startcol + 3);

			$this->meta_description = $rs->getString($startcol + 4);

			$this->meta_keywords = $rs->getString($startcol + 5);

			$this->image = $rs->getInt($startcol + 6);

			$this->template = $rs->getString($startcol + 7);

			$this->content = $rs->getString($startcol + 8);

			$this->page_id = $rs->getInt($startcol + 9);

			$this->url = $rs->getString($startcol + 10);

			$this->description = $rs->getString($startcol + 11);

			$this->is_secure = $rs->getBoolean($startcol + 12);

			$this->created_at = $rs->getTimestamp($startcol + 13, null);

			$this->updated_at = $rs->getTimestamp($startcol + 14, null);

			$this->publication_status = $rs->getString($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Page object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PagePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			PagePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(PagePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

    if ($this->isModified() && !$this->isColumnModified(PagePeer::UPDATED_AT))
    {
      $this->setUpdatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(PagePeer::DATABASE_NAME);
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
					$pk = PagePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += PagePeer::doUpdate($this, $con);
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


			if (($retval = PagePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getPageType();
				break;
			case 3:
				return $this->getNavigationTitle();
				break;
			case 4:
				return $this->getMetaDescription();
				break;
			case 5:
				return $this->getMetaKeywords();
				break;
			case 6:
				return $this->getImage();
				break;
			case 7:
				return $this->getTemplate();
				break;
			case 8:
				return $this->getContent();
				break;
			case 9:
				return $this->getPageId();
				break;
			case 10:
				return $this->getUrl();
				break;
			case 11:
				return $this->getDescription();
				break;
			case 12:
				return $this->getIsSecure();
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
		$keys = PagePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getPageType(),
			$keys[3] => $this->getNavigationTitle(),
			$keys[4] => $this->getMetaDescription(),
			$keys[5] => $this->getMetaKeywords(),
			$keys[6] => $this->getImage(),
			$keys[7] => $this->getTemplate(),
			$keys[8] => $this->getContent(),
			$keys[9] => $this->getPageId(),
			$keys[10] => $this->getUrl(),
			$keys[11] => $this->getDescription(),
			$keys[12] => $this->getIsSecure(),
			$keys[13] => $this->getCreatedAt(),
			$keys[14] => $this->getUpdatedAt(),
			$keys[15] => $this->getPublicationStatus(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = PagePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setPageType($value);
				break;
			case 3:
				$this->setNavigationTitle($value);
				break;
			case 4:
				$this->setMetaDescription($value);
				break;
			case 5:
				$this->setMetaKeywords($value);
				break;
			case 6:
				$this->setImage($value);
				break;
			case 7:
				$this->setTemplate($value);
				break;
			case 8:
				$this->setContent($value);
				break;
			case 9:
				$this->setPageId($value);
				break;
			case 10:
				$this->setUrl($value);
				break;
			case 11:
				$this->setDescription($value);
				break;
			case 12:
				$this->setIsSecure($value);
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
		$keys = PagePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPageType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNavigationTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setMetaDescription($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMetaKeywords($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setImage($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setTemplate($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setContent($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPageId($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUrl($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDescription($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setIsSecure($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setCreatedAt($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUpdatedAt($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setPublicationStatus($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(PagePeer::DATABASE_NAME);

		if ($this->isColumnModified(PagePeer::ID)) $criteria->add(PagePeer::ID, $this->id);
		if ($this->isColumnModified(PagePeer::LABEL)) $criteria->add(PagePeer::LABEL, $this->label);
		if ($this->isColumnModified(PagePeer::PAGE_TYPE)) $criteria->add(PagePeer::PAGE_TYPE, $this->page_type);
		if ($this->isColumnModified(PagePeer::NAVIGATION_TITLE)) $criteria->add(PagePeer::NAVIGATION_TITLE, $this->navigation_title);
		if ($this->isColumnModified(PagePeer::META_DESCRIPTION)) $criteria->add(PagePeer::META_DESCRIPTION, $this->meta_description);
		if ($this->isColumnModified(PagePeer::META_KEYWORDS)) $criteria->add(PagePeer::META_KEYWORDS, $this->meta_keywords);
		if ($this->isColumnModified(PagePeer::IMAGE)) $criteria->add(PagePeer::IMAGE, $this->image);
		if ($this->isColumnModified(PagePeer::TEMPLATE)) $criteria->add(PagePeer::TEMPLATE, $this->template);
		if ($this->isColumnModified(PagePeer::CONTENT)) $criteria->add(PagePeer::CONTENT, $this->content);
		if ($this->isColumnModified(PagePeer::PAGE_ID)) $criteria->add(PagePeer::PAGE_ID, $this->page_id);
		if ($this->isColumnModified(PagePeer::URL)) $criteria->add(PagePeer::URL, $this->url);
		if ($this->isColumnModified(PagePeer::DESCRIPTION)) $criteria->add(PagePeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(PagePeer::IS_SECURE)) $criteria->add(PagePeer::IS_SECURE, $this->is_secure);
		if ($this->isColumnModified(PagePeer::CREATED_AT)) $criteria->add(PagePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(PagePeer::UPDATED_AT)) $criteria->add(PagePeer::UPDATED_AT, $this->updated_at);
		if ($this->isColumnModified(PagePeer::PUBLICATION_STATUS)) $criteria->add(PagePeer::PUBLICATION_STATUS, $this->publication_status);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(PagePeer::DATABASE_NAME);

		$criteria->add(PagePeer::ID, $this->id);

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

		$copyObj->setPageType($this->page_type);

		$copyObj->setNavigationTitle($this->navigation_title);

		$copyObj->setMetaDescription($this->meta_description);

		$copyObj->setMetaKeywords($this->meta_keywords);

		$copyObj->setImage($this->image);

		$copyObj->setTemplate($this->template);

		$copyObj->setContent($this->content);

		$copyObj->setPageId($this->page_id);

		$copyObj->setUrl($this->url);

		$copyObj->setDescription($this->description);

		$copyObj->setIsSecure($this->is_secure);

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
			self::$peer = new PagePeer();
		}
		return self::$peer;
	}

} 