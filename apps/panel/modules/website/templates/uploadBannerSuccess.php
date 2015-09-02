<div style="background:#FFFFFF; height:1250px">
<?php echo $message;?>
<form name="tform" action="" method="POST" enctype="multipart/form-data" style=" padding:10px;text-align:left;">
		<div style="border: solid 1px #D7E0ED;padding:5px; background:#f5f9fa">
			Banner:&nbsp;<input name="banner" type="file" style="border:solid 1px #D7E0ED">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Url&nbsp;<input name="bannerUrl" type="text" value="<?php if(!$sf_params->get("bannerUrl")&& $banner) echo $banner->getDescription(); else echo $sf_params->get("bannerUrl");?>" style="width:440px;border:solid 1px #D7E0ED">
			<?php if($banner && is_readable($banner->getServerAbsoluteUrl())):?>
				<?php if($banner->isImage()):?>
					<br>
					<br>
					<img align="absmiddle" src="<?php echo $banner->getRelativeThumbUrl()?>" border="0" />
					<a href="" onclick="deleteBanner('<?php echo $banner->getId()?>')"><img border="0" src="/images/icons/delete.png"/></a>
				<?php endif;?>
				<input type="hidden" value="<?php echo $banner->getId()?>" name="bannerId" />
			<?php endif;?>
		</div>
		<br/>
		<div style="border: solid 1px #D7E0ED;padding:5px; background:#f5f9fa">
		<?php
			$user = $sf_user->getSubscriber();
			if ($user->getType() == 'admin')
			{
				$isAdmin = 1;
			}
			else
			{
				$isAdmin = 0;
			}
		?>
		<?php echo backend_input("tel", $prefData["tel"], array("style" => "width:468px", "labelname" => "Phone", "validate" => "Integer", "onfocus" => "validateField('tel', 'admin/validateInteger');"))?>
		<?php echo backend_input("tel2", $prefData["tel2"], array("style" => "width:468px", "labelname" => "Phone 2", "validate" => "Integer", "onfocus" => "validateField('tel2', 'admin/validateInteger');"))?>
		<?php echo backend_textarea("info_bg", $prefData["info_bg"], array("richtext" => true, "style" => "width:740px;height:305px", "labelname" => "Text (bg)"))?>
		<?php echo backend_textarea("info_en", $prefData["info_en"], array("richtext" => true, "style" => "width:740px;height:305px", "labelname" => "Text (en)"))?>
		<?php echo backend_textarea("info_ru", $prefData["info_ru"], array("richtext" => true, "style" => "width:740px;height:305px", "labelname" => "Text (ru)"))?>
		</div>
		<br>
		<input id="btnSubmit" type="submit" class='save_btn' value="">
		<input type="hidden" value="sent" name="submitted" />
</form>
</div>