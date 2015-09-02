function initBindings() {
	$('div.free').contextMenu('freeBlock', {
		bindings: {
			'insertBlock': function(t) {
				insertBlock(t.id);
			},
			'deleteBlock': function(t) {
				deleteBlock(t.id);
			}
		}
	});
	$('div.richtext').contextMenu('freeBlock', {
		bindings: {
			'insertBlock': function(t) {
				insertBlock(t.id);
			},
			'deleteBlock': function(t) {
				deleteBlock(t.id);
			}
		}
	});
}

/*function getXhr()
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
}*/

var pageDocumentId = null;
var selectedElement = null;
var hasRichtextEditor = false;

$(document).ready(function()
{
	var divElements = document.getElementsByTagName('div');
	for (i = 0; i < divElements.length; i += 1)
  	{
		if ((divElements[i].id.indexOf("richtext") == 0) || (divElements[i].id.indexOf("/") > 0))
		{
			divElements[i].onclick = function()
			{
				selectElement(this);
			}
		}
  	}
	initBindings();	
	pageDocumentId = document.title;
});

function deleteBlock(blockId)
{
/*	function state_ChangeLocal()
	{
		if (xmlhttplocal.readyState==4)
		{
			if (xmlhttplocal.status==200)
			{
				window.location.reload();
			}
		}
	}*/
	var blockArray = blockId.split("/");
	if (blockArray[1])
	{
		blockId = blockArray[0] + "_" + blockArray[1];
	}
	
	var cookies = document.cookie.split(";");
	for (i=0; i < cookies.length; i++)
	{
		if (cookies[i].indexOf("pageId") > 0)
		{
			var temp = cookies[i].split("=");
			pageDocumentId = temp[1];
		}
	}
	
/*	var url = "/admin/website/deleteBlock/pageId/" + pageDocumentId + "/blockId/" + blockId;
	var xmlhttplocal = new XMLHttpRequest();
	if (xmlhttplocal!=null)
	{
		xmlhttplocal.open("GET",url,true);
		xmlhttplocal.send(null);
		xmlhttplocal.onreadystatechange=function(){state_ChangeLocal()};
	}*/

	$.ajax({
		url: '/admin/website/deleteBlock/pageId/' + pageDocumentId + '/blockId/' + blockId,
		async: false,
		success: function(res)
		{
			window.location.reload();
		},
		error: function(xhr, ajaxOptions, thrownError)
		{
			alert("deleteBlock error: " + thrownError + " (status: " + xhr.status + ")");
		}
	});
}

function getBlocksForModule(module)
{
//	var url = "/admin/website/getBlocksForModule/modulename/" + module;
//	var xmlhttp = getXhr();
//	if (xmlhttp != null)
//	{
//		xmlhttp.open("GET",url,true);
//		xmlhttp.send(null);
//		xmlhttp.onreadystatechange=function()
//		{
//			if (xmlhttp.readyState==4)
//			{
//				if (xmlhttp.status==200)
//				{
//					document.getElementById("blocks_for_module_select").innerHTML=xmlhttp.responseText;
//				}
//				else
//				{
//					alert("getBlocksForModule error : " + xmlhttp.statusText);
//				}
//			}
//		};
//	}

	$.ajax({
		url: '/admin/website/getBlocksForModule/modulename/' + module,
		async: false,
		success: function(res)
		{
			document.getElementById("blocks_for_module_select").innerHTML = res;
		},
		error: function(xhr, ajaxOptions, thrownError)
		{
			alert("getBlocksForModule error: " + thrownError + " (status: " + xhr.status + ")");
		}
	});
}

