<html>
<head>
<?php if ($sf_params->get("submitted") && !$message): ?>
<script language="javascript" type="text/javascript" src="/js/backend/jquery.js"></script>

<script type="text/javascript">
	$.ajax({
		url: "/admin/media/galleryPicsList/parentMediaId/<?php echo $sf_params->get('parentMediaId'); ?>/gallery_type/<?php echo $sf_params->get('gallery_type'); ?>",
		success: function(msg)
		{
			parent.document.getElementById("galleryPicsList").innerHTML = msg;
/*			var closeButton = parent.document.getElementById("gallery_close");
			if (closeButton)
				closeButton.click();*/
		}
	});
</script>
<?php endif;?>
</head>
<body style="margin:0; padding:0; background:#FFFFFF;">
<div id="mediaUpload" style="float:left; padding:10px;">
<?php if ($message) echo '<div class="error">'.$message.'</div>'; ?>
<?php if ($sf_params->get("submitted") && !$message) echo '<div class="success">Image uploaded successfully!</div>'; ?>
	<form action="" enctype="multipart/form-data" method="POST">
	<?php
		if ($sf_params->get('gw'))
		{
			echo backend_hidden('gw', $sf_params->get('gw'));
		}
		if ($sf_params->get('gh'))
		{
			echo backend_hidden('gh', $sf_params->get('gh'));
		}
		if ($sf_params->get('gp'))
		{
			echo backend_hidden('gp', $sf_params->get('gp'));
		}
		
		if ($sf_params->get('gtw'))
		{
			echo backend_hidden('gtw', $sf_params->get('gtw'));
		}
		if ($sf_params->get('gth'))
		{
			echo backend_hidden('gth', $sf_params->get('gth'));
		}
		if ($sf_params->get('gtp'))
		{
			echo backend_hidden('gtp', $sf_params->get('gtp'));
		}
		echo backend_hidden('parentMediaId', $sf_params->get('parentMediaId'));
		echo backend_hidden('gallery_type', $sf_params->get('gallery_type', 0));
	?>
		<input type="hidden" name="submitted" value="yes"/>
		<input type="file" name="galleryPic"/>
		<input type="submit" value="Add"/>
	</form>
</div>
</body>