<?php echo $sf_params->get("backendMsg");?>
<div id='content_tabs'>
<form id='form' name='form' action='<?php echo $formAction; ?>' onsubmit='return validateEditForm()' method='POST'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
	<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
	<?php if ($obj) echo 'ID: '.$obj->getId(); ?>
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'ListitemI18n', 'maxlength' => '255', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>

	<?php if($userType == "admin"):?>
		<?php echo backend_input('attrValue', $obj, array('labelname' => 'Value' , 'model' => 'ListitemI18n', 'maxlength' => '255'), 'getValue'); ?>
	<?php endif;?>

	<?php echo backend_select('attrCulture', $obj, Lists::getListitemsForSelect('culture'), array('labelname' => 'Culture' , 'model' => 'ListitemI18n', 'unique' => 'true', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getCulture'); ?>

	<?php echo backend_tags($tags, $obj); ?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type="text/javascript">setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>