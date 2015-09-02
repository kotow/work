<?php

function mb_ucfirst($str, $encode = 'UTF-8')
{
	mb_internal_encoding($encode);
	$fc = mb_strtoupper(mb_substr($str, 0, 1));
	return $fc.mb_substr($str, 1);
}

function locale($label, $lang = null)
{
	mb_internal_encoding("UTF-8");

	if(is_null($lang))
	{
		$lang = sfContext::getInstance()->getUser()->getCulture();
	}

	$localeFile = sfConfig::get('sf_root_dir')."/cache/locales.php";
	
	if (is_readable($localeFile))
	{
		include $localeFile;

		$lbl = explode('.', $label);
		$ind = count($lbl)-1;
		
		if (($lbl[$ind] == 'label') && ($ind>0))
		{
			unset($lbl[$ind]);
			$ind--; $add = ':';
			$labelStr = '.label';
		}
		
		$lbl[$ind] = ucfirst($lbl[$ind]);
		$upLabel = implode('.', $lbl);

		if ($upLabel.$labelStr == $label)
		{
			if ($lang == 'bg')
			{
				$str = mb_ucfirst($locales[strtolower($upLabel)][$lang]).$add;
			}
			else
			{
				$str = ucfirst($locales[strtolower($upLabel)][$lang]).$add;
			}
		}
		else
		{
			$str = $locales[strtolower($upLabel)][$lang].$add;
		}
	}
	
	if ($str == $add)
	{
		$str = '*'.$upLabel.'*';
	}
	return $str;
}

?>