<?php echo $message;?>
<form name="tform" action="" method="POST" enctype="multipart/form-data" style=" margin:10px; text-align:left">

	<h3>Banners : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input id="btnSubmit" type="submit" class='save_btn' value="">
	</h3>
	
		<div style="border: solid 1px #D7E0ED;padding:5px; background:#f5f9fa">
		468 x 60&nbsp;&nbsp;&nbsp;
		<input name="banner1" type="file" style="width:300px;border:solid 1px #D7E0ED"><br>
		Url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="banner1Url" type="text" value="<?php if($banner1) echo $banner1->getDescription()?>" style="width:220px;border:solid 1px #D7E0ED">
		<?php if($banner1 && is_readable($banner1->getServerAbsoluteUrl())):?>
			<?php if($banner1->isImage()):?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img align="absmiddle" style="width:200px" src="<?php echo $banner1->getRelativeThumbUrl()?>" border="0" />
				<a href="" onclick="deleteBanner('<?php echo $banner1->getId()?>')"><img border="0" src="/images/icons/delete.png"/></a>
			<?php endif;?>
			<input type="hidden" value="<?php echo $banner1->getId()?>" name="banner1Id" />
		<?php endif;?>
		</div>
		<br/>
		
		<div style="border: solid 1px #D7E0ED;padding:5px; background:#f5f9fa">
		160 x 600&nbsp;
		<input name="banner2" type="file" style="width:300px;border:solid 1px #D7E0ED"><br>
		Url&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="banner2Url" value="<?php if($banner2) echo $banner2->getDescription()?>" type="text" style="width:220px;border:solid 1px #D7E0ED">
		<?php if($banner2 && is_readable($banner2->getServerAbsoluteThumbUrl())):?>
			<?php if($banner2->isImage()):?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img align="absmiddle" src="<?php echo $banner2->getRelativeThumbUrl()?>" border="0" />
				<a href="" onclick="deleteBanner(<?php echo $banner2->getId()?>)"><img border="0" src="/images/icons/delete.png"/></a>
			<?php endif;?>
			<input type="hidden" value="<?php echo $banner2->getId()?>" name="banner2Id" />
		<?php endif;?>
		</div>
		<br/>
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
		<div style="border: solid 1px #D7E0ED;padding:5px; background:#f5f9fa">
			<textarea cols="50" rows="10" onclick="selectElement(this, <?php echo $isAdmin; ?>)" id="richtext_Info" name="info">
			<?php if($info) echo $info->getContent();?>
			</textarea>
		</div>
		<input type="hidden" value="sent" name="submitted" />
</form>