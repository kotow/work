<?php
/**
 * user actions.
 *
 * @package    cms
 * @subpackage user
 */

class userActions extends sfActions
{


	public function executeIndex()
	{
		$this->redirect('/panel');
	}

	public function executeForceLogin()
	{
		$access = false;
		$user = $this->getUser()->getSubscriber();
		if (($user && $user->getType() == "admin" && $user->getBackend() == 1))
		{
			$access = true;
		}
		else
		{
			$user = $this->getUser()->getAttribute('forceAutoLogAsAdmin');
			$access = true;
		}

		if ($access)
		{
			if ($this->getRequestParameter("fulid"))
			{
				$fulid = $this->getRequestParameter('fulid');
				$subscriber = Document::getDocumentInstance($fulid);
				if ($subscriber)
				{
					$this->getUser()->setAttribute('forceAutoLogAsAdmin', $user);

					$this->getUser()->signIn($subscriber);
					$this->user = $subscriber;

					if(!$page = Document::getDocumentByExclusiveTag("website_page_welcome"))
					{
						$page = Document::getDocumentByExclusiveTag("website_page_home");
					}

					if($page)
					{
						$href = $page->getHref();
						$this->redirect($href);
					}
				}
			}
		}
		exit();
	}

	public function executeLogin()
	{
		$referer = @$_SERVER['HTTP_REFERER'];
		if (!strstr($referer, 'panel') || !strstr($referer, "?"))
			$referer = null;

		$this->getUser()->setAttribute('referer', $referer);

		$this->setLayout("panel");
		if ($this->getRequestParameter("submit"))
		{
			if ($this->getRequestParameter("login") && $this->getRequestParameter("password"))
			{
				$subscriber_pass = $this->getRequestParameter('password');
				$subscriber_login = $this->getRequestParameter('login');

				$c = new Criteria();
				$c->add(UserPeer::LOGIN, $subscriber_login);
				$subscriber = UserPeer::doSelectOne($c);

				if ($subscriber)
				{
					if ($subscriber->getBackend() != 1)
					{
//						$this->getRequest()->setError('login_error', 'Your have no access to site admisnistration');
						UtilsHelper::setBackendMsg('Your have no access to site admisnistration', "info");
					}
					elseif($subscriber->getPublicationStatus() != UtilsHelper::STATUS_ACTIVE)
					{
//						$this->getRequest()->setError('login_error', 'Your account is not active');
						UtilsHelper::setBackendMsg('Your account is not active', "info");
					}
					elseif (sha1($subscriber->getSalt().$subscriber_pass) == $subscriber->getSha1Password())
					{
						$this->getUser()->signIn($subscriber);
						$this->user = $subscriber;
						//exit("referer ".$_SERVER['HTTP_REFERER']);

						$this->redirect($this->getUser()->getAttribute("referer"));
					}
					else
					{
//						$this->getRequest()->setError('login_error', 'Wrong password');
						UtilsHelper::setBackendMsg('Wrong username or password', "error");
					}
				}
				else
				{
					UtilsHelper::setBackendMsg('Wrong username or password', "error");
				}
			}
			else
			{
//				$this->getRequest()->setError('login_error', 'Please, enter username and password');
				UtilsHelper::setBackendMsg('Please, enter username and password', "info");
			}
		}
		else
		{
			if ($subscriber = $this->getUser()->getAttribute('forceAutoLogAsAdmin'))
			{
				$this->getUser()->signIn($subscriber);
				$this->getUser()->setAttribute('forceAutoLogAsAdmin', null);
				$this->redirect("http://".$_SERVER['HTTP_HOST']."/admin/index.php?refresh=".$this->getRequestParameter('refresh'));
			}
		}
	}

	public function executeLogout()
	{
		$this->getUser()->signOut();
		$this->redirect('/panel');
	}

	public function executeEditUser()
	{
		$this->setLayout(false);
		$this->user = $this->getUser()->getSubscriber();
		return PanelService::objectEdit('user', 'User', $this);
	}

}