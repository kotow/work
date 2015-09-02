<div class="qfEntryHeader"><span>Search Templates</span></div>
<div class="qfEntryContent qfEntryContentSearch">
	<div class="qfSessHolder qfMaxWd">
    	<div class="qfTrMarkItemAddDel">
			<a href="<?php echo $addHref; ?>" class="qfSessCtrlBtn qfSessCtrlPlus">Добави</a>
		</div>
<?php foreach ($brands as $b): ?>
<?php if (isset($searchTemplates[$b->getId()])): ?>
<?php
$src = '/images/trade-mark00.jpg';
if ($img = Document::getDocumentInstance($b->getImage()))
{
	$src = $img->getRelativeThumbUrl();
}
?>
		<div class="qfSearchWrap">		
			<div class="qfSearchListWrap qfBoxBorderBg">
            	<div class="qfSearchTag">
                    <div class="qfTrMarkContainer">
                        <div class="qfTrMarkCell qfTrMarkLogo"><img alt="trade mark" src="<?php echo $src; ?>"></div>
                        <div class="qfTrMarkCell qfTrMarkHeading"><?php echo $b->getLabel(); ?></div>
                    </div>
                    <span class="qfSearchTagExpMarker"></span>
                </div>
				<div class="qfSearchListWrapExpand">
<?php $ind = 0; foreach ($searchTemplates[$b->getId()] as $search): $ind++;?>
					<div class="qfSearchListitem">
						<div class="qfSearchItemCell qfSearchLeft">
							<div class="qfSearchItemLData">
								<span class="qfSearchItemNum"><?php echo $ind; ?></span>
								<span class="qfSearchItemName"><a href="<?php echo $addHref.'?brand='.$b->getId().'&obj_id='.$search->getId(); ?>"><?php echo $search->getLabel(); ?></a></span>
								<span class="qfSearchItemDate"><?php echo UtilsHelper::DateBG($search->getCreatedAt(), 'd.m.Y'); ?> г.</span>
							</div>
						</div>
						<div class="qfSearchItemCell qfSearchRight">
							<p><span>Ключови думи по име:</span><?php echo $search->getLabel(); ?></p>
							<p><span>Класификации на лого:</span><?php echo $search->getViennaClasses(); ?></p>
							<p><span>Продукти:</span><?php echo $search->getNiceClasses(); ?></p>
							<span title="delete" class="qfSearchListitemDelete" id="<?php echo $search->getId(); ?>">x</span>
						</div>
					</div>
<?php endforeach; ?>
<?php /*
					<div class="qfSearchListitem">
						<div class="qfSearchItemCell qfSearchLeft">
							<div class="qfSearchItemLData">
								<span class="qfSearchItemNum">2</span>
								<span class="qfSearchItemName">Наименование на търсенето</span>
								<span class="qfSearchItemDate">22.07.2014 г.</span>
							</div>
						</div>
						<div class="qfSearchItemCell qfSearchRight">
							<p><span>Ключови думи по име:</span>*енско</p>
							<p><span>Класификации на лого:</span>115240, 205486, 236558</p>
							<p><span>Продукти:</span>14, 16, 18</p>
							<span title="delete" class="qfSearchListitemDelete">x</span>
						</div>
					</div>
					<div class="qfSearchListitem">
						<div class="qfSearchItemCell qfSearchLeft">
							<div class="qfSearchItemLData">
								<span class="qfSearchItemNum">3</span>
								<span class="qfSearchItemName">Наименование на търсенето</span>
								<span class="qfSearchItemDate">22.07.2014 г.</span>
							</div>
						</div>
						<div class="qfSearchItemCell qfSearchRight">
							<p><span>Ключови думи по име:</span>*енско</p>
							<p><span>Класификации на лого:</span>115240, 205486, 236558</p>
							<p><span>Продукти:</span>14, 16, 18</p>
							<span title="delete" class="qfSearchListitemDelete">x</span>
						</div>
					</div>
*/ ?>
					<div class="qfSearcjCtrls">
						<div class="qfSessMainCtrls">
							<a class="qfSessCtrlBtn qfSessCtrlPlus" href="<?php echo $addHref.'?brand='.$b->getId(); ?>">Добави</a>
