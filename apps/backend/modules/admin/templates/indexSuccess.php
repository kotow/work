<div id="actionDiv">
	<div id="actionDivHead">
		<a onclick="$('#actionDiv').fadeOut();">close <img align="absmiddle" src="/images/icons/delete.png"></a>&nbsp;
	</div>
	<div id="actionDivContent"></div>
</div>
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="top">
			<table width="1000" height="100%" id="mainContent" cellpadding="0" cellspacing="0">
				<tr height="30">
					<td colspan="3">
						<?php echo $mainMenu ?>
					</td>
				</tr>
				<tr>
					<td id="leftTreeReplaced" width="200" align="left" valign="top"></td>
					<td class="centerContent" width="800">
						<table width="100%" height="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td id="docName" valign="bottom"></td>
							</tr>
							<tr>
								<td id="actionsBar" valign="middle">
									<?php
									$module = explode("_",$refresh);
									foreach ($moduleFilters as $filter):
									if($module[1] == $filter['moduleName']):
									?>
										<div style="float:left;" >
										<?php foreach ($filter['filters'] as $f):?>
											<?php if ($f['name'] == 'separator'): ?>
												<?php echo str_replace(array(' ', '|'), array('&nbsp;', '<img src="/images/icons/separator.png" border="0" align="absmiddle">'), $f['value']); ?>
											<?php else: ?>
												<?php if(empty($f['pop'])):?>
													<a onclick="executeMainListFilter('<?php echo $f['name']?>')" ><img src="/images/icons/<?php echo $f['name']?>.png" align="absmiddle" title="<?php echo $f['value']?>"></a>
												<?php else:?>
													<a onclick="executeMainListFilter('<?php echo $f['name']?>','<?php echo $f['pop']?>')" ><img src="/images/icons/<?php echo $f['name']?>.png" align="absmiddle" title="<?php echo $f['value']?>"></a>
												<?php endif;?>
											<?php endif;?>
										<?php endforeach;?>
										</div>
									<?php endif;?>
									<?php endforeach;?>
									<?php if(method_exists("BackendFilters", $module[1]."_search")):?>
										<div style="float:right;">
											Search: <input id="searchKeys" type="text">&nbsp;
											<?php //if($module[1] == "user" || $module[1] == "news"):?>
												<!--<select type="checkbox" name="stype" id="stype">
													<option value="simple">Simple (email, encoding and case sensitive)</option>
													<option value="extended">Extended (slower)</option>
												</select>-->
											<?php //endif;?>
											<input id="back_searchBtn" type="submit" value=">>"
											onclick="executeMainListFilter('<?php echo $module[1]?>_search/keys/')">
										</div>
									<?php endif;?>
									<div id="backendMsg"></div>
								</td>
							</tr>
							<tr>
								<td id="languageBarReplaced" align="left" valign="top"></td>
							</tr>
							<tr>
								<td id="save_status" align="left" valign="top"></td>
							</tr>
							<tr height="100%">
								<td id="documentContent" align="left" valign="top"></td>
							</tr>
						</table>
					</td>
					<td id="rightTreeReplaced" style="display:none" width="200" valign="top"></td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<span>
	<?php echo $contextMenus; ?>
	<div class="contextMenu" id="freeBlock">
		<ul>
			<li id="insertBlock"><img src="/images/icons/edit_document.png"/>Insert block</li>
		</ul>
	</div>
	<div class="contextMenu" id="deleteBlock">
		<ul>
			<li id="deleteBlock"><img src="/images/icons/delete_document.png"/>Delete block</li>
		</ul>
	</div>

</span>

<?php if($refresh):?>
	<script type="text/javascript">
		<?php if ($id):?>
			RefreshIndex('<?php echo $refresh?>','<?php echo $model?>','<?php echo $id?>','<?php echo $err?>', "edit");
		<?php elseif ($parent): ?>
			RefreshIndex('<?php echo $refresh?>','<?php echo $model?>','<?php echo $parent?>','<?php echo $err?>', "create");
		<?php else:?>
			RefreshIndex('<?php echo $refresh?>');
		<?php endif;?>
	</script>
<?php endif;?>