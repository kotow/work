<?php
/**
 * @author     Jordan Hristov / Ilya Popivanov
 */

class myUser extends sfBasicSecurityUser
{
	public function signIn($user)
	{
		$id = $user->getId();
		$this->setAttribute('subscriber_id', $id, 'subscriber');
		$this->setAuthenticated(true);
		$this->addCredential('subscriber');
		$this->setAttribute('login', $user->getLogin(), 'subscriber');
	}

	public function signInById($id)
	{
		$user = Document::getDocumentInstance($id);
		$this->setAttribute('subscriber_id', $id, 'subscriber');
		$this->setAuthenticated(true);
		$this->addCredential('subscriber');
		$this->setAttribute('login', $user->getLogin(), 'subscriber');
	}

	public function signOut()
	{
		$this->getAttributeHolder()->removeNamespace('subscriber');
		$this->setAuthenticated(false);
		$this->clearCredentials();
	}

	public function getSubscriberId()
	{
		return $this->getAttribute('subscriber_id', '', 'subscriber');
	}

	public function getSubscriber()
	{
		if($this->getSubscriberId()) return Document::getDocumentInstance($this->getSubscriberId());
	}

	public function getLogin()
	{
		return $this->getAttribute('login', '', 'subscriber');
	}
}