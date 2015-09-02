<?php

/*
* This file is part of the symfony package.
* (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPropelPager.class.php 6466 2007-12-11 19:15:51Z fabien $
 */

/**
 *
 * sfPropelPager class.
 *
 * @package    symfony
 * @subpackage addon
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfPropelPager.class.php 6466 2007-12-11 19:15:51Z fabien $
 */
class sfPropelPager extends sfPager
{
	protected
	$criteria               = null,
	$results                = null,
	$offset                 = 0,
	$limit	                = 0,
	$runCriteria 			= true,
	$peer_method_name       = 'doSelect',
	$peer_count_method_name = 'doCount';

	public function __construct($class, $maxPerPage = 10)
	{
		parent::__construct($class, $maxPerPage);

		$this->setCriteria(new Criteria());
		$this->tableName = constant($class.'Peer::TABLE_NAME');
	}

	public function init()
	{
		$hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
		$maxRecordLimit = $this->getMaxRecordLimit();

		if(!$this->results)
		{
			$cForCount = clone $this->getCriteria();
			$cForCount->setOffset(0);
			$cForCount->setLimit(0);
			$cForCount->clearGroupByColumns();
		}

		// require the model class (because autoloading can crash under some conditions)
		if (!$classPath = sfCore::getClassPath($this->getClassPeer()))
		{
			throw new sfException(sprintf('Unable to find path for class "%s".', $this->getClassPeer()));
		}

		require_once($classPath);

		$count = count($this->getResults(true));

		$this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);


		if(!$this->results)
		{
			$c = $this->getCriteria();
			$c->setOffset(0);
			$c->setLimit(0);
		}
		else
		{
			$this->offset = 0;
			$this->limit = 0;
		}

		if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
		{
			$this->setLastPage(0);
		}
		else
		{
			$this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));
			$offset = ($this->getPage() - 1) * $this->getMaxPerPage();
			$this->offset = $offset;
			
			if($c) $c->setOffset($this->offset);

			if ($hasMaxRecordLimit)
			{
				$maxRecordLimit = $maxRecordLimit - $offset;
				if ($maxRecordLimit > $this->getMaxPerPage())
				{
					if($c) $c->setLimit($this->getMaxPerPage());
					$this->limit = $this->getMaxPerPage();
				}
				else
				{
					if($c) $c->setLimit($maxRecordLimit);
					$this->limit = $maxRecordLimit;
				}
			}
			else
			{
				if($c) $c->setLimit($this->getMaxPerPage());
				$this->limit = $this->getMaxPerPage();
			}
		}
		
	}

	protected function retrieveObject($offset)
	{
		if(!$this->results)
		{
			$cForRetrieve = clone $this->getCriteria();
			$cForRetrieve->setOffset($offset - 1);
			$cForRetrieve->setLimit(1);
	
			$results = call_user_func(array($this->getClassPeer(), $this->getPeerMethod()), $cForRetrieve);
	
			return is_array($results) && isset($results[0]) ? $results[0] : null;
		}
		else
		{
			return $this->results[$offset];
		}
	}

	public function getResults($init = false)
	{
		if(!$this->results && $this->runCriteria)
		{
			$c = $this->getCriteria();
			return call_user_func(array($this->getClassPeer(), $this->getPeerMethod()), $c);
		}
		else
		{
			if ($init)
			{
				return $this->results;
			}
			$res = array_slice($this->results, $this->offset, $this->limit);
			return $res;
		}
	}

	public function setResults($results)
	{
		$this->runCriteria = false;
		$this->results = $results;
	}

	public function getPeerMethod()
	{
		return $this->peer_method_name;
	}

	public function setPeerMethod($peer_method_name)
	{
		$this->peer_method_name = $peer_method_name;
	}

	public function getPeerCountMethod()
	{
		return $this->peer_count_method_name;
	}

	public function setPeerCountMethod($peer_count_method_name)
	{
		$this->peer_count_method_name = $peer_count_method_name;
	}

	public function getClassPeer()
	{
		return $this->class.'Peer';
	}
}