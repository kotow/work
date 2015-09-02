<div class="head_field">
	<img src="/images/layout/login_icon.png" class="icon">
	<div class="tab_head">
<h1>Reset password</h1>
</div>
	<div class="holder_dark">
	<div class="login_holder">
	
<form action="" method="post">
<table cellpadding="3" cellspacing="0" border="0">
	<tr>
		<th>Email</th>
		<td>
			<?php
			
			echo frontend_input("resetpassword", "e-mail", 
			array(	"class" => "edit",
					"size" => "20",
					"onfocus" => "if(this.value=='e-mail'){this.value = '';}"
					));
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="Reset" class="common_btn" /></td>
	</tr>
	</table>
</form>



	</div>
	</div>
</div>
<div class="h10"></div>
