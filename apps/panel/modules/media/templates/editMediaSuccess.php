<!-- START CONTENT -->
<?php echo $sf_params->get('backendMsg'); ?>
<?php echo panel_heading('attrLabel', $obj, 'getLabel', 'Create new', $documentName); ?>
<form method='POST' action='<?php echo $formAction; ?>' enctype='multipart/form-data' name='editForm' id='editForm'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo panel_hidden('moduleName', $moduleName); ?>
		<?php echo panel_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php echo panel_hidden('id', $obj, '', 'getId'); ?>
	<?php echo panel_hidden('parent', $sf_request->getParameter('parent')); ?>
	<fieldset class='drop-shadow'>
<?php if ($obj): ?>
	<div class="field">
		<label style="float:left;">Image info<a title="Image info" href="javascript: void(0);"></a></label>
		<span>
			&nbsp;&nbsp;&nbsp;<b>File name: </b><?php echo $obj->getFilename() ?>
			|&nbsp;&nbsp;&nbsp;<b>File type: </b><?php echo $obj->getFiletype() ?>
			|&nbsp;&nbsp;&nbsp;<b>Size: </b><?php echo round(filesize($obj->getServerAbsoluteUrl())/1024)." Kb" ?>
		</span>
	</div>
<?php endif; ?>
	<?php echo panel_input('attrLabel', $obj, array('labelname' => 'Label', 'maxlength' => 255, 'required' => 'true', 'class' => 'large'), 'getLabel'); ?>
	<?php echo panel_input('attrDescription', $obj, array('labelname' => 'Description' , 'maxlength' => 255, 'class' => 'large'), 'getDescription'); ?>
	<?php echo panel_image('attrImage', $obj, array('labelname' => 'Picture', 'allowed' => 'images', 'showOnly' => 1), 'getId'); ?>
	<div class="field">
		<label style="float:left;">Upload file<a title="Upload file" href="javascript: void(0);"></a></label>
		<?php echo input_file_tag('attrFilename', '', array ('size' => 50));?>
	</div>
	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0) { echo panel_tags($tags, $obj); echo panel_separator('hr', array('class' => 'brake')); } ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	<?php echo panel_modal(); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->
