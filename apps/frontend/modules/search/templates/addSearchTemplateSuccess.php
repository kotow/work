<div class="qfEntryHeader">
<?php if ($obj): ?>
	<span>Search Templates / Add Template</span>
<?php else: ?>
	<span>Search Templates / Edit Template</span>
<?php endif; ?>
</div>

<?php if ($success): ?>

<div class="qfEntryContent">
	<div class="qfBoxContainer">
		<h2>Данните за новия темплейт за търсене бяха записани успешно!</h2>
	</div>
</div>

<?php else: ?>

<div class="qfEntryContent">
	<div class="qfBoxContainer">
		<h2>Добавяне на темплейт за търсене</h2>

		<div id="flashMsg"></div>

		<form action="" method="POST">
		<div class="qfTogFmPiece">
			<label for="brand">Към Търговска Марка: </label>
                <select id="brand" name="brand" class="qfDdSel">
<?php $brId = $sf_params->get('brand'); ?>
<?php foreach ($brands as $id => $lbl): ?>
                    <option value="<?php echo $id; ?>" <?php if ($id == $brId) echo 'selected="selected"'; ?>><?php echo $lbl; ?></option>
<?php endforeach; ?>
                </select>
		</div>

		<div class="qfTwoColsBox">
			<div class="qfTwoCol qfTwoCol01">
				<h3 class="qfFmPieceHeading">Легална информация</h3>
				<label for="label">Наименование: </label>
				<?php echo frontend_input('label', $obj, array(), 'getLabel'); ?>
				<label for="rights_owner">Притежател: </label>
				<?php echo frontend_input('rights_owner', $obj, array(), 'getRightsOwner'); ?>
				<label for="rights_representative">Представител: </label>
				<?php echo frontend_input('rights_representative', $obj, array(), 'getRightsRepresentative'); ?>
			</div>
			<div class="qfTwoCol qfTwoCol02">
				<h3 class="qfFmPieceHeading">Търсене по класове</h3>
				<label for="vienna_classes">Класове по Виенската класификация: </label>
				<?php echo frontend_input('vienna_classes', $obj, array(), 'getViennaClasses'); ?>
				<label for="nice_classes">Класове по Ницска класификация: </label>
				<?php echo frontend_input('nice_classes', $obj, array(), 'getNiceClasses'); ?>
			</div>
		</div>
		<div class="qfTogFmPiece">
			<h3 class="qfFmPieceHeading">Регистрационна информация</h3>
			<div class="qfTwoColsBox">
				<div class="qfTwoCol qfTwoCol01">
					<label for="application_number">Заявка номер: </label>
					<?php echo frontend_input('application_number', $obj, array(), 'getApplicationNumber'); ?>
					<label for="register_number">Регистров номер: </label>
					<?php echo frontend_input('register_number', $obj, array(), 'getRegisterNumber'); ?>
					<label for="application_date">Дата на заявяване: </label>
					<?php echo frontend_input('application_date', $obj, array('class'=>'qfDatePick', 'id'=>'datepicker'), 'getApplicationDate'); ?>
				</div>
				<div class="qfTwoCol qfTwoCol02">
					<label for="expires_on">Срок: </label>
					<?php echo frontend_input('expires_on', $obj, array('class'=>'qfDatePick', 'id'=>'datepicker3'), 'getExpiresOn'); ?>
					<label for="designated_contracting_party">Държави в които е в сила: </label>
					<?php echo frontend_input('designated_contracting_party', $obj, array(), 'getDesignatedContractingParty'); ?>
					<label for="registration_date">Дата на регистриране: </label>
					<?php echo frontend_input('registration_date', $obj, array('class'=>'qfDatePick', 'id'=>'datepicker2'), 'getRegistrationDate'); ?>
				</div>
			</div>
		</div>
		<!-- <div class="qfAddCtrls">
			<span class="hideFmPart">Скрий допълнителните полета</span>
		</div> -->
		<div class="qfFmCtrls">
			<input type="submit" name="submit" value="Запиши" class="qfSubmitBtn">
		</div>
		<div></div>
		</form>
	</div>
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
	$( "#brand" ).select2();
});
</script>
<?php endif; ?>