<?php
/**
 * @package    cms
 * @subpackage core website
 * @author     Jordan Hristov / Ilya Popivanov
 */

class websiteCoreActions extends sfActions
{
	protected $pageDocument = null;

	/* MAIN FRONT METHODS */
	public function executeLogo()
	{
		$this->setLayout(false);
	}

	public function executePageGallery()
	{
		$this->setLayout(false);
		$id = $this->getRequestParameter('pageref');
		if ($page = Document::getDocumentInstance($id))
		{
			$this->images = Document::getChildrenOf($id, "Media");
			//$this->galleryLabel = $page->getGalleryLabel();
		}
	}

	public function executeSlider()
	{
		$this->setLayout(false);
		$slides = array();
		for($i=1; $i<=6 ; $i++)
		{
			$s = Document::getDocumentByExclusiveTag('s'.$i);
			if($s) $slides[] = $s;
		}
		$this->news = $slides;
	}

	public function validateContact()
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

	public function handleErrorContact()
	{

		$this->setLayout(false);
		$request = $this->getRequest();
		$this->errors = $request->getErrors();

		UtilsHelper::setFlashMsg('', UtilsHelper::MSG_ERROR);

		return "Success";
	}

	public function executeContact()
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

	public function executeMenu()
	{
		$this->setLayout(false);
	}

/*	public function executeCalendar()
	{
		$this->setLayout(false);
		if($date = $this->getRequestParameter("date"))
		{
			$this->events = null;
			$this->culture = $this->getUser()->getCulture();
			$dateParts = explode("-", $date);
			$this->date = $dateParts[2]."-".$dateParts[1]."-".$dateParts[0];

			$c = new Criteria();
			$c->add(NewsI18nPeer::END_DATE, $this->date."%", Criteria::LIKE);
			$c->add(NewsI18nPeer::CULTURE , $this->culture);
			$this->events = NewsI18nPeer::doSelect($c);
		}
	}*/

	public function executeFlashMsg()
	{
		$this->setLayout(false);
	}

	public function executeLanguageMenu()
	{
		$this->setLayout(false);
/*		$currentPage = Document::getParentOf($this->getRequestParameter("pageref"), "Page");
		$this->lang = $this->getUser()->getCulture();
		$this->cultureItems = Lists::getListitemsForSelect("culture");
		if ($currentPage)
		{
			$this->versions = Document::getChildrenOf($currentPage->getId(), "PageI18n");
		}*/
	}

	public function executeHeader()
	{
		$this->setLayout(false);
	}

	public function executeFooter()
	{
		$this->setLayout(false);
	}

