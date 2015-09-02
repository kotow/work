<?php
/**
 * @package    cms
 * @subpackage core newsletter
 * @author     Jordan Hristov / Ilya Popivanov
 */

class newsletterCoreActions extends sfActions
{
	public function validateUnsubscribe()
	{
		if($this->getRequestParameter("codeid"))
		{
			return true;
		}

		$result = true;

		if ($this->getRequestParameter('unsubscribeMail'))
		{
			$email = trim($this->getRequestParameter('unsubscribeMail'));
			if ($email == "")
			{
				$this->getRequest()->setError('unsubscribe_email', "Please enter your email");
				$result = false;
			}
			else
			{
				$myValidator = new sfEmailValidator();
				$myValidator->initialize($this->getContext(), array());

				if (!$myValidator->execute(urldecode($email), $error))
				{
					$this->getRequest()->setError('unsubscribe_email', "Please enter your email");
					$result = false;
				}
				else
				{
					$c = new Criteria();
					$c->add(SubscriberPeer::EMAIL, $email);
					$c->add(SubscriberPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
					$this->user = SubscriberPeer::doSelectOne($c);

					if (!$this->user)
					{
						$this->getRequest()->setError('unsubscribe_email', "No such email");
						$result = false;
					}
				}
			}
		}
		return $result;
	}

	public function handleErrorUnsubscribe()
	{
		$this->setLayout(false);
		return "Success";
	}

	public function executeUnsubscribe()
	{
		$this->setLayout(false);
		if($code = $this->getRequestParameter("codeid"))
		{
			try
			{
				$c = new Criteria();
				$c->add(SubscriberPeer::CODE, $code);
				$c->add(SubscriberPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
				$user = SubscriberPeer::doSelectOne($c);

				if (!$user)
				{
					$this->getRequest()->setError('unsubscribe_email', "A problem occured");
				}
				else
				{

					$user->setPublicationStatus(UtilsHelper::STATUS_WAITING);
					$user->save();
					$this->msg = "<br><br><b>Unsubscribtion successfull</b>";

					$subject = "Unsubscribtion";

					/*$mail = new sfMail();
					$mail->initialize();
					$mail->setMailer('sendmail');
					$mail->setCharset('utf-8');
					$mail->setSender(UtilsHelper::NO_REPLY_MAIL , '');
					$mail->setFrom(UtilsHelper::NO_REPLY_MAIL, '');
					$mail->addAddress(UtilsHelper::SYSTEM_MAIL );
					$mail->setContentType('text/html');
					$mail->setSubject($subject);
					$mail->setBody("User: <b>".$user->getLabel()."</b> ( email: <b>".$user->getEmail()."</b> unsubscribed");
					$mail->send();*/

					$mail2 = new sfMail();
					$mail2->initialize();
					$mail2->setMailer('sendmail');
					$mail2->setCharset('utf-8');
					$mail2->setSender(UtilsHelper::NO_REPLY_MAIL  , '');
					$mail2->setFrom(UtilsHelper::NO_REPLY_MAIL , '');
					$mail2->addAddress($user->getEmail());
					$mail2->setContentType('text/html');
					$mail2->setSubject($subject);
					$mail2->setBody("Successfully unsubsribed");
					$mail2->send();
				}

			}
			catch (Exception $e)
			{
				$this->getRequest()->setError('unsubscribe_email', "A problem occured");
				FileHelper::Log("newsletter/executeUnsubscribe error:".$e->getMessage(), UtilsHelper::MSG_ERROR);
			}
		}
		else
		{
			if($unsubscribeMail = $this->getRequestParameter("unsubscribeMail"))
			{
				try
				{
					if($this->user)
					{

						$code = $this->user->getCode();
						if(empty($code)) $code = md5(time());
						$this->user->setCode($code);
						$this->user->save();

						$mail = new sfMail();
						$mail->initialize();
						$mail->setMailer('sendmail');
						$mail->setCharset('utf-8');
						$mail->setSender(UtilsHelper::NO_REPLY_MAIL , '');
						$mail->setFrom(UtilsHelper::NO_REPLY_MAIL, '');
						$mail->addAddress($this->user->getEmail());
						$mail->setContentType('text/html');
						$mail->setSubject("Usubscribtion");
						$unsubscribePage = Document::getDocumentByExclusiveTag('website_page_newsletter_unsubscribe');
						if ($unsubscribePage)
						{
							$this->unsubscribePageUrl = $unsubscribePage->getHref();
						}

						$request = $this->getRequest();
						$request->setParameter('unsubscribePageUrl', $this->unsubscribePageUrl."?codeid=".$code);

						$body = $this->getPresentationFor("newsletter", "unsubscribeRequestMail");
						$mail->setBody($body);
						$mail->send();
						$this->msg = "Link sent";
					}
				}
				catch (Exception $e)
				{
					$this->msg = "A probleme occured";
					FileHelper::Log("newsletter/executeUnsubscribe error:".$e->getMessage(),  UtilsHelper::MSG_ERROR);
				}
			}
		}
	}

	public function executeSubscribeHome()
	{
		$this->setLayout(false);
		$resultPage = Document::getDocumentByExclusiveTag('website_page_newsletter_result');
		if ($resultPage)
		{
			$this->resultPageHref = $resultPage->getHref();
		}
	}

	public function executeSubscribe()
	{
		$this->setLayout(false);
		$resultPage = Document::getDocumentByExclusiveTag('website_page_newsletter_result');
		if ($resultPage)
		{
			$this->resultPageHref = $resultPage->getHref();
		}
	}

	public function executeUnsubscribeRequestMail()
	{
		$this->setLayout(false);
		$this->unsubscribePageUrl = $this->getRequestParameter("unsubscribePageUrl");
	}

	public function executeConfirmMail()
	{
		$this->setLayout(false);
		$this->activationUrl = $this->getRequestParameter("activationUrl");
	}

	public function validateResult()
	{
		if($this->getRequestParameter("codeid"))
		{
			return true;
		}

		$result = true;

		if ($this->getRequestParameter('newsletter_email'))
		{
			$email = trim($this->getRequestParameter('newsletter_email'));
			if ($email == "")
			{
				$this->getRequest()->setError('newsletter_email', "Please enter your email");
				$result = false;
			}
			else
			{
				$myValidator = new sfEmailValidator();
				$myValidator->initialize($this->getContext(), array());

				if (!$myValidator->execute(urldecode($email), $error))
				{
					$this->getRequest()->setError('newsletter_email', "Please enter your email");
					$result = false;
				}
				else
				{
					$c = new Criteria();
					$c->add(SubscriberPeer::EMAIL, $email);
					$c->add(SubscriberPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_ACTIVE);
					$user = SubscriberPeer::doSelectOne($c);

					if ($user)
					{
						$this->getRequest()->setError('newsletter_email', "Email alreday exists!");
						$result = false;
					}
				}
			}
		}
		return $result;
	}

	public function handleErrorResult()
	{
		$this->setLayout(false);
		return "Success";
	}

	public function executeResult()
	{
		$this->setLayout(false);

		if($code = $this->getRequestParameter("codeid"))
		{
			$c = new Criteria();
			$c->add(SubscriberPeer::CODE, $code);
			$user = SubscriberPeer::doSelectOne($c);

			if ($user)
			{
				$user->setPublicationStatus(UtilsHelper::STATUS_ACTIVE);
				//$user->setCode(null);
				$user->save();
				$this->msg = "Subscribtion confirmed";
			}
			else
			{
				$this->err = "A problem occured";
			}

			return "Confirm";
		}

		$email = trim($this->getRequestParameter('newsletter_email'));

		if(!empty($email))
		{
			$new = false;
			$c = new Criteria();
			$c->add(SubscriberPeer::EMAIL, $email);
			$c->add(SubscriberPeer::PUBLICATION_STATUS, UtilsHelper::STATUS_WAITING);
			$subscriber = SubscriberPeer::doSelectOne($c);

			if (!$subscriber)
			{
				$subscriber = new Subscriber();
				$subscriber->setLabel($email);
				$subscriber->setEmail($email);
				$code = md5(time());
				$subscriber->setCode($code);
				$new = true;
			}
			else
			{
				$code = $subscriber->getCode();
			}

			$from_name = UtilsHelper::SYSTEM_SENDER;
			$from_email = UtilsHelper::NO_REPLY_MAIL;

			$mail = new sfMail();
			$mail->initialize();
			$mail->setMailer('sendmail');
			$mail->setCharset('utf-8');

			$mail->setSender($from_email, $from_name);
			$mail->setFrom($from_email, $from_name);
			$mail->addReplyTo($from_email);

			$mail->addAddress($email);
			$mail->addBcc(UtilsHelper::COPY_MAIL);
			$mail->setContentType('text/html');

			$mail->setSubject('Newsletter subscribtion');

			$resultPage = Document::getDocumentByExclusiveTag('website_page_newsletter_result');
			if ($resultPage)
			{
				$resultPageHref = $resultPage->getHref();
			}

			$request = $this->getRequest();
			$request->setParameter('activationUrl', $resultPageHref."?codeid=".$code);

			$body = $this->getPresentationFor("newsletter", "confirmMail");
			$mail->setBody($body);

			try
			{
				$mail->send();

				$defMailinglist = Document::getDocumentByExclusiveTag('newsletter_mailinglist_default');
				if ($defMailinglist && $new)
				{
					$subscriber->save(null, $defMailinglist);
					$subscriber->setPublicationStatus(UtilsHelper::STATUS_WAITING, true);
				}

				$this->msg = "Subscribtion successfull, check your email";
			}
			catch( Exception $e)
			{
				$this->getRequest()->setError('newsletter_email', "A problem occured");
			}
		}
		else
		{
			$this->getRequest()->setError('newsletter_email', "Please enter your email");
			$this->form = true;
		}
	}
}