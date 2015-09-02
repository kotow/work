<div id="admin_login">
<?php echo $sf_params->get("backendMsg");?>
		<div id="login_block">
  			<div class="position">
    				<form action="" method="post">
    					<p id="login_username">
    						<label for="username">Username:</label>
    						<input type="text" name="login" id="login" class="inputbox" size="15">
    					</p>
    					<p id="login_password">
    						<label for="password">Password:</label>
    						<input type="password" name="password" id="password" class="inputbox" size="15">
    					</p>
    					<div style="padding-left: 106px;">
    						<input type="submit" name="submit" value="Login" class="login_btn">
    					</div>
    				</form>
  			</div>
		</div>
</div>
<!-- loged-out -->