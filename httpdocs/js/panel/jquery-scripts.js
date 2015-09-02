// JavaScript Document

jQuery(document).ready(function() {
/*
$(function() {
        
  $(".client").editable("/clients/save", { 
      indicator : "<img src='/images/indicator.gif'>",
      tooltip   : "Click to edit...",
      width: (($(".client").width())+20) + "px",
      height: (($(".client").height())+5) + "px",
      style  : "inherit"
  });
  
  $(".tech").editable("/clients/save", { 
      indicator : "<img src='/images/indicator.gif'>",
      tooltip   : "Click to edit...",
      width: (($(".tech").width())+20) + "px",
      height: (($(".tech").height())+5) + "px",
      style  : "inherit"
  });
  
   $(".label").editable("/clients/save", { 
      indicator : "<img src='/images/indicator.gif'>",
      tooltip   : "Click to edit...",
      width: (($(".label").width())+20) + "px",
      height: (($(".label").height())+5) + "px",
      style  : "inherit"
  });
  
   $(".contact").editable("/clients/save", { 
      indicator : "<img src='/images/indicator.gif'>",
      tooltip   : "Click to edit...",
      width: (($(".contact").width())+20) + "px",
      height: (($(".contact").height())+5) + "px",
      style  : "inherit"
  });
  
  $(".num").editable("/clients/save", { 
      indicator : "<img src='/images/indicator.gif'>",
      tooltip   : "Click to edit...",
      width: (($(".num").width())+20) + "px",
      height: (($(".num").height())+5) + "px",
      style  : "inherit"
  });
});
*/

	$(function() {
		$( "#accordion" ).accordion({
		autoHeight: false,
		collapsible: true,
		header: 'h3.trigger' ,
		navigation: true,
		icons: {
			header: "ui-icon-triangle-1-e",
			headerSelected: "ui-icon-triangle-1-s"
		}
		});
	});

/*	$(function() {
		$("#sf_culture").change(function() {
			var culture = $(this).val();
			$.ajax({
				url: '/panel/admin/changeCulture/culture/'+culture,
				success: function(msg)
				{
					location.reload();
				}
			});
		});
	});*/

/*	$(function() {
		$( "#tabs" ).tabs({
		cache: true,
		fx: { opacity: 'toggle', duration:'normal'}
		});
	});

	$(function() {
		$('#slider').bxSlider({
			mode: 'fade',
			hideControlOnEnd: true,
			controls: true,
			pager: true,
			auto: true,
		});
	});

	$(function(){ $('#boardbox').equalHeights(); });

	$(function() {
		$(".tab").mouseover(function() {
		$(this).css({"background-color":"#F1F1F1"})
			}).mouseout(function(){
		$(this).css({"background-color":"#fff"});
			});
	});*/

});

$(function() {
	$( "#sortable" ).sortable({
		placeholder: "ui-state-highlight",
		update : function () {
			var order = $(this).sortable('serialize',{key:'item[]'});
			//var order_str = order.join(',');
//			alert(order);
			$.ajax({
				url: '/panel/admin/changeOrder/?'+order,
				async: false,
				success: function(msg)
				{
					//alert(msg);
				}
			});
		}
	});
	$( "#sortable" ).disableSelection();
});

$(function() {
	$("#sortable .row").mouseover(function () {
		$(this).toggleClass("hover");
	}).mouseout(function() {
		$(this).removeClass("hover");
	});
});

/*$(function() {
	$("#cat-sortable .row").mouseover(function () {
	     $(this).toggleClass("hover");
	}).mouseout(function() {
		$(this).removeClass("hover");
	});
});*/


