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
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'Listitem', 'maxlength' => '255', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
	<?php if($userType == "admin" || $showvalue):?>
		<?php echo backend_input('attrValue', $obj, array('labelname' => 'Value' , 'model' => 'Listitem', 'maxlength' => '255'), 'getValue'); ?>
	<?php endif;?>
	<?php if($userType == "admin" || $showtags):?>
		<?php echo backend_tags($tags, $obj); ?>
	<?php endif;?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type="text/javascript">setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>