	/* MAIN DISPLAY METHODS */
	public function executeDisplay()
	{
		$parameters = $this->getRequest()->getParameterHolder()->getAll();
		$culture = $this->getUser()->getCulture();
		$user = $this->getUser()->getSubscriber();

		if (isset($parameters['rewriteUrl']))
		{

			if (isset($parameters['pageref']))
			{
				$document = Document::getDocumentInstance($parameters['pageref']);
			}
			else
			{
				if (BackendService::loadUrlRelations())
				{
					if(array_key_exists('urlRelations', $_SESSION) && array_key_exists($parameters['rewriteUrl'], $_SESSION['urlRelations']))
					{
						$documentId = $_SESSION['urlRelations'][$parameters['rewriteUrl']];
						$document = Document::getDocumentInstance($documentId);
					}
				}
				else
				{
					$c = new Criteria();
					$c->add(UrlrewritePeer::LABEL, $parameters['rewriteUrl']);
					$rewriteUrl = UrlrewritePeer::doSelectOne($c);

					/*if ($rewriteUrl && array_key_exists('sf_culture', $parameters))
					{
						$document = Document::getDocumentInstance($rewriteUrl->getPageId());

						if(substr(get_class($document), -4) == "I18n")
						{
							$parent = Document::getParentOf($rewriteUrl->getPageId());
							$document = Document::getDocumentInstance($parent->getId());
						}
					}
					else*/if ($rewriteUrl)
					{
						$document = Document::getDocumentInstance($rewriteUrl->getPageId());
					}
				}
			}

			if (!isset($document))
			{
				$elements = explode("_", substr($parameters['rewriteUrl'], 0, -5));
				$id = array_pop($elements);
				$key = $elements[0];

				if(Document::getStatus($id) == UtilsHelper::STATUS_ACTIVE)
				{
					if ($key == "news")
					{
						if ($document = Document::getDocumentByExclusiveTag("website_page_newslist"))
						{
							$this->getRequest()->setParameter("month", $id);
							$this->getRequest()->setParameter("year", $elements[2]);
							$this->pageTitle = "News - ".$elements[1]." ".$elements[2];
						}
					}
					else
					{
						$rewritedDoc = Document::getDocumentInstance($id);
						if ($rewritedDoc)
						{
							$documentClass = get_class($rewritedDoc);

							if ($document = Document::getDocumentByExclusiveTag("website_page_".$documentClass."_detail"))
							{
								$this->getRequest()->setParameter($documentClass."_id", $id);

								/*if(class_exists($documentClass."I18n"))
									$this->pageTitle = $rewritedDoc->getLabelI18n();
								else*/
									$this->pageTitle = $rewritedDoc->getLabel();
							}
						}
					}
				}
			}
		}
		else
		{
			if (array_key_exists('pageref', $parameters) && is_numeric($parameters['pageref']))
			{
				$document = Document::getDocumentInstance($parameters['pageref']);
			}
			else
			{
				$document = Document::getDocumentByExclusiveTag('website_page_home');
			}
		}

		if (isset($document))
		{
			//$page = Document::getDocumentByCulture($document, $culture);
			//if(Document::getStatus($document->getId()) != UtilsHelper::STATUS_ACTIVE) $this->forward404();
			$page = $document;
			if ($page->getPublicationStatus() != UtilsHelper::STATUS_ACTIVE) $this->forward404();
		}

		if (isset($page) && get_class($page) == "Page")
		{
			//$culture = $pageI18n->getCulture();
			//$this->getUser()->setCulture($culture);
		}
		else
		{
			$page = null;
		}

		if (($page && $page->getIsSecure()) && (!$this->getUser()->isAuthenticated()))
		{
			$page = Document::getDocumentByExclusiveTag('website_page_login');
		}
		$this->pageDocument = $page;

		$this->forward404Unless($page);
		$this->getRequest()->setParameter('pageref', $page->getId());
		$this->getRequest()->setParameter('rewriteUrl', null);

		switch ($page->getPageType())
		{
//			case "ACTIONPAGE": return $this->redirect($page->getActionName());
			case "EXTERNAL"  : return $this->redirect($page->getUrl());
			case "REFERENCE" : $this->redirect(Document::getDocumentInstance($page->getPageId())->getHref()); break;
		}

		if (is_object($user))
		{
			if ($user->getBackend())
			{
				$this->setLayout('editPageContent');
				$this->content = $this->getContent(true);
			}
			else
			{
				$this->content = $this->getContent();
			}
			$this->setResponseParams($user);
		}
		else
		{
			$this->content = $this->getContent();
			$this->setResponseParams();
		}
	}

