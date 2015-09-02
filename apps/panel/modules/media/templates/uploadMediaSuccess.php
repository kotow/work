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
		var src = "/media/display/thumb/thumbs/id/"+id+"/<?php echo time()?>";
		var code = '<li onclick="upload_image(\'attrImage\', \'images\','+id+', \'\')" id="'+el+'"><img src="'+src+'" /></li>';
		var container = parent.document.getElementById("container_"+el);
		container.innerHTML = code;
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

<style type="text/css">
	body {margin: 0; padding: 0;}
	form {margin: 0;}
</style>

</head>
<body style="margin:0; padding:0; background:#FFFFFF;">
<input type="hidden" id="inputSave" value="<?php echo $sf_params->get("input"); ?>">
<div id="mediaUpload" style="padding:10px;">
<?php if ($message) echo '<div style="color: #ff0000; margin-bottom:5px">'.$message.'</div>'; ?>
<?php if ($sf_params->get("submitted") && !$message) echo '<div style="color: #008f00;">Uploaded successfully!</div>'; ?>
	<form enctype="multipart/form-data" method="POST">
		<input type="hidden" name="submitted" value="yes" />
		<input type="hidden" name="attrLabel" value="<?php echo $label; ?>" />
<?php
	if ($sf_params->get('gw'))
	{
		echo panel_hidden('gw', $sf_params->get('gw'));
	}
	if ($sf_params->get('gh'))
	{
		echo panel_hidden('gh', $sf_params->get('gh'));
	}
	if ($sf_params->get('gp'))
	{
		echo panel_hidden('gp', $sf_params->get('gp'));
	}
	if ($sf_params->get('gtw'))
	{
		echo panel_hidden('gtw', $sf_params->get('gtw'));
	}
	if ($sf_params->get('gth'))
	{
		echo panel_hidden('gth', $sf_params->get('gth'));
	}
	if ($sf_params->get('gtp'))
	{
		echo panel_hidden('gtp', $sf_params->get('gtp'));
	}
?>
		<span style="display: block;">Picture:</span> <input type="file" name="mainPic" /><br>
		<span style="display: block;">Description:</span> <textarea cols="33" rows="2" name="attrDescription"><?php echo $description; ?></textarea><br>
		<input type="submit" value="Upload/Save" />
	</form>
</div>
</body>