$(function() {
	$("a.status").click(function () {
		if ($(this).hasClass("offline"))
		{
			var status = "online";
		}
		else
		{
			var status = "offline"
		}
		var obj = $(this);
		var item = $(this).parent().parent().parent().attr('id');
		var id = item.split('_')[1];
		var linkURL = "/panel/admin/setPublicationStatus/items/"+id+"/status/"+status;
		$.ajax({
			url: linkURL,
			async: false,
			success: function(msg)
			{
				if (msg == "OK")
					//$("#"+item).slideUp('slow', function(){ $("#"+item).remove(); });
					obj.toggleClass("offline");
				else
					alert(msg);
			}
		});

//		alert ('item='+item+'; status='+status);
//		$(this).toggleClass("offline");
	});

	$(".moveup").click(function() {
		var li = $(this).parent().parent().parent(); //alert(li.attr('id'));
		var index = $("ul.mainList > li").index(li); //alert('u: index='+index);
		li.insertBefore( li.prev() );
		var item = li.attr('id');
		var id = item.split('_')[1];
		var linkURL = "/panel/admin/moveDocument/id/"+id+"/up/1";
		$.ajax({
			url: linkURL,
			async: false,
			success: function(msg)
			{
				if (msg != "OK")
					alert(msg);
			}
		});
		if (index == 0)
			location.reload();
	});

	$(".movedown").click(function() {
		var li = $(this).parent().parent().parent(); //alert(li.attr('id'));
		var index = $("ul.mainList > li").index(li)+1;
		var size = $("ul.mainList li").size(); //alert('u: index='+index+", size: "+size);
		li.insertAfter( li.next() );
		var item = li.attr('id');
		var id = item.split('_')[1];
		var linkURL = "/panel/admin/moveDocument/id/"+id+"/up/0";
		$.ajax({
			url: linkURL,
			async: false,
			success: function(msg)
			{
				if (msg != "OK")
					alert(msg);
			}
		});
		if (index == size)
			location.reload();
	});
});

$(function() {
	$(".SelectAll").click(function () {
		$(":checkbox").attr("checked", true);
	});

	$(".DeselectAll").click(function () {
		$(":checkbox").attr("checked", false);
	});
});


