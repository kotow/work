function loadAjaxPage( linkURL, containerID )
{
	$.ajax({
		url: linkURL,
		success: function(msg)
		{
			$("#"+containerID).html( msg );
		}
	});
}

function de(el, id)
{
	if(el.checked) var act = false; else var act = true;
	var inputs = document.getElementById("row_"+id).getElementsByTagName("input");
	for(var i=0; i < inputs.length; i++)
	{
		if(inputs[i].id != 'field_'+id)
		{
			if(act == false)
			{
				var imgCheck = document.getElementById('image_'+id);
				if (imgCheck.checked)
				{
					imgCheck.disabled = false;
					return;
				}

				var imgKey = document.getElementById('keywords_'+id);
				if (imgKey.checked)
				{
					imgKey.disabled = false;
					return;
				}
			}
			inputs[i].disabled = act;
		}
	}
}

function de2(el, id)
{
	if(el.checked) var act = true; else var act = false;
	var inputs = document.getElementById("row_"+id).getElementsByTagName("input");
	for(var i=0; i < inputs.length; i++)
	{
		if(inputs[i].id != 'field_'+id && inputs[i].id != el.id)
			inputs[i].disabled = act;
	}
}
function detectRssFields()
{
	var url = document.getElementById('attrUrl').value;
	url = url.split("&").join("@");
	url = url.split("?").join("|");
	var id = document.getElementById('id').value;

	$("#detected_fields").html('<img src="/images/load.gif" align="absmiddle"/> reading feed ...');
	loadAjaxPage('/admin/company/detectRssFields?rss_url='+url+'&id='+id, 'detected_fields');
}

function detectXmlFields()
{
	var url = document.getElementById('attrUrl').value;
	url = url.split("&").join("@");
	url = url.split("?").join("|");
	var id = document.getElementById('id').value;

	$("#detected_fields").html('<img src="/images/load.gif" align="absmiddle"/> reading feed ...');
	loadAjaxPage('/admin/company/detectXmlFields?xml_url='+url+'&id='+id, 'detected_fields');
}

function showFields(val)
{
	if(val == "EXTERNAL")
	{
		document.getElementById('EXTERNAL').style.display = "block";
		document.getElementById('REFERENCE').style.display = "none";
	}
	else if(val == "REFERENCE")
	{
		document.getElementById('EXTERNAL').style.display = "none";
		document.getElementById('REFERENCE').style.display = "block";
	}
	else
	{
		document.getElementById('EXTERNAL').style.display = "none";
		document.getElementById('REFERENCE').style.display = "none";
	}
}

function show_hide_admin_options(obj, silent)
{
	if(obj.value == 1)
	{
		if(silent)
		{
			document.getElementById('adminTab').style.display = "block";
			document.getElementById('attrBackend').value = "1";
		}
		else
		{
			if(confirm("This option enables access to administration! Do you want to proceed?"))
			{
				document.getElementById('adminTab').style.display = "block";
				document.getElementById('attrBackend').value = "1";
			}
			else
			{
				obj.options[1].selected == true;
				document.getElementById('adminTab').style.display = "none";
				document.getElementById('attrBackend').value = "0";
			}
		}
	}
	else
	{
		document.getElementById('adminTab').style.display = "none";
		document.getElementById('attrBackend').value = "0";
	}

}

function selectChecks(ids, el)
{
	var idsArr = ids.split(",");
	for(var i=0; i < idsArr.length; i++)
	{
		var box = document.getElementById(idsArr[i]);
		if(typeof box != "undefined" && box != null)
		{
			if(el.checked)
			{
				box.checked = true;
			}
			else
			{
				box.checked = false;
			}
		}
	}

}

function deleteBanner(documentId)
{
	if (confirm("Are you sure you want to delete this banner?"))
	{
		var url = "/admin/admin/delete/id/" + documentId;
		var xmlhttp = getXhr();
		if (xmlhttp != null)
		{
			xmlhttp.open("GET",url,true);
			xmlhttp.send(null);
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					// CHECK SESSION EXPIRED!!!
					var response = xmlhttp.responseText;
					if (response.indexOf("<!-- loged-out -->") > 0)
					{
						var updateElement = document.getElementById("bodyContent");
						updateElement.innerHTML = xmlhttp.responseText;
						selectedDocuments = new Array();
						return;
					}
					else
					{
						window.location.replace("/admin/website/banner");
					}
				}
			};
		}
	}
}

function addMedia(input, allowed)
{
	var w = document.getElementById("media_browse");
	w.style.display = "block";
	$("#media_browse").draggable({});
	$("#media_browse").fadeIn();

	if(typeof allowed == "undefined") allowed = ""
	var url = "/admin/media/uploadMediaContainer/input/"+input+"/allowed/"+allowed;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('media_browseContent').innerHTML = xmlhttp.responseText;
			}
		};
	}
}

function addGalleryMedia(id, paramsStr)
{
	var w = document.getElementById("media_gallery");
	w.style.display = "block";
	$("#media_gallery").draggable({});
	$("#media_gallery").fadeIn();

	var url = "/admin/media/uploadGalleryMediaContainer/parentMediaId/"+id+"/paramsStr/"+paramsStr;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('media_galleryContent').innerHTML = xmlhttp.responseText;
			}
		};
	}
}

function removeElement(id)
{
	var Node = document.getElementById(id);
	Node.parentNode.removeChild(Node);
}

function removeKeyword(id)
{
	var keywordsField = document.getElementById('keywords');
	var existingItems = keywordsField.value.split(",");
	var found = in_array(id, existingItems);
	if(found !== false)
	{
		existingItems.splice(found,1);
	}
	keywordsField.value = existingItems.join(",");
	removeElement("key_"+id);
}

function stock(id, label)
{
	var stockDiv = document.getElementById('keywordsStock');
	var keywordsField = document.getElementById('keywords');
	var existingItems = keywordsField.value.split(",");
	var found = in_array(id, existingItems);

	if(found === false)
	{
		stockDiv.innerHTML += "<div id='key_"+id+"' class='s' onclick='removeKeyword(\""+id+"\")'>"+label+"</div>";
		keywordsField.value += id+",";
	}
}

