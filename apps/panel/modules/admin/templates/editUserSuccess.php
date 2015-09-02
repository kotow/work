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

	<?php //echo panel_select('attrUserType', $obj, Lists::getListitemsForSelect('user_types'), array('onchange' => 'show_hide_admin_options(this)', 'labelname' => 'Account type' , 'model' => 'User'), 'getUserType'); ?>
	<?php echo panel_input('attrFirstName', $obj, array('labelname' => 'First name' , 'model' => 'User', 'maxlength' => '100', 'required' => 'true', 'class' => 'large'), 'getFirstName'); ?>
	<?php echo panel_input('attrLastName', $obj, array('labelname' => 'Last name' , 'model' => 'User', 'maxlength' => '100'), 'getLastName'); ?>
	<?php echo panel_input('attrEmail', $obj, array('labelname' => 'Email' , 'model' => 'User', 'maxlength' => '100', 'required' => 'true', 'validate' => 'Email', 'class' => 'large'), 'getEmail'); ?>
	<?php echo panel_input('attrPassword', $obj, array('labelname' => 'Password' , 'model' => 'User', 'maxlength' => '50', 'class' => 'large'), 'getPassword'); ?>
	<?php echo panel_input('Confirmpass', $obj, array('labelname' => 'Confirm password' , 'model' => 'User', 'maxlength' => '50', 'validate' => 'compare', 'class' => 'large'), 'getConfirmpass'); ?>
	<?php echo panel_input('attrPhone', $obj, array('labelname' => 'Phone' , 'model' => 'User', 'maxlength' => '20'), 'getPhone'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>

	<?php echo panel_hidden('attrBackend', $obj, array('labelname' => 'Backend' , 'model' => 'User'), 'getBackend'); ?>
	<?php echo panel_select('attrType', $obj, Lists::getListitemsForSelect('usertype'), array('labelname' => 'Type' , 'model' => 'User'), 'getType'); ?>
	<?php //echo panel_date('attrBirthDate', $obj, array('labelname' => 'BirthDate' , 'model' => 'User'), 'getBirthDate'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0) { echo panel_tags($tags, $obj); echo panel_separator('hr', array('class' => 'brake')); } ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	<?php //echo panel_modal(); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->