	private function getContent($backend = false)
	{
		$templateFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->pageDocument->getTemplate().'.xml';
		if (!is_file($templateFile))
		{
			$templateFile = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->pageDocument->getTemplate().'.xml';
		}
		$tags = XMLParser::getXMLdataValues($templateFile, true, true);

		$targets = XMLParser::getTargetsForTemplateBlocks($tags);
		$content = '';
		$processContent = false;
		$freeCnt = 0;

		if ($backend)
		{
			$freeContentStr = 'free content...';
			$richTextStr = 'Click here to edit richtext content...';
		}
		else
		{
			$freeContentStr = '';
		}

		// CREATING PREDEFINED RICHTEXT FIELDS
		if ($this->pageDocument->getContent() === null)
		{
			$richtextCnt = 0;
			$richrextBoxes = '';
			foreach ($tags as $tag)
			{
				if (($tag['tag'] == 'LAYOUT') && ($tag['type'] == 'open'))
				{
					$processContent = true;
					continue;
				}
				if (($tag['tag'] == 'LAYOUT') && ($tag['type'] == 'close'))
				{
					$processContent = false;
					continue;
				}

				if ($processContent)
				{
					if ($tag['type'] == 'complete')
					{
						if ((array_key_exists("attributes", $tag) && array_key_exists('ID', $tag['attributes'])) && isset($targets[$tag['attributes']['ID']]))
						{
							$templateType = $targets[$tag['attributes']['ID']]['type'];
							if ($templateType == 'richtext')
							{
								$richtextCnt++;
								$richrextBoxes .='<block id="richtext'.$richtextCnt.'" target="'.$tag['attributes']["ID"].'" action="richtext"><![CDATA[<p></p>Click here to edit richtext content...<p></p>]]></block>';
							}
						}
					}
				}
			}
			if ($richrextBoxes)
				$richrextBoxes = '<?xml version="1.0" encoding="UTF-8"?><blocks>'.$richrextBoxes.'</blocks>';
			$this->pageDocument->setContent($richrextBoxes);
			$this->pageDocument->save();
		}

		foreach ($tags as $tag)
		{
			if (($tag['tag'] == 'LAYOUT') && ($tag['type'] == 'open'))
			{
				$processContent = true;
				continue;
			}
			if (($tag['tag'] == 'LAYOUT') && ($tag['type'] == 'close'))
			{
				$processContent = false;
				continue;
			}
			if ($processContent)
			{
				if ($tag['type'] == 'open')
				{

					$content .= str_repeat(chr(9), $tag['level'] - 3).'<'.$tag['tag'];
					if(array_key_exists('attributes', $tag))
					{
						foreach ($tag['attributes'] as $key => $val)
						{
							$content .= ' '.strtolower($key).'="'.$val.'"';
						}
					}
					$content .= '>'.chr(10);
				}
				if ($tag['type'] == 'complete')
				{
					$content .= str_repeat(chr(9), $tag['level'] - 3).'<'.$tag['tag'];

					if(array_key_exists("attributes", $tag))
					foreach ($tag['attributes'] as $key => $val)
					{
						$content .= ' '.strtolower($key).'="'.$val.'"';
					}
					$content .= '>'.chr(10);
					//content here
					if ((array_key_exists("attributes", $tag) && array_key_exists('ID', $tag['attributes'])) && isset($targets[$tag['attributes']['ID']]))
					{

						if ($targets[$tag['attributes']['ID']]['type'] != 'free' && $targets[$tag['attributes']['ID']]['type'] != 'richtext')
						{
							$component = explode('/', $targets[$tag['attributes']['ID']]['type']);

							// check if defined BLOCK exists ---> checking if "execute<BlockName>" method exist in <module> class
							$controler = $this->getController();
							if ( $controler->actionExists($component[0], $component[1]))
							{
								// render block params
								if (isset($targets[$tag['attributes']['ID']]['parameters']))
								{
									$arr = array();
									$parameters = explode(' ', $targets[$tag['attributes']['ID']]['parameters']);
									foreach ($parameters as $parameter)
									{
										$param = explode('=', $parameter);
										$arr[$param[0]] = $param[1];
									}
									$this->getRequest()->setParameter('params', $arr);
								}
								$content .= $this->getPresentationFor($component[0], $component[1]);
							}
							else
							{
								$content .= "<br>Block '".$component[0]."/".$component[1]."' doesn't exist!<br>";
							}
						}
						else
						{
							$freeCnt++;
							$blobData = $this->pageDocument->getContent();
							if (!empty($blobData))
							{
								$blockContents = $blobData;

								$blockContentsTags = XMLParser::getXMLdataValues($blockContents, false, false);

								$foundBlock = false;
								foreach ($blockContentsTags as $block)
								{
									if (($block["tag"] == "BLOCK") && ($block['attributes']["TARGET"] == $tag['attributes']['ID']))
									{
										if ($block['attributes']["ACTION"] == "richtext")
										{
											if ($backend)
											{
												if ($block["value"] == '')
												{
													$richTemplate = SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'website'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'richtext.php';
													if (file_exists($richTemplate))
													{
														$block["value"] = file_get_contents($richTemplate);
													}
													else
													{
														$block["value"] = '<p></p>'.$richTextStr.'<p></p>';
													}
												}
												$content .= '<form method="post" action="/admin/website/savePageContent"><input type="hidden" name="id" value="'.$this->pageDocument->getId().'"/><input type="hidden" name="parentBlock" value="'.$block['attributes']["TARGET"].'"/><div id="'.$block['attributes']["ID"].'" class="richtext">'.$block["value"].'</div></form>';
												//$content .= '<form method="post" action="/admin/website/savePageContent"><input type="hidden" name="id" value="'.$this->pageDocument->getId().'"/><input type="hidden" name="parentBlock" value="'.$block['attributes']["TARGET"].'"/><div id="'.$block['attributes']["ID"].'" class="richtext">'.$block["value"].'</div></form>';
											}
											else
											{
												$content .= '<div id="'.$block['attributes']["ID"].'" class="richtext">'.$block["value"].'</div>';
												//$content .= '<div id="'.$block['attributes']["ID"].'" class="richtext">'.$block["value"].'</div>';
											}
										}
										else
										{
											$url = $block['attributes']["ACTION"];
											$action = explode('/', $url);

											// check if defined BLOCK exists ---> checking if "execute<BlockName>" method exist in <module> class
											$controler = $this->getController();
											if ( $controler->actionExists($action[0], $action[1]))
											{
												// render block params
												if (isset($block['attributes']['PARAMETERS']))
												{
													$arr = array();
													$parameters = explode(' ', $block['attributes']['PARAMETERS']);
													foreach ($parameters as $parameter)
													{
														$param = explode('=', $parameter);
														//$arr[$block['attributes']['ID']][$param[0]] = $param[1];
														if(array_key_exists(1, $param)) $arr[$param[0]] = $param[1];
													}
													$this->getRequest()->setParameter('params', $arr);
													//$this->getRequest()->setParameter('paramid', $block['attributes']['ID']);
												}

												$this->getRequest()->setParameter('blockId', $block['attributes']["ID"]);
												$content .= '<div id="'.$block['attributes']["ID"].'" class="free">'.$this->getPresentationFor($action[0], $action[1]).'</div>';
											}
											else
											{
												$content .= '<div id="'.$block['attributes']["ID"].'" class="free">Block '.$action[0].'/'.$action[1].' does not exist!</div>';
											}
										}
										$foundBlock = true;
									}
								}
								if (!$foundBlock)
								{
									$content .= '<div id="new/Block'.$freeCnt.'" class="free">'.$freeContentStr.'</div>';
								}

							}
							else
							{
								$content .= '<div id="new/Block'.$freeCnt.'" class="free">'.$freeContentStr.'</div>';;
							}
						}
					}
					$content .= str_repeat(chr(9), $tag['level'] - 3).'</'.$tag['tag'].'>'.chr(10);
				}
				if ($tag['type'] == 'close') {
					$content .= str_repeat(chr(9), $tag['level'] - 3).'</'.$tag['tag'].'>'.chr(10);
				}
			}
		}

		return $content;
	}

