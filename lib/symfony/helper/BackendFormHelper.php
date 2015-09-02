<?php
use_helper('Form');
use_helper('Date');

function method_exist($input, $searchMethod)
{
	$objMethods = get_class_methods(get_class($input));
	return in_array($searchMethod, $objMethods);
}

function getVal($input, $methode, $name)
{
	if($value = sfContext::getInstance()->getRequest()->getParameter($name))
	{
		return $value;
	}
	elseif (is_object($input) && !is_null($methode))
	{
		if (method_exist($input, $methode))
		{
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
		$value = $name;
	}
	return $value;
}

function clearOptions($options, $defsize = 50)
{
	foreach ($options as $key => $option)
	{
		$authorised = array("style", "value", "id", "class", "name", "alt", "title", "onclick", "ondblclick", "onchange", "required", "onblur", "onfocus", "size", "maxlength", "readonly", "withtime", "culture", "include_custom", "empty", "year_start", "year_end", "rich");
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
	if($options['div']) $div = $options['div']; else $div = "div";
	$labelname = getLabelName($options['labelname'], $name);
	if($options['required'])
		$star = "<em>*</em>";
	if(!empty($labelname))
		$code = "<".$div.">".getLabelName($options['labelname'], $name)." ".$star." : </".$div.">\n";
	return $code;
}
function backend_hidden($name, $input = null,  $options = array(), $methode = null)
{
	return input_hidden_tag($name, getVal($input, $methode, $name), $options);
}

function backend_input($name, $input = null, $options = array(), $methode = null)
{
	$code = getDivLabel($options, $name);
	if($options['validate']) $errSpan = "<span id='".$name."Error'></span>";
	if($options['password'])
	{
		$code .= input_password_tag($name, getVal($input, $methode, $name), clearOptions($options));
	}
	else
	{
		$code .= input_tag($name, getVal($input, $methode, $name), clearOptions($options));
	}


	if($name == "attrRewriteUrl") $code .= ' <img align="absbottom" src="/images/btn_generate.gif" onClick="generateUrl(\'attrRewriteUrl\', \'attrLabel\');"/>';
	$code .= $errSpan;
	return $code;
}

function backend_droppable($name, $input = null, $options = array(), $methode = null)
{
	$code = backend_hidden('attr'.ucfirst($name), $input, '', 'get'.ucfirst($name));
	$code .= getDivLabel($options, $name);
	$obj = Document::getDocumentInstance(getVal($input, $methode, $name));



	if ($options['width'])
	{
		$code .= backend_hidden($name.'_thumbwidth', $options['width']);
	}
	if ($options['height'])
	{
		$code .= backend_hidden($name.'_thumbheight', $options['height']);
	}
	if ($options['path'])
	{
		$code .= backend_hidden('thumbpath', $options['path']);
	}
	$code .= "<table><tr>";
	if($obj && get_class($obj) == "Media")
	{
		$label = $obj->getLabel();
		$fileName = $obj->getFilename();

		if($obj->isImage())
		{
			$src = "/media/display/thumb/thumbs/id/".$obj->getId();

			$code .= '<td class="attrImage"
							id="'.$name.'"
							name="'.$name.'">';
			$code .= '<img	align="absbottom"
							height="100"
							src="'.$src.'"/>';
			$code .= '</td><td valign="bottom">';
			$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'&nbsp;\'; document.getElementById(\'attr'.ucfirst($name).'\').value = \'0\'; ">';
			$code .= '</td>';
		}
		else
		{
			$code .= '<td class="attrImage"
							id="'.$name.'"
							name="'.$name.'">'.$label."<br>".$fileName.'</td><td valign="bottom">';
			$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'&nbsp;\'; document.getElementById(\'attr'.ucfirst($name).'\').value = \'0\'; ">';
			$code .= '</td>';
		}
	}
	else
	{
		$code .= '<td class="attrImage"
						id="'.$name.'"
						name="'.$name.'">&nbsp;</td><td valign="bottom">';
		$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'&nbsp;\'; document.getElementById(\'attr'.ucfirst($name).'\').value = \'0\'; ">';
		$code .= '</td>';
	}
	$code .= "</tr></table>";
	return $code;
}

function backend_media($name, $input = null, $options = array(), $methode = null)
{
	$code = backend_hidden('attr'.$name, getVal($input, $methode, $name), '', 'get'.ucfirst($name));
	$code .= getDivLabel($options, $name);
	$obj = Document::getDocumentInstance(getVal($input, $methode));

	if(array_key_exists("allowed", $options)) $allowed = ", '".$options['allowed']."'";

	$code .= "<table><tr>";
	if($obj  && get_class($obj) == "Media")
	{
		$label = $obj->getLabel();
		$fileName = $obj->getFilename();

		if($obj->isImage())
		{
			$src = "/media/display/thumb/thumbs/id/".$obj->getId();

			$code .= '<td onclick="addMedia(\''.$name.'\''.$allowed.')" class="attrImage"
							id="'.$name.'"
							name="'.$name.'" align="center">';
			$code .= '<img align="absbottom"
							src="'.$src.'"/>';
			$code .= '</td><td valign="bottom">';

			$code .= '&nbsp;<img style="border:none"
			src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'click to choose media\';
			document.getElementById(\'attr'.$name.'\').value = \'0\'; ">';

			$code .= '</td>';
		}
		else
		{
			$code .= '<td onclick="addMedia(\''.$name.'\''.$allowed.')" class="attrImage"
							id="'.$name.'"
							name="'.$name.'" align="center">'.$label.'</td><td valign="bottom">';
			$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'click to choose media\'; document.getElementById(\'attr'.$name.'\').value = \'0\'; ">';
			$code .= '</td>';
		}
	}
	else
	{
		$code .= '<td onclick="addMedia(\''.$name.'\''.$allowed.')" class="attrImage"
						id="'.$name.'"
						name="'.$name.'" align="center">click to choose media</td><td valign="bottom">';
		$code .= '&nbsp;<img style="border:none" src="/images/icons/clear.gif" onclick="document.getElementById(\''.$name.'\').innerHTML = \'click to choose media\'; document.getElementById(\'attr'.$name.'\').value = \'0\'; ">';
		$code .= '</td>';
	}
	$code .= "</tr></table>";
	return $code;
}

function backend_gallery($objId, $options = array())
{
	$paramsStr = "";
	if ($options['width'])
	{
		$code .= backend_hidden('gw', $options['width']);
		$paramsStr .= "gw-".$options['width']."-";
	}
	if ($options['height'])
	{
		$code .= backend_hidden('gh', $options['height']);
		$paramsStr .= "gh-".$options['height']."-";
	}
	if ($options['path'])
	{
		$code .= backend_hidden('gp', $options['path']);
		$paramsStr .= "gp-".$options['path']."-";
	}

	if ($options['thumb_width'])
	{
		$code .= backend_hidden('gtw', $options['thumb_width']);
		$paramsStr .= "gtw-".$options['thumb_width']."-";
	}
	if ($options['thumb_height'])
	{
		$code .= backend_hidden('gth', $options['thumb_height']);
		$paramsStr .= "gth-".$options['thumb_height']."-";
	}
	if ($options['thumb_path'])
	{
		$code .= backend_hidden('gtp', $options['thumb_path']);
		$paramsStr .= "gtp-".$options['thumb_path']."-";
	}

	$paramsStr = str_replace("/", "_", $paramsStr);
	$children = Document::getChildrenOf($objId, "Media");
	$code = "<br><div id='line'></div><br><a href='javascript:;' onclick='addGalleryMedia(".$objId.",\"".$paramsStr."\")'>> Add pic to gallery</a><ul id='galleryPicsList'>";
	foreach ($children as $pic)
	{
		$code .= "<li><img src='".$pic->getRelativeThumbUrl()."'><img onclick='deleteGalleryMedia(".$objId.", ".$pic->getId().");' src='/images/icons/delete.png'/></li>";
	}
	$code .= "</ul>";
	return $code;
}


function backend_checkbox($name, $input = "0", $options = array(), $methode = null)
{
	$value = getVal($input, $methode, $name);

	if( is_null($value) || empty($value))
	{
		$checked = false;
	}
	else
	{
		$checked = true;
	}

	$options['div'] = "span";

	$code = "<div>";
	$code .= getDivLabel($options, $name);
	//if($options['validate']) $errSpan = "<span id='".$name."Error'></span>";
	$code .= checkbox_tag($name, "1", $checked, clearOptions($options, 1));
	$code .= "</div>";
	//$code .= $errSpan;

	return $code;
}

function backend_multi_checkbox($name, $input = "0", $elements = array(), $options = array(), $methode = null)
{
	$items = getVal($input, $methode, $name);

	if (is_null($items) || empty($items))
	{
		$checked = false;
	}
	else
	{
		if(!is_array($items))
		{
			$items = explode(";", $items);
			//$items = unserialize($items);
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
			$id = $element->getId();
			$docClass = get_class($element);
			$m = "get".$docClass."Properties";
			$properties = Schema::$m();
			if(in_array("Value", $properties))
			{
				$valArr = explode("|", $element->getValue());
				if(substr($valArr[1], 0, 5) == "Lists") $label = $label."<b> [list: ".substr($valArr[1], 6)."]</b>";
			}
		}
		else
		{
			$label = $element;
		}
		$code .= "<div style='width:280px;float:left;margin:0px'>";
		$code .= checkbox_tag($name.'['.$id.']', $id, $checked[$id], clearOptions($options, 1))." ".$label;
		$code .= "</div>";
	}

	$code .= "</div>";

	return $code;
}

function backend_select($name, $input = null, $option_tags = null, $options = array(), $methode = null)
{
	$code = getDivLabel($options, $name);
	if ($options['validate']) $errSpan = "<span id='".$name."Error'></span>";

	if ($options['unique'])
	{
		if (substr(get_class($input),-4) == "I18n")
		{
			$parentClass = substr(get_class($input), 0, -4);
		}
		else
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
			$children = Document::getChildrenOf(sfContext::getInstance()->getRequest()->getParameter('parent'), ucfirst($options['model']));
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
function backend_select_html($name, $input = null, $option_tags = null, $options = array(), $methode = null)
{
	return options_for_select($option_tags, getVal($input, $methode, $name), $options);
}
function backend_select_items($name, $html, $options = array())
{
	$code = getDivLabel($options, $name);
	if ($options['validate']) $errSpan = "<br><span id='".$name."Error'></span>";

	$code .= select_tag($name, $html, clearOptions($options, 1));
	$code .= $errSpan;
	return $code;
}

function backend_textarea($name, $input = null, $options = array(), $methode = null)
{
	$code = getDivLabel($options, $name);

	$isAdmin = 0;
	$user = sfContext::getInstance()->getUser()->getSubscriber();
	if ($user && ($user->getType() == 'admin'))
	{
		$isAdmin = 1;
	}

	if ($options['richtext'])
	{
		$options['id'] = 'richtext_'.$name;
		$options['onclick'] = 'selectElement(this, '.$isAdmin.'); '.$options['onclick'];
	}

	if($options['validate']) $errSpan = "<span id='".$name."Error'></span>";
	$code .= textarea_tag($name, getVal($input, $methode, $name), clearOptions($options));
	$code .= $errSpan;
	return $code;
}

function backend_date($name, $input = null, $options = array(), $methode = null)
{
	$code = getDivLabel($options, $name);
	if($options['validate']) $errSpan = "<span id='".$name."Error'></span>";
	$code .= input_date_tag($name, getVal($input, $methode, $name), clearOptions($options));
	$code .= $errSpan;
	return $code;
}

/*function backend_tags($tags, $obj)
{
	if(count($tags) > 0)
		$code = "<h3>Tags</h3>";
	foreach ($tags as $tag)
	{
		$code .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n".
				"\t<tr>\n".
				"\t\t<td>\n".
				"\t\t\t".backend_checkbox('tag_id_'.$tag->getId(), Document::hasTag($obj, $tag->getTagId()), array("class" => "check_box", "labelname" => ""))."\n".
				"\t\t</td>\n".
				"\t\t<td class=\"label_checkbox\">".getLabelName($options['labelname'], $tag->getLabel())."</td>\n".
				"\t</tr>".
				"</table>";
	}
	return $code;
}*/

function backend_tags($tags, $obj)
{
	$count = count($tags);
	if ($count)
	{
		$width = intval(100/$count)-1;
	}
	if ($count > 4)
	{
		$width = 19;
	}

	if($count)
	{
		$widthStr = 'width="'.$width.'%"';
	}
	if($count > 0)
	{
		$code = "<h3>Tags</h3>
		<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
	}
	$ind = 0;
	foreach ($tags as $tag)
	{
		if ($ind % 5 == 0)
		{
			$code .=
				"\t<tr>\n";
			$closed = false;
		}
		$code .=
			"\t\t<td>\n".
			"\t\t\t".backend_checkbox('tag_id_'.$tag->getId(), Document::hasTag($obj, $tag->getTagId()), array("class" => "check_box", "labelname" => ""))."\n".
			"\t\t</td>\n".
			"\t\t<td ".$widthStr." class=\"label_checkbox\">".getLabelName($options['labelname'], $tag->getLabel())."</td>\n";
		if ($ind % 5 == 4)
		{
			$code .=
				"\t</tr>\n";
			$closed = true;
		}
		$ind++;
	}
	if($count > 0)
	{
		if (!$closed)
		{
			$code .=
				"\t</tr>\n";
		}
		$code .=
			"</table>";
	}
	return $code;
}

function backend_keywords($name, $input = null, $options = array(), $methode = null)
{
	$keywords = getVal($input, $methode, $name);
	if ($keywords)
	{
		$keywords = substr($keywords, 1, -1);
		$keywords = str_replace('][', ',', $keywords).',';
	}
	$keywordsArr = explode(",", $keywords);

	$code = '<div id="keywordsStock" style="width:325px">';
	foreach ($keywordsArr as $key)
	{
		$keyObj = Document::getDocumentInstance($key);
		if($keyObj = Document::getDocumentInstance($key))
		{
			$code .= '<div id="key_'.$key.'" class="s" onclick="removeKeyword(\''.$key.'\')">'.$keyObj->getLabel().'</div>';
		}
	}
	$code .= '</div>';
	$code .= input_hidden_tag($name, $keywords, array('id' => 'keywords'));
	$code .= '<br><div style="clear:both"></div>';
	$code .= getDivLabel($options, $name);
	if ($options['size'])
	{
		$size = $options['size'];
	}
	else
	{
		$size = 50;
	}
	$code .= '<input type="text" id="keyword" autocomplete="off" size="'.$size.'" onfocus="document.getElementById(\'fk\').style.display = \'none\'"
	onkeyup="getKeywords(this.value, document.getElementById(\'fk\'))">
	&nbsp<input type="button" value="'.$options['btnLabel'].'" onclick="addKeyword(document.getElementById(\'keyword\').value)"><div id="fk"></div>';
	return $code;
}
