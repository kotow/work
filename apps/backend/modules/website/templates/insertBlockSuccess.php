<?php if($error):
echo $error;
?>

<?php else:?>
<?php use_helper('Object') ?>
<?php echo form_tag('website/saveBlock') ?>
<?php echo object_input_hidden_tag($page, 'getId'); ?>
<?php echo input_hidden_tag('parentBlock', $sf_request->getParameter('parentBlock')); ?>
<?php echo input_hidden_tag('blockId', $sf_request->getParameter('blockId')); ?>
<table width="100%" id="insertBlockTable">
<tbody>
<tr id="head" height="20">
  <td colspan="2" align="center">
  Insert Block
  </td>
</tr>
<tr>
  
  <td align="right">
  <?php echo select_tag('modulename', options_for_select($modules, ''), array ('style' => 'width:250px;background-color:#222;border:solid 1px #ccc;color:#fff;padding:5px;border-radius:5px;margin:10px', 'onChange' => 'getBlocksForModule(this.value);')); ?></td>
</tr>
<tr>
  
  <td align="right">
  	<select style="width:250px;background-color:#222;border:solid 1px #ccc;color:#fff;padding:10px;border-radius:5px;margin:10px" id="blocks_for_module_select" name="block">
  		<option value="">Select a block...</option>
  	</select>
  </td>
</tr>
<tr>
	
	<td align="right">
		<button type="submit" name="save" style="background-color:#222;border:solid 1px #ccc;color:#fff;padding:5px;border-radius:5px;margin:10px;width:113px">Add</button>
		<button type="button" name="close" onclick="$('#blocks_insert').fadeOut();" style="background-color:#222;border:solid 1px #ccc;color:#fff;padding:5px;border-radius:5px;margin:10px;width:113px">Close</button>
	</td>
</tr>	
</tbody>
</table>
</form>
<?php endif;?>