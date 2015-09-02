<div class="qfEntryHeader"><span>Import Session History</span></div>
<div class="qfEntryContent">
	<div class="qfSessHolder qfMaxWd">
		<div class="qfSearchWrap">
			<div class="qfSearchTag">
				<div class="qfTrMarkContainer">
					<div class="qfTrMarkCell qfTrMarkHeading qfMidHeadingBgr">Доклади от Импорт Сесии</div>
				</div>
			</div>
			<div class="qfSearchListWrap qfBoxBorderBg">
				<table border="0" cellspacing="0" cellpadding="0" class="qfTabInpSess">
					<tbody>
					<tr>
						<th>Име на сесия</th>
						<th>Име на файл</th>
						<th>Размер</th>
						<th>Качена от</th>
						<th>Старт #</th>
						<th>Брой</th>
						<th>Дата</th>
					</tr>
<?php foreach ($importsArr as $is): ?>
<?php $import = Document::getDocumentInstance($is->getImportId()); 

?>
					<tr onclick="document.location = '<?php echo $reportHref.'?is='.$is->getId(); ?>'">
						<td><?php echo $is->getLabel(); ?></td>
						<td><?php if($import): echo $import->getLabel(); else: ?>Ръчно импортирани марки<?php endif;?></td>
						<td><?php if($import) echo number_format($import->getSize(), 0, '', ' ')." bytes";?> </td>
						<td><?php if($import) if ($usr = Document::getDocumentInstance($import->getUser())) echo $usr->getLabel(); else echo 'Потребител #'.$import->getUser(); ?></td>
						<td><?php echo $is->getStartId(); ?></td>
						<td><?php echo $is->getTmCount(); ?></td>
						<td><?php if($import) echo UtilsHelper::DateBG($import->getCreatedAt(), 'd.m.Y'); ?> г.</td>
					</tr>
<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>