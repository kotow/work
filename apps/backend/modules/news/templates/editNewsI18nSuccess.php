<?php echo $sf_params->get("backendMsg");?>
<div id='tabs' class='tabsmenu'>
	<ul>
		<li><a href='#' rel='tab1' onclick='SelectTab(this)' class='selected'>General</a></li>
		<li><a href='#' rel='tab2' onclick='SelectTab(this)'>Content</a></li>
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
		<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'NewsI18n', 'maxlength' => '255', 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
		<?php echo backend_input('attrShortDescription', $obj, array('labelname' => 'Short description' , 'model' => 'NewsI18n', 'maxlength' => '255'), 'getShortDescription'); ?>
		<?php echo backend_media('attrImage', $obj, array('labelname' => 'Main image' , 'model' => 'NewsI18n', 'allowed' => 'images'), 'getImage'); ?>
		<?php echo backend_date('attrStartDate', $obj, array('labelname' => 'Start date' , 'model' => 'NewsI18n'), 'getStartDate'); ?>
		<?php echo backend_date('attrEndDate', $obj, array('labelname' => 'End date' , 'model' => 'NewsI18n'), 'getEndDate'); ?>
		<?php echo backend_select('attrCulture', $obj, Lists::getListitemsForSelect('culture'), array('labelname' => 'Culture' , 'model' => 'NewsI18n', 'unique' => 'true', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getCulture'); ?>
		<?php
		if($obj)
		{
			echo backend_gallery($obj->getId(),
			array(
			'width' => '600',
			'thumb_width' => '100',
			'path' => 'upload'
			));
		}
		?>
		<?php echo backend_tags($tags, $obj); ?>
	</div>

	<div id='tab2' name='tabContent' style='display: none'>
		<?php echo backend_textarea('attrContent', $obj, array('labelname' => 'Content' , 'model' => 'NewsI18n', 'size' => '50', 'richtext' => 'true', 'rows' => '10'), 'getContent'); ?>
	</div>

	<?php echo backend_hidden('imageFields', 'Image'); ?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type="text/javascript">setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>