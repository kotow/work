<?php echo $sf_params->get("backendMsg");?>
<div id='content_tabs'>
<form id='form' name='form' action='/admin/admin/saveTag' onsubmit='return validateEditForm()' method='POST'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
	<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
	<?php if ($obj) echo 'ID: '.$obj->getId(); ?>
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
	<?php echo backend_input('attrTagId', $obj, array('labelname' => 'Tag ID' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getTagId'); ?>
	<?php echo backend_input('attrModule', $obj, array('labelname' => 'Module' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getModule'); ?>
	<?php echo backend_input('attrDocumentModel', $obj, array('labelname' => 'Document Model' , 'model' => 'Tag', 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getDocumentModel'); ?>
	<?php echo backend_checkbox('attrExclusive', $obj, array('labelname' => 'Exclusive' , 'model' => 'Tag'), 'getExclusive'); ?>
	<?php echo backend_tags($tags, $obj); ?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type="text/javascript">setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>