function getKeywords(key, updateDiv)
{
	var url = "/admin/keywords/getKeywords/keyword/"+key;
	var xhr = getXhr();
	var keys = "";
	var keysList = "";
	if (xhr != null)
	{
		xhr.onreadystatechange=function()
		{
			if (xhr.readyState==4 && xhr.status==200)
			{
				keys = xhr.responseText;
				var parts = keys.split(";");
				for(i=0 ; i < parts.length ; i++)
				{
					if(parts[i] != "")
					{
						var elements = parts[i].split(",");
						keysList += "<div class='k' title='Добави' onclick='stock(\""+elements[0]+"\",\""+elements[1]+"\")'>"+elements[1]+"</div>";
					}
				}

				if(keysList != "")
				{
					updateDiv.style.display = "block";
				}
				else
				{
					updateDiv.style.display = "none";
				}

				updateDiv.innerHTML = keysList;
			}
		};
	}

	xhr.open("GET", url, true);
	xhr.send(null);
}

function addKeyword(key)
{
	var url = "/admin/keywords/addKeyword/keyword/"+key;
	var xhr = getXhr();

	if (xhr != null)
	{
		xhr.onreadystatechange=function()
		{
			if (xhr.readyState==4 && xhr.status==200)
			{
				var addedKey = xhr.responseText;
				if(addedKey != "")
				{
					var parts = addedKey.split(",");
					stock(parts[0], parts[1]);
				}
			}
		};
	}

	xhr.open("GET", url, true);
	xhr.send(null);
}

