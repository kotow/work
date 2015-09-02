<html>
<head>

<?php if($sf_params->get("submitted") && !$message): ?>
<script language="javascript" type="text/javascript" src="/js/backend/jquery.js"></script>
<!--<script language="javascript" type="text/javascript" src="/js/backend/jquery.treeview.js"></script>-->

<script type="text/javascript">
$(document).ready(function() {
<?php if($isImg): ?> 
	selectMedia(<?php echo $newId; ?>, <?php echo $isImg; ?>);
<?php else: ?>
	selectMedia(<?php echo $newId; ?>, 0);
<?php endif; ?>
});

function selectMedia(id, isImg)
{
	var el = document.getElementById("inputSave").value;
	parent.document.getElementById("attr"+el).value = id;

	var insertButton = parent.document.getElementById("insert");
	var closeButton = parent.document.getElementById("image_close");

	if (insertButton)
	{
		// frontend (richtext) behaviour
		insertButton.click();
	}
	else if (closeButton)
	{
		var src = "/media/display/thumb/thumbs/id/"+id;
		var code = '<img src="'+src+'" />';
		parent.document.getElementById(document.getElementById("inputSave").value).innerHTML = code;

		// panel upload image behaviour
		closeButton.click();
	}
	else
	{
		// backend behaviour
		var src = "/media/display/thumb/thumbs/id/"+id;
		var code = '<img align="absbottom" height="100" src="'+src+'"/>';
		parent.document.getElementById(document.getElementById("inputSave").value).innerHTML = code;
	}
}
</script>
<?php endif; ?>

</head>
<body style="margin:0; padding:0; background:#FFFFFF;">
<input type="hidden" id="inputSave" value="<?php echo $sf_params->get("input"); ?>">
<div id="mediaUpload" style="padding:10px;">
<?php if ($message) echo '<div class="error" style="margin-bottom:5px">'.$message.'</div>'; ?>
<?php if ($sf_params->get("submitted") && !$message) echo '<div class="success">Image uploaded successfully!</div>'; ?>
	<form enctype="multipart/form-data" method="POST">
		<input type="hidden" name="submitted" value="yes" />
		<input type="file" name="mainPic" />
		<input type="submit" value="Add" />
	</form>
</div>
</body>