<?php
/**
 * @package    cms
 * @subpackage user
 * @author     Jordan Hristov / Ilya Popivanov
 */

class userActions extends sfActions
{

	public function showDashboard()
	{
		$tag = "website_page_tracked_trademarks";
		$page = Document::getDocumentByExclusiveTag($tag);
		if ($page)
		{
			$this->redirect($page->getHref(true));
		}
	}

	public function validateLogin()
	{
		$result = false;
		if ($login = $this->getRequestParameter('login'))
		{
			$password = $this->getRequestParameter('password');

			$c = new Criteria();
			$c->add(UserPeer::LOGIN, $login);
			$user = UserPeer::doSelectOne($c);
			if ($user)
			{
				if($user->getPublicationStatus() != "ACTIVE")
				{
					UtilsHelper::setFlashMsg(UtilsHelper::Localize("user.Not-active", $culture), UtilsHelper::MSG_INFO );
				}
				elseif (sha1($user->getSalt().$password) == $user->getSha1Password())
				{
					$this->getUser()->setAttribute('pass', $password);
					$this->getUser()->signIn($user);

					// redirect to dashboard
					$this->showDashboard();
					$result = true;
				}
				else
				{
					UtilsHelper::setFlashMsg(UtilsHelper::Localize("user.Wrong-login", $culture), UtilsHelper::MSG_ERROR);
				}
			}
			else
			{
				UtilsHelper::setFlashMsg(UtilsHelper::Localize("user.Wrong-login", $culture), UtilsHelper::MSG_ERROR);
			}
		}
		else
		{
			if ($this->getUser()->isAuthenticated())
			{
				// redirect to dashboard
				$this->showDashboard();
			}
		}
	}

	public function handleErrorLogin()
	{
		$this->setLayout(false);
		return "NotLogged";
	}

	public function executeLogin()
	{
		$this->setLayout(false);
		$user = $this->getUser()->getSubscriber();
		$this->user = $user;
	}

	public function executeLogout()
	{
		$this->getUser()->signOut();
		$loginPage = Document::getDocumentByExclusiveTag("website_page_home");
		if ($loginPage)
		{
			$loginPageUrl = $loginPage->getHref();
			$this->redirect($loginPageUrl);
		}
		$this->redirect('http://'.$_SERVER['SERVER_NAME']);
	}

}