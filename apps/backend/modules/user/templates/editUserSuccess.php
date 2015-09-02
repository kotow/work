<?php echo $sf_params->get("backendMsg");?>
<div id='tabs' class='tabsmenu'>
	<ul>
		<li><a href='#' rel='tab1' onclick='SelectTab(this)' class='selected'>General</a></li>
		<li id="adminTab" style='display: none'><a href='#' rel='tab2' onclick='SelectTab(this)'>Administrator options</a></li>
	</ul>
</div>
<div id='content_tabs'>
<form id='form' name='form' action='<?php echo $formAction; ?>' onsubmit='return validateEditForm()' method='POST'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
	<?php endif; ?>

	<div id='tab1' name='tabGeneral'>
		<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
		<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
		<?php if ($obj) echo 'ID: '.$obj->getId(); ?>
		<?php echo backend_select('attrType', $obj, Lists::getListitemsForSelect('usertype'), array('labelname' => 'Account type' , 'model' => 'User'), 'getType'); ?>
		<?php echo backend_input('attrFirstName', $obj, array('labelname' => 'First name' , 'model' => 'User', 'maxlength' => '100', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getFirstName'); ?>
		<?php echo backend_input('attrLastName', $obj, array('labelname' => 'Last name' , 'model' => 'User', 'maxlength' => '100'), 'getLastName'); ?>
		<?php echo backend_input('attrLogin', $obj, array('labelname' => 'Login' , 'model' => 'User', 'maxlength' => '100', 'required' => 'true'), 'getLogin'); ?>
		<?php echo backend_input('attrEmail', $obj, array('labelname' => 'Email' , 'model' => 'User', 'maxlength' => '100', 'validate' => 'Email', 'onfocus' => 'validateField(\'attrEmail\', \'admin/validateEmail\');'), 'getEmail'); ?>
		<?php echo backend_input('attrPassword', $obj, array('labelname' => 'Password' , 'model' => 'User', 'maxlength' => '50', 'onfocus' => ' validateEditForm();'), 'getPassword'); ?>
		<?php echo backend_input('Confirmpass', $obj, array('labelname' => 'Confirm password' , 'model' => 'User', 'maxlength' => '50', 'validate' => 'compare', 'onfocus' => 'validateCompare(this.id, \'attrPassword\', \'Password\');  validateEditForm();'), 'getConfirmpass'); ?>
		<?php echo backend_input('attrPhone', $obj, array('labelname' => 'Phone' , 'model' => 'User', 'maxlength' => '20'), 'getPhone'); ?>
		<?php echo backend_tags($tags, $obj); ?>
	</div>

	<div id='tab2' name='tabAdmin' style='display: none'>
		<?php //echo backend_hidden('attrBackend', $obj, array('labelname' => 'Backend' , 'model' => 'User'), 'getBackend'); ?>
		<?php //echo backend_select('attrType', $obj, Lists::getListitemsForSelect('usertype'), array('labelname' => 'Type' , 'model' => 'User'), 'getType'); ?>
	</div>

	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type="text/javascript">
setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);
show_hide_admin_options(document.getElementById('attrBackend'), true);
</script>