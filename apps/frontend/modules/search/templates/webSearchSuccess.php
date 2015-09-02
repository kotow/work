<div class="qfEntryHeader"><span>Web Search</span></div>
<div id="flashMsg"></div>
<div class="qfEntryContent">
	<!-- <form> -->
	<div class="qfBoxContainer">
		<h2>Търсене</h2>
		<form method="POST" action="" id="webSearch">
		<div class="qfTwoColsBox">
			<div class="qfTwoCol qfTwoCol01">
				<h3 class="qfFmPieceHeading">Легална информация</h3>
											
				<label for="name1">Наименование: </label>
				<?php echo frontend_input("field-Label")?>
				
				<label for="name2">Притежател: </label>
				<?php echo frontend_input("field-RightsOwner")?>
				
				<label for="name3">Представител: </label>
				<?php echo frontend_input("field-RightsRepresentative")?>
				
			</div>
			<div class="qfTwoCol qfTwoCol02">
				<h3 class="qfFmPieceHeading">Търсене по класове</h3>
				
				<label for="name4">Класове по Виенската класификация: </label>
				<?php echo frontend_input("field-ViennaClasses")?>
				
				<label for="name5">Класове по Ницска класификация: </label>
				<?php echo frontend_input("field-NiceClasses")?>
				
			</div>
		</div>
		<div class="qfTogFmPiece">
			<h3 class="qfFmPieceHeading">Регистрационна информация</h3>
			<div class="qfTwoColsBox">
				<div class="qfTwoCol qfTwoCol01">
				
					<label for="name1">Заявка номер: </label>
					<?php echo frontend_input("field-ApplicationNumber")?>
					
					<label for="name2">Регистров номер: </label>
					<?php echo frontend_input("field-RegisterNumber")?>
					
					
					<label for="name3">Дата на заявяване: </label>
					<?php echo frontend_input("field-ApplicationDate", null, array("readonly"=>"readonly"))?>
					
					<label for="name3">Тип: </label>
					<?php echo frontend_select("field-Kind", null, UtilsHelper::loadTrademarkTypes(array(""=>"Моля изберете")))?>
					
				</div>
				<div class="qfTwoCol qfTwoCol02">
				
					<label for="name4">Срок: </label>
					<?php echo frontend_input("field-ExpiresOn")?>
					
					<label for="name5">Държави в които е в сила: </label>
					<?php echo frontend_select("field-DesignatedContractingParty", null, array(""=>"Моля изберете")+$countries)?>
					
					<label for="name5">Статус: </label>
					<?php echo frontend_input("field-Status")?>
					
					<label for="name5">Дата на регистриране: </label>
					<?php echo frontend_input("field-RegistrationDate", null, array("readonly"=>"readonly"))?>
					
				</div>
			</div>
		</div>
		<div class="qfAddCtrls">
			<span class="hideFmPart">Скрий допълнителните полета</span>
		</div>
		<div class="qfFmCtrls">
			<a href="search-results.html"><input type="submit" value="Търси" class="qfSubmitBtn" onclick="$('#webSearch').submit();"></a>
		</div>
		<div></div>
		<?php echo frontend_hidden("submitted", "submitted")?>
		</form>
	</div>
	<!-- </form> -->
</div>

<script type="text/javascript">
$(document).ready(function(){
	$( "#field-ApplicationDate" ).datepicker({dateFormat: 'yy-mm-dd'});
	$( "#field-RegistrationDate" ).datepicker({dateFormat: 'yy-mm-dd'});
});

</script>
