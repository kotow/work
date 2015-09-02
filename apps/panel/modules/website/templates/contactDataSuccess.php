<div style="background:#FFFFFF; height:380px">
<?php echo $message;?>
<form name="tform" action="" method="POST" enctype="multipart/form-data" style=" padding:10px;text-align:left;">
		<div style="border: solid 1px #D7E0ED;padding:5px; background:#f5f9fa">
			<?php echo backend_textarea("address_bg", $prefData["address_bg"], array("style" => "width:468px;height:50px", "labelname" => "Address (bg)"))?>
			<?php echo backend_textarea("address_en", $prefData["address_en"], array("style" => "width:468px;height:50px", "labelname" => "Address (en)"))?>
			<?php echo backend_textarea("address_ru", $prefData["address_ru"], array("style" => "width:468px;height:50px", "labelname" => "Address (ru)"))?>
			<?php echo backend_input("tel", $prefData["tel"], array("style" => "width:468px", "labelname" => "Phone"))?>
			<?php echo backend_input("fax", $prefData["fax"], array("style" => "width:468px", "labelname" => "Fax"))?>
			<?php echo backend_input("email", $prefData["email"], array("style" => "width:468px", "labelname" => "E-mail"))?>
			
		</div><br>

		<input id="btnSubmit" type="submit" class='save_btn' value="">
		<input type="hidden" value="sent" name="submitted" />
</form>
</div>