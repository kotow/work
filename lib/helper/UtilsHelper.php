<?php

/**
 *	Utils Helper
 *
 */
class UtilsHelper
{
	//===================================================================================================================== CONSTANTS
	const STATUS_ACTIVE = 'ACTIVE';
	const STATUS_WAITING = 'WAITING';
	const STATUS_DEACTIVATED = 'DEACTIVATED';
	const MSG_ERROR = 1;
	const MSG_SUCCESS = 2;
	const MSG_INFO = 3;
	const MSG_WARNING = 4;
	const STANDARD_ERROR = 'There was an error. Please try again later.';

	const NO_REPLY_MAIL = 'no_reply@tm-smart.com';
	const NO_REPLY_NAME = 'TM SMART';
	const SYSTEM_MAIL = 'system@cms.com';
	const SYSTEM_SENDER = 'CMS';
	const THUMB_WIDTH = 100;
	const THUMB_HEIGHT = 100;

	//===================================================================================================================== FUNCTIONS
	function strip_tags_only($str, $tags)
	{
		if(!is_array($tags))
		{
			$tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
			if(end($tags) == '') array_pop($tags);
		}

		foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
		return $str;
	}

	public static function getImgTags($string)
	{
		$result = array();
		$images = array();
		$contentParts = array();

		$imgTags = explode('<img', $string);
		$contentParts[] = array_shift($imgTags);

		foreach ($imgTags as $imgTagPart)
		{
			$parts = explode('/>', $imgTagPart);
			$paramStr = array_shift($parts);

			$contentParts[] = implode('/>', $parts);

			if(strstr($paramStr, "src"))
			{
				$src = strstr($paramStr, "src");
				$src = substr($src, 5);
				$pos = strpos($src, '"');
				$images[] = substr($src, 0, $pos);
			}
		}

		$content = implode('', $contentParts);

		//$content = preg_replace('@(<[ \\n\\r\\t]*script(>|[^>]*>))@i', '', $content);
		//$content = preg_replace('@(<[ \\n\\r\\t]*/[ \\n\\r\\t]*script(>|[^>]*>))@i', '', $content);
		$result['content'] = $content;
		$result['images'] = $images;

		return $result;
	}

	public static function charset_decode_utf_8 ($string)
	{
		if (! ereg("[\200-\237]", $string) and ! ereg("[\241-\377]", $string))
		return $string;

		$string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/e",
		"'&#'.((ord('\\1')-224)*4096 + (ord('\\2')-128)*64 + (ord('\\3')-128)).';'",
		$string);

		$string = preg_replace("/([\300-\337])([\200-\277])/e",
		"'&#'.((ord('\\1')-192)*64+(ord('\\2')-128)).';'",
		$string);

