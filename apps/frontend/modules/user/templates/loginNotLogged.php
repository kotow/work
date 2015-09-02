<div class="qfContainerBlock qfMainBody">
	<div class="qfEntryContent">
		<div class="loginContainer">
			<div id="flashMsg"></div>
			<form method="post" name="" action="">
				<div class="qfFmMinHeading"><h2>Потребителски вход</h2></div>
				<label for="name1">Име: </label>
				<?php echo frontend_input("login", null, array(	"class" => "twikiInputField twikiFocus","id" => "name1"));?>
				<label for="name2">Парола: </label>
				<input type="password" id="name2" value="" name="password">
				<div class="qfFmCtrls">
					<a href=""><input class="qfSubmitBtn" type="submit" value="Влез"></a>
				</div>
			</form>
		</div>
	</div>
</div>

