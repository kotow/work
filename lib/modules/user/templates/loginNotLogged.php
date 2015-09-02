<?php
$culture = $sf_user->getCulture();
$loginLabel = UtilsHelper::Localize("user.frontend.Login-label",$culture);
$loginPass = UtilsHelper::Localize("user.frontend.Login-pass",$culture);
$loginEnter = UtilsHelper::Localize("user.frontend.Enter",$culture);
?>
	
	<form method="post" name="" action="">
		<span class="twikiActionFormStepSign">►</span>
		<b><?php echo $loginLabel?></b>
		<p>
			<?php
			echo frontend_input("login", null, 
			array(	"class" => "twikiInputField twikiFocus",
					"size" => "40"
					));
			?>
			</p><p>
		</p>
		<span class="twikiActionFormStepSign">►</span>
		<b><?php echo $loginPass?></b>
		<p>
			<input type="password" value="" name="password" size="40" class="twikiInputField"> 
			</p><p>
		</p>
		<input type="submit" value="<?php echo $loginEnter?>" class="twikiSubmit">
	</form>