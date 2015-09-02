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

	<?php echo panel_input('attrLabel', $obj, array('labelname' => 'Label (Mark)', 'maxlength' => '255', 'required' => 'true', 'class' => 'large'), 'getLabel'); ?>
	<?php echo panel_input('attrApplicationNumber', $obj, array('labelname' => 'Application number', 'maxlength' => '255', 'required' => 'true', 'class' => 'large'), 'getApplicationNumber'); ?>
	<?php echo panel_date('attrApplicationDate', $obj, array('labelname' => 'Application date', 'rich'=>1, 'class' => 'short'), 'getApplicationDate'); ?>
	<?php echo panel_input('attrRegisterNumber', $obj, array('labelname' => 'Register number', 'maxlength' => '255', 'required' => 'true', 'class' => 'large'), 'getRegisterNumber'); ?>
	<?php echo panel_date('attrRegistrationDate', $obj, array('labelname' => 'Registration date', 'rich'=>1, 'class' => 'short'), 'getRegistrationDate'); ?>
	<?php echo panel_select('attrFromSystem', $obj, $systemsArr, array('labelname' => 'From system', 'disabled' => 1, 'class' => 'short'), 'getFromSystem'); ?>
	<?php echo panel_select('attrKind', $obj, $kindsArr, array('labelname' => 'Kind', 'class' => 'short'), 'getKind'); ?>
	<?php echo panel_date('attrDateRequested', $obj, array('labelname' => 'Date requested', 'rich'=>1, 'class' => 'short'), 'getDateRequested'); ?>
	<?php echo panel_input('attrStatus', $obj, array('labelname' => 'Status', 'maxlength' => '255', 'class' => 'large'), 'getStatus'); ?>
	<?php echo panel_date('attrExpiresOn', $obj, array('labelname' => 'Expires on', 'rich'=>1, 'class' => 'short'), 'getExpiresOn'); ?>
	<?php echo panel_textarea('attrPublications', $obj, array('labelname' => 'Publications', 'size' => '70x5',  'rows' => '10'), 'getPublications'); ?>
	<?php echo panel_input('attrViennaClasses', $obj, array('labelname' => 'VIENNA classes', 'maxlength' => '512', 'class' => 'large'), 'getViennaClasses'); ?>
	<?php echo panel_input('attrNiceClasses', $obj, array('labelname' => 'NICE classes', 'maxlength' => '512', 'class' => 'large'), 'getNiceClasses'); ?>
	<?php echo panel_input('attrRightsOwner', $obj, array('labelname' => 'Rights owner', 'maxlength' => '255', 'class' => 'large'), 'getRightsOwner'); ?>
	<?php echo panel_textarea('attrRightsOwnerAddress', $obj, array('labelname' => 'Rights owner address', 'size' => '70x5', 'rows' => '10'), 'getRightsOwnerAddress'); ?>
	<?php echo panel_input('attrRightsRepresentative', $obj, array('labelname' => 'Rights representative', 'maxlength' => '255', 'class' => 'large'), 'getRightsRepresentative'); ?>
	<?php echo panel_textarea('attrRightsRepresentativeAddress', $obj, array('labelname' => 'Rights representative address', 'size' => '70x5', 'rows' => '10'), 'getRightsRepresentativeAddress'); ?>
	<?php echo panel_input('attrOfficeOfOrigin', $obj, array('labelname' => 'Office of origin', 'maxlength' => '10', 'class' => 'short'), 'getOfficeOfOrigin'); ?>
	<?php echo panel_input('attrDesignatedContractingParty', $obj, array('labelname' => 'Designated contracting party', 'maxlength' => '512', 'class' => 'large'), 'getDesignatedContractingParty'); ?>
	<?php echo panel_image('attrImage', $obj, array('labelname' => 'Image', 'allowed' => 'images'), 'getImage'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0) { echo panel_tags($tags, $obj); echo panel_separator('hr', array('class' => 'brake')); } ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	<?php echo panel_modal_images(); ?>
	</fieldset>
</form>
<div class='clear'></div>
<!-- END CONTENT -->
