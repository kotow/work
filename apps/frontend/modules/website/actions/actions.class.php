<?php
/**
 * @package    cms
 * @subpackage website
 * @author     Jordan Hristov / Ilya Popivanov
 */

class websiteActions extends websiteCoreActions
{

	public function executeHeader()
	{
		$this->setLayout(false);
	}

	public function executeMainNav()
	{
		$this->setLayout(false);

		$menuItems = array();
		if ($menu = Document::getDocumentByExclusiveTag("website_menu_main"))
		{
			$topics = Document::getChildrenOf($menu->getId(), 'Topic');
			foreach ($topics as $t)
			{
				$pages = Document::getChildrenOf($t->getId(), 'Page');
				foreach ($pages as $p)
				{
					if (Document::hasTag($p, 'website_page_index'))
					{
						$menuItems[$t->getId()] = $p;
						break;
					}
				}
			}
		}
		$this->menuItems = $menuItems;
	}


/*	public function executeSlider()
	{
		$this->setLayout(false);
		$c = new Criteria();
		$items = SlidePeer::doSelect($c);
		$slides = array();
		foreach ($items as $item)
		{
			$gen = Document::getGenericDocument($item);
			if ($gen->getPublicationStatus() == UtilsHelper::STATUS_ACTIVE)
			$slides[] = Document::getDocumentByCulture($item, null, true);
		}
		$this->slides = $slides;
		$this->attractions = Document::getDocumentsByTag("home_attraction");
	}

	public function executeTopHeader()
	{
		$this->setLayout(false);
	}
	
	public function executeContactBlock()
	{
		$this->setLayout(false);
	}

	public function executeRotator()
	{
		$toursTopic = Document::getDocumentByExclusiveTag("tours", false);
		$this->tours = Document::getChildrenOf($toursTopic->getId(), "Page");
		$this->setLayout(false);
	}

	public function executeTopicMenu()
	{
		$this->setLayout(false);
		$pageI18n = Document::getDocumentInstance($this->getRequestParameter('pageref'));
		$page = Document::getParentOf($this->getRequestParameter('pageref'), "Page", false);
		if($page) $topic = Document::getParentOf($page);

		$this->title = $pageI18n->getNavigationTitle();
			
		if($topic && get_class($topic) == "Topic")
		{
			$this->title = $topic->getLabelI18n();
			if($topic) $this->pages = Document::getChildrenOf($topic->getId(),"Page");
		}
	}

	public function executeProjectsList()
	{
		$this->setLayout(false);
		if ($page = Document::getParentOf($this->getRequestParameter('pageref'), "Page", false))
			$topic = Document::getParentOf($page);
		if ($topic && get_class($topic) == "Topic")
		{
			$this->projects = Document::getChildrenOf($topic->getId(), "Page");
		}
	}

	public function executeTopicMenuProjects()
	{
		$this->setLayout(false);

		if ($page = Document::getParentOf($this->getRequestParameter('pageref'), "Page", false))
			$topic = Document::getParentOf($page);
//		if ($topic = Document::getDocumentByExclusiveTag("portfolio"))
		if ($topic && get_class($topic) == "Topic")
		{
			$parentTopic = Document::getParentOf($topic->getId(), null, false);
			if ($t18n = Document::getDocumentByCulture($topic, null, true))
				$this->title = $t18n->getNavigationTitle();
			else
				$this->title = $topic->getLabel();
			if ($parentTopic)
			{
				$topicsArr = Document::getChildrenOf($parentTopic, "Topic");
				$this->topics = $topicsArr;
				$pagesArr = array();
				foreach ($topicsArr as $t)
				{
					$pages = Document::getChildrenOf($t->getId(), "Page");
					foreach ($pages as $p)
					{
						$p18n = Document::getDocumentByCulture($p, null, true);
						$pagesArr[$t->getId()][] = $p18n->getId();
					}
				}
				$this->pages = $pagesArr;
			}
		}
	}

	public function executeProjectDetail()
	{
		$this->setLayout(false);
		$pageref = $this->getRequestParameter("pageref");
		$this->page = Document::getDocumentInstance($pageref);
		$this->images = Document::getChildrenOf($pageref, "Media", false);
	}

	public function executeOtherProjects()
	{
		$this->setLayout(false);

		$currId = $this->getRequestParameter('pageref');
		$pagesArr = null;
		if ($page = Document::getParentOf($currId, "Page", false))
			$topic = Document::getParentOf($page);
		// get parent Topic
		if ($topic && get_class($topic) == "Topic")
		{
			$pages = Document::getChildrenOf($topic->getId(), "Page");
			foreach ($pages as $x)
			{
				if (Document::getStatus($x->getId()) != UtilsHelper::STATUS_ACTIVE) continue;
				if (Document::hasTag($x, 'website_page_index')) continue;
				if ($p = Document::getDocumentByCulture($x, null, true))
				{
					// skip current project (Page)
					if ($p->getId() != $currId)
						$pagesArr[] = $p;
				}
			}
		}
		$this->pages = $pagesArr;
	}

	public function executeMenuService()
	{
		$this->setLayout(false);

		if ($page = Document::getParentOf($this->getRequestParameter('pageref'), "Page", false))
			$topic = Document::getParentOf($page);
		if ($topic && get_class($topic) == "Topic")
		{
			$this->title = $topic->getLabel();
			$this->pages = Document::getChildrenOf($topic->getId(), "Page");
		}
	}

	public function executeServicesList()
	{
		$this->setLayout(false);
		if ($page = Document::getParentOf($this->getRequestParameter('pageref'), "Page", false))
			$topic = Document::getParentOf($page);
		if ($topic && get_class($topic) == "Topic")
		{
			$this->services = Document::getChildrenOf($topic->getId(), "Page");
		}
	}


	public function executeServiceDetail()
	{
		$this->setLayout(false);
		$pageref = $this->getRequestParameter("pageref");
		$this->page = Document::getDocumentInstance($pageref);
		$this->images = Document::getChildrenOf($pageref, "Media", false);
	}

	public function executePromoMenu()
	{
		$this->setLayout(false);
		$page = Document::getParentOf($this->getRequestParameter('pageref'), "Page", false);
		if($page) $topic = Document::getParentOf($page);
		$isPromo = Document::hasTag($topic, "promos_topic");
		if(!$isPromo)
		{
			$topic = Document::getDocumentByExclusiveTag("promos_topic", false);
			if($topic)
				$this->pages = Document::getChildrenOf($topic->getId(), "Page");
		}
	}

	public function executeReserve()
	{
		$this->setLayout(false);
	}

	public function executeHomeBox()
	{
		$this->setLayout(false);
		$this->pages = Document::getDocumentsByTag("show_home");
	}

	public function executeSubfooter()
	{
		$this->setLayout(false);
		$c = new Criteria();
		$c->addDescendingOrderByColumn(NewsI18nPeer::START_DATE);
		$c->add(NewsI18nPeer::CULTURE, $this->getUser()->getCulture());
		$c->setLimit(2);
		$this->news = NewsI18nPeer::doSelect($c);
	}


	public function executeFeatured()
	{
		$this->setLayout(false);
		$this->featured = Document::getDocumentsByTag("featured");
	}

	public function executeSectionOne()
	{
		$this->setLayout(false);
	}

	public function executeLead()
	{
		$this->setLayout(false);
		$page = Document::getDocumentInstance($this->getRequestParameter('pageref'));
		if($page) $this->title = $page->getLabel();
	}

	public function executeMenuOpen()
	{
		$this->setLayout(false);
		$menuTopic= Document::getDocumentByExclusiveTag("menu_topic", false);
		if($menuTopic) $this->pages = Document::getChildrenOf($menuTopic->getId(), "Page");
	}

	public function executeFreeContent()
	{
		$this->setLayout(false);
	}

	public function executeSidebarContent()
	{
		$this->setLayout(false);
	}

	public function executeBackSlider()
	{
		$this->setLayout(false);
	}
	public function executeSidebarLinks()
	{
		$this->setLayout(false);
	}

	public function validateQuote()
	{
		$result = true;
		if($this->getRequestParameter('submitted') == "submitted")
		{
			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll();

			foreach ($params as $key => $param)
			{
				if(!is_array($param))
				{
					${$key} = trim($param);
				}
				else
				{
					${$key} = $param;
				}
			}

			$fields = array(
			"cf_name" => "",
			"cf_email" => "Email",
			"cf_msg" => "",
			"cf_captcha" => "Captcha"
			);

			foreach ($fields as $field => $validator)
			{
				$validatorClass = "";

				$value = $$field;
				if(!$value)
				{
					$request->setError('err'.$field, UtilsHelper::Localize("website.frontend.No-".$field));
					$result = false;
				}
				elseif($validator && $validator != "Captcha")
				{
					$validatorClass ="sf".$validator."Validator";
					$myValidator = new $validatorClass();
					$myValidator->initialize($this->getContext(), array());
					if($validator == "Email" || $validator == "Url") $value = urldecode($value);
					if (!$myValidator->execute($value, $error))
					{
						$request->setError('err'.$field, UtilsHelper::Localize("website.frontend.Wrong-".$field));
						$result = false;
					}
				}
				elseif ($validator == "Captcha")
				{
					$request = $this->getRequest();
					if($this->getUser()->getAttribute('captcha_code') != $value)
					{
						$request->setError('errcaptcha', UtilsHelper::Localize("website.frontend.Wrong-Captcha"));
						$result = false;
					}
				}
			}
		}
		return $result;
	}

	public function handleErrorQuote()
	{

		$this->setLayout(false);
		$request = $this->getRequest();
		$this->errors = $request->getErrors();

		UtilsHelper::setFlashMsg('', UtilsHelper::MSG_ERROR);

		return "Success";
	}

	public function executeQuote()
	{
		//exit(UtilsHelper::Settings("main_email"));
		$this->setLayout(false);
		if ($this->getRequestParameter("submitted") == "submitted")
		{
			$request = $this->getRequest();
			$params = $request->getParameterHolder()->getAll();
			foreach ($params as $key => $param)
			{
				if(!is_array($param))
				{
					${$key} = trim($param);
				}
				else
				{
					${$key} = $param;
				}
			}

			$mail = new sfMail();
			$mail->initialize();
			$mail->setMailer('sendmail');
			$mail->setCharset('utf-8');
			$mail->setContentType('text/html');

			$mail->setFrom($email, $full_name);
			$mail->addAddress(UtilsHelper::Settings("main_email"));

			$mail->setSubject("Съобщение от $cf_name");

			$mail->setSender($cf_email, $cf_name);
			$mail->setFrom($cf_email, $cf_name);
			$mail->addReplyTo($cf_email);

			//$serviceLabel = null;
			//$serviceObj = Document::getDocumentInstance($service);
			//if($serviceObj) $serviceLabel = $serviceObj->getLabel();
			$msg = "";
			$msg .= "Име: ".$cf_name."\n".
			$msg .= "И-Мейл: ".$cf_email."\n";
			//$msg .= "Adress: ".$adress."\n";
			//$msg .= "City: ".$city."\n";
			//$msg .= "Zip Code: ".$zip."\n";
			//$msg .= "State: ".$state."\n";
			//if($home_phone) 	$message .= "Home Phone: ".$home_phone."\n";
			//$msg .= "Cell Phone: ".$cell_phone."\n";
			$msg .= "Съобщение: ".$cf_msg."\n";
			//$msg .= "Date of Opening: ".$date_open."\n";
			//if($date_close) 	$msg .= "Date of Closing: ".$date_close."\n";
			//if($serviceLabel) 	$msg .= "Service: ".$serviceLabel."\n";

			$mail->setBody(nl2br($msg));
			$mail->send();
			//UtilsHelper::setFlashMsg( UtilsHelper::Localize("website.frontend.Sent"), UtilsHelper::MSG_SUCCESS);
			$this->success = true;
		}
	}
*/
}