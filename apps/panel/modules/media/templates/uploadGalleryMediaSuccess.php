<html>
<head>
<?php if ($sf_params->get("submitted") && !$message): ?>
<script language="javascript" type="text/javascript" src="/js/backend/jquery.js"></script>

<script type="text/javascript">
	$.ajax({
		url: "/panel/media/galleryPicsList/parentMediaId/<?php echo $sf_params->get('parentMediaId'); ?>",
		success: function(msg)
		{
			parent.document.getElementById("galleryPicsList").innerHTML = msg;
		}
	});
</script>
<?php endif;?>

<style type="text/css">
	body {margin: 0; padding: 0;}
	form {margin: 0;}
</style>

</head>
<body style="margin:0; padding:0; background:#FFFFFF; font-family: Arial,sans-serif; font-size: 12px;">
<div id="mediaUpload" style="float:left; padding:10px;">
<?php if ($message) echo '<div style="color: #ff0000;">'.$message.'</div>'; ?>
<?php if ($sf_params->get("submitted") && !$message) echo '<div style="color: #008f00;">Uploaded successfully!</div>'; ?>
	<form action="" enctype="multipart/form-data" method="POST">
	<?php
/*
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
		echo panel_hidden('parentMediaId', $sf_params->get('parentMediaId'));
		//echo panel_hidden('galleryType', $sf_params->get('galleryType', 0));
*/
	?>
		<input type="hidden" name="submitted" value="yes"/>
		<span style="display: block;">Picture:</span> <input type="file" name="galleryPic" size="30" /><br>
		<span style="display: block;">Description:</span> <textarea cols="33" rows="2" name="attrDescription"></textarea><br>
		<input type="submit" value="Upload/Save" />
	</form>
</div>
</body>