function saveForm(act, module, docType)
{
	var form = document.getElementById("form");
	params = "";
	tinyMCE.triggerSave();
	for(var i=0; i < form.elements.length; i++)
	{
		if(form.elements[i].name == "id")
		{
			id = form.elements[i].value;
		}
		else if(form.elements[i].name == "attrLabel")
		{
			label = form.elements[i].value;
			label = label.replace(/&/gi, '%26');
			label = label.replace(/&/gi, '%26');
			label = label.replace(/&/gi, '%26');
			label = label.replace(/&/gi, '%26');
			label = label.replace(/&/gi, '%26');

		}
		else if(form.elements[i].name == "parent")
		{
			parentId = form.elements[i].value;
		}

		if(docType == "User")
		{
			if(form.elements[i].name == "attrFirstName")
			{
				label = form.elements[i].value;
				label = label.replace(/&/gi, '%26');
        label = label.replace(/&/gi, '%26');
        label = label.replace(/&/gi, '%26');
			}

			if(form.elements[i].name == "attrLastName")
			{
				label += ' '+form.elements[i].value;
				label = label.replace(/&/gi, '%26');
        label = label.replace(/&/gi, '%26');
        label = label.replace(/&/gi, '%26');
			}
		}

		if (params != "")
		{
			params = params+"&";
		}

		if(form.elements[i].type == "checkbox" && form.elements[i].checked == false)
		{
			params = params+form.elements[i].name+'=0';
		}
		else if(form.elements[i].type == "checkbox" && form.elements[i].checked)
		{
			params = params+form.elements[i].name+'='+form.elements[i].value;
		}
		else
		{
			var val = form.elements[i].value;
			if (typeof(val)=='string')
			{
//				val = val.replace(/&/gi, '%26');
				val = value = encodeURIComponent(val);
			}
			params = params+form.elements[i].name+'='+val;
		}
	}

	var url = '/admin/'+act+'?'+params;

	var xhr = getXhr();
	var save_status = document.getElementById("save_status")
	xhr.onreadystatechange = function()
	{
		if (xhr.readyState != 4 || xhr.status != 200)
		{
			save_status.innerHTML = '<img src="/images/load.gif" />'
		}
		else if (xhr.readyState == 4 && xhr.status == 200)
		{
			var response = xhr.responseText;
			var responseArr = response.split("|");
			if(responseArr[0] == "OK")
			{
				if(id != "")
				{

					editDocument(docType, id);

					updatedLeftElement = document.getElementById(id);
					if(typeof(updatedLeftElement) != "undefined")
					{
						updatedLeftElement.innerHTML = label;
					}
				}
				else
				{
					id = responseArr[2];
					parseMainList(null, parentId);

					var parentLi = document.getElementById("li_"+parentId);
					var ulElement = document.getElementById("ul_"+parentId);
					if(ulElement)
					{
						var elsUl = ulElement.getElementsByTagName("li");
						var nbrElUl = elsUl.length;

						var xhrlast = getXhr();
						if (xhrlast != null)
						{

							xhrlast.open("GET", "admin/getLastChildId/parentId/" + parentId + "/position/2", true);
							xhrlast.send(null);
							xhrlast.onreadystatechange=function()
							{
								if (xhrlast.readyState==4 && xhrlast.status==200)
								{
									var lastLiId = xhrlast.responseText;
									var lastLi = document.getElementById("li_"+lastLiId);
									if(lastLi)
									{
										if(lastLi.className == "expandable lastExpandable")
										{
											lastLi.className = "expandable";
										}
										else if(lastLi.className == "collapsable lastCollapsable")
										{
											lastLi.className = "collapsable";
										}
										else
										{
											lastLi.className = "";
										}
									}

									var newLi = document.createElement('li');
									var newSpan = document.createElement('span');

									ulElement.appendChild(newLi);
									newLi.appendChild(newSpan);

									newLi.className = "last";
									newLi.id = "li_"+id;

									newSpan.style.background = "transparent url(/images/icons/"+docType.toLowerCase()+".png) 0 0 no-repeat";
									newSpan.className = module.toLowerCase()+"_"+docType.toLowerCase();
									newSpan.onclick = function() {parseMainList(this)}
									newSpan.id = id;
									newSpan.innerHTML = label;
									initBindings();
								}
							};
						}
					}
					else
					{
						var ulElement = document.createElement('ul');
						if(parentLi) parentLi.appendChild(ulElement);

						var newLi = document.createElement('li');
						var newSpan = document.createElement('span');

						ulElement.appendChild(newLi);
						newLi.appendChild(newSpan);

						newLi.className = "last";
						newLi.id = "li_"+id;

						newSpan.style.background = "transparent url(/images/icons/"+docType.toLowerCase()+".png) 0 0 no-repeat";
						newSpan.className = module.toLowerCase()+"_"+docType.toLowerCase();
						newSpan.onclick = function() {parseMainList(this)}
						newSpan.id = id;
						newSpan.innerHTML = label;
						initBindings();
					}
				}
			}

			save_status.innerHTML = "<img src='/images/icons/save.jpg' border='0' align='absmiddle'> " + responseArr[1];
			save_status.style.padding = "10px 20px 10px 20px";
		}
	}


	xhr.open("POST", url, true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=UTF-8");
	xhr.setRequestHeader("Content-length", params.length);
	xhr.setRequestHeader("Connection", "close");
	xhr.send(params);
}

function deleteDocument(documentId)
{

	if (confirm("Are you sure you want to delete this element and all sub-elements?"))
	{
		var xhrp = getXhr();
		xhrp.open("GET", "admin/getParentId/id/" + documentId, true);
		xhrp.send(null);
		xhrp.onreadystatechange=function()
		{
			if (xhrp.readyState==4 && xhrp.status==200)
			{
				parentDocumentId = xhrp.responseText;

				var url = "admin/delete/id/" + documentId;
				var xmlhttp = getXhr();
				if (xmlhttp != null)
				{
					xmlhttp.open("GET",url,true);
					xmlhttp.send(null);
					xmlhttp.onreadystatechange=function()
					{
						if (xmlhttp.readyState==4 && xmlhttp.status==200)
						{
							// CHECK SESSION EXPIRED!!!
							var response = xmlhttp.responseText;
							if (response.indexOf("<!-- loged-out -->") > 0)
							{
								var updateElement = document.getElementById("bodyContent");
								updateElement.innerHTML = xmlhttp.responseText;
								selectedDocuments = new Array();
								return;
							}
							else if (response == "no_delete")
							{
								alert("you can not delete some of the selected items");
							}
							else
							{
								var el = document.getElementById("li_"+documentId);
								if(el) var parentUl = el.parentNode;

								if(parentUl)
								{
									elId = el.id;
									parentUl.removeChild(el);

									var xhr = getXhr();
									if (xhr != null)
									{
										xhr.open("GET", "admin/getLastChildId/parentId/" + parentDocumentId, true);

										xhr.send(null);
										xhr.onreadystatechange=function()
										{
											if (xhr.readyState==4 && xhr.status==200)
											{
												var lastLiId = xhr.responseText;
												var lastLi = document.getElementById("li_"+lastLiId);
												if(lastLi)
												{
													if(lastLi.className == "expandable")
													{
														lastLi.className += " lastExpandable";
													}
													else if(lastLi.className == "collapsable")
													{
														lastLi.className += " lastCollapsable";
													}
													else
													{
														lastLi.className = "last";
													}
												}
											}


										};
									}
									refreshMainList();
								}
							}
						}
					};
				}
			}
		};
	}
}

function executeMainListAction(action, parent, page)
{
	if(action == "admin/delete")
	{
		var url = action+"/p/"+parent+"/selectedDocuments/"+selectedDocuments;
		var xmlhttp = getXhr();
		if (xmlhttp != null)
		{
			xmlhttp.open("GET",url,true);
			xmlhttp.send(null);

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					if(typeof(selectedDocuments) != "undefined" && selectedDocuments && selectedDocuments.length > 0)
					{
						var response = xmlhttp.responseText;
						if (response.indexOf("<!-- loged-out -->") > 0)
						{
							var updateElement = document.getElementById("bodyContent");
							updateElement.innerHTML = xmlhttp.responseText;
							selectedDocuments = new Array();
							return;
						}
						if (response == "no_delete")
						{
							alert("you can not delete some of the selected items");
						}
						else
						{
							var firstEl = document.getElementById("li_"+selectedDocuments[0]);
							if(firstEl) var parentUl = firstEl.parentNode;

							if(parentUl)
							{
								for(var i = 0; i < selectedDocuments.length; i++)
								{
									var el = document.getElementById("li_"+selectedDocuments[i])
									if(el) parentUl.removeChild(el);
								}

								var xhr = getXhr();
								if (xhr != null)
								{
									xhr.open("GET", "admin/getLastChildId/parentId/" + parent, true);

									xhr.send(null);
									xhr.onreadystatechange=function()
									{
										if (xhr.readyState==4 && xhr.status==200)
										{
											var lastLiId = xhr.responseText;
											var lastLi = document.getElementById("li_"+lastLiId);
											if(lastLi)
											{
												if(lastLi.className == "expandable")
												{
													lastLi.className += " lastExpandable";
												}
												else if(lastLi.className == "collapsable")
												{
													lastLi.className += " lastCollapsable";
												}
												else
												{
													lastLi.className = "last";
												}
											}
										}

									};
								}
							}
						}
					}

					parseMainList(null, parent, page);
				}
			};
		}
	}
	else
	{
		var url = action+"/p/"+parent+"/selectedDocuments/"+selectedDocuments;
		var xmlhttp = getXhr();
		if (xmlhttp != null)
		{
			xmlhttp.open("GET",url,true);
			xmlhttp.send(null);

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					parseMainList(null, parent, page);
				}
			};
		}
	}
}

var run = true;
var run2 = true;
var run3 = true;
var validatedFields = new Array();
var selectedDocuments = new Array();
var modulename = null;
var rootname = null;
var parentDocumentId = null;
var pageDocumentId = null;
var clickedDocument = null;
var selectedElement = null;
var currentLanguage = 'en';

function in_array(needle, arr)
{
	for(var i = 0, l = arr.length; i < l; i++)
	{
		if(arr[i] == needle)
		{
			return i;
		}
	}
	return false;
}