	public function setResponseParams($user = null)
	{
		$response = $this->getResponse();
		
		if($user)
		{
			$backend = $user->getBackend();
			$type = $user->getType();
		}
		else
		{
			$backend = 0;
		}
		// HTTP headers
		//$response->setContentType('text/xhtml');
		//$response->setHttpHeader('Content-Language', 'fr');
		//$response->setStatusCode(403);
		//$response->addVaryHttpHeader('Accept-Language');
		//$response->addCacheControlHttpHeader('no-cache');

		// Cookies
		//$response->setCookie($name, $content, $expire, $path, $domain);

		// Metas and page headers
		//$response->addMeta('robots', 'NONE');
		//echo $this->pageDocument->getMetaKeywords();
		$response->addMeta('keywords', $this->pageDocument->getMetaKeywords());
		$response->addMeta('description', $this->pageDocument->getMetaDescription());
		//$response->addMeta('language', $this->pageDocument->getMetaLanguage());
		if ($this->pageDocument)
		{

			if ($backend && $type == "admin")
			{
				//$response->setCookie('pageId', $this->pageDocument->getId());
				$response->setTitle($this->pageDocument->getId());
			}
			else
			{
				if (!$this->pageTitle) $this->pageTitle = $this->pageDocument->getNavigationTitle();
				$response->setTitle($this->pageTitle);
			}


		}

		$b = Website::getBrowser();

		if (file_exists(SF_ROOT_DIR."/www/css/frontend.css"))
		$response->addStyleSheet("frontend");

		if (file_exists(SF_ROOT_DIR."/www/css/print.css"))
		$response->addStyleSheet("print");

		if (file_exists(SF_ROOT_DIR."/www/css/".$b["browser"].$b['version'].".css"))
		$response->addStyleSheet($b["browser"].$b['version']);
		if (file_exists(SF_ROOT_DIR."/www/css/".$b["browser"].".css") )
		$response->addStyleSheet($b["browser"]);
	}


