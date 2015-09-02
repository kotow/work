<?php
use_helper('Form');
use_helper('Date');

function panel_multi_checkbox($name, $input = "0", $elements = array(), $options = array(), $methode = null)
{
	$items = get_val($input, $methode, $name);

	if (is_null($items) || empty($items))
	{
		$checked = false;
	}
	else
	{
		if (!is_array($items))
		{
			if (strpos($items, '[') !== false)
				$items = explode("][", substr($items, 1, -1));
			else
				$items = explode(";", $items);
		}

		foreach($items as $item)
		{
			$checked[$item] = 1;
		}
	}

	$out = get_field_wrapper($options, $name);

	if ($err = sfContext::getInstance()->getRequest()->getError($name))
		$options['class'] .= " error";

	$code = "<input type='hidden' name='$name' value='none'>";

	foreach ($elements as $id => $element)
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
				$valArr = explode("|", $element->get_value());
				if(substr($valArr[1], 0, 5) == "Lists") $label = $label."<b> [list: ".substr($valArr[1], 6)."]</b>";
			}
		}
		else
		{
			$label = $element;
		}
		$code .= "<div style='width:200px; float:left; margin:0px'>";
		$code .= checkbox_tag($name.'['.$id.']', $id, $checked[$id], clear_options($options, 1))." ".$label;
		$code .= "</div>";
	}

	return str_replace('##code##', $code, $out);
}

function exist_mothod($input, $searchMethod)
{
	$objMethods = get_class_methods(get_class($input));
	return in_array($searchMethod, $objMethods);
}

function get_val($input, $methode, $name = null)
{
	$value = sfContext::getInstance()->getRequest()->getParameter($name);
	if (!is_null($value))
	{
		return $value;
	}
	elseif (is_object($input) && !is_null($methode))
	{
		if (exist_mothod($input, $methode))
		{
			$value = $input->$methode();
		}
		else
		{
			return "";
		}
	}
	elseif (!is_null($input))
	{
		$value = $input;
	}

	return $value;
}

function get_radio_val($input, $methode, $name, $resValue=null)
{
	$value = sfContext::getInstance()->getRequest()->getParameter($name);
	if($value !== null)
	{
		return $value == $resValue;
	}
	elseif (is_object($input) && $methode !== null)
	{
		if (method_exist($input, $methode))
		{
			$value = $input->$methode();
		}
	}
	elseif ($input !== null)
		return $input;
	return $value == $resValue;
}

function get_label_name($labelname, $name)
{
	if(!is_null($labelname))
		return $labelname;
	else
		return $name;
}

function clear_options($options, $defsize = 50)
{
	$optionCleaned = array();
	$authorised = array("style", "with_format", "value", "id", "class", "name", "alt", "title", "onclick", "ondblclick", "onchange", "required", "onblur", "onfocus", "size", "rows", "cols", "maxlength", "readonly", "withtime", "culture", "include_custom", "empty", "year_start", "year_end", "rich", "parse", 'disabled');
	foreach ($options as $key => $option)
	{
		if (in_array(strtolower($key), $authorised))
		{
			$optionCleaned[$key] = $option;
		}
	}
	if (!array_key_exists("size", $optionCleaned) )
		$optionCleaned["size"] = $defsize;

	return $optionCleaned;
}

function get_field_wrapper($options, $name)
{
	if (array_key_exists('required', $options) && $options['required'])
	{
		$required = ' <a href="javascript: void(0);" title="Required"><em>*</em></a>';
	}
	else
	{
		$required = '';
	}
	if (array_key_exists('richtext', $options))
		return '
		<div class="field">
			<label style="float:left">'.get_label_name($options['labelname'], $name).$required.'</label>
			<div class="field-right">
				##code##
			</div>
			<div class="clear"></div>
		</div>
';
	else if (array_key_exists('wait', $options))
		return '
		<div class="field">
			<label style="float:left;">'.get_label_name($options['labelname'], $name).$required.'</label>
			##code## <img id="select_wait" style="display: none;" title="Working..." src="/images/load.gif">
        </div>
';
	else
		return '
		<div class="field">
			<label style="float:left;">'.get_label_name($options['labelname'], $name).$required.'</label>
				##code##
        </div>
';
}

function panel_hidden($name, $input = null,  $options = array(), $methode = null)
{
	return input_hidden_tag($name, get_val($input, $methode, $name), $options);
}