function getXhr()
{
	var xhr = null;
	if(window.XMLHttpRequest)
	{
		xhr = new XMLHttpRequest();
	}
	else if(window.ActiveXObject)
	{
		try
		{
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	else
	{
		alert("Can't create XMLHTTPRequest");
		xhr = false;
	}
	return xhr;
}

function validateField(fieldid, url, exec)
{
	var absurl = "/admin/" + url;

	if (run === false && typeof(exec) == "undefined" && in_array(fieldid, validatedFields))
	{
		return;
	}

	var el = document.getElementById(fieldid);
	if (el)
	{
		var value = el.value;
		value = encodeURIComponent(value);

		if(absurl.indexOf("?") < 0) absurl += "?";
		var xhr = getXhr();

		xhr.onreadystatechange = function()
		{
			if (xhr.readyState == 4 && xhr.status == 200)
			{
				var resp = xhr.responseText;

				if (document.getElementById)
				{
					reciever = document.getElementById(fieldid+"Error");
				}
				else if (document.all)
				{
					reciever = document.all[fieldid+"Error"];
				}

				if (resp == "ok")
				{
					reciever.innerHTML = "";
					reciever.className = "valid";
				}
				else
				{
					var obj = document.getElementById(fieldid);
					if(obj)
					{
						var objvalue = obj.value.replace(/^\s+|\s+$/g, '');
						if(obj.attributes['required'] || objvalue != "")
						{
							reciever.innerHTML = resp;
							reciever.className = "error";
						}
						else
						{
							reciever.innerHTML = "";
							reciever.className = "valid";
						}
					}
				}
				validateEditForm();
				setTimeout('validateField("'+fieldid+'", "'+url+'", true)', 1000);
				run = false;
				validatedFields[validatedFields.length] = fieldid;
			}
		}
		xhr.open("GET",absurl+"&value="+value,true);
		xhr.send(null);
	}
}

function validateEditForm(exec)
{
	if (run2 === false && typeof(exec) == "undefined")
	{
		return;
	}

	if (document.getElementById("form"))
	{
		var el = document.getElementById("form").elements;
		var len = el.length;
		var ok = true;

		for(var i = 0 ; i < len ; i++)
		{
			var element = el[i];

			if (document.getElementById)
			{
				var errObj = document.getElementById(element.name+"Error");
			}
			else if (document.all)
			{
				var errObj = document.all[element.name+"Error"];
			}

			if (errObj)
			{
				var errClass = errObj.className;
				if (element.attributes['required'] && ((errClass != "valid") && (errClass != "")))
				{
					ok = false;
				}
				if ((!element.attributes['required']) && (errClass == "error"))
				{
					ok = false;
				}
			}
			else
			{
				if (element.attributes['required'])
				{
					var val = element.value.replace(/^\s+|\s+$/g, '');
					if (val == "")
					{
						ok = false;
					}
				}
			}
		}

		var btnSubmit = document.getElementById('btnSubmit');
		if (typeof(btnSubmit) != "undefined" && btnSubmit != null)
		{
			if (ok)
			{
				btnSubmit.disabled = false;
				btnSubmit.className = "save_btn";
			}
			else
			{
				btnSubmit.disabled = true;
				btnSubmit.className = "save_btndisabled";
			}
		}
	}
	setTimeout('validateEditForm(true)', 1000);
	run2 = false;
}

function validateCompare(id1, id2, compareLabel, exec)
{
	if(run3 === false && typeof(exec) == "undefined")
	{
		return;
	}

	reciever = document.getElementById(id1+"Error");
	el1 = document.getElementById(id1);
	el2 = document.getElementById(id2);

	if(el1.value != el2.value)
	{
		reciever.innerHTML = "Field do not match with field '"+compareLabel+"'";
		reciever.className = "error";
	}
	else
	{
		reciever.innerHTML = "";
		reciever.className = "valid";
	}

	validateEditForm();
	setTimeout('validateCompare("'+id1+'", "'+id2+'", "'+compareLabel+'", true)', 1000);
	run3 = false;
}

function SelectTab(tabSelectedObj)
{
	var tabSelected = tabSelectedObj.getAttribute("rel");
	var tabs = document.getElementById("tabs").getElementsByTagName("a");
	var subcontentids = [];
	for (var i=0; i<tabs.length; i++)
	{
		subcontentids[subcontentids.length] = tabs[i].getAttribute("rel")

		tabs[i].className = (tabs[i].getAttribute("rel") == tabSelected)? "selected" : ""
	}

	for (var i=0; i<subcontentids.length; i++)
	{
		subcontent = document.getElementById(subcontentids[i]);
		subcontent.style.display = (subcontent.id == tabSelected) ? "block" : "none";
	}
}

function displayForm(formIndex) {
	for (index = 1; index > 0; index++) {
		element = document.getElementById('backendForm' + index);
		if (!element) {
			break;
		}
		if (index == formIndex) {
			element.style.display = "block";
		}
		else {
			element.style.display = "none";
		}
	}
}

function stripVowelAccent(str)
{
	var s=str;

	var rExps=[ /[\xC0-\xC2]/g, /[\xE0-\xE2]/g,
	/[\xC8-\xCA]/g, /[\xE8-\xEB]/g,
	/[\xCC-\xCE]/g, /[\xEC-\xEE]/g,
	/[\xD2-\xD4]/g, /[\xF2-\xF4]/g,
	/[\xD9-\xDB]/g, /[\xF9-\xFB]/g ];

	var repChar=['A','a','E','e','I','i','O','o','U','u'];

	for(var i=0; i<rExps.length; i++)
	s = s.replace(rExps[i],repChar[i]);

	return s;
}

function generateUrl(textElement, sourceElement)
{
	var stripped = stripVowelAccent(document.getElementById(sourceElement).value);
	stripped = stripped.replace(/ /g, '-');
	document.getElementById(textElement).value = stripped.toLowerCase() + '.html';
}

function changePageType(typeValue)
{
	switch (typeValue)
	{
		case 'REFERENCE':
		document.getElementById("attrPageId").disabled = false;
		document.getElementById("attrActionName").disabled = true;
		document.getElementById("attrUrl").disabled = true;
		document.getElementById("attrTemplate").disabled = true;
		document.getElementById("attrStylesheet").disabled = true;
		break;
		case 'EXTERNAL':
		document.getElementById("attrPageId").disabled = true;
		document.getElementById("attrActionName").disabled = true;
		document.getElementById("attrUrl").disabled = false;
		document.getElementById("attrTemplate").disabled = true;
		document.getElementById("stylesheet").disabled = true;
		break;
		default:
		document.getElementById("attrPageId").disabled = true;
		document.getElementById("attrActionName").disabled = true;
		document.getElementById("attrUrl").disabled = true;
		document.getElementById("template").disabled = false;
		document.getElementById("attrStylesheet").disabled = false;
		break;
	}
}

function ucfirst(str)
{
	var ch = str.charAt(0).toUpperCase();
	return ch + str.substr(1, str.length-1);
}

function RefreshIndex(menuId, model, id, err, type)
{
	var url = '';
	var rootArray = menuId.split("_");
	modulename = ucfirst(rootArray[1]);

	url = "admin/leftTree/modulename/" + modulename;
	rootname = null;

	clickedDocument = null;
	selectedElement = null;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				state_Change('leftTreeReplaced', modulename, xmlhttp);

				if(type == "edit")
				{
					editDocument(model, id, err);
				}
				else if(type == "create")
				{
					createDocument(model, id, err);
				}
			}
		};
	}
}

