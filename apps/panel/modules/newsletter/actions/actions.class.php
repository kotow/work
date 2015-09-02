<?php

/**
 * Newsletter  actions.
 *
 * @package		XXXXXX
 * @subpackage	newsletter
 */

class newsletterActions extends sfActions
{
	public function executePreferences()
	{
	}

	public function executeUploadBanners()
	{
		$this->setLayout("panel");

		$c = new Criteria();
		$c->add(PrefPeer::LABEL, "newsletter");
		$info = PrefPeer::doSelectOne($c);

		if(!$info)
		{
			$info = new Pref();
			$info->setLabel("newsletter");
			$info->save();
		}

		if($this->getRequestParameter('submitted'))
		{
			$request = $this->getRequest();
			try
			{
				$request->setParameter('parent', $info->getId());
				if($request->getFileName('banner1'))
				{
					$request->setParameter('id', $this->getRequestParameter('banner1Id'));
					$request->setParameter('attrLabel', 'newsletter468x60');

					$media = Media::upload('banner1', "upload/newsletter", array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"));
					if($media && $media->IsImage())
					{
						$media->resizeImage(null, 60, 468);
						$media->resizeImage("thumbs", 30, 231);
					}
				}

				if(!$media) $media = Document::getDocumentInstance($this->getRequestParameter('banner1Id'));
				if($media)
				{
					$media->setDescription($this->getRequestParameter('banner1Url'));
					$media->save();
				}

				if($request->getFileName('banner2'))
				{
					$request->setParameter('id', $this->getRequestParameter('banner2Id'));
					$request->setParameter('attrLabel', 'newsletter160x600');

					$media2 = Media::upload('banner2', "upload/newsletter", array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"));
					if($media2 && $media2->IsImage())
					{
						$media2->resizeImage(null, 600, 160);
						$media2->resizeImage("thumbs", 125, 40);
					}
				}

				if(!$media2) $media2 = Document::getDocumentInstance($this->getRequestParameter('banner2Id'));
				if($media2)
				{
					$media2->setDescription($this->getRequestParameter('banner2Url'));
					$media2->save();
				}

				$infoVal = $this->getRequestParameter('info');
				if(!$infoVal) $infoVal = null;
				$info->setContent($infoVal);
				$info->save();

			}
			catch (Exception $e)
			{
				$this->message = UtilsHelper::Localize("media.".$e->getMessage());
			}
		}

		$c = new Criteria();
		$c->add(PrefPeer::LABEL, "newsletter");
		$this->info = PrefPeer::doSelectOne($c);

		$c = new Criteria();
		$c->add(MediaPeer::LABEL, "newsletter468x60");
		$this->banner1 = MediaPeer::doSelectOne($c);

		$c = new Criteria();
		$c->add(MediaPeer::LABEL, "newsletter160x600");
		$this->banner2 = MediaPeer::doSelectOne($c);
	}

	public function executeNewsletterSend()
	{
		$mailinglists = $this->getRequestParameter("mailinglists");
		$newsletters = $this->getRequestParameter("newsletters");

		$mailinglists = explode(";", substr($mailinglists, 0, -1));
		$newsletters =  explode(",", $newsletters);

		$allSubscribers = array();

		foreach ($mailinglists as $mailinglist)
		{
			$subscribers = Document::getChildrenOf($mailinglist, "Subscriber");
			$allSubscribers = array_merge($subscribers, $allSubscribers);
		}

		try
		{
			foreach($newsletters as $newsletter)
			{
				$this->getRequest()->setParameter("newsletterId", $newsletter);

				$newsletter = Document::getDocumentInstance($newsletter);
				if ($newsletter) $subject = $newsletter->getLabel();

				$newsletterHtml = $this->getPresentationFor("newsletter", "newsletter");

				$i = $ind = 0;
				$mailAddresses = array();
				$cnt = count($allSubscribers);
				foreach ($allSubscribers as $subscriber)
				{
					$ind++;
					if ($subscriber->getPublicationStatus() == UtilsHelper::STATUS_ACTIVE)
					{
						$mailAddresses[] = $subscriber->getEmail();
						$i++;
					}

					if ($i == 100 || $ind == $cnt)
					{
						if(!empty($mailAddresses))
						{
							$this->sendMail($mailAddresses, $subject, $newsletterHtml);
						}
						$mailAddresses = array();
						$i = 0;
					}
				}
			}
		}
		catch (Exception $e)
		{
			exit("<br><br>".$e->getMessage());
		}

		exit("<br><br>Newsletters have been sent");
	}

	public function sendMail($mailAddresses, $subject, $newsletterHtml)
	{
		$mail = new sfMail();
		$mail->initialize();
		$mail->setMailer('sendmail');
		$mail->setCharset('utf-8');
		$mail->setSender(UtilsHelper::NEWSLETTER_FROM_MAIL, 'Sgrada.com');
		$mail->setFrom(UtilsHelper::NEWSLETTER_FROM_MAIL, 'Sgrada.com');
		$mail->addAddress(UtilsHelper::NEWSLETTER_TO_MAIL);

		foreach ($mailAddresses as $mailAdd)
		{
			$mail->addBcc($mailAdd);
		}
		$mail->setContentType('text/html');
		$mail->setSubject($subject);
		$mail->setBody($newsletterHtml);
		$mail->send();
	}

	public function executeSendNewsletter()
	{
		$mailinglistsFolder = Document::getDocumentByExclusiveTag("newsletter_folder_mailinglist");
		if ($mailinglistsFolder)
		{
			$this->mailinglists = Document::getChildrenOf($mailinglistsFolder->getId(), "Mailinglist");
		}
		$this->items = $this->getRequestParameter('items');

		$mls = explode(",", $this->items);
		foreach ($mls as $ml)
		{
			$obj = Document::getDocumentInstance($ml);
			if (!$obj || get_class($obj) != "Newsletter")
			{
				exit("<br><br>Please choose at least one newsletter");
			}
		}
	}

	public function executeNewsletter()
	{
		$newsletter = Document::getDocumentInstance($this->getRequestParameter("newsletterId"));
		if ($newsletter)
		{
			$this->content = $newsletter->getContent();
		}
		$this->setLayout(false);
	}

	public function executeEditNewsletter()
	{
		$this->setLayout(false);
		PanelService::objectEdit('newsletter', 'Newsletter', $this);
	}

	public function executeEditSubscriber()
	{
		$this->setLayout(false);
		PanelService::objectEdit('newsletter', 'Subscriber', $this);
	}

	public function executeEditMailinglist()
	{
		$this->setLayout(false);
		PanelService::objectEdit('newsletter', 'Mailinglist', $this);
	}
}