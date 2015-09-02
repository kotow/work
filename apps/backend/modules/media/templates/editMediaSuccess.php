<?php $lang = $sf_user->getCulture()?>
<?php if($err):?>
<br>
<br>
<h3 style="color:red;margin:10px"><?php echo UtilsHelper::Localize("media.backend.".$err, $lang)?><h3>
<?php endif; ?>
<?php echo $sf_params->get("backendMsg");?>
<div id='content_tabs'>
<div id="cropdiv"></div>
<?php echo form_tag('media/saveMedia', array('id' => 'form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validateEditForm();')); ?>
<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
<?php endif; ?>

<table>
<?php if ($obj): ?>
<tr>
	<td colspan="2">
	&nbsp;&nbsp;&nbsp;<b>File name: </b><?php echo $obj->getFilename() ?>
	|&nbsp;&nbsp;&nbsp;<b>File type: </b><?php echo $obj->getFiletype() ?>
	|&nbsp;&nbsp;&nbsp;<b>Size: </b><?php echo round(filesize($obj->getServerAbsoluteUrl())/1024)." Kb" ?>
	</td>
</tr>
<?php endif; ?>
<tr>
<td>

	<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
	<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
	<?php if ($obj) echo 'id: '.$obj->getId(); ?>
	
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
	<?php echo backend_input('attrDescription', $obj, array('labelname' => 'Description' , 'maxlength' => 255), 'getDescription'); ?>
	<div>File : </div>
	<?php echo input_file_tag('attrFilename', '', array ('size' => 50));?>
	<?php echo backend_tags($tags, $obj); ?>
	
</td>
<td>
	<?php
		if ($obj && $obj->isImage())
		{
			list($w, $h) = getimagesize($obj->getServerAbsoluteUrl());
			echo "<a href='#' onclick='displayCrop(\"".$obj->getId()."\", \"".$obj->getRelativeUrl()."\", \"".$w."\", \"".$h."\")'>".image_tag($obj->getRelativeDirUrl()."thumbs/".$obj->getFilename(),array('id' => 'img','height' => '100',))."</a>";
		}
	?>
</td>
</tr>
</table>

<div id='line'></div>
	<input id='btnSubmit' class="save_btndisabled" value="" type='submit' disabled/>
</form>
</div>
<script type="text/javascript">
setTimeout(function(){$('#backendMsg').fadeOut(6000)},2000);
</script>