		return $string;
	}

	public static function sendEmail($to, $body, $subject = "", $from = self::NO_REPLY_MAIL, $fromName = self::NO_REPLY_NAME, $replyTo =  self::NO_REPLY_MAIL, $bcc = array(), $attachment = '')
	{
		$template_header = '';
		$template_footer = '';
		try
		{
			$mail = new sfMail();
			$mail->initialize();
			$mail->setMailer('sendmail');
			$mail->setCharset('utf-8');
			$mail->setContentType('text/html');

			$mail->setSender($from, $fromName);
			$mail->setFrom($from, $fromName);
			$mail->addReplyTo($replyTo);
			$mail->addAddress($to);
			
			if (is_array($attachment))
			{
				foreach ($attachment as $key=>$row)
				{
					$mail->addAttachment($row);
				}
			}
			else
			{
				if ($attachment != '')
				{
					$mail->addAttachment($attachment);
				}
			}

			foreach ($bcc as $bcc_address) $mail->addBcc($bcc_address);

			$mail->setSubject($subject);
			$mail->setBody($template_header.$body.$template_footer);
			$mail->send();
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	public static function pager($model, $criteria = null, $limit = 10)
	{
		$request = sfContext::getInstance()->getRequest();
		$pager = new sfPropelPager($model, $limit);

		if (is_array($criteria))
		{
			$pager->setResults($criteria);
		}
		else
		{
			if (is_null($criteria))
				$criteria = new Criteria();
			$pager->setCriteria($criteria);
		}

		$request = sfContext::getInstance()->getRequest();

		$pager->setPage($request->getParameter('page'));
		$pager->init();
		return $pager;
	}

	public static function setStyles($title = null)
	{
		$response = sfContext::getInstance()->getResponse();
		$response->setTitle($title);
		$b = Website::getBrowser();
		if (file_exists(SF_ROOT_DIR."/www/css/frontend.css"))
			$response->addStyleSheet("frontend");
		if (file_exists(SF_ROOT_DIR."/www/css/print.css"))
			$response->addStyleSheet("print");
		if (file_exists(SF_ROOT_DIR."/www/css/".$b["browser"].$b['version'].".css"))
			$response->addStyleSheet($b["browser"].$b['version']);
		if (file_exists(SF_ROOT_DIR."/www/css/".$b["browser"].".css") )
			$response->addStyleSheet($b["browser"]);
	}

	public static function getmicrotime()
	{
		list($usec, $sec) = explode(" ",microtime());
		return ((float)$usec + (float)$sec);
	}

	public static function cyrillicConvert($str)
	{
		$search = array('А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ь','Ъ','Ю','Я');
		$replace = array('а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ъ','ю','я');
		$str = @str_replace($search, $replace, $str);

		$search = array('а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ъ','ю','я');
		$replace = array('a','b','v','g','d','e','j','z','i','i','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sh','sht','i','a','iu','ia');
		$str = @str_replace($search, $replace, $str);
		return $str;
	}

	public static function cleanStr($str , $search = null, $replace = null )
	{
		$str = preg_replace("'&.*?;'si", '', $str);
		//$str = html_entity_decode($str);
		$str = html_entity_decode(htmlentities($str));
		if (is_null($search) && is_null($replace))
		{
			$search = array(","," ","/","\\","[","]","?","!","@","é","è","à","ù","ê","â","û","î","ô","ç","ä","ë","ü","ï","ö","#","$","~","&","'","\"","=",":",";","*","€","%","+","(",")","£","¤","µ","^","¨","°","{","}","|","§","<",">",".","’",'„','�?','“');
			$replace = array("-","-","-","-","-","-","-","-","-","e","e","a","u","e","a","u","i","o","c","a","e","u","i","o","-","-","-","-","-","-","-","-","-","-","E","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-","-");
		}

		$cleanStr = @str_replace($search, $replace, $str);
		for ($i=0; $i<5; $i++)
		{
			$cleanStr = str_replace('--', '-', $cleanStr);
		}
		return $cleanStr;
	}

	public static function cleanURL($object, $fullUrl = false)
	{
		if (is_integer($object))
		{
			$href = "object_not_found_".$object.'.html';
			$object = Document::getDocumentInstance($object);
		}

		if ($object && is_object($object))
		{
			$id = $object->getId();
			$href = UtilsHelper::cleanStr($object->getLabel())."_".$id.'.html';
		}
		elseif ($object && is_array($object))
		{
			$href = UtilsHelper::cleanStr($object['label'])."_".$object['id'].'.html';
		}

		for ($i=0; $i<5; $i++)
		{
			$href = str_replace('--', '-', $href);
		}
		if (substr($href, 0, 1) == '-')
		{
			$href = substr($href, 1);
		}

		if ($fullUrl)
		{
			return 'http://'.$_SERVER['HTTP_HOST'].'/'.$href;
		}
		return $href;
	}

	public static function cutStr($orgStr, $maxLen, $addStr = '', $closeTags = true)
	{
		mb_internal_encoding("UTF-8");

		html_entity_decode($orgStr);
		$orgStr = preg_replace("'&.*?;'siU", '', $orgStr);
		$str = $orgStr; //$str = iconv('UTF-8', 'WINDOWS-1251', $orgStr);
		$len = mb_strlen($str);
		if ($len > $maxLen)
		{
			$snippet = mb_substr($str, 0, $maxLen);
			$snippet = strrpos ( $snippet, "<" ) > strrpos ( $snippet, ">" ) ? rtrim ( substr ( $str, 0, strrpos ( $snippet, "<" ) ) ).$addStr : rtrim ( $snippet ).$addStr;
			if ($closeTags)
			{
				$snippet = self::closeTags($snippet);
			}
			return $snippet;
		}
		else
		{
			if ($closeTags)
			{
				$str = self::closeTags($orgStr);
			}
			return $str;
		}
	}

	public static function closeTags($html)
	{
		//put all opened tags into an array
		preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
		$openedtags = $result[1];

		//put all closed tags into an array
		preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
		$closedtags = $result[1];

		$len_opened = count ( $openedtags );
		// all tags are closed
		if( count ( $closedtags ) == $len_opened )
		{
			return $html;
		}
		$openedtags = array_reverse ( $openedtags );
		// close tags
		for( $i = 0; $i < $len_opened; $i++ )
		{
			if ( !in_array ( $openedtags[$i], $closedtags ) )
			{
				$html .= "</" . $openedtags[$i] . ">";
			}
			else
			{
				unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
			}
		}
		return $html;
	}

	public static function clearRssStr($orgStr, $convert = false)
	{
		if ($convert)
		{
			$str = iconv('UTF-8', 'WINDOWS-1251', $orgStr);
		}
		else
		{
			$str = $orgStr;
		}
		$search = array("’",'„','”','“','"',"'");
		$replace = array('&quot;','&quot;','&quot;','&quot;','&quot;','&quot;');

		$cleanStr = @str_replace($search, $replace, $str);
		return $cleanStr;
	}

	public static function cleanRssURL($object, $fullUrl = false)
	{
		$url = self::cleanURL($object, $fullUrl);
		$str = iconv('UTF-8', 'WINDOWS-1251', $url);
		return $str;
	}

	public static function cutRssStr($orgStr, $maxLen, $addStr)
	{
		$str = iconv('UTF-8', 'WINDOWS-1251', $orgStr);
		$len = strlen($str);
		if ($len > $maxLen)
		{
			return substr($str, 0, $maxLen).$addStr;
		}
		else
		{
			return $str;
		}
	}

	//================================================================================================== Date finctions

	public static function Date($datetimestr, $format, $mktime = false)
	{
		//example date: 2008-05-06 11:44:41
		$datetime = explode(' ', $datetimestr);
		$date = explode('-', $datetime[0]);
		if (isset($datetime[1]))
			$time = explode(':', $datetime[1]);
		else
			$time = array(0,0,0);
		//	mktime(hour, minute, second, month, day, year)
		$timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		if ($mktime)
		{
			return $timestamp;
		}
		else
		{
			return date($format, $timestamp);
		}
	}
	public static function DateBG($datetimestr, $format, $mktime = false)
	{
		//example date: 2008-05-06 11:44:41
		$datetime = explode(' ', $datetimestr);
		$date = explode('-', $datetime[0]);
		if (isset($datetime[1]))
			$time = explode(':', $datetime[1]);
		else
			$time = array(0,0,0);
		//	mktime(hour, minute, second, month, day, year)
		$timestamp = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
		if ($mktime)
		{
			return $timestamp;
		}
		else
		{
			$month['01'] = 'Януари';
			$month['02'] = 'Февруари';
			$month['03'] = 'Март';
			$month['04'] = 'Април';
			$month['05'] = 'Май';
			$month['06'] = 'Юни';
			$month['07'] = 'Юли';
			$month['08'] = 'Август';
			$month['09'] = 'Септември';
			$month['10'] = 'Октомври';
			$month['11'] = 'Ноември';
			$month['12'] = 'Декември';
			$m1 = substr($month[$date[1]], 0, 3);
			$m2 = $month[$date[1]];
			$format = str_replace(array('M','F'), array($m1, $m2), $format);
			return date($format, $timestamp);
		}
	}

	public static function GetRAWDate($datetimestr = null)
	{
		if (!$datetimestr)
		{
			$datetimestr = date("Y-m-d H:i:s", time());
		}
		$datetime = explode(' ', $datetimestr);
		$date = explode('-', $datetime[0]);
		$time = explode(':', $datetime[1]);
		//	mktime(hour, minute, second, month, day, year)
		return $date[0] . $date[1] . $date[2] . $time[0] . $time[1] . $time[2];
	}

	public static function ConvertDateToEn($datetimestr, $format = "Y-m-d 00:00:00")
	{
		if(substr($datetimestr, 4, 1) != "-")
		{
			$datetime = explode(' ', $datetimestr);

			if(substr($datetime[0], 2, 1) == ".")
			{
				$date = explode('.', $datetime[0]);
			}
			else
			{
				$date = explode('/', $datetime[0]);
			}
			//$time = explode(':', $datetime[1]);

			$timestamp = mktime(0, 0, 0, $date[1], $date[0], $date[2]);
			return date($format, $timestamp);
		}

		return $datetimestr;
	}

	//================================================================================================== String FILL finctions

	public static function LeftFill($str, $len, $addChar = '0', $trim=false)
	{
		$orgLen = strlen($str);
		if ($orgLen > $len)
		{
			if ($trim)
			return substr($str, -$len);
			else
			return $str;
		}
		else
		{
			for ($i = $len-$orgLen; $i > 0; $i--)
			{
				$str = $addChar.$str;
			}
			return $str;
		}
	}

	public static function RightFill($str, $len, $addChar = ' ', $trim=false)
	{
		$orgLen = strlen($str);
		if ($orgLen > $len)
		{
			if ($trim)
			return substr($str, 0, $len);
			else
			return $str;
		}
		else
		{
			for ($i = $len-$orgLen; $i > 0; $i--)
			{
				$str .= $addChar;
			}
			return $str;
		}
	}

	//================================================================================================== Localization translate

	public static function mb_ucfirst($str)
	{
		mb_internal_encoding("UTF-8");

		$fc = mb_strtoupper(mb_substr($str, 0, 1));
		return $fc.mb_substr($str, 1);
	}

	public static function Localize($label)
	{
		mb_internal_encoding("UTF-8");
		$localeFile = sfConfig::get('sf_root_dir')."/cache/locales.php";
		if (is_readable($localeFile))
		{
			include $localeFile;
			$add = "";
			$str = "";
			$labelStr = false;
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
			$search = mb_strtolower($upLabel);
			// if we want Upper first letter...
			if ($labelStr || $upLabel.$labelStr == $label)
			{

				$str = self::mb_ucfirst($locales[$search]).$add;
			}
			else
			{
				if (array_key_exists($search, $locales))
					$str = $locales[$search].$add;
			}
		}
		// if we have no match...
		if (isset($add) && $str == $add)
		{
			//$str = '*'.$upLabel.'*';
			$str = '';
		}
		if (!isset($str)) $str = null;
		return $str;
	}

	public static function Settings($label)
	{
		mb_internal_encoding("UTF-8");
		$localeFile = sfConfig::get('sf_root_dir')."/cache/settings.php";
		if (is_readable($localeFile))
		{
			include $localeFile;
			$str = "";
			$search = mb_strtolower($label);
			if (array_key_exists($search, $settings))
				$str = $settings[$search];
		}
		// if we have no match...
		if (isset($add) && $str == $add)
		{
			$str = '*'.$label.'*';
		}
		if (!isset($str)) $str = null;
		return $str;
	}

	//================================================================================================== DB Field functions
	public static function convertFieldName($property)
	{
		$propertyName = "";
		$props = explode("_", $property);
		foreach ($props as $prop)
		{
			$propertyName .= ucfirst($prop);
		}
		return $propertyName;
	}

	//================================================================================================== Sorting functions
	public static function array_sort($array, $type='asc')
	{
		$result = array();
		foreach($array as $var => $val)
		{
			$set = false;
			foreach($result as $var2 => $val2)
			{
				if ($set == false)
				{
					if ($val > $val2 && $type=='desc' || $val < $val2 && $type=='asc')
					{
						$temp = array();
						foreach($result as $var3 => $val3)
						{
							if ($var3 == $var2)
							{
								$set=true;
							}
							if ($set)
							{
								$temp[$var3] = $val3;
								unset($result[$var3]);
							}
						}
						$result[$var] = $val;
						foreach($temp as $var3 => $val3)
						{
							$result[$var3] = $val3;
						}
					}
				}
			}
			if(!$set)
			{
				$result[$var] = $val;
			}
		}
		return $result;
	}

	public static function array_sort2($array, $field='label', $type='asc')
	{
		$result = array();
		foreach($array as $key => $val)
		{
			$set = false;
			foreach($result as $key2 => $val2)
			{
				if ($set == false)
				{
					if (($val[$field] > $val2[$field] && $type=='desc') || ($val[$field] < $val2[$field] && $type=='asc'))
					{
						$temp = array();
						foreach($result as $key3 => $val3)
						{
							if ($key3 == $key2)
							{
								$set = true;
							}
							if ($set)
							{
								$temp[$key3] = $val3;
								unset($result[$key3]);
							}
						}
						$result[$key] = $val;
						foreach($temp as $key3 => $val3)
						{
							$result[$key3] = $val3;
						}
					}
				}
			}
			if (!$set)
			{
				$result[$key] = $val;
			}
		}
		return $result;
	}

	public static function quicksort($arr, $field='label', $sort='asc')
	{
		if (count($arr) <= 1)
		{
			return $arr;
		}
		$piv = $arr[0];
		$x = $y = array();
		$len = count($arr);
		$i = 1;
		while($i < $len)
		{
			if (($sort == 'asc') && ($arr[$i][$field] <= $piv[$field]))
			{
				$x[] = $arr[$i];
			}
			else if (($sort == 'desc') && ($arr[$i][$field] > $piv[$field]))
			{
				$x[] = $arr[$i];
			}
			else
			{
				$y[] = $arr[$i];
			}
			++$i;
		}
		return array_merge(UtilsHelper::quicksort($x, $field, $sort), array($piv), UtilsHelper::quicksort($y, $field, $sort));
	}

	public static function makeBlock($itemsArr, $label, $paramStr)
	{
		$str = '<td width="20%" valign="top" height="100%">
		<table cellspacing="0" cellpadding="0" border="0" class="top_ten_location">
		<tr>
		<td valign="top">
		<h2 class="top_ten_title">'.UtilsHelper::Localize('properties.frontend.'.$label).'</h2>
		<ul class="top_ten_list">
		';

		foreach ($itemsArr as $item)
		{
			$str .= '					<li><a title="'.$item['label'].' ('.$item['count'].') " href="'.$listUrl.'?'.$paramStr.'='.$item['id'].'">'.$item['label'].' ('.$item['count'].')</a></li>
			';
		}

		$str .= '				</ul>
		</td>
		</tr>
		</table>
		</td>';

		return $str;
	}

	public static function setFlashMsg($msg = '', $type = 1, $ajax = false)
	{
		$context = sfContext::getInstance();
		$request = $context->getRequest();
		$errors = $request->getErrors();
		$errStr = "";

		$i = 1;
		$br = '';

		foreach($errors as $key => $error)
		{
			$errStr .= $error.$br;
			if ($i != count($errors)) $errStr .= "<br />";
			$i++;
		}

		switch ($type)
		{
			case self::MSG_WARNING:
				$oops = '<span class="warning_title">Warning</span><br/>';
				$class  = 'warning';
				break;

			case self::MSG_INFO:
				$oops = '<span class="info_title">Info</span><br/>';
				$class  = 'info';
				break;

			case self::MSG_ERROR:
				$oops = '<span class="error_title">Error</span><br/>';
				$class  = 'error';
				$icon  = '/images/icons/ico_error.png';
				break;

			case self::MSG_SUCCESS:
				$class = 'success';
				$oops = '<span class="success_title">Success</span><br/>';
				break;
			default:
				$oops = '';
				$class = 'success';
				break;
		}

		if($errStr != "") $msg .= "";

		$msg = '<div class="'.$class.' flashMsg">'.$msg.$errStr.'<br class="clear size5"/><br class="clear size5"/></div>';
		if ($ajax == false)
		{
			$user_session = $context->getUser();
			$user_session->setAttribute("flashMsg", $msg);
		}
		return $msg;
	}

	public static function setBackendMsg($msg = '', $type = "success")
	{
		$context = sfContext::getInstance();
		$request = $context->getRequest();
		$msg = "<div class='".$type."' id='backendMsg'>".$msg."</div>";
		$request->setParameter("backendMsg", $msg);
		return $msg;
	}

	/**
	 * Add params in url, keeping the old ones
	 *
	 * @param string $in_arr
	 * @return string
	 */
	public static function keepUrl($in_arr='', $acceptOnly = array())
	{
		if (!is_array($in_arr))
		{
			if (strlen($in_arr) > 0)
			{
				$prearr = explode('=',$in_arr);
				$in_arr = array($prearr[0]=>$prearr[1]);
			}
			else
			{
				$in_arr = array();
			}
		}

		$q = $_SERVER['QUERY_STRING'];
		if (count($in_arr) < 1) return $q;

		$q = explode('&',$q);
		foreach($q as $val)
		{
			if ($val)
			{
				$expl = explode('=',$val);
				if(!isset($in_arr[$expl[0]]))
				{
					$in_arr[$expl[0]] = $expl[1];
				}
			}
		}

		if(isset($in_arr['url'])) unset($in_arr['url']);

		$newArr = array();
		if(!empty($acceptOnly))
		{
			foreach($in_arr as $key=>$val)
			{
				if(in_array($key,$acceptOnly)) $newArr[] = $key.'='.$val;
			}
		}
		else
		{
			foreach($in_arr as $key=>$val)
			{
				$newArr[] = $key.'='.$val;
			}
		}

		return '?'.implode('&',$newArr);
	}

	// checks if the Email is well formatted
	public static function validateEmail($email) {
		return preg_match("/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email);
	}

	/**
	 * Remove HTML tags, including invisible text such as style and
	 * script code, and embedded objects.  Add line breaks around
	 * block-level tags to prevent word joining after tag removal.
	 */
	public static function strip_html_tags( $text )
	{

		$text = preg_replace(
		array(
		// Remove invisible content
		'@<head[^>]*?>.*?</head>@siu',
		'@<style[^>]*?>.*?</style>@siu',
		'@<script[^>]*?.*?</script>@siu',
		'@<object[^>]*?.*?</object>@siu',
		'@<embed[^>]*?.*?</embed>@siu',
		'@<applet[^>]*?.*?</applet>@siu',
		'@<noframes[^>]*?.*?</noframes>@siu',
		'@<noscript[^>]*?.*?</noscript>@siu',
		'@<noembed[^>]*?.*?</noembed>@siu',
		// Add line breaks before and after blocks
		'@</?((br)|(address)|(blockquote)|(center)|(del))@iu',
		'@</?((div)|(u)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
		'@</?((dir)|(dl)|(dt)|(dd)|(menu)|(ol)|(ul))@iu',
		'@</?(li>)@iu',
		'@<?(li>)@iu',
		'@</?((table)|(th)|(td)|(caption))@iu',
		'@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
		'@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
		'@</?((frameset)|(frame)|(iframe))@iu',
		),
		array(
		'', '', '', '', '', '', '', '', '',
		"\r\n\$0", "\r\n\$0", "\r\n\$0", "\r\n\$0", " - \$0", "\r\n\$0", "\r\n\$0", "\r\n\$0",
		"\r\n\$0", "\r\n\$0",
		),
		$text );
		return strip_tags( $text );
	}

	/**
	 * format new lines
	 *
	 * @param string $text
	 * @return string
	 */
	public static function Only1br($string)
	{
		$string = str_replace(array("<br>","<br/>","<br />"), "\n\n\n", $string);
		$string = preg_replace("/\n\s/", "\n", $string);
		$string = preg_replace("/\s\n/", "\n", $string);
		$string = preg_replace("/\t/", "", $string);
		//$string = preg_replace("/\s+?\n\s+?\n\s+?/", "\n", $string);
		//$string = preg_replace("/\s+?\n\s+?\n\s+?/", "\n", $string);

		//	$string = preg_replace("/\n\s\n/","",$string);

		$string = preg_replace("/\s?\n\s?\n\s?/", "\n", $string);
		$string = preg_replace("/\s?\n\s?\n\s?/", "\n", $string);
		//a$string = preg_replace("/\r\n+/s","\r\n",$string);
		//$string = preg_replace('/\r/', '', $string);
		$string = nl2br($string);
		return $string;
	}

	public static function diff($old, $new)
	{
		foreach($old as $oindex => $ovalue)
		{
			//echo $oindex." => ".$ovalue;

			$nkeys = array_keys($new, $ovalue);
			//var_dump($nkeys);
			foreach($nkeys as $nindex)
			{
				$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ? $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
				if($matrix[$oindex][$nindex] > $maxlen)
				{
					$maxlen = $matrix[$oindex][$nindex];
					$omax = $oindex + 1 - $maxlen;
					$nmax = $nindex + 1 - $maxlen;
				}
			}
		}
		if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
		return array_merge(
			self::diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
			array_slice($new, $nmax, $maxlen),
			self::diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
	}

	public static function htmlDiff($old, $new)
	{
		$diff = self::diff(explode(" ", $old), explode(" ", $new));
		foreach($diff as $k)
		{
			if(is_array($k))
			$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
			else
			$ret .= $k . ' ';
		}
		return $ret;
	}

	public static function loadTrademarkTypes($kindsArr = array())
	{
//		$kindsArr['mixed'] = 'Combined';
//		$kindsArr['text'] = 'Word';
//		$kindsArr['image'] = 'Image';
		$kindsArr['mixed'] = 'Комбинирана';
		$kindsArr['text'] = 'Словна';
		$kindsArr['image'] = 'Образнa';
		$kindsArr['3d'] = '3D';
		$kindsArr['sound'] = 'Звукова';
		return $kindsArr;
	}

}