function ClickMenu(el)
{
	var menuId = el.id;
	var url = '';
	var urlRight = '';
	if (menuId.indexOf("modules_") == 0)
	{
		var rootArray = menuId.split("_");
		modulename = ucfirst(rootArray[1]);
		rootname = rootArray[2];
		if (rootname)
		{
			rootname = ucfirst(rootname);
			url = "admin/leftTree/modulename/" +  rootname;
		}
		else
		{
			url = "admin/leftTree/modulename/" +  modulename;
			rootname = null;
		}
	}

	if (menuId.indexOf("action_") == 0)
	{
		var menuArray = menuId.split("_");
		url = menuArray[1] + "/" + menuArray[2];
		window.location = url;
	}

	clickedDocument = null;
	selectedElement = null;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				state_Change('leftTreeReplaced', modulename, xmlhttp);
			}
		};
		parseLanguageBar("");
	}
}

function state_Change(documentId, modulename, xmlhttp, clps)
{
	if (typeof clps == "undefined")
	{
		clps = true;
	}
	else
	{
		clps = false;
	}
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		document.getElementById(documentId).innerHTML = xmlhttp.responseText;

		if (documentId == 'leftTreeReplaced')
		{

			$(document).ready(function()
			{

				$("#leftNavigation").treeview({
					collapsed: clps
				});

				/*$(".draggable").draggable({ helper: "clone" });
				$(".draggable").droppable(
				{
					//accept: ".Media",
					//tolerance: "pointer",

					drop: function(ev, ui)
					{
						alert("drop");
						var dropguy = $(ui.draggable.element).clone();
						var droppedElementId = ui.element.id;
						var droppableName = 'attr' + ui.droppable.element.id;

						droppableName = droppableName.replace(' ui-droppable', '');

						document.getElementById(droppableName).value = droppedElementId;

						if (ui.element.attributes['image'].value == '1')
						{
							var inner = '<img height="100" src="/media/display/thumb/thumbs/id/' + droppedElementId + '"/>';
						}
						else
						{
							var inner = ui.element.innerHTML;
						}

						ui.droppable.element.innerHTML = inner;
					}
				});*/

			});

			initBindings();
			document.getElementById('rightTreeReplaced').innerHTML = "";

			if (rootname)
			{
				elements = document.getElementsByName('rootfolder_' + rootname.toLowerCase());
			}
			else
			{
				elements = document.getElementsByName('rootfolder_' + modulename.toLowerCase());
			}
			parseMainList(null, elements.item(0));
			document.getElementById('documentContent').innerHTML= '';

			var selectLang = document.getElementById("currentLanguage");
			if (selectLang != null)
			{
				changeCurrentLang(selectLang.value);
			}
		}

	}
}

function right_state_Change(documentId, xmlhttp)
{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		document.getElementById(documentId).innerHTML=xmlhttp.responseText;

		if (documentId == 'rightNavigation')
		{
			$(document).ready(function()
			{
				$("#rightNavigation").treeview(
				{
					collapsed: true
				});
			});

			$(document).ready(function()
			{
				$(".draggable").draggable({ helper: "clone" });

				$(".attrImage").droppable(
				{
					accept: ".Media",
					tolerance: "pointer",

					drop: function(ev, ui)
					{
						//var dropguy = $(ui.draggable.element).clone();
						var droppedElementId = ui.element.id;
						var droppableName = 'attr' + ui.droppable.element.id;

						droppableName = droppableName.replace(' ui-droppable', '');

						document.getElementById(droppableName).value = droppedElementId;

						if (ui.element.attributes['image'].value == '1')
						{
							var inner = '<img height="100" src="/media/display/thumb/thumbs/id/' + droppedElementId + '"/>';
						}
						else
						{
							var inner = ui.element.innerHTML;
						}

						ui.droppable.element.innerHTML = inner;
					}
				});
			});
		}
	}
}

function initRightTree(modulename)
{
	url = "admin/rightTree/modulename/" +  modulename;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				right_state_Change('rightTreeReplaced', xmlhttp);
			}
		};
	}
}

function getRightTree(modulename)
{
	url = "admin/getRightTree/modulename/" +  modulename;
	var xmlhttp=getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				right_state_Change('rightNavigation', xmlhttp);
			}
		};
	}
}

