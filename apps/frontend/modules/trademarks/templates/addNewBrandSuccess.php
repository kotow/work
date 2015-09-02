<div class="qfEntryHeader">
	<span>Tracked Trademarks / Add New Trademark</span>
</div>

<?php if ($success): ?>

<div class="qfEntryContent">
	<div class="qfBoxContainer">
		<h2>Данните за новия TradeMark бяха въведени успешно!</h2>
	</div>
</div>

<?php else: ?>

<?php //var_dump($_POST); ?>
<?php //var_dump($brand); ?>
<?php //var_dump($client); ?>

<div class="qfEntryContent">
	<form action="" method="POST" enctype="multipart/form-data">
	<div class="qfBoxContainer">
		<h2>Въвеждане на данни</h2>

		<div id="flashMsg"></div>

		<div class="qfOneColFmRd">
			<div class="qfOneColFmRdHeading"><h3>Тип:</h3></div>
<?php /*
			<div class="qfOneColFmRdBtn"><div class="qfOneColFmRdBtnCell"><input type="radio" value="combined" name="rd01"><label>Combined</label></div></div>
			<div class="qfOneColFmRdBtn"><div class="qfOneColFmRdBtnCell"><input type="radio" value="word" name="rd01"><label>Word</label></div></div>
			<div class="qfOneColFmRdBtn"><div class="qfOneColFmRdBtnCell"><input type="radio" value="image" name="rd01"><label>Image</label></div></div>
*/ ?>
<?php $kindVal =  $sf_params->get('kind') ? $sf_params->get('kind') : $brand->getKind(); ?>
<?php // $new_labels= array('Комбинирана', 'Словна', 'Образнa'); $i = 0;?>
<?php foreach ($trademarkTypes as $kind => $lbl): $checked = ($kind == $kindVal) ? 'checked':''; ?>
			<div class="qfOneColFmRdBtn">
				<div class="qfOneColFmRdBtnCell">
					<input type="radio" <?php echo $checked; ?> value="<?php echo $kind; ?>" name="kind" id="kind_<?php echo $kind; ?>"><label for="kind_<?php echo $kind; ?>"><?php echo $lbl; ?></label>
				</div>
			</div>
            <? $i++;?>
<?php endforeach; ?>
		</div>
		<div class="qfTwoColsBox">
			<div class="qfTwoCol qfTwoCol01">
				<h3 class="qfFmPieceHeading">Основна информация</h3>							
				<label for="label">Наименование:* </label>
				<?php echo frontend_input('label', $brand, array(), 'getLabel'); ?>
				
				<label for="owner">Притежател: </label>
                <select id="owner" name="owner" class="qfDdSel">
                    <option value="">-- изберете --</option>
<?php /*
                    <option value="1">Option one</option>
                    <option value="2">Option two</option>
                    <option value="3">Option three</option>
*/ ?>
<?php $owId = $sf_params->get('owner') ? $sf_params->get('owner') : $brand->getClientId(); ?>
<?php foreach ($ownersArr as $id => $lbl): ?>
                    <option value="<?php echo $id; ?>" <?php if ($id == $owId) echo 'selected="selected"'; ?>><?php echo $lbl; ?></option>
<?php endforeach; ?>
                </select>
                                
				<label for="rights_owner">Притежател (нов):* </label>
				<?php echo frontend_input('rights_owner', $brand, array(), 'getRightsOwner'); ?>
				<label for="rights_owner_address">Адрес на притежателя (нов): </label>
				<?php echo frontend_textarea('rights_owner_address', $brand, array('size'=>'50x1'), 'getRightsOwnerAddress'); ?>
				<label for="rights_representative">Представител:* </label>
				<?php echo frontend_input('rights_representative', $brand, array(), 'getRightsRepresentative'); ?>
				<label for="rights_representative_address">Адрес на представителя: </label>
				<?php echo frontend_textarea('rights_representative_address', $brand, array('size'=>'50x1'), 'getRightsRepresentativeAddress'); ?>
			</div>
