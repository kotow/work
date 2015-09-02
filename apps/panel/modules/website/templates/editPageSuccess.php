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

	<?php echo panel_input('attrLabel', $obj, array('labelname' => 'Label', 'model' => 'PageI18n', 'maxlength' => 255, 'required' => 'true', 'class' => 'large'), 'getLabel'); ?>
	<?php echo panel_input('attrNavigationTitle', $obj, array('labelname' => 'Heading' , 'model' => 'PageI18n', 'maxlength' => 255, 'required' => 'true', 'class' => 'large'), 'getNavigationTitle'); ?>
	<?php echo panel_input('attrRewriteUrl', $obj, array('labelname' => 'SEO Firendly URL', 'model' => 'PageI18n', 'maxlength' => 255, 'class' => 'large'), 'getRewriteUrl'); ?>
	<?php echo panel_select('attrPageType', $obj, Lists::getListitemsForSelect('page_types'), array('labelname' => 'Page type' , 'model' => 'PageI18n', 'required' => 'true', 'class' => 'medium', 'onchange' => 'refresh_types();'), 'getPageType'); ?>
	<span id='REFERENCE' style='display:none'>
		<?php //echo panel_input('attrPageId', $obj, array('labelname' => 'Page to reference' , 'model' => 'PageI18n', 'maxlength' => 255, 'validate' => 'Integer'), 'getPageId'); ?>
		<?php echo panel_select('attrPageId', $obj, $allPages, array('labelname' => 'Page to reference' , 'model' => 'PageI18n', 'class' => 'medium'), 'getPageId'); ?>
	</span>
	<span id='EXTERNAL' style='display:none'>
		<?php echo panel_input('attrUrl', $obj, array('labelname' => 'Url to external page' , 'model' => 'PageI18n', 'maxlength' => 255, 'validate' => 'Url', 'class' => 'large'), 'getUrl'); ?>
	</span>

<div id="page_attributes">
	<?php echo panel_image('attrImage', $obj, array('labelname' => 'Main picture' , 'model' => 'PageI18n', 'allowed' => 'images'), 'getImage'); ?>
	<?php //echo panel_image('attrImage2', $obj, array('labelname' => 'Main picture 2' , 'model' => 'PageI18n', 'allowed' => 'images'), 'getImage2'); ?>
	<?php echo panel_textarea('attrDescription', $obj, array('labelname' => 'Description' , 'model' => 'PageI18n', 'size' => '50x10', 'richtext' => 'true', 'rows' => '10', 'class' => 'mceEditor'), 'getDescription'); ?>
	<?php //echo panel_textarea('attrDescription2', $obj, array('labelname' => 'Description 2' , 'model' => 'PageI18n', 'size' => '50x10', 'richtext' => 'true', 'rows' => '10', 'class' => 'mceEditor'), 'getDescription2'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>

	<?php //echo panel_input('attrMetaHeading', $obj, array('labelname' => 'META Heading', 'model' => 'PageI18n', 'maxlength' => 255, 'class' => 'large'), 'getMetaHeading'); ?>
	<?php echo panel_input('attrMetaDescription', $obj, array('labelname' => 'META Description', 'model' => 'PageI18n', 'maxlength' => 255, 'class' => 'large'), 'getMetaDescription'); ?>
	<?php echo panel_input('attrMetaKeywords', $obj, array('labelname' => 'META Keywords', 'model' => 'PageI18n', 'maxlength' => 255, 'class' => 'large'), 'getMetaKeywords'); ?>

	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
<?php
	if (!$obj)
		echo panel_select('attrTemplate', $obj, $template, array('labelname' => 'Template' , 'model' => 'PageI18n', 'required' => 'true', 'class' => 'medium', 'wait' => 1), 'getTemplate');
	else
	{
		$user = $sf_user->getSubscriber();
		if ($user && $user->getType() == 'admin')
			echo panel_select('attrTemplate', $obj, $template, array('labelname' => 'Template' , 'model' => 'PageI18n', 'required' => 'true', 'class' => 'medium', 'wait' => 1), 'getTemplate');
		else
			echo panel_select('attrTemplate', $obj, $template, array('labelname' => 'Template' , 'model' => 'PageI18n', 'disabled' => 'true', 'class' => 'medium'), 'getTemplate');
	}
?>
<div id="richtext_contents">
	<?php echo panel_textarea('attrContent', $obj, array('labelname' => 'Content' , 'model' => 'PageI18n', 'size'=> '50x5', 'richtext' => 'true', 'parse' => 1, 'class' => 'mceEditor'), 'getContent'); ?>
</div>
	<?php echo panel_checkbox('attrIsSecure', $obj, array('labelname' => 'Is secure' , 'model' => 'PageI18n'), 'getIsSecure'); ?>
	<?php //echo panel_select('attrCulture', $obj, Lists::getListitemsForSelect('culture'), array('labelname' => 'Culture' , 'model' => 'PageI18n', 'unique' => 'true', 'required' => 'true', 'class' => 'medium'), 'getCulture'); ?>
</div>

<?php
	if ($obj)
	{
		echo panel_gallery($obj->getId(),
			array(
				'labelname' => 'Images gallery',
				'width' => '600',
				'thumb_width' => '120',
				'path' => 'upload'
			)
		);
	}
?>
	<?php echo panel_separator('hr', array('class' => 'brake')); ?>
	<?php if (count($tags)>0 && $sf_user->getSubscriber()->getType() == "admin") { echo panel_tags($tags, $obj, $sf_params->get('id')); echo panel_separator('hr', array('class' => 'brake')); } ?>
	<?php echo panel_save_button(array('div' => 'buttons', 'class' => 'submit', 'value' => 'Save changes')); ?>
	<?php echo panel_modal_images(); ?>
	</fieldset>
</form>
<div class='clear'></div>

<script type="text/javascript">
$(function() {
	refresh_types();
});
</script>
<!-- END CONTENT -->