function parseMainList(obj, parentId, page, filter, pop)
{
	if(obj && typeof(obj) == "object")
	{
		var parentId = obj.id;
	}

	parentDocumentId = parentId;
	document.getElementById("save_status").innerHTML = "";
	document.getElementById("save_status").style.padding = "0";
	var updateElement = document.getElementById("documentContent");
	var inModule = '';

	if(typeof(filter) != "undefined" && filter != "")
	{
		if(typeof(pop) != "undefined" && pop != "")
		{
			var p = pop.indexOf(",");
			updateElement = document.getElementById("actionDivContent");
			actionDiv = document.getElementById("actionDiv");
			var url = modulename.toLowerCase()+"/"+filter+"/items/"+selectedDocuments;
			updateElement.style.width = pop.substr(0,p);
			updateElement.style.height = pop.substr(p+1);
			updateElement.style.left = (window.outerWidth-1000)/2+220;
			$("#actionDiv").draggable({});
			$("#actionDiv").fadeIn();
		}
		else
		{
			if (rootname)
			{
				var url = "/admin/admin/mainList/modulename/" + rootname + "/page/"+page+"/filter/" + filter;
				inModule = rootname;
			}
			else
			{
				var url = "/admin/admin/mainList/modulename/" + modulename + "/page/"+page+"/filter/" + filter;
				inModule = modulename;
			}
		}
	}
	else
	{
		if (rootname)
		{
			var url = "/admin/admin/mainList/parent/" + parentId + "/modulename/" + rootname + "/page/" + page;
			inModule = rootname;
		}
		else
		{
			var url = "/admin/admin/mainList/parent/" + parentId + "/modulename/" + modulename + "/page/" + page;
			inModule = modulename;
		}
	}

	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// CHECK SESSION EXPIRED!!!
				var response = xmlhttp.responseText;
				if (response.indexOf("<!-- loged-out -->") > 0)
				{
					updateElement = document.getElementById("bodyContent");
				}
				else
				{
					parseLanguageBar(parentId);
					initBindings();
				}

				//if(typeof(page) != "undefined") alert(xmlhttp.responseText);

				updateElement.innerHTML = xmlhttp.responseText;
				selectedDocuments = new Array();
			}
			else
			{
				updateElement.innerHTML = "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='/images/load.gif' border='0'>";
			}
		};
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
}

function getTree(elementId)
{
	if (rootname)
	{
		var url = "admin/parentsTree/modulename/" + rootname + "/id/" + elementId;
		inModule = rootname;
	}
	else
	{
		var url = "admin/parentsTree/modulename/" + modulename + "/id/" + elementId;
		inModule = modulename;
	}

	xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState == 4)
			{
				if (xmlhttp.status == 200)
				{
					document.getElementById('docName').innerHTML = xmlhttp.responseText;
					initBindings();
				}
				else
				{
					alert("parseTree error : " + xmlhttp.statusText);
				}
			}
		};
	}
}

function parseLanguageBar(parentElementId)
{
	if (!parentElementId)
	{
		document.getElementById('languageBarReplaced').innerHTML = "";
		return;
	}

	if (rootname)
	{
		url = "admin/languageBar/parent/" + parentElementId + "/modulename/" + rootname;
	}
	else
	{
		url = "admin/languageBar/parent/" + parentElementId + "/modulename/" + modulename;
	}
	clickedDocument = document.getElementById(parentElementId);

	xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('languageBarReplaced').innerHTML = xmlhttp.responseText;
				getTree(parentElementId);
				initBindings();
			}
		};
	}
}

function createDocument(type, parentId, err)
{
	document.getElementById("save_status").innerHTML = "";
	document.getElementById("save_status").style.padding = "0";
	if (type == 'Folder')
	{
		url = "admin/editFolder/parent/" + parentId + "/parentmodule/" + modulename;
	}
	else if (type == 'Tag')
	{
		url = "admin/editTag/parent/" + parentId + "/parentmodule/" + modulename;
	}
	else
	{
		url = modulename.toLowerCase() + "/edit" + type + "/parent/" + parentId;
	}

	if (typeof err != "undefined")
	{
		url += "/err/" + err;
	}

	parentDocumentId = parentId;
	var xmlhttp = getXhr();

	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// CHECK SESSION EXPIRED!!!
				var response = xmlhttp.responseText;
				if (response.indexOf("<!-- loged-out -->") > 0)
				{
					var updateElement = document.getElementById("bodyContent");
					updateElement.innerHTML = xmlhttp.responseText;
					selectedDocuments = new Array();
					return;
				}
				else if (type == 'Folder' || type == 'Tag')
				{
					var updateElement = document.getElementById("documentContent");
					updateElement.innerHTML = '<iframe src="/admin/admin/edit'+type+'/parent/'+parentId+'" width="100%" height="100%" frameborder="0"></iframe>';
					selectedDocuments = new Array();
					return;
				}
				else
				{
					var updateElement = document.getElementById("documentContent");
					updateElement.innerHTML = '<iframe src="/admin/'+modulename.toLowerCase()+'/edit'+type+'/parent/'+parentId+'" width="100%" height="100%" frameborder="0"></iframe>';
					selectedDocuments = new Array();
					return;
				}
				/*else
				{
					state_Change('documentContent', modulename, xmlhttp);
				}*/
			}
		};

		if (type.indexOf("I18n") < 0)
		{
			parseLanguageBar(parentId);
		}
		else
		{
			getTree(parentId);
		}

		if(typeof(modulename) != "undefined")
		{
			initRightTree(modulename);
		}
	}
}

