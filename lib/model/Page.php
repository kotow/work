<?php

/**
 * Subclass for representing a row from the 'm_website_page' table.
 * @package lib.model
 */
class Page extends BasePage
{
	public function save($con = null, $parent = null)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();

			if (!$this->getId())
			{
				$this->setId(Document::getGenericDocument($this)->getId());
			}

			parent::save($con);

			// create relationship
			if (!$parent && !Document::getParentOf($this->getId()))
			{
				$parent = Rootfolder::getRootfolder($this);
			}
			Relation::saveRelation($parent, $this);

			$con->commit();
			Document::cacheObj($this, get_class($this));
			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

	public function delete($con = null)
	{
		try
		{
			$con = Propel::getConnection();
			$con->begin();

			//deletes generic document
			$genericDocument = Document::getGenericDocument($this);
			$genericDocument->delete();

			parent::delete();
			Document::deleteObjCache($this);
			$con->commit();

			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
	}

	public function getHref($absolute = true)
	{
		$protocol = "http://"; $server = '';
		if ($absolute)
		{
			if ($_SERVER['HTTP_HOST'])
			{
				$host = $_SERVER['HTTP_HOST'];
			}
			else
			{
				$website = Document::getDocumentByExclusiveTag("website_website_default");
				if ($website)
				{
					$host = $website->getUrl();
				}
			}

			if (!$host)
			{
				FileHelper::Log("Can not retrieve website URL or HTTP_HOST", UtilsHelper::MSG_ERROR );
			}
			else
			{
				if (substr($host, -1) != "/") $host .= "/";
				if (substr($host, 0, 7) == "http://") $host = substr($host, 7);
				if (substr($host, 0, 8) == "https://") $host = substr($host, 8);
			}
			$server = $protocol.$host;
		}

		if ($this->getPageType() == "CONTENT")
		{
			if ($rewriteUrl = $this->getRewriteUrl())
			{
				return $server.$rewriteUrl;
			}
//			else
//			{
//				return "/website/display/pageref/".$this->getId();
//			}
		}
		else if ($this->getPageType() == "REFERENCE")
		{
			$ref = Document::getDocumentInstance($this->getPageId());
			return $ref->getHref($absolute);
		}
		else if ($this->getPageType() == "EXTERNAL")
		{
				return $this->getUrl();
		}
		if ($absolute)
			return $server."website/display/pageref/".$this->getId();
		else
			return "/website/display/pageref/".$this->getId();
	}

	public function getRewriteUrl()
	{
		$rewriteUrl = Document::getChildrenOf($this->getId(), 'Urlrewrite');
		if (count($rewriteUrl) > 0)
		{
			return $rewriteUrl[0]->getLabel();
		}
		else
		{
			return null;
		}
	}

	public function setRewriteUrl($value)
	{
		try
		{
			if (!$this->getId())
			{
				$this->setId(Document::getGenericDocument($this)->getId());
			}

			$con = Propel::getConnection();
			$con->begin();
//			$rewriteUrl = UrlrewritePeer::retrieveByPk($value);

			$c = new Criteria();
			$c->add(UrlrewritePeer::PAGE_ID, $this->getId());
			$rewriteUrl = UrlrewritePeer::doSelectOne($c);

			//$rewriteUrl = Document::getDocumentInstance($value);
			$value = trim($value);
			if ($rewriteUrl)
			{
				if ($value != '')
				{
					$value = Urlrewrite::checkRewriteUrl($value, $this->getId());
					$rewriteUrl->setLabel($value);
					$rewriteUrl->save(null, $this);
				}
				else
				{
					if ($value == '')
					{
						$rewriteUrl->delete();
					}
				}
			}
			else
			{
				if ($value)
				{
					$value = Urlrewrite::checkRewriteUrl($value, $this->getId());
					$rewriteUrl = new Urlrewrite();
					$rewriteUrl->setLabel($value);
					$rewriteUrl->setPageId($this->getId());
					$rewriteUrl->save(null, $this);
				}
			}
			$con->commit();

			return true;
		}
		catch (Exception $e)
		{
			$con->rollback();
			throw $e;
		}
		return true;
	}

	public function getBreadcrumb()
	{
		$breadcrumb = array();
		$parent = Document::getParentOf($this->getId());
		while ($parent)
		{
			if (get_class($parent) == 'Topic')
			{
				$breadcrumb[] = $parent;
			}
			if (get_class($parent) == 'Menu' || get_class($parent) == 'Website')
			{
				break;
			}
			$parent = Document::getParentOf($parent->getId());
		}
		$breadcrumb[] = Document::getDocumentByExclusiveTag('website_page_home');
		return array_reverse($breadcrumb);
	}

}