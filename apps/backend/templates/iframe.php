<html>
	<head>
		<script language="javascript" type="text/javascript" src="/js/backend/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/jquery.contextmenu.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/jquery.treeview.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.mouse.js"></script>
		<script language="javascript" type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/jquery.dimensions.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/jquery.rte.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.draggable.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.draggableext.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.droppable.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.droppableext.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.sortable.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/backoffice.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/contextMenus.js"></script>
		
		<META HTTP-EQUIV="cache-control" CONTENT="max-age=60, must-revalidate"> 
		<?php include_title() ?>
	</head>
	
	<body style="background:#FBFFED" id="bodyContent">
		<div style='display:none' id='media_browse' >
			<div id='media_browseHead'>
				<a onclick='$("#media_browse").fadeOut();'>close <img align='absmiddle' src='/images/icons/delete.png'/></a>
			</div>
			<div id='media_browseContent' style='width:350px;height:100px;margin:0;padding:0'></div>
		</div>
		<div style='display:none' id='media_gallery' >
			<div id='media_galleryHead'>
				<a onclick='$("#media_gallery").fadeOut();'>close <img align='absmiddle' src='/images/icons/delete.png'/></a>
			</div>
			<div id='media_galleryContent' style='width:350px;height:100px;margin:0;padding:0'></div>
		</div>
		<?php echo $sf_data->getRaw('sf_content') ?>
		<script language="javascript" type="text/javascript">validateEditForm();</script>
	</body>

</html>