function editDocument(type, documentId, err)
{
	document.getElementById("save_status").innerHTML = "";
	document.getElementById("save_status").style.padding = "0";

	if (type == 'Folder')
	{
		url = "admin/editFolder/parentmodule/" + modulename + "/id/" + documentId;
	}
	else if (type == 'Tag')
	{
		url = "admin/editTag/parentmodule/" + modulename + "/id/" + documentId;
	}
	else
	{
		url = modulename.toLowerCase() + "/edit" + type + "/id/" + documentId;
	}

	if (typeof err != "undefined")
	{
		url += "/err/" + err;
	}

	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// CHECK SESSION EXPIRED!!!
				var response = xmlhttp.responseText;
				if (response.indexOf("<!-- loged-out -->") > 0)
				{
					var updateElement = document.getElementById("bodyContent");
					updateElement.innerHTML = xmlhttp.responseText;
					selectedDocuments = new Array();
					return;
				}
				else if (type == 'Folder' || type == 'Tag')
				{
					var updateElement = document.getElementById("documentContent");
					updateElement.innerHTML = '<iframe src="/admin/admin/edit'+type+'/id/'+documentId+'" width="100%" height="100%" frameborder="0"></iframe>';
					validateEditForm();
					selectedDocuments = new Array();
				}
				else
				{
					var updateElement = document.getElementById("documentContent");
					updateElement.innerHTML = '<iframe src="/admin/'+modulename.toLowerCase()+'/edit'+type+'/id/'+documentId+'" width="100%" height="100%" frameborder="0"></iframe>';
					validateEditForm();
					selectedDocuments = new Array();
					if (type == 'User')
					{
						show_hide_admin_options(document.getElementById("attrUserType"), true);
					}
					return;
				}
				/*else
				{
					state_Change('documentContent', modulename, xmlhttp);
					validateEditForm();
					selectedDocuments = new Array();
					if (type == 'User')
					{
						show_hide_admin_options(document.getElementById("attrUserType"), true);
					}
				}*/
			}
		};

		if(type.indexOf("I18n") < 0)
		{
			parseLanguageBar(documentId);
		}
		else
		{
			getTree(documentId);
		}

		if(typeof(modulename) != "undefined")
		{
			initRightTree(modulename);
		}
	}
}

function refreshLeftTree()
{
	if (rootname)
	{
		url = "admin/leftTree/modulename/" + rootname;
	}
	else
	{
		url = "admin/leftTree/modulename/" + modulename;
	}

	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('leftTreeReplaced').innerHTML = xmlhttp.responseText;
				$(document).ready(function(){
					$("#leftNavigation").treeview({
						collapsed: false
					});
				});
				initBindings();
				document.getElementById("documentContent").innerHTML = "";
			}
		};
	}
}

function refreshMainList()
{
	if (rootname)
	{
		url = "admin/mainList/parent/" + parentDocumentId + "/modulename/" + rootname;
	}
	else
	{
		url = "admin/mainList/parent/" + parentDocumentId + "/modulename/" + modulename;
	}
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById('documentContent').innerHTML = xmlhttp.responseText;
				initBindings();
			}
		};
	}
}

function editPageContent(pageId)
{
	if (!pageDocumentId)
	{
		pageDocumentId = pageId;
	}
	var url = "website/editPageContent/id/" + pageId;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("mainContent").innerHTML=xmlhttp.responseText;
			}
		};
	}
}

function orderDocument(id, up)
{
	var url = "/admin/admin/orderDocument/id/"+id+"/up/"+up;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// CHECK SESSION EXPIRED!!!
				var response = xmlhttp.responseText;
				if (response.indexOf("<!-- loged-out -->") > 0)
				{
					var updateElement = document.getElementById("bodyContent");
					updateElement.innerHTML = xmlhttp.responseText;
					selectedDocuments = new Array();
					return;
				}
				else
				{
					refreshLeftTree();
					refreshMainList();
				}
			}
		};
	}
}

// ------------------------- EDIT PAGE CONTENT FUNCTIONS ------------------------- //
var pageDocumentId = null;
var selectedElement = null;
var hasRichtextEditor = false;

window.onload = function() {
	var divElements = document.getElementsByTagName('div');
	for(var i = 0; i < divElements.length; i += 1)
	{
		if ((divElements[i].id.indexOf("richtext") == 0) || (divElements[i].id.indexOf("/") > 0)) {
			divElements[i].style.border = "1px  dotted #000;";
			divElements[i].style.margin = "3px;";
			divElements[i].onclick = function() {
				selectElement(this);
			}
		}
	}
	initBindings();
	pageDocumentId = document.title;
}

function deleteBlock(blockId)
{
	var blockArray = blockId.split("/");
	if (blockArray[1]) {
		blockId = blockArray[0] + "_" + blockArray[1];
	}

	var cookies = document.cookie.split(";");
	for (i=0; i < cookies.length; i++) {
		if (cookies[i].indexOf("pageId") > 0) {
			var temp = cookies[i].split("=");
			pageDocumentId = temp[1];
		}
	}

	var url = "/admin/website/deleteBlock/pageId/" + pageDocumentId + "/blockId/" + blockId;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				window.location.reload();
			}
		};
	}
}

function insertBlock(blockId)
{
	var parent = document.getElementById(blockId).parentNode.id;
	if (typeof parent == 'object') {
		parent = document.getElementById(blockId).parentNode.parentNode.id;
	}

	var blockArray = blockId.split("/");
	if (blockArray[1]) {
		blockId = blockArray[0] + "_" + blockArray[1];
	}

	pageDocumentId = document.title;

	url = "/admin/website/insertBlock/pageId/" + pageDocumentId + "/parentBlock/" + parent + "/blockId/" + blockId;
	WindowObjectReference = window.open(url, "Insert block", "width=500,height=410,resizable,scrollbars=no,status=1");
}

function selectElement(element, admin)
{
	var codeStr = "";
	if (admin == 1)
	{
		 codeStr = "code,";
	}
	if (element.id.indexOf("richtext") == 0)
	{
		if (hasRichtextEditor && (element.id.indexOf("richtext_") != 0)) {
			tinyMCE.execCommand('mceRemoveControl', false, hasRichtextEditor);
		}
		hasRichtextEditor = element.id;
		tinyMCE.init({
			// General options
			mode : "exact",
			elements : element.id,
			theme : "advanced",
			relative_urls : false,
			plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
			/*theme_advanced_buttons1 : "code,|,save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",*/
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontsizeselect,forecolor,template,undo,redo,link,unlink,anchor,pastetext,bullist,numlist,outdent,indent",
			theme_advanced_buttons2 : "hr,sub,sup,charmap,iespell,code,tablecontrols",
//			theme_advanced_buttons1 : codeStr+"bold,italic,underline,link,unlink,pastetext,bullist,numlist,hr,charmap",
//			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",

			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			//paste_auto_cleanup_on_paste : true,
			width : 740,
			height: 300,

			// Example content CSS (should be your site CSS)
			content_css : "/css/backend/richtext.css",

			// Drop lists for link/image/media/template dialogs
			template_templates : [
			{
				title : "Blocks",
				src : "/admin/website/getBlockModules",
				description : "Adds a block"
			},
			{
				title : "Documents",
				src : "/admin/website/getDocumentModules",
				description : "Adds a document"
			}
			]
		});
	}
}

