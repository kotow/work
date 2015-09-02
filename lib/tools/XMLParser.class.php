<?php
/**
 * @author     Jordan Hristov / Ilya Popivanov
 */

class XMLParser  {

	public static function getXMLdata($data, $file = null)
	{
		$vals = array();
		$keys = array();
		$parser = xml_parser_create('UTF-8');
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE,1);
		$res = (bool)xml_parse_into_struct($parser, $data, $vals, $keys);
		if (!$res)
		{
			echo 'XML Parse error: '.xml_error_string(xml_get_error_code($parser)).' at line '.xml_get_current_line_number($parser);
			if ($file)
				echo " in file'$file'.";
		}
		xml_parser_free($parser);
		return array($vals, $keys);
	}

	public static function getXMLdataValues($data, $isFile = true, $encode = false)
	{
		if ($isFile)
		{
			$handle = fopen($data, "r");
			$xmlContent = fread($handle, filesize($data));
			fclose($handle);
		}
		else
		{
			$xmlContent = $data;
		}
		//$xmlContent = Utilshelper::charset_decode_utf_8($xmlContent);
		//$xmlContent = iconv( "UTF-8", "UTF-8//TRANSLIT",  $xmlContent );
    	
		if ($encode)
		{
			$xmlContent = utf8_encode($xmlContent);
		}
		if ($isFile)
		{
			$xmlData = self::getXMLdata($xmlContent, $data);
		}
    	else
    	{
    		$xmlData = self::getXMLdata($xmlContent);
    	}
		return $xmlData[0];
	}

	public static function getTargetsForTemplateBlocks($tags)
	{
		$targets = array();
		foreach ($tags as $tag)
		{
			if (($tag['tag'] == 'DESTINATION') && ($tag['type'] == 'complete'))
			{
				$targets[$tag['attributes']['ID']]['type'] = $tag['attributes']['TYPE'];
				if (isset($tag['attributes']['PARAMETERS']))
				{
					$targets[$tag['attributes']['ID']]['parameters'] = $tag['attributes']['PARAMETERS'];
				}
				if (isset($tag['attributes']['LABEL']))
				{
					$targets[$tag['attributes']['ID']]['label'] = $tag['attributes']['LABEL'];
				}
			}
		}
		return $targets;
	}

}
