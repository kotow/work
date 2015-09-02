tinyMCEPopup.requireLangPack();

var TemplateDialog =
{
	preInit : function()
	{
		var url = tinyMCEPopup.getParam("template_external_list_url");
		if (url != null)
		document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + tinyMCEPopup.editor.documentBaseURI.toAbsolute(url) + '"></sc'+'ript>');
	},

	init : function()
	{
		var ed = tinyMCEPopup.editor, tsrc, sel, x, u;
		this.resize();
	},

	resize : function()
	{
		var w, h, e;

		/*if(!self.innerWidth)
		{
			w = document.body.clientWidth - 50;
			h = document.body.clientHeight - 160;
		}
		else
		{
			w = self.innerWidth - 50;
			h = self.innerHeight - 170;
		}

		e = document.getElementById('templatesrc');

		if(e)
		{
			e.style.height = Math.abs(h) + 'px';
			e.style.width  = Math.abs(w - 5) + 'px';
		}*/
	},

	loadCSSFiles : function(d)
	{
		var ed = tinyMCEPopup.editor;

		tinymce.each(ed.getParam("content_css", '').split(','), function(u)
		{
			d.write('<link href="' + ed.documentBaseURI.toAbsolute(u) + '" rel="stylesheet" type="text/css" />');
		});
	},

	selectTemplate : function(u)
	{
		//var d = window.frames['templatesrc'].document;

		if (!u)
		return;

		//d.body.innerHTML = this.templateHTML = this.getFileContents(u);
		this.templateHTML = this.getFileContents(u);
	},

	insert : function()
	{
		tinyMCEPopup.execCommand('mceInsertTemplate', false, {
			content : this.templateHTML,
			selection : tinyMCEPopup.editor.selection.getContent()
		});
		tinyMCEPopup.close();
	},

	getFileContents : function(u)
	{
		var x, d, t = 'text/plain';

		function g(s) {
			x = 0;

			try
			{
				x = new ActiveXObject(s);
			}
			catch (s)
			{

			}

			return x;
		};

		x = window.ActiveXObject ? g('Msxml2.XMLHTTP') || g('Microsoft.XMLHTTP') : new XMLHttpRequest();

		// Synchronous AJAX load file
		x.overrideMimeType && x.overrideMimeType(t);
		x.open("GET", u, false);
		x.send(null);

		return x.responseText;
	}
};

TemplateDialog.preInit();
tinyMCEPopup.onInit.add(TemplateDialog.init, TemplateDialog);