function displayCrop(id, path, w, h)
{
	flvplayerContainer = document.getElementById("cropdiv");
	flvplayerContainer.innerHTML ='<span id="frame"><a class="flvclose" onclick="closeCrop(); return false;" href="#">X close</a><br>' + "\n"+
	'<object id="player" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,65,0" width="350" height="380"  align="middle">' + "\n"+
	'<param name="allowScriptAccess" value="sameDomain">' + "\n"+
	'<param name="movie" value="/admin/crop.swf">' + "\n"+
	'<param name="menu" value="false">' + "\n"+
	'<param name="quality" value="high">' + "\n"+
	'<param name="wmode" value="transparent">' + "\n"+
	'<param name="scale" value="noscale">' + "\n"+
	'<param name="bgcolor" value="">' + "\n"+
	'<param name=FlashVars value="imgid='+id+'&imgpath='+path+'&w='+w+'&h='+h+'">' + "\n"+
	'<embed FlashVars="imgid='+id+'&imgpath='+path+'&imgw='+w+'&imgh='+h+'" wmode="transparent" src="/admin/crop.swf" menu="false" quality="high" scale="noscale" bgcolor="" width="350" height="380"  align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>' + "\n"+
	'</object>' + "\n"+
	'</span><br>' + "\n";

	ScrollTop = document.body.scrollTop;
	if (ScrollTop == 0)
	{
		if (window.pageYOffset)
		ScrollTop = window.pageYOffset;
		else
		ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
	}

	document.getElementById("cropdiv").style.left = "0px";
	document.getElementById("cropdiv").style.top = "0px";
	document.getElementById("cropdiv").style.display = "block";
	document.getElementById("cropdiv").style.width = "500px";
	document.getElementById("cropdiv").style.height = "410px";
	document.getElementById("frame").style.position = "relative";
}

function closeCrop()
{
	document.getElementById("cropdiv").innerHTML = "";
	document.getElementById("cropdiv").style.display = "none";
}

function addToSelected(id, cell)
{
	var l = selectedDocuments.length;
	var found = in_array(id, selectedDocuments);

	if(found !== false)
	{
		selectedDocuments.splice(found,1);
		cell.style.background = 'none';
		cell.style.color = '#496A94';
	}
	else
	{
		selectedDocuments[l] = id;
		cell.style.background = '#3C476F';
		cell.style.color = '#ffffff';
	}
	url = "/items/"+selectedDocuments;
}

function setStatus(status, parent, page, filter)
{
	if(selectedDocuments.length == 0)
	{
		alert('please choose at least one document');
		return;
	}
	url = "admin/setPublicationStatus/status/"+status+"/items/"+selectedDocuments;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// CHECK SESSION EXPIRED!!!
				var response = xmlhttp.responseText;
				if (response.indexOf("<!-- loged-out -->") > 0)
				{
					updateElement = document.getElementById("bodyContent");
					updateElement.innerHTML = xmlhttp.responseText;
					selectedDocuments = new Array();
				}
				else
				{
					if (xmlhttp.responseText != 'OK')
					{
						alert (xmlhttp.responseText);
					}
					parseMainList(null, parent, page, filter)
				}
			}
		};
	}
}

function urlencode(str)
{
  str = str.split(".").join("%FF");
  str = str.split("?").join("%FE");
  str = str.split("/").join("%FD");
	
	return str;
}

function executeMainListFilter(filter, pop)
{
	var search = document.getElementById('searchKeys');
	if(search && (filter.indexOf("_search/keys/") != -1))
	{
		var searchVal = search.value;
		searchVal = urlencode(searchVal);
		filter = filter+searchVal;
		var stype = document.getElementById('stype');
		if(stype)
		{
			filter += '/stype/'+stype.value;
		}
	}

	parseMainList(null, '', 1, filter, pop);
}

function addCheckboxValTo(id, ch)
{
	var st = document.getElementById(id);
	var stVal = st.value;
	var chVal = ch.value;
	var shLen = ch.length;

	if(ch && ch.checked)
	{
		stVal += chVal + ";";
	}
	else
	{
		if(stVal.indexOf(chVal + ";") == 0)
		{
			//stVal = stVal.replace(chVal + ";", "");
			stVal = stVal.split(chVal + ";").join("");
		}
		else
		{
		//	stVal = stVal.replace(";"+chVal+";", ";");
			stVal = stVal.split(";"+chVal+";").join(";");
		}
	}
	st.value = stVal;
}

function sendNewsletter(mailinglists, newsletters)
{
	url = "newsletter/newsletterSend/newsletters/" + newsletters + "/mailinglists/"+mailinglists;
	doAjax(url);
}

function doAjax(url)
{
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET", url, true);
		xmlhttp.send(null);

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				// CHECK SESSION EXPIRED!!!
				var response = xmlhttp.responseText;
				if (response.indexOf("<!-- loged-out -->") > 0)
				{
					var updateElement = document.getElementById("bodyContent");
					updateElement.innerHTML = xmlhttp.responseText;
					selectedDocuments = new Array();
					return;
				}
				else
				{
					document.getElementById("actionDivContent").innerHTML = xmlhttp.responseText;
				}
			}
		};
	}
}

function deleteGalleryMedia(parentId, deleteId)
{
	if (confirm("Are you sure you want to delete this picture?"))
	{
		var xmlhttp = getXhr();
		if (xmlhttp != null)
		{
			var url = "/admin/media/galleryPicsList/parentMediaId/"+parentId+"/deleteId/"+deleteId;
			xmlhttp.open("GET", url, true);
			xmlhttp.send(null);

			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					var updateElement = document.getElementById("galleryPicsList");
					if (updateElement)
					{
						updateElement.innerHTML = xmlhttp.responseText;
					}
				}
			};
		}
	}
}