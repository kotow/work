<?php
use_helper('Form');
use_helper('Date');

function method_exist($input, $searchMethod)
{
	$objMethods = get_class_methods(get_class($input));
	return in_array($searchMethod, $objMethods);
}

function getVal($input, $methode, $name, $format = null)
{
	$value = sfContext::getInstance()->getRequest()->getParameter($name);
	if (!is_null($value))
	{
		if($value == 'Available at') $value = null;
		return $value;
	}
	elseif (is_object($input) && !is_null($methode))
	{
		if (method_exist($input, $methode))
		{
			if ($format)
				$value = $input->$methode($format);
			else
				$value = $input->$methode();
		}
		else
		{
			return "";
		}
	}
	elseif(!is_null($input))
	{
		$value = $input;
	}

	return $value;
}

function getLabelName($labelname, $name)
{
	if(!is_null($labelname))
	{
		$value = $labelname;
	}
	else
	{
		$value = '';
	}
	return $value;
}

function clearOptions($options, $defsize = 50)
{
	$optionCleaned = array();
	foreach ($options as $key => $option)
	{
		$authorised = array("class", "value", "format", "year_start", "year_end", "id", "class", "name", "alt", "title", "onclick", "onmouseover", "onmouseout", "ondblclick", "onchange", "onkeyup", "required", "onblur", "onfocus", "size", "maxlength", "readonly", "style", "disabled", "withtime", "rich");
		if (in_array(strtolower($key), $authorised))
		{
			$optionCleaned[$key] = $option;
		}
		if(!array_key_exists("size", $optionCleaned) )
			$optionCleaned["size"] = $defsize;
	}

	return $optionCleaned;
}

function getDivLabel($options, $name)
{
	$code = "";
	if(array_key_exists('div',$options)) $div = $options['div']; else $div = "div";
	if(array_key_exists('labelname',$options)) $labelname = getLabelName($options['labelname'], $name);
	if(array_key_exists('required', $options)) $star = "<em>*</em>";
	if(!empty($labelname)) $code = "<".$div.">".getLabelName($options['labelname'], $name)." ".$star." : </".$div.">\n";
	return $code;
}

function frontend_hidden($name, $input = null,  $options = array(), $methode = null)
{
	return input_hidden_tag($name, getVal($input, $methode, $name), $options);
}

function frontend_input($name, $input = null, $options = array(), $methode = null)
{
	$context = sfContext::getInstance();
	$request = $context->getRequest();
	$errors = $request->getErrors();
	
	if(array_key_exists("err".$name, $errors))
	{
		if (isset($options["class"]))
			$options["class"] .= " error";
		else
			$options["class"] = "error";
	}
	$code = getDivLabel($options, $name);
	$errSpan = "";
	if(array_key_exists('validate', $options)) $errSpan = "<br><span id='".$name."Error'></span>";
	if(array_key_exists('password', $options))
	{
		$code .= input_password_tag($name, getVal($input, $methode, $name), clearOptions($options));
	}
	else
	{
		if (isset($options['format']))
			$code .= input_tag($name, getVal($input, $methode, $name, $options['format']), clearOptions($options));
		else
			$code .= input_tag($name, getVal($input, $methode, $name), clearOptions($options));
	}

	if($name == "attrRewriteUrl") $code .= ' <img align="absbottom" src="/images/btn_generate.gif" onClick="generateUrl(\'attrRewriteUrl\', \'attrLabel\');"/>';
	$code .= $errSpan;
	return $code;
}

function frontend_droppable($name, $input = null, $options = array(), $methode = null)
{
	$code = frontend_hidden('attr'.ucfirst($name), $input, '', 'get'.ucfirst($name));
	$code .= getDivLabel($options, $name);
	$obj = Document::getDocumentInstance(getVal($input, $methode, $name));

	if($options['width']) $code .= frontend_hidden('thumbwidth', $options['width']);
	if($options['height']) $code .= frontend_hidden('thumbheight', $options['height']);

	if($options['path']) $thumbpath = $options['path']."/";

	if($options['path']) $code .= frontend_hidden('thumbpath', $options['path']);
	$code .= "<table><tr>";
	if($obj)
	{
		$label = $obj->getLabel();
		$fileName = $obj->getFilename();

		if($obj->isImage())
		{
			$src = "/media/display/thumb/thumbs/id/".$obj->getId();

			$code .= '<td 	class="attrImage"
							id="'.$name.'"
							name="'.$name.'">';
			$code .= '<img	align="absbottom"
							height="100"
							src="'.$src.'"/>';
			$code .= '</td><td valign="bottom">';

			$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'&nbsp;\'; document.getElementById(\'attr'.ucfirst($name).'\').value = \'\'; ">';
			$code .= '</td>';
		}
		else
		{
			$code .= '<td 	class="attrImage"
							id="'.$name.'"
							name="'.$name.'">'.$label."<br>".$fileName.'</td><td valign="bottom">';
			$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'&nbsp;\'; document.getElementById(\'attr'.ucfirst($name).'\').value = \'\'; ">';
			$code .= '</td>';
		}

	}
	else
	{
		$code .= '<td 	class="attrImage"
						id="'.$name.'"
						name="'.$name.'">&nbsp;</td><td valign="bottom">';
		$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'&nbsp;\'; document.getElementById(\'attr'.ucfirst($name).'\').value = \'\'; ">';
		$code .= '</td>';
	}
	$code .= "</tr></table>";
	return $code;
}

function frontend_radio($name, $input = null, $value, $options = array(), $methode = null)
{
	$context = sfContext::getInstance();
	$request = $context->getRequest();
	$errors = $request->getErrors();
	if(array_key_exists("err".$name, $errors))
	{
		$options["class"] .= " error";
	}
	$code = getDivLabel($options, $name);
	$code .= radiobutton_tag($name, $value, $value == getVal($input, $methode, $name), clearOptions($options));
	return $code;
}