/*
$(function() {
	$( "#cat-sortable" ).sortable({
		placeholder: "ui-state-highlight",
		update : function () {
			var order = $(this).sortable('serialize',{key:'cat[]'});
			//var order_str = order.join(',');
			alert(order);
		}
	});
	$( "#cat-sortable" ).disableSelection();
});

$(function() {
	$( ".cat-subcat" ).sortable({
		placeholder: "ui-state-highlight",
		update : function () {
			var catID = $(this).parent().attr('id');
			var order = 'cat='+catID+'&'+$(this).sortable('serialize',{key:'sub[]'});
			//var order_str = order.join(',');
			alert(order);
		}
	});
	$( ".cat-subcat" ).disableSelection();
});
*/

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#delete-all" ).dialog({
		autoOpen: false,
		resizable: false,
		closeOnEscape: false,
		modal: true,
		/*beforeClose: function() {
			//alert( $("#del_all_wait").css("display") );
				if ($("#del_all_wait").css("display") != 'none')
				{
					return false;
				}
				return true;
		},*/
		buttons: {
			"Delete selected": function() {
				var items = $( "#deletedObjects" ).val();
//					alert(items);
				var ids = items.split(',');
				var checked = [];
				var len = ids.length;
				for (var i=0; i<len; i++)
				{
					checked.push( ids[i].split('_')[1] );
				}
				items = checked.join(',');
				var linkURL = "/panel/admin/delete/selectedDocuments/"+items;
				$('#del_all_wait').show();
				$.ajax({
					url: linkURL,
					success: function(msg)
					{
						/*if (msg == "no_delete")
							alert("You can't delete some of the selected objects!");
						else*/
						{
							// remove objects
							for (var i=0; i<len; i++)
								$("#"+ids[i]).slideUp('slow', function(){ $("#"+ids[i]).remove(); });
						}
						$('#del_all_wait').hide();
						$( "#delete-all" ).dialog( "close" );
					}
				});
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#delete-this" ).dialog({
		autoOpen: false,
		resizable: false,
		closeOnEscape: false,
		modal: true,
		/*beforeClose: function() {
			//alert( $("#del_wait").css("display") );
				if ($("#del_wait").css("display") != 'none')
				{
					return false;
				}
				return true;
		},*/
		buttons: {
			"Delete": function() {
				var item = $( "#deletedObjects" ).val();
				var id = item.split('_')[1];
				var linkURL = "/panel/admin/delete/id/"+id;
				$('#del_wait').show();
				$.ajax({
					url: linkURL,
					success: function(msg)
					{
						/*if (msg == "no_delete")
							alert("You can't delete this object!");
						else*/
							$("#"+item).slideUp('slow', function(){ $("#"+item).remove(); });
						$('#del_wait').hide();
						$( "#delete-this" ).dialog( "close" );
					}
				});
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#edit-image" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 350,
//		width: 500,
		modal: true,
		buttons: {
//			"Save": function() {
//				$( this ).dialog( "close" );
//			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$(function() {
	$( ".del" )
		.click(function() {
			var item = $(this).parent().parent().parent().attr('id');
			$( "#deletedObjects" ).val(item);
			$( "#delete-this" ).dialog( "open" );
		});
});

$(function() {
	$( ".delete-all" )
		.click(function() {
			if ( $("input:checkbox:checked").size() == 0)
			{
				alert( 'Please, select some items to delete!' );
			}
			else
			{
				var checked = []; var id = '';
				$("input:checkbox:checked").each(function() {
					id = $(this).parent().parent().parent().attr('id');
					//alert('id='+id);
					checked.push( id );
//						checked.push( id.split('_')[1] );
				});
				//alert( 'checked='+checked.join(',') );
				$( "#deletedObjects" ).val( checked.join(',') );
				$( "#delete-all" ).dialog( "open" );
			}
		});
});

/*$(function() {
	$(".btn-seo-url").click(function () {
		if ($(this).siblings("input:text").attr("readOnly") == true) {
			$(this).siblings("input:text").attr("readOnly", false).removeClass("readonly");
		} else {
			$(this).siblings("input:text").attr("readOnly", true).addClass("readonly");
		}
	});
});*/

function bind_functions()
{
	$(function() {
	$( ".image-delete" )
		.click(function() {
			var image = $(this).parent().parent().attr('id');
//			alert ('delete image='+image);
			delId = image.split('_')[1];
			//$( "#deletedImage" ).val( image.split('_')[1] );
			$( "#delete-image" ).dialog( "open" );
		});
	});

	$(function() {
		$( ".image-edit" )
			.click(function() {
				var image = $(this).parent().parent().attr('id');
				//alert ('edit image='+image);
				id = image.split('_')[1];
				edit_image(id);
				$( "#edit-image" ).dialog( "open" );
			});
	});

	$(function() {
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$( "#delete-image" ).dialog({
			autoOpen: false,
			resizable: false,
			closeOnEscape: false,
			modal: true,
			buttons: {
				"Delete": function() {
					//var id = $( "#deletedImage" ).val();
					refresh_gallery(delId);
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});

	$(function() {
		$( "#images-grid" ).sortable({
			placeholder: "image-highlight",
			update : function () {
				var order = $(this).sortable('serialize',{key:'item[]'});
				//var order_str = order.join(',');
//				alert(order);
				$.ajax({
					url: '/panel/admin/changeOrder/?'+order,
					success: function(msg)
					{
						//alert(msg);
					}
				});
			}
		});
		$( "#images-grid" ).disableSelection();
	});

	$(function() {
		$( "#images-grid .ui-state-default" ).mouseover(function () {
			$(this).find(".image-options").toggleClass("hover");
		}).mouseout(function() {
			$(this).find(".image-options").removeClass("hover");
		});
	});
}

function tinymce_all()
{
	$( 'textarea.mceEditor' ).each(function() {
		var id = $(this).attr('id');
		tinymce_init(id);
	});
}

function tinymce_init(id)
{
	tinyMCE.init({
        // General options
		mode : "exact",
		elements : id,
		theme : "advanced",
		relative_urls : false,
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "code,fullscreen,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,|,visualchars,nonbreaking,template",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        heme_advanced_blockformats : "h1,h2",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
       	content_css : "/css/frontend.css",
	});
}
function refresh_texareas() {
	$( 'textarea.mceEditor' ).each(function() {
		var id = $(this).attr('id');
		tinyMCE.execCommand("mceRemoveControl", false, id);
	});
	var id = 0 + $('#id').val();
	var template = $('#attrTemplate option:selected').text();
	$('#select_wait').show();
	$.ajax({
		url: '/panel/admin/getRichtextFields/id/'+id+'/template/'+template,
		success: function(msg)
		{
			$("#richtext_contents").html(msg);
			tinymce_all();
			$('#select_wait').hide();
		}
	});
}

/*function load_texareas() {
	$( 'textarea.ckeditor' ).each(function() {
		var id = $(this).attr('id');
		var el = CKEDITOR.instances[id];
		if (el) {
			//alert("RemoveD: "+id);
			CKEDITOR.remove(el);
		}
	});
	var id = 0 + $('#id').val();
	var template = $('#attrTemplate option:selected').text();
	$('#select_wait').show();
	$.ajax({
		url: '/panel/admin/getRichtextFields/id/'+id+'/template/'+template,
		success: function(msg)
		{
			$("#richtext_contents").html(msg);
			//alert("Replace all");
			CKEDITOR.replaceAll();
			//$( 'textarea.ckeditor' ).ckeditor();
			$('#select_wait').hide();
		}
	});
}*/

$(function() {
	$('#attrTemplate').change(function () {
		//load_texareas();
		refresh_texareas();
	});
/*	if (document.getElementById('attrTemplate'))
	{
		alert('manual load!');
		load_texareas();
	}*/
});

/*$(function() {
    $('#btnAdd').click(function() {
        var num     = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
        var newNum  = new Number(num + 1);      // the numeric ID of the new input field being added

        // create the new element via clone(), and manipulate it's ID using newNum value
        var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);

        // manipulate the name/id values of the input inside the new element
        newElem.children(':first').attr('id', 'name' + newNum).attr('name', 'name' + newNum);

        // insert the new element after the last "duplicatable" input field
        $('#input' + num).after(newElem);

        // enable the "remove" button
        $('#btnDel').attr('style','visibility:visible;');

        // business rule: you can only add 5 names

    });

    $('#btnDel').click(function() {
        var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
        $('#input' + num).remove();     // remove the last element

        // enable the "add" button
        $('#btnAdd').attr('disabled','');

        // if only one element remains, disable the "remove" button
        if (num-1 == 1)
            $('#btnDel').attr('style','visibility:hidden');
    });

    $('#btnDel').attr('style','visibility:hidden');
});*/

$(function() {
    $('#add_gallery_image').click(function() {
        $("#upload-gallery").dialog( "open" );
    });
});

function refresh_gallery(del)
{
	var el = document.getElementById('galleryPicsList');
	if (el)
	{
		var par = $("#id").val();
		var add = '';
		if (typeof del != "undefined")
			add = '/deleteId/'+del;
		$.ajax({
			url: "/panel/media/galleryPicsList/parentMediaId/"+par+"/gallery_type/1"+add,
			success: function(msg)
			{
				$("#galleryPicsList").html(msg);
				bind_functions();
			}
		});
	}
	else
		bind_functions();
}

function refresh_types()
{
	var el = document.getElementById('attrPageType');
	if (el)
	{
		type = $('#attrPageType option:selected').val();
		if (type == 'REFERENCE')
		{
			$('#REFERENCE').show();
			$('#EXTERNAL').hide();
			$('#page_attributes').hide();
		}
		else if (type == 'EXTERNAL')
		{
			$('#REFERENCE').hide();
			$('#EXTERNAL').show();
			$('#page_attributes').hide();
		}
		else
		{
			$('#REFERENCE').hide();
			$('#EXTERNAL').hide();
			$('#page_attributes').show();
		}
	}
}

function generateUrl(textElement, sourceElement)
{
	text = $('#'+sourceElement).val();
	// replace non letter or digits by '-'
	// lowercase
	text = text.toLowerCase();
//	text = text.replace(/[^\pL\d]+/u, '-');
	// trim
	text = text.replace(/\s+/g, '-');
	// remove unwanted characters
	text = text.replace(/[^a-z0-9а-я\-]+/g, '');
	// remove '--'
	text = text.replace(/--/g, '-');
	text = text.replace(/--/g, '-');
	// remove last '-'
	if (text.charAt( text.length-1 ) == "-") {
		text = text.slice(0, -1);
	}
	if (text == '')
		text = new Date().getTime();
	$('#'+textElement).val(text+'.html');
}

function validate_form()
{
	document.forms.editForm.submit();
	return true;
}

/*$(function() {
	$( 'textarea.ckeditor' ).ckeditor();
});*/

$(function() {
	tinymce_all();
	refresh_gallery();
});

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#upload-gallery" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 360,
		modal: true,
		buttons: {
//			"Save": function() {
//				$( this ).dialog( "close" );
//			},
			Close: function() {
				refresh_gallery();
				$( this ).dialog( "close" );
			}
		}
	});
});

function upload_gallery(id, params)
{
	if (typeof allowed == "undefined") allowed = ""
	$("#upload-gallery").html('<iframe src="/panel/media/uploadGalleryMedia/parentMediaId/'+id+'/'+params+'" width="100%" height="170px" frameborder="0"></iframe>');
	$("#upload-gallery").dialog( "open" );
}

function upload_gallery_close()
{
	$("#upload-gallery").dialog( "close" );
}

$(function() {
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#upload-image" ).dialog({
		autoOpen: false,
		resizable: false,
		width: 360,
		modal: true,
		buttons: {
//			"Save": function() {
//				$( this ).dialog( "close" );
//			},
			Close: function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

function upload_image(input, allowed, id, params)
{
	if (typeof allowed == "undefined") allowed = ""
	$("#upload-image").html('<iframe src ="/panel/media/uploadMedia/input/'+input+'/allowed/'+allowed+'/id/'+id+'/'+params+'" width="100%" height="170px" frameborder="0"></iframe>');
	$("#upload-image").dialog( "open" );
}
function upload_image_close()
{
	$("#upload-image").dialog( "close" );
}

function clear_image(name)
{
	$('#'+name).html('<img src="/images/icons/no_img.gif" title="Click here to insert image" />');
	$('#attr'+name ).val(0);
}

function edit_image(id)
{
	params = $('#gallery_params').val();
	$("#edit-image").html('<iframe src ="/panel/media/editGalleryMedia/id/'+id+'/'+params+'" width="100%" height="200px" frameborder="0"></iframe>');
	$("#edit-image").dialog( "open" );
}
function edit_image_close()
{
	refresh_gallery();
	$("#edit-image").dialog( "close" );
}

function noEdit()
{
	alert('You have no right to EDIT this object!');
	return false;
}

function noDelete()
{
	alert('You have no right to DELETE this object!');
	return false;
}

// Keywords functions



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
	if (found !== false)
	{
		existingItems.splice(found,1);
	}
	keywordsField.value = existingItems.join(",");
	removeElement("key_"+id);
}

function stockKeyword(id, label)
{
	var stockDiv = document.getElementById('keywordsStock');
	var keywordsField = document.getElementById('keywords');
	var existingItems = keywordsField.value.split(",");
	var found = in_array(id, existingItems);
	if (found === false)
	{
		stockDiv.innerHTML += '<div id="key_'+id+'" class="key_del" title="Click to remove keyword" onclick="removeKeyword(\''+id+'\')">'+label+'</div>';
		keywordsField.value += id+',';
	}
}

function getKeywords(key, updateDiv, btnTitle)
{
	if (btnTitle == "")
	{
		btnTitle = 'Add keyword';
	}
	$.ajax({
		url: '/panel/keywords/getKeywords/keyword/'+key,
		success: function(keys)
		{
			var keysList = "";
			var parts = keys.split(";");
			for (i=0 ; i < parts.length ; i++)
			{
				if (parts[i] != "")
				{
					var elements = parts[i].split(",");
					keysList += '<div class="key_add" title="'+btnTitle+'" onclick="stockKeyword(\''+elements[0]+'\',\''+elements[1]+'\')">'+elements[1]+'</div>';
				}
			}
			if (keysList != "")
			{
				updateDiv.style.display = "block";
			}
			else
			{
				updateDiv.style.display = "none";
			}
			updateDiv.innerHTML = keysList;
		}
	});
}

function addKeyword(key)
{
	$.ajax({
		url: '/panel/keywords/addKeyword/keyword/'+key,
		success: function(addedKey)
		{
			if(addedKey != "")
			{
				var parts = addedKey.split(",");
				stockKeyword(parts[0], parts[1]);
				var keywordField = document.getElementById('keyword');
				keywordField.value = '';
			}
		}
	});
}
