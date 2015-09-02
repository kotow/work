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

	<?php echo panel_input('attrLabel', $obj, array('labelname' => 'Label (Mark)', 'model' => 'Search', 'maxlength' => '255', 'class' => 'large'), 'getLabel'); ?>
	<?php echo panel_input('attrApplicationNumber', $obj, array('labelname' => 'Application number', 'model' => 'Search', 'maxlength' => '255', 'class' => 'large'), 'getApplicationNumber'); ?>
	<?php echo panel_input('attrRegisterNumber', $obj, array('labelname' => 'Register number', 'model' => 'Search', 'maxlength' => '255', 'class' => 'large'), 'getRegisterNumber'); ?>
	<?php echo panel_input('attrRegistrationDate', $obj, array('labelname' => 'Registration date', 'model' => 'Search', 'class' => 'small'), 'getRegistrationDate'); ?>
	<?php echo panel_input('attrDateRequested', $obj, array('labelname' => 'Date requested', 'model' => 'Search', 'maxlength' => '12', 'class' => 'small'), 'getDateRequested'); ?>
	<?php echo panel_input('attrExpiresOn', $obj, array('labelname' => 'Expires on', 'model' => 'Search', 'class' => 'large'), 'getExpiresOn'); ?>
	<?php echo panel_input('attrViennaClasses', $obj, array('labelname' => 'VIENNA classes', 'model' => 'Search', 'maxlength' => '512', 'class' => 'large'), 'getViennaClasses'); ?>
	<?php echo panel_input('attrNiceClasses', $obj, array('labelname' => 'NICE classes', 'model' => 'Search', 'maxlength' => '512', 'class' => 'large'), 'getNiceClasses'); ?>
	<?php echo panel_input('attrRightsOwner', $obj, array('labelname' => 'Rights owner', 'model' => 'Search', 'maxlength' => '255',  'class' => 'large'), 'getRightsOwner'); ?>
	<?php echo panel_input('attrRightsRepresentative', $obj, array('labelname' => 'Rights representative', 'model' => 'Search', 'maxlength' => '255', 'class' => 'large'), 'getRightsRepresentative'); ?>
	<?php echo panel_input('attrOfficeOfOrigin', $obj, array('labelname' => 'Office of origin', 'model' => 'Search', 'maxlength' => '10', 'class' => 'large'), 'getOfficeOf_origin'); ?>
	<?php echo panel_input('attrDesignatedContractingParty', $obj, array('labelname' => 'Designated contracting party', 'model' => 'Search', 'maxlength' => '512', 'class' => 'large'), 'getDesignatedContracting_party'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0) { echo panel_tags($tags, $obj); echo panel_separator('hr', array('class' => 'brake')); } ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->
