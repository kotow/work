<div class="qfEntryHeader"><span>Tracked Trademarks</span></div>
<div class="qfEntryContent">
	<div class="qfTrTrMarks">
		<div class="qfTrMarksFilters">
			<div class="qfTrMarksFilter qfTrMarksFilter01">
				<select name="filter01">
					<option value="all">-- всички клиенти --</option>
<?php foreach ($ownersArr as $oId => $lbl): ?>
					<option value="<?php echo $oId;?>"><?php echo $lbl; ?></option>
<?php endforeach; ?>

				</select>
			</div>
			<div class="qfTrMarksFilter qfTrMarksFilter02">
				<select name="filter02">
					<option value="sort_date">Сортирай по дата</option>
					<option value="sort_name">Сортирай по име</option>
				</select>
			</div>
			<div class="qfTrMarksFilter qfTrMarksFilter02">
				<input type="text" placeholder="search..." class="qfTrMrSearch" name="search">
			</div>
            <div class="qfTrMarkItemAddDel qfTrMarkItemAddDelTop">
                <a class="qfSessCtrlBtn qfSessCtrlPlus" href="<?php echo $addTrademarkURL; ?>">Добави</a>
            </div>
		</div>

		<div class="qfTrTrColFull qfTrTrCol01" id="trademarks_container">
<?php foreach ($brands as $b): ?>
<?php
$src = '/images/trade-mark00.jpg';
if ($image = Document::getDocumentInstance($b->getImage()))
{
	$src = $image->getRelativeThumbUrl();
}
?>
			<div class="qfTrMarkItem qfTrMarkItemOpt_<?php echo $b->getClientId(); ?>" data-sort="<?php echo strtotime($b->getRegistrationDate()); ?>">
				<span title="delete" class="qfTrMarkItemDelete" id="<?php echo $b->getId(); ?>">x</span>
				<div class="qfTrMarkPiece qfTrMarkPLogo">
					<a href="<?php echo $detailURL.'?brand_id='.$b->getId(); ?>"><img alt="trademark logo" src="<?php echo $src; ?>"></a>
				</div>
               
				<div class="qfTrMarkPiece qfTrMarkPHeading">
                	<a class="qfTrMarkTitle" href="<?php echo $detailURL.'?brand_id='.$b->getId(); ?>"><?php echo $b->getLabel(); ?></a>
                    <div class="qfDateReg">
                     <?php  echo $b->getRegistrationDate() ? UtilsHelper::Date($b->getRegistrationDate(), 'd.m.Y') : '-'; ?>                
                    </div>    
                </div>
			</div>
<?php endforeach; ?>
		</div>

	</div>
	<div class="qfTrMarkItemAddDel">
		<a class="qfSessCtrlBtn qfSessCtrlPlus" href="<?php echo $addTrademarkURL; ?>">Добави</a>
	</div>
</div>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>