<?php echo $sf_params->get("backendMsg");?>
<div id='content_tabs'>
<form id='form' name='form' action='<?php echo $formAction; ?>' onsubmit='return validateEditForm()' method='POST'>
	<?php if ($moduleName && $documentName): ?>
		<?php echo backend_hidden('moduleName', $moduleName); ?>
		<?php echo backend_hidden('documentName', $documentName); ?>
	<?php endif; ?>
	<?php echo backend_hidden('id', $obj, '', 'getId'); ?>
	<?php echo backend_hidden('parent', $sf_request->getParameter('parent')); ?>
	<?php if ($obj) echo 'ID: '.$obj->getId(); ?><br>
	<?php if ($obj): ?><a href='<?php echo $obj->getHref(); ?>' target='_blank'><img id='btnEditPage' align='absbottom' src='/images/btn_editpage.gif'/></a><?php endif; ?>
	<?php echo backend_input('attrLabel', $obj, array('labelname' => 'Label' , 'model' => 'PageI18n', 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getLabel'); ?>
	<?php echo backend_input('attrRewriteUrl', $obj, array('labelname' => 'Url Rewrite' , 'model' => 'PageI18n', 'maxlength' => 255), 'getRewriteUrl'); ?>
	<!--<input type="hidden" value="CONTENT" name="attrPageType">-->
	<?php //echo backend_hidden('attrPageType', $obj, '', 'getPageType'); ?>
	<?php echo backend_select('attrPageType', $obj, Lists::getListitemsForSelect('page_types'), array('labelname' => 'Page type' , 'model' => 'PageI18n', 'required' => 'true', 'onchange' => ' validateEditForm(); showFields(this.value)'), 'getPageType'); ?>

	<span id="REFERENCE" style="display:none">
		<?php echo backend_input('attrPageId', $obj, array('labelname' => 'Page Id' , 'model' => 'PageI18n', 'maxlength' => 255, 'validate' => 'Integer', 'onfocus' => 'validateField(\'attrPageId\', \'admin/validateInteger\')'), 'getPageId'); ?>
	</span>
	<span id="EXTERNAL" style="display:none">
		<?php echo backend_input('attrUrl', $obj, array('labelname' => 'Url' , 'model' => 'PageI18n', 'maxlength' => 255, 'validate' => 'Url', 'onfocus' => 'validateField(\'attrUrl\', \'admin/validateUrl\')'), 'getUrl'); ?>
	</span>

	<?php echo backend_input('attrNavigationTitle', $obj, array('labelname' => 'Navigation title' , 'model' => 'PageI18n', 'maxlength' => 255, 'required' => 'true', 'onfocus' => ' validateEditForm();'), 'getNavigationTitle'); ?>
	<?php echo backend_select('attrTemplate', $obj, $template, array('labelname' => 'Template' , 'model' => 'PageI18n', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getTemplate'); ?>
	<?php echo backend_checkbox('attrIsSecure', $obj, array('labelname' => 'Is secure' , 'model' => 'PageI18n'), 'getIsSecure'); ?>
	<?php echo backend_select('attrCulture', $obj, Lists::getListitemsForSelect('culture'), array('labelname' => 'Culture' , 'model' => 'PageI18n', 'unique' => 'true', 'required' => 'true', 'onchange' => ' validateEditForm();'), 'getCulture'); ?>
	
	<?php //echo backend_media('attrImage', $obj, array('labelname' => 'Background PNG' , 'model' => 'PageI18n', 'allowed' => 'png'), 'getImage'); ?>
	<?php echo backend_input('attrGalleryLabel', $obj, array('labelname' => 'Gallery Label' , 'model' => 'PageI18n', 'maxlength' => 255, 'onfocus' => ' validateEditForm();'), 'getGalleryLabel'); ?>
	<?php
		if($obj)
		{
			echo backend_gallery($obj->getId(),
			array(
			'width' => '600',
			'thumb_width' => '126',
			'path' => 'upload'
			));
		}
		?>
	<?php echo backend_tags($tags, $obj); ?>
	<div id='line'></div>
	<input id='btnSubmit' type='submit' class='save_btndisabled' value='' disabled/>
</form>
</div>
<script type="text/javascript">setTimeout(function(){$('#backendMsg').fadeOut(1000)},2000);</script>