function insertBlock(blockId)
{
	//alert(blockId);
	var parentObj = document.getElementById(blockId).parentNode;
	function getParentId(po)
	{
		if (typeof po.id == 'object' || po.id == '') 
		{
			return getParentId(po.parentNode);
		}
		else
		{
			return po.id;
		}
	}

	parent = getParentId(parentObj);
	var blockArray = blockId.split("/");
	if (blockArray[1])
	{
		blockId = blockArray[0] + "_" + blockArray[1];
	}
 	pageDocumentId = document.title;

/* 	alert(pageDocumentId);
 	var cookies = document.cookie.split(";");
	for (i=0; i < cookies.length; i++) {
		if (cookies[i].indexOf("pageId") > 0) {
			var temp = cookies[i].split("=");
			pageDocumentId = temp[1];
		}
	}*/

/*
	var url = "/admin/website/insertBlock/pageId/" + pageDocumentId + "/parentBlock/" + parent + "/blockId/" + blockId;
	var xmlhttp = getXhr();
	if (xmlhttp != null)
	{
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4)
			{
				if (xmlhttp.status==200)
				{
					//$(document).ready(function()
					//{
						$("#blocks_insert").fadeIn();
						$("#blocks_insert").draggable({});
						ScrollTop = document.body.scrollTop;
						  if (ScrollTop == 0)
						  {
							  if (window.pageYOffset)
								  ScrollTop = window.pageYOffset;
							  else
								  ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
						  }
						document.getElementById("blocks_insert").style.position = "absolute";
						document.getElementById("blocks_insert").style.left = ((document.body.clientWidth-480)/2)+"px";
						document.getElementById("blocks_insert").style.top = (ScrollTop+((document.documentElement.clientHeight-360)/2))+"px";
						document.getElementById("blocks_insert").style.zIndex = 1000;
					//});
					
					document.getElementById("blocks_insert").innerHTML = xmlhttp.responseText;
				}
				else
				{
					alert("insertBlock div error : " + xmlhttp.statusText);
				}
			}
		};
	}
	//WindowObjectReference = window.open(url,"Insert block",	"width=500,height=410,resizable,scrollbars=no,status=1");
*/
	$.ajax({
		url: '/admin/website/insertBlock/pageId/' + pageDocumentId + '/parentBlock/' + parent + '/blockId/' + blockId,
		async: false,
		success: function(res)
		{
			$("#blocks_insert").fadeIn();
			$("#blocks_insert").draggable({});
			ScrollTop = document.body.scrollTop;
			if (ScrollTop == 0)
			{
				if (window.pageYOffset)
					ScrollTop = window.pageYOffset;
				else
					ScrollTop = (document.body.parentElement) ? document.body.parentElement.scrollTop : 0;
			}
			document.getElementById("blocks_insert").style.position = "absolute";
			document.getElementById("blocks_insert").style.left = ((document.body.clientWidth-480)/2)+"px";
			document.getElementById("blocks_insert").style.top = (ScrollTop+((document.documentElement.clientHeight-360)/2))+"px";
			document.getElementById("blocks_insert").style.zIndex = 1000;

			document.getElementById("blocks_insert").innerHTML = res;
		},
		error: function(xhr, ajaxOptions, thrownError)
		{
			alert("insertBlock error: " + thrownError + " (status: " + xhr.status + ")");
		}
	});
}

function removeTiny()
{	
	;
}

function selectElement(element)
{
	if (element.id.indexOf("richtext") == 0)
	{
		/*if (document.getElementById("right_column"))
		{
			document.getElementById("right_column").style.display = "none";
		}*/
		if (hasRichtextEditor && (element.id.indexOf("richtext_") != 0))
		{
			tinyMCE.execCommand('mceRemoveControl', false, hasRichtextEditor);
		}

		hasRichtextEditor = element.id;
		tinyMCE.init({
			// General options
			mode : "exact",
			elements : element.id,
			theme : "advanced",
			relative_urls : false,
			plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

			// Theme options
/*
			theme_advanced_buttons1 : "save,code,fullscreen,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,|,visualchars,nonbreaking,template",
*/
			theme_advanced_buttons1 : "save,code,fullscreen,|template,pastetext,pasteword,|,formatselect,|,link,unlink,anchor,",
			theme_advanced_buttons2 : "bold,italic,underline,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,",
			theme_advanced_buttons3 : "template,image",
			theme_advanced_buttons4 : "",
		
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_blockformats : "h1,h2,h3,h4,h5",
			theme_advanced_resizing : true,
			width : "100%",

			// Skin options
			skin : "o2k7",
			skin_variant : "silver",

			// Example content CSS (should be your site CSS)
		   	//content_css : "/css/style.css",
		});

/*
		tinyMCE.init({
		// General options
		mode : "exact",
		elements : element.id,
		theme : "advanced",
		relative_urls : false,
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,youtube",
	
		// Theme options
		theme_advanced_buttons1 : "save,code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,formatselect,forecolor,link,unlink,anchor,bullist,numlist,outdent,indent,undo,redo,hr,sub,sup,charmap,iespell,fullscreen,template,youtube",
		theme_advanced_buttons2 : "tablecontrols",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_blockformats : "h1,h2",
		paste_auto_cleanup_on_paste : true,
		
//		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
//		theme_advanced_buttons2 : "code,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,|,insertdate,inserttime,preview,|,forecolor,backcolor",
//		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
//		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
//		theme_advanced_toolbar_location : "top",
//		theme_advanced_toolbar_align : "left",
//		theme_advanced_statusbar_location : "bottom",
//		theme_advanced_resizing : true,
	
		// Example content CSS (should be your site CSS)
		content_css : "/css/frontend.css",
	
		// Drop lists for link/image/media/template dialogs
		template_templates : [
//			{
//				title : "Blocks",
//				src : "/admin/website/getBlockModules",
//				description : "Adds a block"
//			},
			{
				title : "Documents",
				src : "/admin/website/getDocumentModules",
				description : "Adds a document"
			}
		]
	});
*/

	}
}
