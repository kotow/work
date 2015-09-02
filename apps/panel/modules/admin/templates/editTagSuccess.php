<!-- START CONTENT -->
<?php echo $sf_params->get('backendMsg'); ?>
<?php echo panel_heading('attrLabel', $obj, 'getLabel', 'Create new', $documentName); ?>
<form method='POST' action='<?php echo $formAction; ?>' name='editForm' id='editForm'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo panel_hidden('moduleName', $moduleName); ?>
		<?php echo panel_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php if ($obj) echo panel_hidden('http_ref', $_SERVER["HTTP_REFERER"] ? $_SERVER["HTTP_REFERER"] : $sf_request->getParameter('http_ref')); ?>
	<?php echo panel_hidden('id', $obj, '', 'getId'); ?>
	<?php echo panel_hidden('parent', $sf_request->getParameter('parent')); ?>
	<fieldset class='drop-shadow'>

	<?php echo panel_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'class' => 'medium'), 'getLabel'); ?>
	<?php echo panel_input('attrTagId', $obj, array('labelname' => 'Tag ID' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'class' => 'medium'), 'getTagId'); ?>
	<?php echo panel_input('attrModule', $obj, array('labelname' => 'Module' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'class' => 'medium'), 'getModule'); ?>
	<?php echo panel_input('attrDocumentModel', $obj, array('labelname' => 'Document Model' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'class' => 'medium'), 'getDocumentModel'); ?>
	<?php echo panel_checkbox('attrExclusive', $obj, array('labelname' => 'Exclusive' , 'model' => 'Tag'), 'getExclusive'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0) { echo panel_tags($tags, $obj); echo panel_separator('hr', array('class' => 'brake')); } ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	<?php //echo panel_modal(); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->