<?php /*
							<a class="qfSessCtrlBtn qfSessCtrlTrash">Изтрий</a>
*/ ?>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php /*
		<div class="qfSearchWrap">
			<div class="qfSearchTag">
				<div class="qfTrMarkContainer">
					<div class="qfTrMarkCell qfTrMarkLogo"><img alt="trade mark01" src="/images/trade-mark03.jpg"></div>
					<div class="qfTrMarkCell qfTrMarkHeading">Carlsberg</div>
				</div>
				<span class="qfSearchTagExpMarker"></span>
			</div>
			<div class="qfSearchListWrap qfBoxBorderBg">
				<div class="qfSearchListWrapExpand">
					<div class="qfSearchListitem">
						<div class="qfSearchItemCell qfSearchLeft">
							<div class="qfSearchItemLData">
								<span class="qfSearchItemNum">1</span>
								<span class="qfSearchItemName">Наименование на търсенето</span>
								<span class="qfSearchItemDate">22.07.2014 г.</span>
							</div>
						</div>
						<div class="qfSearchItemCell qfSearchRight">
							<p><span>Ключови думи по име:</span>Карлсберг</p>
							<p><span>Класификации на лого:</span>115240, 205486, 236558</p>
							<p><span>Продукти:</span>14, 16, 18</p>
							<span title="delete" class="qfSearchListitemDelete">x</span>
						</div>
					</div>
					<div class="qfSearchListitem">
						<div class="qfSearchItemCell qfSearchLeft">
							<div class="qfSearchItemLData">
								<span class="qfSearchItemNum">2</span>
								<span class="qfSearchItemName">Наименование на търсенето</span>
								<span class="qfSearchItemDate">22.07.2014 г.</span>
							</div>
						</div>
						<div class="qfSearchItemCell qfSearchRight">
							<p><span>Ключови думи по име:</span>Карлс*</p>
							<p><span>Класификации на лого:</span>115240, 205486, 236558</p>
							<p><span>Продукти:</span>14, 16, 18</p>
							<span title="delete" class="qfSearchListitemDelete">x</span>
						</div>
					</div>
					<div class="qfSearchListitem">
						<div class="qfSearchItemCell qfSearchLeft">
							<div class="qfSearchItemLData">
								<span class="qfSearchItemNum">3</span>
								<span class="qfSearchItemName">Наименование на търсенето</span>
								<span class="qfSearchItemDate">22.07.2014 г.</span>
							</div>
						</div>
						<div class="qfSearchItemCell qfSearchRight">
							<p><span>Ключови думи по име:</span>*берг</p>
							<p><span>Класификации на лого:</span>115240, 205486, 236558</p>
							<p><span>Продукти:</span>14, 16, 18</p>
							<span title="delete" class="qfSearchListitemDelete">x</span>
						</div>
					</div>
					<div class="qfSearcjCtrls">
						<div class="qfSessMainCtrls">
							<a class="qfSessCtrlBtn qfSessCtrlPlus" href="<?php echo $addEditHref; ?>">Добави</a>
							<a class="qfSessCtrlBtn qfSessCtrlTrash">Изтрий</a>
						</div>
					</div>
				</div>
			</div>
		</div>
*/ ?>
<?php endif; ?>
<?php endforeach; ?>
		<div class="qfTrMarkItemAddDel">
			<a href="<?php echo $addHref; ?>" class="qfSessCtrlBtn qfSessCtrlPlus">Добави</a>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".qfSearchListitemDelete").click(function(event) {
		var id = $(this).attr('id'); //alert('id='+id);
		var el = $(this).parent().parent();
		$.ajax({
			url: '/search/removeTemplate?id='+id,
			success: function(msg)
			{
				if (msg == 'OK')
				{
					el.fadeOut(300, function(){
						el.remove();
					});
				}
			}
		});
	});
});

</script>