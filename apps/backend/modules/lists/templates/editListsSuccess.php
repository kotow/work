<?php echo $sf_params->get("backendMsg");?>
<div id='content_tabs'>
<?php if($obj && $userType != "admin" && $obj->getListType() == "system"):?>
	You can not edit this list.
<?php else:?>
<form id='form' name='form' action='<?php echo $formAction; ?>' onsubmit='return validateEditForm()' method='POST'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
	<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
	<?php if ($obj) echo 'ID: '.$obj->getId(); ?>
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'Lists', 'maxlength' => '255', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
	<?php if($userType == "admin"):?>
		<?php echo backend_input('attrListId', $obj, array('labelname' => 'List ID' , 'model' => 'Lists', 'maxlength' => '255', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getListId'); ?>
		<?php echo backend_select('attrListType', $obj, Lists::getListitemsForSelect('list_types'), array('labelname' => 'List type' , 'model' => 'Lists', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getListType'); ?>
	<?php endif;?>
	<?php echo backend_tags($tags, $obj); ?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
<?php endif;?>
</div>
<script type="text/javascript">setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>