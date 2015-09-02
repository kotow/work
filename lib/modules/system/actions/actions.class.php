<?php
/**
 * @package    cms
 * @subpackage core system
 * @author     Jordan Hristov / Ilya Popivanov
 */

class systemCoreActions extends sfActions
{
	public function executeValidateRegexp()
	{
		$myValidator = new sfRegexValidator();
		$myValidator->initialize($this->getContext(), array(
		'match'		=>		"Yes",
		'pattern'	=>		urldecode($this->getRequestParameter('pattern'))
		));
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
		{
			exit(UtilsHelper::Localize('system.frontend.Validate_regexp_error'));
		}
		exit("ok");
	}

	public function executeValidateString()
	{
		$myValidator = new sfStringValidator();
		$myValidator->initialize($this->getContext(), array(
		));
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
		{
			exit(UtilsHelper::Localize('system.frontend.Validate_string_error'));
		}
		exit("ok");
	}

	public function executeValidateIneger()
	{
		$myValidator = new sfNumberValidator();
		$myValidator->initialize($this->getContext(), array(
		'type' 	=>	"int"
		));
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
		{
			exit(UtilsHelper::Localize('system.frontend.Validate_integer_error'));
		}
		exit("ok");
	}

	public function executeValidateFloat()
	{
		$myValidator = new sfNumberValidator();
		$myValidator->initialize($this->getContext(), array(
		'type' 	=>	"float"
		));
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
		{
			exit(UtilsHelper::Localize('system.frontend.Validate_float_error'));
		}
		exit("ok");
	}

	public function executeValidateUrl()
	{
		$myValidator = new sfUrlValidator();
		$myValidator->initialize($this->getContext(), array(
		));
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
		{
			exit(UtilsHelper::Localize('system.frontend.Validate_url_error'));
		}
		exit("ok");
	}

	public function executeValidateEmail()
	{
		$myValidator = new sfEmailValidator();
		$myValidator->initialize($this->getContext(), array(
		));
		$value = urldecode($this->getRequestParameter('value'));
		if (!$myValidator->execute($value, $error))
		{
			exit(UtilsHelper::Localize('system.frontend.Validate_email_error'));
		}
		exit("ok");
	}

}