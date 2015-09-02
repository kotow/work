<html>
<head>
<?php if($sf_params->get("submitted") && !$message): ?>
<script type="text/javascript">
	var closeButton = parent.document.getElementById("edit_close");
	closeButton.click();
</script>
<?php endif; ?>

</head>
<body style="margin:0; padding:0; background:#FFFFFF;">
<input type="hidden" id="inputSave" value="<?php echo $sf_params->get("input"); ?>">
<div id="mediaUpload" style="padding:10px;">
<?php if ($message) echo '<div style="color: #ff0000; margin-bottom:5px">'.$message.'</div>'; ?>
<?php if ($sf_params->get("submitted") && !$message) echo '<div class="success">Uploaded successfully!</div>'; ?>
	<form enctype="multipart/form-data" method="POST">
		<input type="hidden" name="submitted" value="yes" />
		<span style="display: block;">Picture:</span> <input type="file" name="galPic" size="30" /><br>
		<span style="display: block;">Description:</span> <textarea cols="33" rows="2" name="attrDescription"><?php echo $description; ?></textarea><br>
		<input type="submit" value="Upload" />
	</form>
</div>
</body>