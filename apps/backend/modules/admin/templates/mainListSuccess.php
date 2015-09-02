<?php if($children && $pager):?>
<table width="98%" class="mainListTable" id="mainListTable" cellpadding="0" cellspacing="0" border="0">
	<tr >
		<td width="20px" class="noborder">&nbsp;</td>
		<td width="50px" style="background-color:#AFB8DA;">&nbsp;ID</td>
		<td style="background-color:#AFB8DA;">
		<div style="float:left;width:50px;height:20px">&nbsp;LABEL</div>
		<div style="float:right;width:100px;height:20px;text-align:right">
			<img title="Activate" onmouseover="this.style.background='#aaaaff'" onmouseout="this.style.background='none'" src="/images/icons/activate.png" onclick="setStatus('ACTIVE', <?php echo $parent?>, <?php echo $pager->getPage()?>, '<?php echo $filter?>')">
			<img title="Put on waiting" onmouseover="this.style.background='#aaaaff'" onmouseout="this.style.background='none'" src="/images/icons/waiting.png" onclick="setStatus('WAITING', <?php echo $parent?>, <?php echo $pager->getPage()?>, '<?php echo $filter?>')">
			<img title="Deactivate" onmouseover="this.style.background='#aaaaff'" onmouseout="this.style.background='none'" src="/images/icons/deactivate.png" onclick="setStatus('DEACTIVATED', <?php echo $parent?>, <?php echo $pager->getPage()?>, '<?php echo $filter?>')">
		</div>
		<?php $module = strtolower($sf_params->get("modulename"));?>
		<div style="float:right;width:20px;height:20px">
		<a onclick="if (confirm('Are you sure you want to delete this item and all its sub-items?')) executeMainListAction('admin/delete','<?php echo $parent?>')">
		<img src="/images/icons/delete.png" align="absmiddle" title="Delete selected elements"></a>
		</div>
		</td>
	</tr>
	<div id="actionDiv">
		<div id="actionDivHead">
			<a onclick="$('#actionDiv').fadeOut();">close <img align="absmiddle" src="/images/icons/delete.png"></a>&nbsp;
		</div>
		<div id="actionDivContent"></div>
	</div>
	<?php
		foreach ($children as $child):

		//if($filter && (!Document::checkOwner($child->getId()))) continue;

		$label = $child->getLabel();
		$id = $child->getId();
		$modelUp = get_class($child);
		$model = strtolower($modelUp);
		$status = strtolower(Document::getGenericDocument($child)->getPublicationStatus());
		$i18nEls = BackendService::getLanguageBar($id, $sf_params->get("modulename"));
	?>
	<tr>
		<td class="noborder">
			<img src="/images/icons/status_<?php echo $status; ?>.png" border="0">
		</td>
		<td>
			<?php echo $id; ?>
		</td>
		<td onclick="addToSelected(<?php echo $id; ?>, this)">
			<div style="float:left;display:block;margin-top:5px;width:500px">
			<span id="<?php echo $id ?>"
				class="<?php echo $module; ?>_<?php echo $model; ?>"
				style="cursor:pointer; background: url(/images/icons/<?php echo $model; ?>.png) 0 0 no-repeat; padding: 5px 5px 2px 20px; width:100%"
				onClick="editDocument('<?php echo $modelUp; ?>','<?php echo $id ?>')">

				&nbsp;<?php echo UtilsHelper::cutStr($label, 50, '...'); ?></span>
			</div>
			<?php if(count($i18nEls) > 0):?>
				<div style="float:right;height:20px;width:100px;">
					<?php foreach ($i18nEls as $i18n): ?>
						<div class="mainlist_lang">
							<img src="/images/icons/<?php echo $i18n['culture']->getValue()?>.gif" border="0" onclick="editDocument('<?php echo $i18n['type']; ?>', <?php echo $i18n['id'] ?>)" >
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
	<tr>
		<td class="noborder">
		</td>
		<td colspan="3" class="noborder">
<?php $pages = $pager->getLastPage(); if($pages > 1): ?>
			<div>
<?php
	for ($p=1; $p <= $pages ; $p++)
	{
		if ($p == $pager->getPage())
		{
			echo "<b style='color:#970000'> ".$p." </b>";
		}
		else
		{
			echo "<a href='#' onclick='parseMainList( null, ".$parent.", ".$p.", \"$filter\") '>".$p."</a>";
		}
		if ($p != $pager->getLastPage())
		{
			echo " ";
		}
	}
?>
			</div>
			<div id='line'></div>
			<div style="float:left;">
			<?php if ($pager->getFirstPage() != $pager->getPage()): ?>
				&laquo; <a href="#" onclick="parseMainList( null, <?php echo $parent ?>, <?php echo $pager->getPreviousPage()?>, '<?php echo $filter?>');" class="prev"><?php echo UtilsHelper::Localize('media.frontend.gallery-previous', $lang); ?></a>
			<?php endif;?>&nbsp;
			</div>
			<div style="float:right;">&nbsp;
			<?php if ($pages != $pager->getPage()): ?>
				<a href="#" onclick="parseMainList( null, <?php echo $parent ?>, <?php echo $pager->getNextPage()?>, '<?php echo $filter?>');" class="next"> <?php echo UtilsHelper::Localize('media.frontend.gallery-next', $lang); ?></a> &raquo;
			<?php endif;?>
			</div>
<?php endif; ?>
		</td>
	</tr>
</table>
<?php endif; ?>