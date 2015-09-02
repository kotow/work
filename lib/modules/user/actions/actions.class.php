<?php
/**
 * @package    cms
 * @subpackage core user
 * @author     Jordan Hristov / Ilya Popivanov
 */

class userCoreActions extends sfActions
{

	public function validateAccountCreate()
	{
		// default values
		$result = true;
		$this->termsUrl = "";
		$this->type = "user";
		$this->company = null;
		$session_user = $this->getUser();
		$this->user = $session_user->getSubscriber();
		$request = $this->getRequest();

		if($company = Document::getParentOf($session_user->getSubscriberId(), "Company")) $this->company = $company;

		if($this->user)
		{
			$type = $this->user->getUserType();
			if($type == 0) $this->type = "company";
		}
		elseif($this->getRequestParameter("acc"))
		{
			$this->type = $this->getRequestParameter("acc");
		}

		if($this->getRequestParameter('submitted') == "submitted")
		{
			$culture = $this->getUser()->getCulture();
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

			/******* COMMON ********/

			/* firstname */
			/*if(empty($firstname))
			{
				$request->setError('errfirstname', "Please fill the 'First name' field");
				$result = false;
			}*/
			/* end firstname */

			/* e-mail */
			if (!$this->user) {
				if(empty($email))
				{
					$request->setError('erremail', "Please fill the 'Email' field");
					$result = false;
				}
				else
				{
					$myValidator = new sfEmailValidator();
					$myValidator->initialize($this->getContext(), array());
					$email = urldecode($email);
					if (!$myValidator->execute($email, $error))
					{
						$request->setError('erremail', "This email is not valid");
						$result = false;
					}
					else
					{
						if(!$this->user)
						{
							$c = new Criteria();
							$c->add(UserPeer::LOGIN, $email, Criteria::EQUAL);
							$c1 = $c->getNewCriterion(UserPeer::LOGIN, $email, Criteria::EQUAL);
							$c2 = $c->getNewCriterion(UserPeer::EMAIL, $email, Criteria::EQUAL);
							$c1->addOr($c2);
							$c->add($c1);
							$user = UserPeer::doSelectOne($c);

							if ($user)
							{
								$request->setError('erremail', "Your email already exists in our database");
								$result = false;
							}
						}
					}
				}
			}
			/* end e-mail */

			/* pass */
			/*if(empty($password) && !$this->user)
			{
			$request->setError('errpassword', "Please fill the 'Password' field");
			$result = false;
			}
			else
			{
			if(strlen($password) < 4 && !$this->user)
			{
			$request->setError('errpassword', "Your password must be more than 4 chars long");
			$result = false;
			}
			elseif($this->user && strlen($password) > 0 && strlen($password) < 4)
			{
			$request->setError('errpassword', "Your password must be more than 4 chars long");
			$result = false;
			}
			elseif(empty($confirmpass) && !$this->user)
			{
			$request->setError('errpassword', "Your password confirmation do not match");
			$result = false;
			}
			elseif(empty($confirmpass) && $this->user && strlen($password) > 0)
			{
			$request->setError('errpassword', "Your password confirmation do not match");
			$result = false;
			}
			else
			{
			if($password != $confirmpass)
			{
			$request->setError('errpassword', "Your password confirmation do not match");
			$result = false;
			}
			}
			}*/
			/* end pass */

			/* phone
			if(empty($phone))
			{
			$request->setError('errphone', "Please fill the 'phone' field");
			$result = false;
			}
			end phone */

			if (!$this->user)
			{
				/* captcha */
				if(empty($captcha_code))
				{
					$request->setError('errcaptcha_code', "Please fill the 'Verification code' field");
					$result = false;
				}
				else
				{
					$code = $this->getUser()->getAttribute('captcha_code');
					if(!$this->user && $code != $captcha_code)
					{
						$request->setError('errcaptcha_code', "Wrong verification code");
						$result = false;
					}
				}
				/* end captcha */

				/* terms */
				if(empty($terms))
				{
					$request->setError('errterms', "You must accept the terms and conditions");
					$result = false;
				}
				/* end terms */
			}

			/***** END COMMON *****/

			/******* COMPANY ********/
			if ($this->type == "company")
			{
				/* label */
				if(empty($label))
				{
					$request->setError('errlabel', "Please fill the 'Company name' field");
					$result = false;
				}
				/* end label */

				/* country */
				if(empty($country))
				{
					$request->setError('errcountry', "Please fill the 'Country' field");
					$result = false;
				}
				/* end country */

				/* description */
				if(empty($description))
				{
					$request->setError('errdescription', "Please fill the 'Description' field");
					$result = false;
				}

				if($request->getFileSize("logo") > 0)
				{
					try
					{
						$this->media = Media::upload('logo', "upload", array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"));
						if($this->media && $this->media->IsImage())
						{
							$this->media->resizeImage(null, null, 800);
							$this->media->resizeImage("thumbs", null, 100);
						}
					}
					catch (Exception $e)
					{
						$request->setError('errlogo', UtilsHelper::Localize("media.backend.".$e->getMessage()));
						$result = false;
					}
				}
				/* end country */

				/* city
				if(empty($city))
				{
				$request->setError('errcity', "Please fill the 'city' field");
				$result = false;
				}
				end city */

				/* zip
				if(empty($zip))
				{
				$request->setError('errzip', "Please fill the 'zip' field");
				$result = false;
				}
				else
				{
				$myValidator = new sfNumberValidator();
				$myValidator->initialize($this->getContext(), array(
				'type' 	=>	"int"
				));
				if (!$myValidator->execute($zip, $error))
				{
				$request->setError('errzip', "The 'zip' field must be a number");
				$result = false;
				}
				}
				end zip */

				/* address
				if(empty($address))
				{
				$request->setError('erraddress', "Please fill the 'adress' field");
				$result = false;
				}
				end address */
			}
			/***** END COMPANY *****/

			/******** USER *********/
			if($this->type == "user" && ($request->getFileSize("cv") > 0))
			{
				try
				{
					$this->media = Media::upload('cv', "upload",
					array(
					"application/rtf",
					"application/msword",
					"text/plain",
					"text/richtext",
					"text/rtf",
					"application/pdf",
					"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
					"application/vnd.oasis.opendocument.text",
					"text/html"
					));

				}
				catch (Exception $e)
				{
					$request->setError('errcv', UtilsHelper::Localize("media.backend.".$e->getMessage()));
					$result = false;
				}
			}
			/****** END USER *******/

		}

		return $result;
	}

	public function handleErrorAccountCreate()
	{
		$this->setLayout(false);
		UtilsHelper::setFlashMsg();
		if($this->media) $this->media->delete();
		return "Success";
	}

	public function executeAccountCreate()
	{
		$this->setLayout(false);
		//assign vars
		$folder = Document::getDocumentByExclusiveTag("categories_folder_".SECTION);
		if ($folder)
		{
			$cats = Document::getChildrenOf($folder->getId(), "Category");
			foreach ($cats as $cat)
			{
				$categories[$cat->getId()] = $cat->getlabel();
			}
		}
		$first = array(0 => "all categories");
		$categories = $first + $categories;

		$this->categories = $categories;

		if ($this->media)
		{
			$this->cv = $this->media;
		}
		elseif ($this->user && $this->type == "user")
		{
			$cv_id = $this->user->getCv();
			$cv = Document::getDocumentInstance($cv_id);
			$this->cv = $cv;
			$accpage = Document::getDocumentByExclusiveTag("website_page_account");
			if ($accpage)
			{
				$this->accountPageUrl = $accpage->getHref(false);
			}
		}

		if ($this->media)
		{
			$this->logo = $this->media;
		}
		elseif ($this->user && $this->type == "company")
		{
			$logo_id = $this->company->getLogo();
			$logo = Document::getDocumentInstance($logo_id);
			$this->logo = $logo;
			$accpage = Document::getDocumentByExclusiveTag("website_page_account");
			if($accpage)
			{
				$this->accountPageUrl = $accpage->getHref(false);
			}
		}

		if ($this->getRequestParameter('submitted') == "submitted")
		{
			$new = false;
			$search =  array(",","/","\\","[","]","?","!","@","#","$","~","&","'",'"',"=","-",":",";","*","%","+","(",")","{","}","|","§","<",">","_","“","�?","„","`");
			$replace = array("", "", "",  "", "", "", "", "", "", "", "", "", " "," ", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "");
			$params = $this->getRequest()->getParameterHolder()->getAll();

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

			if ($this->user)
			{
				if($this->user->getLogin() == "admin")
				{
					UtilsHelper::setFlashMsg("Admin account cannot be edited in frontend");
					$this->noform = true;
					return "Success";
				}
				UtilsHelper::setFlashMsg("Your profile has been successfully updated", UtilsHelper::MSG_SUCCESS);
			}
			else
			{
				$new = true;
				$code = md5(time());
				$this->user = new User();
				$this->user->setBackend(0); // MAKE SURE NO ACCESS TO ADMIN IS ALLOWED
				$this->user->setActivationCode($code);
			}

			if($this->type == "company")
			{
				$this->user->setFirstname($firstname);
				$this->user->setLastname($lastname);
				$this->user->setEmail($email);
				$this->user->setPhone($phone);
				if(!empty($password)) $this->user->setPassword($password);
			}

			////////// GET SAVE FOLDERS //////////////
			$userFolders = array();
			$mediaFolders = array();
			$alphaFolder = false;
			$mediaAlphaFolder = false;

			$rootfolderUser = Rootfolder::getRootfolderByModule('user');
			$rootfolderMedia = Rootfolder::getRootfolderByModule('media');

			if($rootfolderUser) $folders =  Document::getChildrenOf($rootfolderUser->getId(), 'Folder');
			if($rootfolderMedia) $foldersMedia =  Document::getChildrenOf($rootfolderMedia->getId(), 'Folder');

			foreach ($folders as $folder)
			{
				$userFolders[$folder->getLabel()] = $folder->getId();
			}

			foreach ($foldersMedia as $folder)
			{
				$mediaFolders[$folder->getLabel()] = $folder->getId();
			}

			$title = @str_replace($search, $replace, $firstname);
			$title = trim(@str_replace('  ', ' ', $title));
			$title = mb_strtoupper($title);
			$firstLetter = mb_substr($title, 0, 1);
			if(array_key_exists($firstLetter, $userFolders)) $alphaFolder = Document::getDocumentInstance($userFolders[$firstLetter]);
			if(array_key_exists($firstLetter, $mediaFolders)) $mediaAlphaFolder = Document::getDocumentInstance($mediaFolders[$firstLetter]);

			if(!$alphaFolder)
			{
				$alphaFolder = new Folder();
				$alphaFolder->setLabel($firstLetter);
				$alphaFolder->save(null, $rootfolderUser);
			}

			if(!$mediaAlphaFolder)
			{
				$mediaAlphaFolder = new Folder();
				$mediaAlphaFolder->setLabel($firstLetter);
				$mediaAlphaFolder->save(null, $rootfolderMedia);
			}
			////////////////////////////////////////

			if($this->type == "user")
			{
				if($this->media) $this->user->setCv($this->media->getId());
				$this->user->setEducation($education);
				$jobtypes = "";
				foreach($job_types as $jt) {
					$jobtypes .= "|";
					$jobtypes .= $jt;
				}
				$this->user->setJobType($jobtypes);
				$saved = $this->user->save(null, $alphaFolder);
			}
			elseif($this->type == "company")
			{
				if (!$this->company)
				{
					$this->company = new Company();
				}

				$company_folder = Document::getDocumentByExclusiveTag("company_folder_".$accountType);

				$this->company->setLabel($label);
				$this->company->setAccountType($accountType);
				$this->company->setDescription($description);
				$this->company->setCountry($country);
				$this->company->setCity($city);
				$this->company->setAddress($address);
				$this->company->setZip($xip);
				$this->company->setWeb($web);
				if ($this->media) $this->company->setLogo($this->media->getId());

				if ($company_folder)
					$this->company->save(null, $company_folder);
				else
					$this->company->save();

				$saved = $this->user->save(null, $this->company);
			}

			if($this->media)$this->media->save(null, $mediaAlphaFolder);

			if ($saved)
			{
				if ($new)
				{
					$this->user->setPublicationStatus(UtilsHelper::STATUS_WAITING);

					$confirmMailPage = Document::getDocumentByExclusiveTag('website_page_confirm');
					if($confirmMailPage)
					{
						$data = array();
						$data["user"] = $this->user;
						$data["password"] = $password;
						$data["comfirmUrl"] = $confirmMailPage->getHref();
						$data["code"] = $code;

						$this->getUser()->setAttribute('registrationData', $data);
						$body = $this->getPresentationFor("user", "registrationMail");

						try
						{
							UtilsHelper::sendEmail($email, $body, "Thank you for registering with Us");
							UtilsHelper::setFlashMsg("Please check your email to confirm your registration", UtilsHelper::MSG_SUCCESS);
							$this->noform = true;
						}
						catch (Exception $e)
						{
							UtilsHelper::setFlashMsg("There was a problem while registering our account, please try again");
							if($this->user) $this->user->delete();
							if($this->company) $this->company->delete();
							if($this->media) $this->media->delete();
						}
					}
				}
			}
		}
	}

	public function validateLogin()
	{
		$result = false;
		$culture = $this->getUser()->getCulture();
		if($login = $this->getRequestParameter('login'))
		{
			$password = $this->getRequestParameter('password');

			$c = new Criteria();
			$c->add(UserPeer::LOGIN, $login);
			$user = UserPeer::doSelectOne($c);
			if ($user)
			{
				if($user->getPublicationStatus() != "ACTIVE")
				{
					UtilsHelper::setFlashMsg(UtilsHelper::Localize("user.frontend.Not-active", $culture), UtilsHelper::MSG_INFO );
				}
				elseif (sha1($user->getSalt().$password) == $user->getSha1Password())
				{
					$this->getUser()->setAttribute('pass', $password);
					$this->getUser()->signIn($user);

					$tag = "website_page_home";
					$completeUrl = false;

					$page = Document::getDocumentByExclusiveTag($tag);
					if($page)
					{
						$this->redirect($page->getHref(true));
					}

					$result = true;
				}
				else
				{
					UtilsHelper::setFlashMsg(UtilsHelper::Localize("user.frontend.Wrong-login", $culture), UtilsHelper::MSG_ERROR);
				}
			}
			else
			{
				UtilsHelper::setFlashMsg(UtilsHelper::Localize("user.frontend.Wrong-login", $culture), UtilsHelper::MSG_ERROR);
			}
		}
		elseif ($this->getRequestParameter('logout'))
		{
			$this->getUser()->signOut();
		}
		elseif ($activation_code = $this->getRequestParameter('hash'))
		{
			$c = new Criteria();
			$c->add(UserPeer::ACTIVATION_CODE, $activation_code);
			$c->add(UserPeer::ACTIVATION_CODE, "$activation_code", Criteria::LIKE);
			$user = UserPeer::doSelectOne($c);
			if ($user)
			{
				$user->setPublicationStatus(UtilsHelper::STATUS_ACTIVE);
				$user->setActivationCode('');
				$user->save();
				try
				{
					UtilsHelper::setFlashMsg("Your account has been activated successfully. Thank you for your registration.", UtilsHelper::MSG_SUCCESS);
					$this->noform = true;
				}
				catch (Exception $e)
				{
					UtilsHelper::setFlashMsg("There was a problem while activating your account.");
				}
			}
			else
			{
				UtilsHelper::setFlashMsg("Your account is already activated. ");
			}
		}
	}

	public function validateResetPassword()
	{
		$result = false;

		if($login = $this->getRequestParameter('resetpassword'))
		{
			$c = new Criteria();
			$c->add(UserPeer::LOGIN, $login);
			$user = UserPeer::doSelectOne($c);
			if ($user)
			{
				$now = time();
				// Set user activation code
				$user->setActivationCode($now);
				$user->save();

				$changePassPage = Document::getDocumentByExclusiveTag("website_page_changepassword");
				if ($changePassPage)
				{
					$reset_link = "<a href='".$changePassPage->getHref()."?q=$now'>Reset password</a>";
				}

				$text = "Hi ".$user->getLabel()."!
				<br/>
				<br/>Please click this link to reset your password:
				<br/>$reset_link
				";

				//$this->getPresentationFor('user', 'resetPasswordMessage');
				UtilsHelper::sendEmail($user->getEmail(), $text, "Password reset");

				$result = true;
			}
			else
			{
				UtilsHelper::setFlashMsg('Wrong login email.', UtilsHelper::MSG_ERROR);
			}
		}

		return $result;
	}

	public function validateChangePassword()
	{
		$result = false;

		if($activation_code = $this->getRequestParameter('q'))
		{
			if($this->getRequestParameter('password1') && $this->getRequestParameter('password2'))
			{
				$password1 = $this->getRequestParameter('password1');
				$password2 = $this->getRequestParameter('password2');

				if($password1 == $password2)
				{
					$c = new Criteria();
					$c->add(UserPeer::ACTIVATION_CODE, $activation_code);
					$c->add(UserPeer::ACTIVATION_CODE, "$activation_code", Criteria::LIKE);
					$user = UserPeer::doSelectOne($c);
					if($user)
					{
						$user->setPassword($password2);
						$user->setActivationCode('');
						$user->save();

						return true;
					}
					else
					{
						UtilsHelper::setFlashMsg("Invalid user. Please contact with system administrator", UtilsHelper::MSG_ERROR);
					}
				}
				else
				{
					UtilsHelper::setFlashMsg("Passwords doesn't match.", UtilsHelper::MSG_ERROR);
				}
			}
		}

		return $result;
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

	public function executeCaptcha()
	{
		$this->setLayout(false);
		new Captcha();
		exit();
	}

}