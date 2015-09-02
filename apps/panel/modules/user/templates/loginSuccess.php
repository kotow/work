<div style="width:310px; margin:150px auto; padding:30px; border:solid 1px #CCC; border-radius:6px;" >
	<?php echo $sf_params->get("backendMsg");?>
	<form method="post" action="" class="global_form" id="form">
			<h3>Done.CMS Login</h3>
			<fieldset>
				<div>
					<label class="required" for="email">Username / e-mail</label>
				</div>
				<div>
					<input type="text" name="login" id="login" size="25">
				</div>
			</fieldset>
			<fieldset>
				<div>
					<label class="required" for="password">Password</label>
				</div>
	
				<div>
					<input type="password" name="password" id="password" size="25">
				</div>
			</fieldset>
			<fieldset>
				<input tabindex="5" type="submit" id="submit" name="submit" value="Sign In" style="width:198px"/>
			</fieldset>
	</form>
</div>