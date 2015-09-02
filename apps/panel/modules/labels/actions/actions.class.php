<?php

/**
 * Services  actions.
 *
 * @package		XXXXXX
 * @subpackage	labels
 */

class labelsActions extends sfActions
{

	public function executeEditLabel()
	{
		$this->setLayout(false);

		$culture = sfContext::getInstance()->getUser()->getCulture();
		$id = $this->id = $this->getRequestParameter('id');
		$this->page = $this->getRequestParameter('page');
		$phpFile = sfConfig::get('sf_root_dir')."/cache/locales.php";
		$xmlFile = sfConfig::get('sf_root_dir')."/config/locales.xml";

		if ($this->getRequestParameter('submitEdit'))
		{
			$attrValue = $this->getRequestParameter('attrValue');
			if (trim($attrValue) == '')
			{
				$request = $this->getRequest();
				$request->setError('attrValue', 1);
				UtilsHelper::setBackendMsg('Field <b>Value</b> is empty!', 'error');
				return;
			}

			$locale = $id;

			// write XML Locales (in lib folder);
			if ($content = file_get_contents($xmlFile))
			{
				$lines = explode("</locale>", $content);
				$changed = false;
				foreach ($lines as &$line)
				{
					if (strpos($line, '<locale label="'.$locale.'"') != false)
					{
						$arr = explode("\n", $line);
						foreach ($arr as &$l)
						{
							if (strpos($l, '<item lang="'.$culture.'"') != false)
							{
								//$v = str_replace('"', "'", $attrValue);
								//$val = htmlspecialchars($attrValue);
								$val = htmlentities($attrValue, ENT_COMPAT | ENT_HTML401, 'UTF-8');
								$l = '		<item lang="'.$culture.'" value="'.$val.'" />';
								$changed = true;
								break;
							}
						}
						$line = implode("\n", $arr);
						break;
					}
				}
				if ($changed)
				{
					$content = implode("</locale>", $lines);
					file_put_contents($xmlFile, $content);
				}
				else
				{
					$request = $this->getRequest();
					$request->setError('attrValue', 1);
					UtilsHelper::setBackendMsg('Locale "'.$id.'" is missing in XML file!', 'error');
					return;
				}
			}

			// write COMPILED Locales (in cache folder);
			if ($content = file_get_contents($phpFile))
			{
				$lines = explode("\n", $content);
				foreach ($lines as &$line)
				{
					// replace ['media.frontend.gallery-no-tag-warn']['en']
					if (strpos($line, "['$id']") != false)
					{
						//$val = str_replace('"', '\"', $attrValue);
						//$val = htmlspecialchars($attrValue);
						$val = htmlentities($attrValue, ENT_COMPAT | ENT_HTML401, 'UTF-8');
						$line = "	\$locales['$id'] = \"$val\";";
						break;
					}
				}
				$content = implode("\n", $lines);
				file_put_contents($phpFile, $content);
			}
			PanelService::redirect();
		}
		else
		{
			if (!$this->val = $this->getRequestParameter('attrValue'))
			{
				include($phpFile);
				$this->val = htmlspecialchars_decode($locales[$id]);
			}
			$this->id = $id;
		}
	}

}