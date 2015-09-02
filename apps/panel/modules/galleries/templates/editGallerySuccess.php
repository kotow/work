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

	<?php echo panel_input('attrLabel', $obj, array('labelname' => 'Title' , 'model' => 'Gallery', 'maxlength' => 255, 'required' => 'true', 'class' => 'large'), 'getLabel'); ?>
	<?php echo panel_image('attrImage', $obj, array('labelname' => 'Main picture' , 'model' => 'Gallery', 'allowed' => 'images', 'height' => 120), 'getImage'); ?>
	<?php echo panel_textarea('attrDescription', $obj, array('labelname' => 'Description' , 'model' => 'Gallery', 'size'=> '50x5', 'richtext' => 'true', 'class' => 'mceEditor'), 'getDescription'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0) { echo panel_tags($tags, $obj); echo panel_separator('hr', array('class' => 'brake')); } ?>

	<?php
		if ($obj)
		{
			echo panel_gallery($obj->getId(),
			array(
				'labelname' => 'Images gallery',
//				'width' => '499',
//				'thumb_height' => '48',
				'path' => 'galleries'
			));
		}
	?>

	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	<?php echo panel_modal_images(); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->