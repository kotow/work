<?php echo $sf_params->get('backendMsg');?>
<div id='content_tabs'>
<form id='form' name='form' action='<?php echo $formAction; ?>' onsubmit='return validateEditForm()' method='POST'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
	<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
	<?php if ($obj) echo 'ID: '.$obj->getId(); ?>
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'ProductI18n', 'maxlength' => '255', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
	<?php echo backend_media('attrImage', $obj, array('labelname' => 'Main picture' , 'model' => 'ProductI18n', 'allowed' => 'images'), 'getImage'); ?>
	<?php echo backend_input('attrShortDescription', $obj, array('labelname' => 'Short description' , 'model' => 'ProductI18n', 'maxlength' => '100'), 'getShortDescription'); ?>
	<?php echo backend_textarea('attrDescription', $obj, array('labelname' => 'Description' , 'model' => 'ProductI18n', 'size' => '50', 'richtext' => 'true', 'rows' => '10'), 'getDescription'); ?>
	<?php echo backend_input('attrPrice', $obj, array('labelname' => 'Price' , 'model' => 'ProductI18n'), 'getPrice'); ?>
	<?php echo backend_select('attrCurrency', $obj, Lists::getListitemsForSelect('currency'), array('labelname' => 'Currency' , 'model' => 'ProductI18n', 'unique' => 'true', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getCurrency'); ?>
	<?php echo backend_select('attrCulture', $obj, Lists::getListitemsForSelect('culture'), array('labelname' => 'Culture' , 'model' => 'ProductI18n', 'unique' => 'true', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getCulture'); ?>
<?php
	if ($obj)
	{
		echo backend_gallery($obj->getId(),
		array(
			'width' => '600',
			'thumb_width' => '80',
			'path' => 'upload'
		));
	}
?>
	<?php echo backend_tags($tags, $obj); ?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type='text/javascript'>setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>
