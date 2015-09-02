<div class="moduleName">RESOURCES</div>
<table class="rightTree">
	<tr height="20">
		<td class="titleBarRight" valign="top">
			<br>
			<label for="modules">Module:</label>
			<select id="modules" name="moduleRightTree" onChange="getRightTree(this.value);">
			    <?php echo $resources ?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top">
			<ul id="rightNavigation" class="filetree"/>
		</td>
	</tr>
</table>