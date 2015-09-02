<?php echo $sf_params->get("backendMsg");?>
<?php //if($children): ?>

<h1 class="lead-heading"><?php echo ($module == "website") ? 'Pages' : ucfirst($module); ?></h1>
<?php if ($paging): ?>
<div>
	<div class="pages">
		<?php echo $paging; ?>
	</div>
</div>
<?php endif; ?>
<div class="clear"></div>
<form>
	<!--<input type="hidden" name="deletedObjects" id="deletedObjects" value="" />-->
	<fieldset class="drop-shadow">

<?php
//	var_dump($rights);
	foreach ($rights as $r)
	{
		if ( ($r != '') && (substr($r, 0, 1) != '-') )
		{
			$add = ($parent = $sf_params->get('p')) ? '&parent='.$parent : '';
			$add .= ($page = $sf_params->get('page')) ? '&page='.$page : '';
			$r = str_replace('create', '', $r);
			echo '<a href="?m='.$sf_params->get('m').'&n='.$r.$add.'" class="submit">Add '.$r.'</a>';
		}
	}
?>
<?php if ( !in_array('-delete', $rights) ): ?>
				<ul class="actions">
					<li><a href="javascript:void(0);" title="#" class="SelectAll">Select All</a></li>
					<li><a href="javascript:void(0);" title="#" class="DeselectAll">Deselect All</a></li>
					<li><a href="javascript:void(0);" title="#" class="delete-all">Delete Selected</a></li>
				</ul>
				<div class="clear"></div>
<?php endif; ?>	

		<div class="table-list">
			<div class="row lead">
				<div class="col-a"><strong>Name</strong></div>
				<div class="col-f"><strong>Edit</strong></div>
				<div class="clear"></div>
			</div>
			<ul>

<?php if ($children): ?>

	<?php $href = 'href="javascript:void(0)"'; ?>
	<?php foreach($children as $id => $label): ?>
				<li class="ui-state-default" id="<?php echo $id; ?>">
					<div class="row">
						<!--<div class="col-aa">&nbsp;</div>-->
						<div class="col-aa" ><img src="/images/icons/<?php echo $module; ?>.png" align="top"></div>
						<div class="col-a"><a <?php echo $href; ?>><?php echo UtilsHelper::cutStr($label, 60, '...'); ?></a></div>
						<div class="col-f"><a href="?m=<?php echo $sf_params->get('m')?>&id=<?php echo $id; ?>" title="Edit" class="edit"></a></div>
						<div class="clear"></div>
					</div>
				</li>
	<?php endforeach; ?>

<?php endif; ?>
			</ul>
<?php
/*			<div id="delete-all" title="Delete All Items">
				<p>
					<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
					These items (and all sub-items) will be permanently deleted and cannot be recovered. Are you sure?
					<center style="height: 20px;"><img id="del_all_wait" style="display: none;" title="Working..." src="/images/load.gif"></center>
				</p>
			</div>
			<div id="delete-this" title="Delete Item">
				<p>
					<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
					This item (and all sub-items) will be permanently deleted and cannot be recovered. Are you sure?
					<center style="height: 20px;"><img id="del_wait" style="display: none;" title="Working..." src="/images/load.gif"></center>
				</p>
			</div>*/
?>
			<div class="clear"></div>
		</div>

	</fieldset>
</form>
<?php if ($paging):?>
<div>
	<div class="pages">
		<?php echo $paging; ?>
	</div>
</div>
<?php endif; ?>
<div class="clear"></div>
<?php //endif; ?>