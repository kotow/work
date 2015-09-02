<?php use_helper('Validation') ?>

<div id="horizon">
	<div id="loginbox">
		<br><br>
		<center>
		<table>
			<td valign="top">
				<center>
				<?php echo form_tag('user/login') ?>
				<?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>	
				<?php echo form_error('login') ?>
				<?php echo form_error('password') ?><br>
					<B>Username</B><BR>
					<INPUT TYPE="TEXT" NAME="login" VALUE="" SIZE="15" MAXLENGTH="15">
					<P><B>Password</B><BR>
					<INPUT TYPE="password" NAME="password" VALUE="" SIZE="15" MAXLENGTH="32">
					</P>
					<?php echo submit_tag('sign in') ?>
				</FORM>
				</center>
			</td>
		</table>
		</center>
	</div>
</div>