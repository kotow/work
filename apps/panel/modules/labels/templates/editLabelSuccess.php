<!-- START CONTENT -->
<?php echo $sf_params->get('backendMsg'); ?>

<form method='POST' action='' name='editForm' id='editForm'>
	<?php echo panel_hidden('moduleName', 'labels'); ?>
	<?php echo panel_hidden('id', $obj, '', 'getId'); ?>
	<?php echo panel_hidden('http_ref', $_SERVER["HTTP_REFERER"] ? $_SERVER["HTTP_REFERER"] : $sf_request->getParameter('http_ref')); ?>
	<fieldset class='drop-shadow'>

	<?php echo panel_input('attrValue', $val, array('labelname' => 'Value' , 'model' => 'Label', 'maxlength' => 255, 'required' => true, 'class' => 'large'), 'getValue'); ?>
	<?php //echo panel_textarea('attrValue', $val, array('labelname' => 'Value', 'model' => 'Label', 'size' => '50x5',  'required' => true), 'getValue'); ?>
	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->