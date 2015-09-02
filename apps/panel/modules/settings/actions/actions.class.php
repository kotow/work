<?php

/**
 * Services  actions.
 *
 * @package		XXXXXX
 * @subpackage	settings
 */

class settingsActions extends sfActions
{

	public function executeEditSettings()
	{
		$this->setLayout(false);

		$culture = sfContext::getInstance()->getUser()->getCulture();
		$id = $this->id = $this->getRequestParameter('id');
		$this->page = $this->getRequestParameter('page');

		$phpFile = sfConfig::get('sf_root_dir')."/cache/settings.php";
		$xmlFile = sfConfig::get('sf_root_dir')."/config/settings.xml";

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

			$setting = $id;

			if ($content = file_get_contents($xmlFile))
			{
				$lines = explode("</element>", $content);
				$changed = false;
				foreach ($lines as &$line)
				{
					if (strpos($line, '<element label="'.$setting.'"') != false)
					{
						$arr = explode("\n", $line);
						foreach ($arr as &$l)
						{
							if (strpos($l, '<item lang="'.$culture.'"') != false)
							{
								$v = htmlspecialchars($attrValue);
								$l = '		<item lang="'.$culture.'" value="'.$v.'" />';
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
					$content = implode("</element>", $lines);
					file_put_contents($xmlFile, $content);
				}
				else
				{
					$request = $this->getRequest();
					$request->setError('attrValue', 1);
					UtilsHelper::setBackendMsg('Settings "'.$id.'" is missing in XML file!', 'error');
					return;
				}
			}

			if ($content = file_get_contents($phpFile))
			{
				$lines = explode("\n", $content);
				foreach ($lines as &$line)
				{
					if (strpos($line, "['$id']") != false)
					{
						$v = str_replace('"', '\"', $attrValue);
						$line = "	\$settings['$id'] = \"$v\";";
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
				$this->val = htmlspecialchars_decode($settings[$id]);
			}
			$this->id = $id;
		}
	}

}