	public function executeBreadcrumb()
	{
		$this->setLayout(false);

		$pageRef = $this->getRequestParameter('pageref');
		$breadcrumb = Document::getDocumentInstance($pageRef)->getBreadcrumb();

		//print_r ($breadcrumb);
		$bread = array(); $thisExists = false;
		foreach ($breadcrumb as $crumb)
		{
			$item = array();
			$item['id'] = $crumb->getId();

			if (get_class($crumb) == 'Topic')
			{
				/*$href = null;
				$indexPage = $crumb->getIndexPage();
				$itemI18n = Document::getDocumentByCulture($crumb);
				if ($indexPage)
				{
					$href = $indexPage->getHref();
				}
				if ($href)
				{
					$item['href'] = $href;
				}
				$item['label'] = $itemI18n->getNavigationTitle();
				if (!empty($item['label']))
				$bread[] = $item;*/
				continue;
			}

			// if is Page
			if ($pageRef != $item['id'])
			{
				$item['href'] = $crumb->getHref();
			}
			$item['label'] = $crumb->getLabel();
			$bread[] = $item;
			if ($crumb->getId() == $pageRef)
			{
				$thisExists = true;
			}

		}
		if (!$thisExists)
		{
			$item = array();
			$crumb = Document::getDocumentInstance($pageRef);
			$item['id'] = $pageRef;
			$item['label'] = $crumb->getLabel();
			$bread[] = $item;
		}
		$this->breadcrumb = $bread;
		//print_r ($bread);
	}

	public function executeError404()
	{
		/*$uri = substr($_SERVER["REQUEST_URI"], 1);

		if (BackendService::loadUrlRelations())
		{
		if(array_key_exists('urlRelations', $_SESSION) && array_key_exists($uri, $_SESSION['urlRelations']))
		{

		$documentId = $_SESSION['urlRelations'][$uri];
		exit("Doc".$documentId);
		}
		}
		else
		{
		$c = new Criteria();
		$c->add(UrlrewritePeer::LABEL, $uri);
		$rewriteUrl = UrlrewritePeer::doSelectOne($c);

		if ($rewriteUrl) $documentId = $rewriteUrl->getPageId();
		}

		if (isset($documentId))
		{
		$this->getRequest()->setParameter("pageref", $documentId);
		$this->forward("website", "display");
		}*/

		$page404 = Document::getDocumentByExclusiveTag("website_page_404");

		if ($page404)
		{
			$this->redirect($page404->getHref());
		}
		else
		{
			exit("PAGE 404 NOT FOUND, PLEASE DEFINE TAG 'website_page_404' AND TAG A PAGE DOCUMENT");
		}

		/*$uri = substr($_SERVER["REDIRECT_URL"], 1);

		if (BackendService::loadUrlRelations())
		{
		if(array_key_exists('urlRelations', $_SESSION) && array_key_exists($uri, $_SESSION['urlRelations']))
		{
		$documentId = $_SESSION['urlRelations'][$uri];
		}
		else
		{
		$elements = explode("_", substr($uri, 0, -5));
		$id = array_pop($elements);
		$rewritedDoc = Document::getDocumentInstance($id);
		if ($rewritedDoc)
		{
		$documentClass = get_class($rewritedDoc);
		if($document = Document::getDocumentByExclusiveTag("website_page_".$documentClass."_detail"))
		{
		$this->getRequest()->setParameter($documentClass."_id", $id);
		$documentId = $document->getid();
		}
		}
		}
		}
		else
		{
		$c = new Criteria();
		$c->add(UrlrewritePeer::LABEL, $uri);
		$rewriteUrl = UrlrewritePeer::doSelectOne($c);
		if ($rewriteUrl)
		{
		$documentId = $rewriteUrl->getPageId();
		}
		else
		{
		$elements = explode("_", substr($uri, 0, -5));
		$id = array_pop($elements);
		$rewritedDoc = Document::getDocumentInstance($id);
		if ($rewritedDoc)
		{
		$documentClass = get_class($rewritedDoc);
		if($document = Document::getDocumentByExclusiveTag("website_page_".$documentClass."_detail"))
		{
		$this->getRequest()->setParameter($documentClass."_id", $id);
		$documentId = $document->getid();
		}
		}
		}
		}

		if (isset($documentId))
		{
		$this->getRequest()->setParameter("pageref", $documentId);
		$this->forward("website", "display");
		}

		$page404 = Document::getDocumentByExclusiveTag("website_page_404");


		if ($page404)
		{
		$this->redirect($page404->getHref());
		}
		else
		{
		exit("PAGE 404 NOT FOUND, PLEASE DEFINE TAG 'website_page_404' AND TAG A PAGE DOCUMENT");
		}*/
	}

}