<?php 
$src = '/images/add-logo.jpg';
if ($img = Document::getDocumentInstance($brand->getImage()))
{
	$src = $img->getRelativeThumbUrl();
}
?>
			<div class="qfTwoCol qfTwoCol02">
				<h3 class="qfFmPieceHeading">Лого</h3>
				<div class="qfAddLogoContainer">
					<img alt="add logo" src="<?php echo $src; ?>">
				</div>
				<div class="qfFmCtrls">
					<!-- <input class="qfSubmitBtn" type="submit" value="Изберете файл ..."> -->
					<input disabled="disabled" placeholder="Choose File" id="uploadFile">
					<div class="fileUpload btn btn-primary">
						<span>Изберете файл ...</span>
						<input type="file" class="upload" id="image" name="image">
					</div>
				</div>
				<label for="vienna_classes">Класове по Виенската класификация: </label>
				<?php echo frontend_input('vienna_classes', $brand, array(), 'getViennaClasses'); ?>
				<label for="colors">Цветове: </label>
				<?php echo frontend_input('colors', $brand, array(), 'getColors'); ?>
			</div>
		</div>
		<div class="qfTogFmPiece">
			<h3 class="qfFmPieceHeading">Регистрационна информация</h3>
			<div class="qfTwoColsBox">
				<div class="qfTwoCol qfTwoCol01">
					<label for="application_number">Заявка номер:* </label>
					<?php echo frontend_input('application_number', $brand, array(), 'getApplicationNumber'); ?>
					<label for="register_number">Регистров номер:* </label>
					<?php echo frontend_input('register_number', $brand, array(), 'getRegisterNumber'); ?>
					<label for="application_date">Дата на заявяване:* </label>
					<?php echo frontend_input('application_date', $brand, array('class'=>'qfDatePick', 'id'=>'datepicker', 'format' => 'd-m-Y'), 'getApplicationDate'); ?>
					<label for="registration_date">Дата на регистриране:* </label>
					<?php echo frontend_input('registration_date', $brand, array('class'=>'qfDatePick', 'id'=>'datepicker2', 'format' => 'd-m-Y'), 'getRegistrationDate'); ?>
					<h3 class="qfFmPieceHeading">Класове</h3>
					<label for="nice_classes">Класове по Ницска класификация:* </label>
					<?php echo frontend_input('nice_classes', $brand, array(), 'getNiceClasses'); ?>
				</div>
				<div class="qfTwoCol qfTwoCol02">
					<label for="expires_on">Срок:* </label>
					<?php echo frontend_input('expires_on', $brand, array('class'=>'qfDatePick', 'id'=>'datepicker3', 'format' => 'd-m-Y'), 'getExpiresOn'); ?>
					<label for="office_of_origin">Държава на регистрация:* </label>
					<?php echo frontend_input('office_of_origin', $brand, array(), 'getOfficeOfOrigin'); ?>
					<?php //<input type="text" id="office_of_origin" name="office_of_origin" readonly value="BG"> ?>
					<label for="designated_contracting_party">Държави в които е в сила:* </label>
					<?php echo frontend_input('designated_contracting_party', $brand, array(), 'getDesignatedContractingParty'); ?>
					<label for="status">Статус: </label>
					<?php //<input type="text" id="status" name="status" readonly value="Registered"> ?>
                    <?php echo frontend_input('status', $brand, array(), 'getStatus'); ?>  
				</div>
			</div>
		</div>
		<div class="qfAddCtrls">
			<!-- <span class="hideFmPart">Скрий допълнителните полета</span> -->
		</div>
		<div class="qfFmCtrls">
			<input type="submit" value="Запиши" name="submit" class="qfSubmitBtn">
		</div>
		<div></div>
	</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$( "#datepicker" ).datepicker({
	   changeMonth: true,
       changeYear: true,
       yearRange:'-45:+16',
	   dateFormat: 'dd-mm-yy'
    });
	$( "#datepicker2" ).datepicker({
	   changeMonth: true,
       changeYear: true,
       yearRange:'-45:+16',
	   dateFormat: 'dd-mm-yy'
    });
	$( "#datepicker3" ).datepicker({
	   changeMonth: true,
       changeYear: true,
       yearRange:'-45:+16',
	   dateFormat: 'dd-mm-yy'
    });
	$( "#owner" ).select2();
	
	$('#owner').change(function(){
		var id = $(this).val();
		if (id == "")
		{
			$('#rights_owner').val('');
			$('#rights_owner_address').val('');
		}
		else
		{
			$('#rights_owner').val($('#owner :selected').text());
			$.ajax({
				url: '/trademarks/loadOwnerAddress?id='+id,
				success: function(msg)
				{
					$('#rights_owner_address').val(msg);
				}
			});
		}
	});
});

</script>

<?php endif; ?>