function frontend_checkbox($name, $input = "0", $elements = array(), $options = array(), $methode = null)
{
	$value = getVal($input, $methode, $name);
	if(is_null($value) || empty($value))
	{
		$checked = false;
	}
	else
	{
		if(!is_array($value)) $value = explode(";", $value);
		foreach($value as $item)
		{
			$checked[$item] = 1;
		}
	}

	$options['div'] = "span";
	$code = "<div>";
	$code .= getDivLabel($options, $name);
	//$code .= "<br>";

	foreach($elements as $id => $element)
	{
		if (is_object($element))
		{
			$label = $element->getLabel();
		}
		else
		{
			$label = $element;
		}
		$code .= checkbox_tag($name.'['.$id.']', $id, $checked[$id], clearOptions($options, 1))." ".$label."<br>";
	}

	$code .= "</div>";

	return $code;
}


function frontend_multi_checkbox($name, $input = "0", $elements = array(), $options = array(), $methode = null)
{
	$items = getVal($input, $methode, $name);

	if(is_null($items) || empty($items))
	{
		$checked = false;
	}
	else
	{
		if(!is_array($items))
		{
			$items = explode(";", $items);
		}

		foreach($items as $item)
		{
			$checked[$item] = 1;
		}
	}

	$code = "<div>";
	$code .= getDivLabel($options, $name);

	foreach($elements as $id => $element)
	{
		if (is_object($element))
		{
			$label = $element->getLabel();
		}
		else
		{
			$label = $element;
		}

		$code .= "<div class='checkbox_holder' style='float:left; margin:0px'>";
		$code .= checkbox_tag($name.'['.$id.']', $id, $checked[$id], clearOptions($options, 1))." ".'<label for="job_types_'.$id.'">'.$label."</label>";
		$code .= "</div>";
	}

	$code .= "</div>";

	return $code;
}


function frontend_select($name, $input = null, $option_tags = null, $options = array(), $methode = null)
{
	$context = sfContext::getInstance();
	$request = $context->getRequest();
	$errors = $request->getErrors();
	
	//var_dump($errors);
	if(array_key_exists("err".$name, $errors))
	{
		$options["class"] .= " error";
	}
	
	$errSpan = "";
	$code = getDivLabel($options, $name);
	if(array_key_exists('validate', $options)) $errSpan = "<br><span id='".$name."Error'></span>";

	if (array_key_exists('unique', $options))
	{
		/*if (substr(get_class($input),-4) == "I18n")
		{
			$parentClass = substr(get_class($input), 0, -4);
		}
		else*/
		{
			$parentClass = null;
		}

		if ($input)
		{
			$children = Document::getChildrenOf(Document::getParentOf($input->getId(), $parentClass, false), ucfirst($options['model']));

			$objListitem = $input->$methode();
		}
		else
		{
			$children = Document::getChildrenOf($request->getParameter('parent'), ucfirst($options['model']));
			$objListitem = null;
		}

		foreach ($children as $child)
		{
			$listitem = $child->$methode();
			if ($objListitem != $listitem)
			{
				unset($option_tags[$listitem]);
			}
		}
	}

	$code .= select_tag($name, options_for_select($option_tags, getVal($input, $methode, $name)), clearOptions($options, 1));
	$code .= $errSpan;
	return $code;
}

function frontend_textarea($name, $input = null, $options = array(), $methode = null)
{
	$context = sfContext::getInstance();
	$request = $context->getRequest();
	$errors = $request->getErrors();
	
	if(array_key_exists("err".$name, $errors))
	{
		$options["class"] .= " error";
	}
	
	$errSpan = "";
	$code = getDivLabel($options, $name);
	$user = sfContext::getInstance()->getUser()->getSubscriber();
	if ($user && ($user->getType() == 'admin'))
	{
		$isAdmin = 1;
	}

	if (array_key_exists('richtext', $options))
	{
		$options['id'] = 'richtext_'.$name;
		$options['onclick'] = 'selectElement(this, '.$isAdmin.'); '.$options['onclick'];
	}

	if(array_key_exists('validate', $options)) $errSpan = "<<span id='".$name."Error'></span>";
	$code .= textarea_tag($name, getVal($input, $methode, $name), clearOptions($options));
	$code .= $errSpan;
	return $code;
}

function frontend_date($name, $input = null, $options = array(), $methode = null)
{
	$context = sfContext::getInstance();
	$request = $context->getRequest();
	$errors = $request->getErrors();
	
	if(array_key_exists("err".$name, $errors))
	{
		$options["class"] .= " error";
	}
	
	$errSpan = "";
	$code = getDivLabel($options, $name);
	if(in_array('validate', $options)) $errSpan = "<span id='".$name."Error'></span>";
	$code .= input_date_tag($name, getVal($input, $methode, $name), clearOptions($options));
	$code .= $errSpan;
	return $code;
}

function frontend_tags($tags, $obj)
{
	if(count($tags) > 0)
		$code = "<h3>Tags</h3>";
	foreach ($tags as $tag)
	{
		$code .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n".
				"\t<tr>\n".
				"\t\t<td>\n".
				"\t\t\t".frontend_checkbox('tag_id_'.$tag->getId(), Document::hasTag($obj, $tag->getTagId()), array("class" => "check_box", "labelname" => ""))."\n".
				"\t\t</td>\n".
				"\t\t<td class=\"label_checkbox\">".getLabelName($options['labelname'], $tag->getLabel())."</td>\n".
				"\t</tr>".
				"</table>";
	}
	return $code;

}
