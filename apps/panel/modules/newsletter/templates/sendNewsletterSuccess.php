<form name="tform" action="" method="POST" style="margin:10px 0 0 -50px">
	<b>Mailinglists :<br><br></b>
	<?php echo backend_multi_checkbox('mailinglists', '', $mailinglists, array('labelname' => '', 'onclick' => 'addCheckboxValTo("stock", this)')); ?>
	
	<input type="hidden" id="stock">
	<div style="clear:both;text-align:left;margin-left:105px" >
	<br>
	<br>
	
	<input type="button" onclick="sendNewsletter(document.getElementById('stock').value, '<?php echo $items?>')" value="SEND">
	
	</div>
</form>