function panel_input($name, $input = null, $options = array(), $methode = null)
{
	$out = get_field_wrapper($options, $name);
	if ($err = sfContext::getInstance()->getRequest()->getError($name))
		$options['class'] .= " error";
	if (array_key_exists('password', $options))
	{
		$code = input_password_tag($name, get_val($input, $methode, $name), clear_options($options));
	}
	else
	{
		$code = input_tag($name, get_val($input, $methode, $name), clear_options($options));
	}
	if ($name == "attrRewriteUrl")
	{
		$code .= ' <input type="button" value="Generate" class="seo-url" onClick="generateUrl(\'attrRewriteUrl\', \'attrNavigationTitle\');" />';
	}
	return str_replace('##code##', $code, $out);
}

function panel_droppable($name, $input = null, $options = array(), $methode = null)
{
	$code = panel_hidden('attr'.ucfirst($name), $input, '', 'get'.ucfirst($name));
	$code .= get_field_wrapper($options, $name);
	$obj = Document::getDocumentInstance(get_val($input, $methode, $name));

	if ($options['width'])
	{
		$code .= panel_hidden($name.'_thumbwidth', $options['width']);
	}
	if ($options['height'])
	{
		$code .= panel_hidden($name.'_thumbheight', $options['height']);
	}
	if ($options['path'])
	{
		$code .= panel_hidden('thumbpath', $options['path']);
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

function panel_media($name, $input = null, $options = array(), $methode = null)
{
	return panel_image($name, $input, $options, $methode);
}

function panel_image($name, $input = null, $options = array(), $methode = null)
{
	$allowed = ", 'images'";
	$paramsStr = "";
	if (array_key_exists("allowed", $options))
	{
		$allowed = ", '".$options['allowed']."'";
	}

	if(array_key_exists("width", $options))
	{
		$paramsStr .= "gw-".$options['width']."-";
	}

	if(array_key_exists("height", $options))
	{
		$paramsStr .= "gh-".$options['height']."-";
	}

	if(array_key_exists("thumb_width", $options))
	{
		$paramsStr .= "gtw-".$options['thumb_width']."-";
	}

	if(array_key_exists("thumb_height", $options))
	{
		$paramsStr .= "gth-".$options['thumb_height']."-";
	}

	if(array_key_exists("path", $options))
	{
		$paramsStr .= "gp-".$options['path']."-";
	}
	$paramsStr = str_replace("-", DIRECTORY_SEPARATOR, $paramsStr);

	$obj = Document::getDocumentInstance(get_val($input, $methode));
	if ($obj && $obj->isImage())
	{
		$objId = $obj->getId();
		$src = "/media/display/thumb/thumbs/id/".$objId;
	}
	else
	{
		$objId = 0;
	 	$src = "/images/icons/no_img.gif";
	}

	if (array_key_exists("showOnly", $options))
	{
		$titleStr = 'Image';
		$clearImage = '';
	}
	else
	{
		$titleStr = 'Click here to upload image';
		$clearImage = '<img style="border: medium none;" src="/images/icons/clear.gif" title="Clear image" onclick="clear_image(\''.$name.'\')">';
	}

	if ($options['showOnly'])
		$code ='
<div class="field">
    <label style="float: left;">'.get_label_name($options['labelname'], $name).'</label>
    '.panel_hidden('attr'.$name, get_val($input, $methode, $name), '', 'get'.ucfirst($name)).'
    <div style="width: 200px; float: left;">
        <ul class="insert-image" id="container_'.$name.'">
            <li id="'.$name.'">
            	<img src="'.$src.'" title="image" />
            </li>
        </ul>
    </div>
</div><br style="clear:both">';
	else
		$code ='
<div class="field">
    <label style="float: left;">'.get_label_name($options['labelname'], $name).'</label>
    '.panel_hidden('attr'.$name, get_val($input, $methode, $name), '', 'get'.ucfirst($name)).'
    <div style="width: 200px; float: left;">
        <ul class="insert-image" id="container_'.$name.'">
            <li id="'.$name.'" onclick="upload_image(\''.$name.'\''.$allowed.',\''.$objId.'\', \''.$paramsStr.'\')">
            	<img src="'.$src.'" title="'.$titleStr.'" />
            </li>
        </ul>
        '.$clearImage.'
    </div>
</div><br style="clear:both">';

	return $code;
}

function panel_gallery($objId, $options = array())
{
	$paramsStr = "";
	if (isset($options['width']))
	{
		//$code .= panel_hidden('gw', $options['width']);
		$paramsStr .= "gw-".$options['width']."-";
	}
	if (isset($options['height']))
	{
		//$code .= panel_hidden('gh', $options['height']);
		$paramsStr .= "gh-".$options['height']."-";
	}
	if (isset($options['path']))
	{
		//$code .= panel_hidden('gp', $options['path']);
		$paramsStr .= "gp-".$options['path']."-";
	}
	if (isset($options['thumb_width']))
	{
		//$code .= panel_hidden('gtw', $options['thumb_width']);
		$paramsStr .= "gtw-".$options['thumb_width']."-";
	}
	if (isset($options['thumb_height']))
	{
		//$code .= panel_hidden('gth', $options['thumb_height']);
		$paramsStr .= "gth-".$options['thumb_height']."-";
	}
	if (isset($options['thumb_path']))
	{
		//$code .= panel_hidden('gtp', $options['thumb_path']);
		$paramsStr .= "gtp-".$options['thumb_path']."-";
	}
	if (isset($options['crop_width']))
	{
		//$code .= panel_hidden('gw', $options['width']);
		$paramsStr .= "gcw-".$options['crop_width']."-";
	}
	if (isset($options['crop_height']))
	{
		//$code .= panel_hidden('gh', $options['height']);
		$paramsStr .= "gch-".$options['crop_height']."-";
	}

	$paramsStr = str_replace("/", "_", $paramsStr);
	$paramsStr = str_replace("-", DIRECTORY_SEPARATOR, $paramsStr);

	$code = '
<div class="field">
	<label>'.get_label_name($options['labelname'], '').'</label>
	<a class="support" id="add_gallery_image" href="javascript:void(0);" onclick="upload_gallery('.$objId.',\''.$paramsStr.'\')">Add image to gallery</a>
	<input id="gallery_params" type="hidden" value="'.$paramsStr.'">
</div>

<div class="field">
	<p class="text-highlight">Please note that the maximum allowable size of each file is 4 MB. Allowed file formats are JPG, JPEG, GIF, PNG.</p>
</div>
<input type="hidden" id="usedImage" value="" />
<div class="images-holder" id="galleryPicsList">
	&nbsp;
</div>
';
	return $code;
}

function panel_radio($name, $input = null, $value, $options = array(), $methode = null)
{
	if (isset($options['no_wrapper']))
		$out = '##code##';
	else
		$out = get_field_wrapper($options, $name);
	if ($err = sfContext::getInstance()->getRequest()->getError($name))
	{
		$options["class"] .= " error";
	}
	$checked = get_radio_val($input, $methode, $name, $value);
	$code = radiobutton_tag($name, $value, $checked, clear_options($options));
	return str_replace('##code##', $code, $out);
}

function panel_checkbox($name, $input = "0", $options = array(), $methode = null)
{
	if (isset($options['no_wrapper']))
		$out = '##code##';
	else
		$out = get_field_wrapper($options, $name);

	$value = get_val($input, $methode, $name);
	if( is_null($value) || empty($value))
	{
		$checked = false;
	}
	else
	{
		$checked = true;
	}
	if ($err = sfContext::getInstance()->getRequest()->getError($name))
		$options['class'] .= " error";
	$code = "<input type='hidden' name='$name' value='0'>\n";
	$code .= checkbox_tag($name, "1", $checked, clear_options($options, 1));
	return str_replace('##code##', $code, $out);
}

/*function panel_multi_checkbox($name, $input = "0", $elements = array(), $options = array(), $methode = null)
{
	$items = get_val($input, $methode, $name);

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
	$code .= get_field_wrapper($options, $name);

	foreach ($elements as $id => $element)
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
				$valArr = explode("|", $element->get_value());
				if(substr($valArr[1], 0, 5) == "Lists") $label = $label."<b> [list: ".substr($valArr[1], 6)."]</b>";
			}
		}
		else
		{
			$label = $element;
		}
		$code .= "<div style='width:280px; float:left; margin:0px'>";
		$code .= checkbox_tag($name.'['.$id.']', $id, $checked[$id], clear_options($options, 1))." ".$label;
		$code .= "</div>";
	}

	$code .= "</div>";

	return $code;
}*/

function panel_select($name, $input = null, $option_tags = null, $options = array(), $methode = null)
{
	$out = get_field_wrapper($options, $name);

	if ($err = sfContext::getInstance()->getRequest()->getError($name))
	{
		$options['class'] .= " error";
	}
	$code = select_tag($name, options_for_select($option_tags, get_val($input, $methode, $name)), clear_options($options, 1));
	return str_replace('##code##', $code, $out);
}

function panel_culture($name, $input = null, $option_tags = null, $options = array(), $methode = null)
{
	if ($err = sfContext::getInstance()->getRequest()->getError($name))
	{
		$options['class'] .= " error";
	}

	if(count($option_tags) == 1)
	{
		$culture = array_shift(array_keys($option_tags));
		$code = input_hidden_tag($name, $culture, $options);
		return $code;
	}
	else
	{
		$out = get_field_wrapper($options, $name);
		$code = select_tag($name, options_for_select($option_tags, get_val($input, $methode, $name)), clear_options($options, 1));
		return str_replace('##code##', $code, $out);
	}
}
function panel_select_html($name, $input = null, $option_tags = null, $options = array(), $methode = null)
{
	return options_for_select($option_tags, get_val($input, $methode, $name), $options);
}
function panel_select_items($name, $html, $options = array())
{
	$code = get_field_wrapper($options, $name);
	if ($options['validate']) $errSpan = "<br><span id='".$name."Error'></span>";

	$code .= select_tag($name, $html, clear_options($options, 1));
	$code .= $errSpan;
	return $code;
}

function panel_get_template_blocks($template)
{
	$tplFile = sfConfig::get('sf_root_dir')."/frontend/modules/website/templates/$template.xml";
	if (!file_exists($tplFile))
		$tplFile = sfConfig::get('sf_root_dir')."/lib/modules/website/templates/$template.xml";
	$content = file_get_contents($tplFile);
	$richtext = XMLParser::getXMLdata($content);
	$out = array(); $ind = 0;
	foreach ($richtext[0] as $obj)
	{
		if (($obj['tag'] == 'DESTINATION') && ($obj['type'] == 'complete'))
		{
			if (substr($obj['attributes']['TYPE'], 0, 8) == 'richtext')
			{
				$ind++;
				$out[$ind]['id'] = 'richtext'.$ind;
				$out[$ind]['target'] = $obj['attributes']['ID'];
				$out[$ind]['content'] = '';
			}
		}
	}
	return $out;
}
function panel_get_richtext_blocks($content)
{
	$richtext = XMLParser::getXMLdata($content);
	$out = array(); $ind = 0;
	foreach ($richtext[0] as $obj)
	{
		if (($obj['tag'] == 'BLOCK') && ($obj['type'] == 'complete'))
		{
			if (substr($obj['attributes']['ID'], 0, 8) == 'richtext')
			{
				//$name = substr($obj['attributes']['ID'], 8);
				$ind++;
				$out[$ind]['id'] = $obj['attributes']['ID'];
				$out[$ind]['target'] = $obj['attributes']['TARGET'];
				$out[$ind]['content'] = $obj["value"];
			}
		}
	}
	return $out;
}
function panel_textarea($name, $input = null, $options = array(), $methode = null)
{
/*	$code = get_field_wrapper($options, $name);

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
	$code .= textarea_tag($name, get_val($input, $methode, $name), clear_options($options));
	$code .= $errSpan;*/

//	$out = get_field_wrapper($options, $name);
	$code = $out = '';

	$content = get_val($input, $methode, $name);

	// parse Page->Content (richtext blocks)
	if ($content && array_key_exists("parse", $options) && array_key_exists("richtext", $options))
	{
		$options['id'] = $name;
		$richtext = panel_get_richtext_blocks($content); //var_dump($richtext);
		if (count($richtext)>0)
		{
			echo "<!-- found richtext in content -->\n";
			// sort by RichText number
			ksort($richtext);
			$elementName = $options['labelname'];
			$elementId = $options['id'];
			foreach ($richtext as $i => $arr)
			{
				$options['labelname'] = $elementName.$i;
				$options['id'] = $elementId.$i;
				$edit = get_field_wrapper($options, $name.$i);
				$code = textarea_tag($name.$i, $arr['content'], clear_options($options));
				// add hidden tag with TARGET for richtext content
				$out .= str_replace('##code##', $code, $edit)
					.panel_hidden('contentID'.$i, $arr['id']) // id
					.panel_hidden('contentTarget'.$i, $arr['target']); // target
			}
			return $out;
		}
		else
		{
			echo "<!-- no richtext in content -->\n";
			if ($input)
			{
				// parse template content (richtext blocks)
				if ($template = get_val($input, 'getTemplate', 'attrTemplate'))
				{
					$richtext = panel_get_template_blocks($template); //var_dump($richtext);
					if (count($richtext)>0)
					{
						// sort by RichText number
						ksort($richtext);
						$elementName = $options['labelname'];
						$elementId = $options['id'];
						foreach ($richtext as $i => $arr)
						{
							$options['labelname'] = $elementName.$i;
							$options['id'] = $elementId.$i;
							$edit = get_field_wrapper($options, $name.$i);
							$code = textarea_tag($name.$i, $arr['content'], clear_options($options));
							// add hidden tag with TARGET for richtext content
							$out .= str_replace('##code##', $code, $edit)
								.panel_hidden('contentID'.$i, $arr['id']) //id
								.panel_hidden('contentTarget'.$i, $arr['target']); //targt
						}
						return $out;
					}
					else
					{
						echo "<!-- no richtext in template -->\n";
//						$out = get_field_wrapper($options, $name);
//						if ($options['target'])
//							$out .= panel_hidden(str_replace('attrContent', 'contentTarget', $name), $options['target']);
//						$code = textarea_tag($name, $content, clear_options($options));
					}
				}
			}
			return str_replace('##code##', $code, $out);
		}
	}
	else
	{
		//if ($input)
		{
			$out = get_field_wrapper($options, $name);
			if (array_key_exists("target", $options))
				$out .= panel_hidden(str_replace('attrContent', 'contentTarget', $name), $options['target']);
			if ($err = sfContext::getInstance()->getRequest()->getError($name))
				$options['class'] .= " error";
			$code = textarea_tag($name, $content, clear_options($options));
		}
		return str_replace('##code##', $code, $out);
	}
}

function panel_date($name, $input = null, $options = array(), $methode = null)
{
	$out = get_field_wrapper($options, $name);
	if ($err = sfContext::getInstance()->getRequest()->getError($name))
		$options['class'] .= " error";
	$code = input_date_tag($name, get_val($input, $methode, $name), clear_options($options));
	return str_replace('##code##', $code, $out);
}

function panel_tags($tags, $obj, $id=null)
{
	if ($id)
		$obj = Document::getDocumentInstance($id);
//	if(substr(get_class($obj),-4) == "I18n") $obj = Document::getParentOf($obj->getId());

	$count = count($tags);
	$user = sfContext::getInstance()->getUser()->getSubscriber();
	if ($count == 0 || ($user && $user->getType() != "admin")) return;
	if ($count)
	{
		$width = intval(100/$count)-1;
	}
	if ($count > 4)
	{
		$width = 16;
	}

	if ($count)
	{
		$widthStr = 'width="'.$width.'%"';
	}
	if ($count > 0)
	{
		$code = "<h3>Tags</h3>
		<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
	}
	$ind = 0;
	foreach ($tags as $tag)
	{
		if ($ind % 6 == 0)
		{
			$code .=
				"\t<tr>\n";
			$closed = false;
		}
		$code .=
			"\t\t<td width='20'>\n".
			"\t\t\t".panel_checkbox('tag_id_'.$tag->getId(), Document::hasTag($obj, $tag->getTagId()), array('class' => 'check_box', 'labelname' => '', 'no_wrapper' => 1))."\n".
			"\t\t</td>\n".
			"\t\t<td ".$widthStr." class=\"label_checkbox\">".$tag->getLabel()."</td>\n";
		if ($ind % 6 == 5)
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

function panel_save_button($options = array())
{
	//panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes'))
	$class = (isset($options['class'])) ? $options['class'] : 'submit';
	$label = (isset($options['value'])) ? $options['value'] : 'Save Changes';
	return '
		<br />
		<div class="buttons">
			<a href="javascript:void(0);" onclick="validate_form()" class="'.$class.'">'.$label.'</a>
			<input name="submitEdit" type="hidden" value="save" />
			<input style="display: none;" type="submit" value="save" />
			<div class="clear"></div>
		</div>
';
}

function panel_modal()
{
	return '';
}
function panel_modal_images()
{
	return '
		<!-- START Modal images -->
		<div id="delete-image" title="Delete Image">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>
		</div>
		<div id="edit-image" title="Edit Image">
			&nbsp;
		</div>
		<input style="display: none" type="button" id="edit_close" name="edit_close" onclick="edit_image_close();" />
		<div id="upload-image" title="Upload Image">
			&nbsp;
		</div>
		<input style="display: none" type="button" id="image_close" name="image_close" onclick="upload_image_close();" />
		<div id="upload-gallery" title="Upload Gallery Image">
			&nbsp;
		</div>
		<input style="display: none" type="button" id="galerry_close" name="gallery_close" onclick="upload_gallery_close();" />
		<!-- END Modal images -->
';
}

function panel_keywords($name, $input = null, $options = array(), $methode = null)
{
	$keywords = get_val($input, $methode, $name);
/*	if ($keywords)
	{
		$keywords = substr($keywords, 1, -1);
		$keywords = str_replace('][', ',', $keywords).',';
	}*/
	$keywordsArr = explode(",", $keywords);

	$out = get_field_wrapper($options, $name);
//	$code = '<div style="width: 70%; float: left;"><div id="keywordsStock" style="background: #E1E1E1; min-height: 25px;">&nbsp;';
	$code = '<div style="width: 70%; float: left;"><div id="keywordsStock">';
	foreach ($keywordsArr as $key)
	{
		if ($key)
		{
			$keyObj = Document::getDocumentInstance($key);
			if ($keyObj = Document::getDocumentInstance($key))
			{
				$code .= '<div id="key_'.$key.'" class="key_del" onclick="removeKeyword(\''.$key.'\')">'.$keyObj->getLabel().'</div>';
			}
		}
	}
	$code .= '</div>';
	$code .= input_hidden_tag($name, $keywords, array('id' => 'keywords'));
	$code .= '<br><div style="clear:both"></div>';

	if ($options['size'])
	{
		$size = $options['size'];
	}
	else
	{
		$size = 70;
	}
	$code .= '<input type="text" id="keyword" autocomplete="off" size="'.$size.'" onfocus="document.getElementById(\'fk\').style.display = \'none\'"
	onkeyup="getKeywords(this.value, document.getElementById(\'fk\'), \''.$options['btnLabel'].'\')">
	&nbsp;<input type="button" value="'.$options['btnLabel'].'" onclick="addKeyword(document.getElementById(\'keyword\').value)"><div id="fk">
</div>';
	return str_replace('##code##', $code, $out);
}

function panel_related($name, $input = null, $options = array(), $methode = null)
{
	$related = get_val($input, $methode, $name);
	$relatedArr = explode(";", $related);

	$out = get_field_wrapper($options, $name);
	$code = '<div id="relatedStock">';
	foreach ($relatedArr as $rel)
	{
		if ($rel)
		{
			$relObj = Document::getDocumentInstance($rel);
			if ($relObj = Document::getDocumentInstance($rel))
			{
				$code .= '<div id="rel_'.$rel.'" class="rel_del" onclick="removeRelated(\''.$rel.'\')">'.$relObj->getLabel().'</div>';
			}
		}
	}
	$code .= '</div>';
	$code .= input_hidden_tag($name, $related, array('id' => 'related'));
	$code .= '<div style="clear: both;"></div>';

	if ($options['size'])
	{
		$size = $options['size'];
	}
	else
	{
		$size = 50;
	}
	if ($options['max'])
	{
		$max = $options['max'];
	}
	else
	{
		$max = 3;
	}
//	$code .= '<input type="text" id="relate" autocomplete="off" size="'.$size.'" onfocus="document.getElementById(\'rl\').style.display = \'none\'"
//	onkeyup="getRelated(this.value, document.getElementById(\'rl\'))">
//	&nbsp;<input type="button" value="Find news" onclick="findRelated(document.getElementById(\'relate\').value, 1)">
//	&nbsp;<input type="button" value="Find features" onclick="findRelated(document.getElementById(\'relate\').value, 2)">
//	<div id="rl"></div>
//';
	$code .= '<input type="text" id="relate" autocomplete="off" size="'.$size.'" onfocus="document.getElementById(\'rl\').style.display = \'none\'">
	&nbsp;<input type="button" value="Find news" onclick="getRelated(1, '.$max.')">
	&nbsp;<input type="button" value="Find features" onclick="getRelated(2, '.$max.')">
	<div id="rl"></div>
';
	return str_replace('##code##', $code, $out);
}

function panel_heading($name, $input, $methode, $default, $documentName)
{
	//$obj, 'getLabel', 'Create new page'))
	$val = get_val($input, $methode, $name);
	if (!$val)
		$val = '<i>'.$default.'</i>';
	return '
	<h1 class="lead-heading">'.$documentName.': '.$val.'</h1>
';
}

function panel_separator($element, $options)
{
	return '
	<hr class="brake" />
';
}
